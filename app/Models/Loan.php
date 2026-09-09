<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    protected $primaryKey = 'loan_id';

    protected $fillable = [
        'customer_id',
        'principal_amount',
        'interest_rate',
        'term_months',
        'status',
        'disbursement_date',
        'created_by',
    ];

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function schedules()
    {
        return $this->hasMany(LoanSchedule::class, 'loan_id', 'loan_id');
    }

    public function repayments()
    {
        return $this->hasMany(Repayment::class, 'loan_id', 'loan_id');
    }
}