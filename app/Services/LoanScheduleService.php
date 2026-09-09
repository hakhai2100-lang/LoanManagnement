<?php

namespace App\Services;

use App\Models\Loan;
use App\Models\LoanSchedule;
use Carbon\Carbon;

class LoanScheduleService
{
    public function generateSchedule(Loan $loan): void
    {
        $loan->schedules()->delete();

        $p = (float) $loan->principal_amount;
        $r = (float) ($loan->interest_rate / 100); 
        $n = (int) $loan->term_months;

        $pmt = $p * ($r * pow(1 + $r, $n)) / (pow(1 + $r, $n) - 1);

        $remainingBalance = $p;
        $disbursementDate = $loan->disbursement_date ? Carbon::parse($loan->disbursement_date) : Carbon::today();

        for ($i = 1; $i <= $n; $i++) {
            $interestDue = $remainingBalance * $r;
            $principalDue = $pmt - $interestDue;

            if ($i === $n) {
                $principalDue = $remainingBalance;
                $pmt = $principalDue + $interestDue;
            }

            $remainingBalance -= $principalDue;
            $dueDate = $disbursementDate->copy()->addMonths($i);

            LoanSchedule::create([
                'loan_id' => $loan->loan_id,
                'installment_no' => $i,
                'due_date' => $dueDate->format('Y-m-d'),
                'principal_due' => round($principalDue, 2),
                'interest_due' => round($interestDue, 2),
                'total_due' => round($pmt, 2),
                'status' => 'Pending',
            ]);
        }
    }
}