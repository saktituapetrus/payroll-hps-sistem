<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class YearlyBonus extends Model
{
    protected $fillable = [
        'employee_id',
        'bonus_type',
        'bonus_amount',
        'date_disbursement',
        'status'
    ];

    public function employees()
    {
        return $this->belongsTo('App\Employee', 'employee_id');
    }

    public function getBonusStatus()
    {
        $text = '';

        if ($this->status == 0) {
            $text = 'Belum Dibayar';
        } else if ($this->status == 1) {
            $text = 'Sudah Dibayar';
        }

        return $text;
    }
}
