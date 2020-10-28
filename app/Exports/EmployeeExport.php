<?php

namespace App\Exports;

use App\Employee;

use Illuminate\Contracts\View\View;

use Maatwebsite\Excel\Concerns\FromView;

class EmployeeExport implements FromView
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function view(): View
    {
        $employees =  Employee::all();

        $data = array();

        foreach ($employees as $employee) {
            $arr['id'] = $employee->id;
            $arr['user_id'] = $employee->user_id;
            $arr['name'] = $employee->name;
            $arr['dob'] = $employee->dob;
            $arr['gender'] = $employee->gender;
            $arr['phone'] = $employee->phone;
            $arr['address'] = $employee->address;
            $arr['email'] = $employee->email;
            $arr['password'] = $employee->password;
            $arr['employee_id'] = $employee->employee_id;
            $arr['branch_id'] = $employee->branch_id;
            $arr['department_id'] = $employee->department_id;
            $arr['designation_id'] = $employee->designation_id;
            $arr['company_doj'] = $employee->company_doj;
            $arr['documents'] = $employee->documents;
            $arr['account_holder_name'] = $employee->account_holder_name;
            $arr['account_number'] = $employee->account_number;
            $arr['bank_name'] = $employee->bank_name;
            $arr['bank_identifier_code'] = $employee->bank_identifier_code;
            $arr['branch_location'] = $employee->branch_location;
            $arr['tax_payer_id'] = $employee->tax_payer_id;
            $arr['salary_type'] = $employee->salary_type;
            $arr['salary'] = $employee->salary;
            // $arr['is_active'] = $employee->is_active;
            // $arr['created_by'] = $employee->created_by;

            array_push($data, $arr);
        }

        return view('employee.export', [
            'data' => $data
        ]);
    }
}
