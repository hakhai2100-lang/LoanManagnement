<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Repayment extends Model
{
    use HasFactory;

    protected $primaryKey = 'repayment_id';

    protected $fillable = [
        'loan_id',
        'schedule_id',
        'amount_paid',
        'payment_date',
        'payment_method',
        'received_by',
    ];

    public function loan()
    {
        return $this->belongsTo(Loan::class, 'loan_id', 'loan_id');
    }

    public function schedule()
    {
        return $this->belongsTo(LoanSchedule::class, 'schedule_id', 'schedule_id');
    }

    public function cashier()
    {
        return $this->belongsTo(User::class, 'received_by');
    }
}