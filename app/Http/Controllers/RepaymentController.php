<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\LoanSchedule;
use App\Models\Repayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class RepaymentController extends Controller
{
    /**
     * បង្ហាញផ្ទាំង Form សងប្រាក់
     */
    public function create(Loan $loan)
    {
        $loan->load('schedules', 'customer');
        $pendingSchedules = $loan->schedules->where('status', '!=', 'Paid');

        // ពិនិត្យប្រសិនបើកម្ចីបានបង់ដាច់គ្រប់ចំនួនរួចរាល់ហើយ
        if ($pendingSchedules->isEmpty()) {
            return redirect()->route('loans.show', $loan->loan_id)
                ->with('error', 'កម្ចីនេះត្រូវបានសងគ្រប់ចំនួនរួចរាល់ហើយ!');
        }

        return view('loans.repay', compact('loan', 'pendingSchedules'));
    }

    /**
     * កត់ត្រាការសងប្រាក់តាមលក្ខខណ្ឌ Strict Exact Amount (ជម្រើសទី ១)
     */
    public function store(Request $request, Loan $loan)
    {
        Gate::authorize('repay', $loan);

        // ១. ស្វែងរកកាលវិភាគ Installment បន្ទាប់ដែលមិនទាន់បានបង់
        $nextSchedule = LoanSchedule::where('loan_id', $loan->loan_id)
            ->where('status', '!=', 'Paid')
            ->orderBy('installment_no', 'asc')
            ->first();

        if (!$nextSchedule) {
            return redirect()->route('loans.show', $loan->loan_id)
                ->with('error', 'កម្ចីនេះត្រូវបានសងគ្រប់ចំនួនរួចរាល់ហើយ!');
        }

        $exactAmount = round((float) $nextSchedule->total_due, 2);

        // ២. STRICT EXACT AMOUNT VALIDATION (តម្រូវឱ្យបង់ចំចំនួនគត់នៃដំណាក់កាលនីមួយៗ)
        $request->validate([
            'amount_paid' => [
                'required',
                'numeric',
                function ($attribute, $value, $fail) use ($exactAmount, $nextSchedule) {
                    if (round((float) $value, 2) !== $exactAmount) {
                        $fail('សូមបញ្ចូលចំនួនទឹកប្រាក់ឱ្យត្រូវតាមកាលវិភាគលើកទី ' . $nextSchedule->installment_no . ' គឺ $' . number_format($exactAmount, 2));
                    }
                },
            ],
            'payment_method' => 'required|string',
        ], [
            'amount_paid.required'    => 'សូមបញ្ចូលចំនួនទឹកប្រាក់ដែលត្រូវបង់!',
            'amount_paid.numeric'     => 'ចំនួនទឹកប្រាក់ត្រូវតែជាលេខ!',
            'payment_method.required' => 'សូមជ្រើសរើសវិធីសាស្ត្រទូទាត់ប្រាក់!',
        ]);

        // ៣. រក្សាទុកទិន្នន័យដោយប្រើ Database Transaction
        DB::transaction(function () use ($loan, $request, $nextSchedule) {
            Repayment::create([
                'loan_id'        => $loan->loan_id,
                'schedule_id'    => $nextSchedule->schedule_id,
                'amount_paid'    => $request->amount_paid,
                'payment_date'   => now()->toDateString(),
                'payment_method' => $request->payment_method,
                'received_by'    => Auth::id(),
            ]);

            // កែប្រែ Installment បច្ចុប្បន្នទៅជា Paid
            $nextSchedule->update(['status' => 'Paid']);
        });

        return redirect()->route('loans.show', $loan->loan_id)
            ->with('success', 'ការសងប្រាក់លើកទី ' . $nextSchedule->installment_no . ' ត្រូវបានកត់ត្រា និងទូទាត់ដោយជោគជ័យ!');
    }
}