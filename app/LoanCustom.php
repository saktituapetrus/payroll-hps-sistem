<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LoanCustom extends Model
{
    protected $table = 'loan_customs';

    protected $fillable = [
        'employee_id',
        'loan_type',
        'loan_amount',
        'tenor',
        'loan_date'
    ];

    public function employees()
    {
        return $this->belongsTo('App\Employee', 'employee_id');
    }
}
