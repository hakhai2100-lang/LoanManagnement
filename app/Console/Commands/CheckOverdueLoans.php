<?php

namespace App\Console\Commands;

use App\Models\LoanSchedule;
use Illuminate\Console\Command;

class CheckOverdueLoans extends Command
{
    protected $signature = 'loan:check-overdue';
    protected $description = 'Update loan schedules status to Overdue if due_date is passed';

    public function handle()
    {
        $updated = LoanSchedule::where('due_date', '<', now()->toDateString())
            ->where('status', 'Pending')
            ->update(['status' => 'Overdue']);

        $this->info("Successfully updated {$updated} schedules to Overdue.");
        return Command::SUCCESS;
    }
}