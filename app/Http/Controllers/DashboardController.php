<?php

namespace App\Http\Controllers;

use App\Models\LoanSchedule;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function overdue()
    {
        $overdueSchedules = LoanSchedule::with(['loan.customer'])
            ->where('status', 'Overdue')
            ->orderBy('due_date', 'asc')
            ->paginate(10);

        return view('dashboard.overdue', compact('overdueSchedules'));
    }
}