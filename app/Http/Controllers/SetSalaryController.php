<?php

namespace App\Http\Controllers;

use App\Allowance;
use App\AllowanceOption;
use App\Commission;
use App\DeductionOption;
use App\Employee;
use App\Loan;
use App\LoanOption;
use App\OtherPayment;
use App\Overtime;
use App\PayslipType;
use App\SaturationDeduction;
use App\Imports\SetSalaryImport;
use App\Exports\SetSalaryExport;

use Maatwebsite\Excel\Facades\Excel;

use Illuminate\Http\Request;

class SetSalaryController extends Controller
{
    public function index()
    {
        if (\Auth::user()->can('Manage Set Salary')) {
            $employees = Employee::where(
                [
                    'created_by' => \Auth::user()->creatorId(),
                ]
            )->get();

            return view('setsalary.index', compact('employees'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function edit($id)
    {
        if (\Auth::user()->can('Edit Set Salary')) {

            $payslip_type      = PayslipType::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $allowance_options = AllowanceOption::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $loan_options      = LoanOption::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $deduction_options = DeductionOption::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            if (\Auth::user()->type == 'employee') {
                $currentEmployee      = Employee::where('user_id', '=', \Auth::user()->id)->first();
                $allowances           = Allowance::where('employee_id', $currentEmployee->id)->get();
                $commissions          = Commission::where('employee_id', $currentEmployee->id)->get();
                $loans                = Loan::where('employee_id', $currentEmployee->id)->get();
                $saturationdeductions = SaturationDeduction::where('employee_id', $currentEmployee->id)->get();
                $otherpayments        = OtherPayment::where('employee_id', $currentEmployee->id)->get();
                $overtimes            = Overtime::where('employee_id', $currentEmployee->id)->get();
                $employee             = Employee::where('user_id', '=', \Auth::user()->id)->first();

                return view('setsalary.employee_salary', compact('employee', 'payslip_type', 'allowance_options', 'commissions', 'loan_options', 'overtimes', 'otherpayments', 'saturationdeductions', 'loans', 'deduction_options', 'allowances'));
            } else {
                $allowances           = Allowance::where('employee_id', $id)->get();
                $commissions          = Commission::where('employee_id', $id)->get();
                $loans                = Loan::where('employee_id', $id)->get();
                $saturationdeductions = SaturationDeduction::where('employee_id', $id)->get();
                $otherpayments        = OtherPayment::where('employee_id', $id)->get();
                $overtimes            = Overtime::where('employee_id', $id)->get();
                $employee             = Employee::find($id);

                return view('setsalary.edit', compact('employee', 'payslip_type', 'allowance_options', 'commissions', 'loan_options', 'overtimes', 'otherpayments', 'saturationdeductions', 'loans', 'deduction_options', 'allowances'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function show($id)
    {
        $payslip_type      = PayslipType::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
        $allowance_options = AllowanceOption::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
        $loan_options      = LoanOption::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
        $deduction_options = DeductionOption::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
        if (\Auth::user()->type == 'employee') {
            $currentEmployee      = Employee::where('user_id', '=', \Auth::user()->id)->first();
            $allowances           = Allowance::where('employee_id', $currentEmployee->id)->get();
            $commissions          = Commission::where('employee_id', $currentEmployee->id)->get();
            $loans                = Loan::where('employee_id', $currentEmployee->id)->get();
            $saturationdeductions = SaturationDeduction::where('employee_id', $currentEmployee->id)->get();
            $otherpayments        = OtherPayment::where('employee_id', $currentEmployee->id)->get();
            $overtimes            = Overtime::where('employee_id', $currentEmployee->id)->get();
            $employee             = Employee::where('user_id', '=', \Auth::user()->id)->first();

            return view('setsalary.employee_salary', compact('employee', 'payslip_type', 'allowance_options', 'commissions', 'loan_options', 'overtimes', 'otherpayments', 'saturationdeductions', 'loans', 'deduction_options', 'allowances'));
        } else {
            $allowances           = Allowance::where('employee_id', $id)->get();
            $commissions          = Commission::where('employee_id', $id)->get();
            $loans                = Loan::where('employee_id', $id)->get();
            $saturationdeductions = SaturationDeduction::where('employee_id', $id)->get();
            $otherpayments        = OtherPayment::where('employee_id', $id)->get();
            $overtimes            = Overtime::where('employee_id', $id)->get();
            $employee             = Employee::find($id);

            return view('setsalary.employee_salary', compact('employee', 'payslip_type', 'allowance_options', 'commissions', 'loan_options', 'overtimes', 'otherpayments', 'saturationdeductions', 'loans', 'deduction_options', 'allowances'));
        }
    }


    public function employeeUpdateSalary(Request $request, $id)
    {
        $validator = \Validator::make(
            $request->all(),
            [
                'salary_type' => 'required',
                'salary' => 'required',
            ]
        );
        if ($validator->fails()) {
            $messages = $validator->getMessageBag();

            return redirect()->back()->with('error', $messages->first());
        }
        $employee = Employee::findOrFail($id);
        $input    = $request->all();
        $employee->fill($input)->save();

        return redirect()->back()->with('success', 'User ' . $employee->name . ' updated!');
    }

    public function employeeSalary()
    {
        if (\Auth::user()->type == "employee") {
            $employees = Employee::where('user_id', \Auth::user()->id)->get();

            return view('setsalary.index', compact('employees'));
        }
    }

    /**
     * Author: faaptech
     * Date: 05/05/2020
     * Description: Handle import data set salary
     */
    public function import(Request $request)
    {
        // Parse excel file from request to array
        $data = Excel::toArray(new SetSalaryImport, $request->file('file'));

        // Looping $data with anonymous function and callback two paramaters
        collect(head($data))->each(function ($row, $key) {
            // Update database employees by employee_id
            Employee::where('id', $row['id'])->update([
                'salary_type' => $row['payslip_type'],
                'salary' => $row['salary'],
            ]);

            // Update database allowances by employee_id
            if (!empty($row['allowance_option']) && !empty($row['allowance_title']) && !empty($row['allowance_amount'])) {
                $allowanceMatchThese = [
                    'employee_id' => $row['id'],
                    'allowance_option' => $row['allowance_option'],
                    'title' => $row['allowance_title'],
                    'amount' => $row['allowance_amount'],
                ];

                Allowance::updateOrCreate($allowanceMatchThese, [
                    'allowance_option' => $row['allowance_option'],
                    'title' => $row['allowance_title'],
                    'amount' => $row['allowance_amount'],
                    'created_by' => \Auth::user()->creatorId(),
                ]);
            }

            // Update database commissions by employee_id
            if (!empty($row['commission_title']) && !empty($row['commission_amount'])) {
                $comissionsMatchThese = [
                    'employee_id' => $row['id'],
                    'title' => $row['commission_title'],
                    'amount' => $row['commission_amount'],
                ];

                Commission::updateOrCreate($comissionsMatchThese, [
                    'title' => $row['commission_title'],
                    'amount' => $row['commission_amount'],
                    'created_by' => \Auth::user()->creatorId(),
                ]);
            }

            // Update database loans by employee_id
            if (!empty($row['loan_option']) && !empty($row['loan_title']) && !empty($row['loan_amount']) && !empty($row['loan_start_date']) && !empty($row['loan_end_date']) && !empty($row['loan_reason'])) {
                $loansMatchThese = [
                    'employee_id' => $row['id'],
                    'loan_option' => $row['loan_option'],
                    'title' => $row['loan_title'],
                    'amount' => $row['loan_amount'],
                    'start_date' => $row['loan_start_date'],
                    'end_date' => $row['loan_end_date'],
                    'reason' => $row['loan_reason'],
                ];

                Loan::updateOrCreate($loansMatchThese, [
                    'loan_option' => $row['loan_option'],
                    'title' => $row['loan_title'],
                    'amount' => $row['loan_amount'],
                    'start_date' => $row['loan_start_date'],
                    'end_date' => $row['loan_end_date'],
                    'reason' => $row['loan_reason'],
                    'created_by' => \Auth::user()->creatorId(),
                ]);
            }

            // Update database saturation_deductions by employee_id
            if (!empty($row['saturation_option']) && !empty($row['saturation_title']) && !empty($row['saturation_amount'])) {
                $saturationDeductionsMatchThese = [
                    'employee_id' => $row['id'],
                    'deduction_option' => $row['saturation_option'],
                    'title' => $row['saturation_title'],
                    'amount' => $row['saturation_amount'],
                ];

                SaturationDeduction::updateOrCreate($saturationDeductionsMatchThese, [
                    'deduction_option' => $row['saturation_option'],
                    'title' => $row['saturation_title'],
                    'amount' => $row['saturation_amount'],
                    'created_by' => \Auth::user()->creatorId(),
                ]);
            }

            // Update database other_payments by employee_id
            if (!empty($row['payment_title']) && !empty($row['payment_amount'])) {
                $otherPaymentsMatchThese = [
                    'employee_id' => $row['id'],
                    'title' => $row['payment_title'],
                    'amount' => $row['payment_amount'],
                ];

                OtherPayment::updateOrCreate($otherPaymentsMatchThese, [
                    'title' => $row['payment_title'],
                    'amount' => $row['payment_amount'],
                    'created_by' => \Auth::user()->creatorId(),
                ]);
            }

            // Update database overtimes by employee_id
            if (!empty($row['overtime_title']) && !empty($row['overtime_number_of_days']) && !empty($row['overtime_hours']) && !empty($row['overtime_rate'])) {
                $overtimesMatchThese = [
                    'employee_id' => $row['id'],
                    'title' => $row['overtime_title'],
                    'number_of_days' => $row['overtime_number_of_days'],
                    'hours' => $row['overtime_hours'],
                    'rate' => $row['overtime_rate'],
                ];

                Overtime::updateOrCreate($overtimesMatchThese, [
                    'title' => $row['overtime_title'],
                    'number_of_days' => $row['overtime_number_of_days'],
                    'hours' => $row['overtime_hours'],
                    'rate' => $row['overtime_rate'],
                    'created_by' => \Auth::user()->creatorId(),
                ]);
            }
        });

        // back to previous url
        return back();
    }

    /**
     * Author: faaptech
     * Date: 05/05/2020
     * Description: Handle export data set salary
     */
    public function export()
    {
        // Generate file setsalary.xlsx
        return Excel::download(new SetSalaryExport, 'setsalary.xlsx');
    }
}
