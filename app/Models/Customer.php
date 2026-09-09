<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'customer_code',
        'first_name',
        'last_name',
        'gender',
        'date_of_birth',
        'phone',
        'email',
        'address',
        'city',
        'status',
    ];
}