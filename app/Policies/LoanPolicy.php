<?php

namespace App\Policies;

use App\Models\Loan;
use App\Models\User;

class LoanPolicy
{
    public function approve(User $user, Loan $loan): bool
    {
        $role = strtolower(str_replace(' ', '_', $user->role ?? ''));
        return in_array($role, ['admin', 'loan_officer']) && $loan->status === 'Pending';
    }

    public function disburse(User $user, Loan $loan): bool
    {
        $role = strtolower(str_replace(' ', '_', $user->role ?? ''));
        return in_array($role, ['admin', 'loan_officer']) && $loan->status === 'Approved';
    }

    public function repay(User $user, Loan $loan): bool
    {
        $role = strtolower(str_replace(' ', '_', $user->role ?? ''));
        return in_array($role, ['admin', 'cashier']) && in_array($loan->status, ['Disbursed', 'Approved']);
    }

    public function view(User $user, Loan $loan): bool
    {
        $role = strtolower(str_replace(' ', '_', $user->role ?? ''));
        if (in_array($role, ['admin', 'loan_officer', 'cashier'])) {
            return true;
        }

        return $user->id === $loan->customer_id;
    }
}