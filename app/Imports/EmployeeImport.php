<?php

namespace App\Imports;

use App\Employee;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class EmployeeImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Employee([
            'id' => $row['id'],
            'user_id' => $row['user_id'],
            'name' => $row['name'],
            'dob' => $row['dob'],
            'gender' => $row['gender'],
            'phone' => $row['phone'],
            'address' => $row['address'],
            'email' => $row['email'],
            'password' => \Hash::make($row['password']),
            'employee_id' => $row['employee_id'],
            'branch_id' => $row['branch_id'],
            'department_id' => $row['department_id'],
            'designation_id' => $row['designation_id'],
            'company_doj' => $row['company_doj'],
            'documents' => $row['documents'],
            'account_holder_name' => $row['account_holder_name'],
            'account_number' => $row['account_number'],
            'bank_name' => $row['bank_name'],
            'bank_identifier_code' => $row['bank_identifier_code'],
            'branch_location' => $row['branch_location'],
            'tax_payer_id' => $row['tax_payer_id'],
            'created_by' => $row['created_by'],
        ]);
    }
}
