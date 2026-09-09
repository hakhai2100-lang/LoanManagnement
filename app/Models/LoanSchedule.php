<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanSchedule extends Model
{
    use HasFactory;

    protected $primaryKey = 'schedule_id';

    protected $fillable = [
        'loan_id',
        'installment_no',
        'due_date',
        'principal_due',
        'interest_due',
        'total_due',
        'status',
    ];

    public function loan()
    {
        return $this->belongsTo(Loan::class, 'loan_id', 'loan_id');
    }
}