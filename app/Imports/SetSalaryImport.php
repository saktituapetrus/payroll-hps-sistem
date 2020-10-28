<?php

namespace App\Imports;

use App\PaySlip;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SetSalaryImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new PaySlip([
            'id' => $row['id'],
            'payslip_type' => $row['payslip_type'],
            'salary' => $row['salary'],
            'allowance_option' => $row['allowance_option'],
            'allowance_title' => $row['allowance_title'],
            'allowance_amount' => $row['allowance_amount'],
            'commission_title' => $row['commission_title'],
            'commission_amount' => $row['commission_amount'],
            'loan_option' => $row['loan_option'],
            'loan_title' => $row['loan_title'],
            'loan_amount' => $row['loan_amount'],
            'loan_reason' => $row['loan_reason'],
            'loan_start_date' => $row['loan_start_date'],
            'loan_end_date' => $row['loan_end_date'],
            'saturation_option' => $row['saturation_option'],
            'saturation_title' => $row['saturation_title'],
            'saturation_amount' => $row['saturation_amount'],
            'payment_title' => $row['payment_title'],
            'payment_amount' => $row['payment_amount'],
            'overtime_title' => $row['overtime_title'],
            'overtime_number_of_days' => $row['overtime_number_of_days'],
            'overtime_hours' => $row['overtime_hours'],
            'overtime_rate' => $row['overtime_rate'],
        ]);
    }
}
