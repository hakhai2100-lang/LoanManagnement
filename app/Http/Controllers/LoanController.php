<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Services\LoanScheduleService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LoanController extends Controller
{
    protected $scheduleService;

    public function __construct(LoanScheduleService $scheduleService)
    {
        $this->scheduleService = $scheduleService;
    }

    /**
     * Display a listing of all loans with search and sorting features.
     */
    public function index(Request $request)
    {
        $query = Loan::with('customer', 'schedules');

        if ($request->filled('search')) {
            $search = trim($request->search);

      
            $loanIdSearch = preg_replace('/[^0-9]/', '', $search);

            $query->where(function ($q) use ($search, $loanIdSearch) {
                // Search by Loan ID
                if (!empty($loanIdSearch)) {
                    $q->orWhere('loan_id', (int) $loanIdSearch);
                }
         
                $q->orWhereHas('customer', function ($subQuery) use ($search) {
                    $subQuery->where('name', 'like', "%{$search}%");
                });
            });
        }

        $loans = $query->orderBy('loan_id', 'asc')
            ->paginate(10)
            ->withQueryString();

        return view('loans.index', compact('loans'));
    }

    /**
     * Show the loan application form.
     */
    public function create()
    {
        return view('loans.apply');
    }

    /**
     * Store a newly created loan application.
     */
    public function store(Request $request)
    {
        $request->validate([
            'principal_amount' => 'required|numeric|min:50',
            'interest_rate'    => 'required|numeric|min:0.1|max:100',
            'term_months'      => 'required|integer|min:1|max:60',
        ]);

        Loan::create([
            'customer_id'      => Auth::id(),
            'principal_amount' => $request->principal_amount,
            'interest_rate'    => $request->interest_rate,
            'term_months'      => $request->term_months,
            'status'           => 'Pending',
            'created_by'       => Auth::id(),
        ]);

        return redirect()->route('loans.my')
            ->with('success', 'Loan application submitted successfully and is currently pending review!');
    }

    /**
     * Display the authenticated customer's personal loans.
     */
    public function myLoans()
    {
        $loans = Loan::where('customer_id', Auth::id())
            ->orderBy('loan_id', 'asc')
            ->paginate(10);

        return view('loans.my_loans', compact('loans'));
    }

    /**
     * Cancel a loan application.
     */
    public function cancel(Loan $loan)
    {
        if ($loan->customer_id !== Auth::id() && Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        if ($loan->status !== 'Pending') {
            return redirect()->back()->with('error', 'Cannot cancel an approved or already disbursed loan!');
        }

        $loan->update(['status' => 'Rejected']);

        return redirect()->back()->with('success', 'Loan application LN-' . str_pad($loan->loan_id, 4, '0', STR_PAD_LEFT) . ' has been cancelled successfully!');
    }

    /**
     * Display a list of pending and approved loans.
     */
    public function pendingLoans()
    {
        $loans = Loan::with('customer')
            ->whereIn('status', ['Pending', 'Approved'])
            ->orderBy('loan_id', 'asc')
            ->paginate(10);

        return view('loans.pending', compact('loans'));
    }

    /**
     * Approve a loan application (Loan Officer / Admin).
     */
    public function approve(Loan $loan)
    {
        if ($loan->status !== 'Pending') {
            return redirect()->back()->with('error', 'This loan is not in Pending status!');
        }

        $loan->update(['status' => 'Approved']);

        return redirect()->back()->with('success', 'Loan LN-' . str_pad($loan->loan_id, 4, '0', STR_PAD_LEFT) . ' has been approved successfully!');
    }

    /**
     * Disburse the loan and generate the repayment schedule.
     */
    public function disburse(Loan $loan)
    {
        if ($loan->status !== 'Approved') {
            return redirect()->back()->with('error', 'Only approved loans can be disbursed!');
        }

        DB::transaction(function () use ($loan) {
            $loan->update([
                'status'            => 'Disbursed',
                'disbursement_date' => now()->toDateString(),
            ]);

            // Call the service to generate the loan schedule
            $this->scheduleService->generateSchedule($loan);
        });

        return redirect()->route('loans.schedule', $loan->loan_id)
            ->with('success', 'Loan disbursed and repayment schedule generated successfully!');
    }

    /**
     * Show the loan repayment schedule.
     */
    public function schedule(Loan $loan)
    {
        $loan->load(['customer', 'schedules' => function ($query) {
            $query->orderBy('installment_no', 'asc');
        }]);

        return view('loans.schedule', compact('loan'));
    }

    /**
     * Display loan details and remaining balance.
     */
    public function show(Loan $loan)
    {
        $loan->load(['customer', 'schedules', 'repayments']);

        $totalPaid = $loan->repayments->sum('amount_paid');
        $totalPayable = $loan->schedules->sum('total_due');
        $remainingBalance = max(0, $totalPayable - $totalPaid);

        return view('loans.show', compact('loan', 'totalPaid', 'totalPayable', 'remainingBalance'));
    }
}