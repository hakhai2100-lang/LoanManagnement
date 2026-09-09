<?php

namespace App\Console\Commands;

use App\Models\LoanSchedule;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CheckOverdueSchedules extends Command
{
    protected $signature = 'loans:check-overdue';
    protected $description = 'ត្រួតពិនិត្យ និងផ្លាស់ប្តូរស្ថានភាពកាលវិភាគដែលហួសកាលកំណត់ទៅជា Overdue';

    public function handle(): void
    {
        $today = Carbon::today()->toDateString();

        $updatedCount = LoanSchedule::where('status', 'Pending')
            ->where('due_date', '<', $today)
            ->update(['status' => 'Overdue']);

        $this->info("បានធ្វើបច្ចុប្បន្នភាពចំនួន {$updatedCount} Installments ទៅជា Overdue ដោយជោគជ័យ។");
    }
}