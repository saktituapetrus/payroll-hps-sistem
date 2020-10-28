<?php

namespace App\Http\Controllers;

use App\Employee;
use App\PaySlip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;

class PaySlipController extends Controller
{

    public function index()
    {
        $emp = Employee::allowance(1);

        if (\Auth::user()->can('Manage Pay Slip')) {
            $employeeID = \Auth::user()->id;
            $employees  = Employee::where(
                [
                    'created_by' => \Auth::user()->creatorId(),
                ]
            )->get();
            $month      = [
                '01' => 'JAN',
                '02' => 'FEB',
                '03' => 'MAR',
                '04' => 'APR',
                '05' => 'MAY',
                '06' => 'JUN',
                '07' => 'JUL',
                '08' => 'AUG',
                '09' => 'SEP',
                '10' => 'OCT',
                '11' => 'NOV',
                '12' => 'DEC',
            ];
            $year       = [
                '2020' => '2020',
                '2021' => '2021',
                '2022' => '2022',
                '2023' => '2023',
                '2024' => '2024',
                '2025' => '2025',
                '2026' => '2026',
                '2027' => '2027',
                '2028' => '2028',
                '2029' => '2029',
                '2030' => '2030',
            ];


            return view('payslip.index', compact('employees', 'month', 'year'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function create()
    {
        //
    }






    

    public function store(Request $request)
    {
        $validator = \Validator::make(
            $request->all(),
            [
                'month' => 'required',
                'year' => 'required',

            ]
        );

        if ($validator->fails()) {
            $messages = $validator->getMessageBag();

            return redirect()->back()->with('error', $messages->first());
        }

        $month              = $request->month;
        $year               = $request->year;
        $formate_month_year = $year . '-' . $month;
     
        $validatePaysilp    = PaySlip::where('salary_month', '=', $formate_month_year)->get()->toarray();
      
        if (empty($validatePaysilp)) {


            // $employees = Employee::where(
            //     [
            //         'created_by' => Auth::user()->id,
            //     ]
            // )->get();

            $employees = Employee::all();
            // dd($employees);
            foreach ($employees as $employee) {

                $payslipEmployee                       = new PaySlip();
                $payslipEmployee->employee_id          = $employee->id;
                $payslipEmployee->net_payble           = $employee->get_net_salary();
                $payslipEmployee->salary_month         = $formate_month_year;
                $payslipEmployee->status               = 0;
                $payslipEmployee->basic_salary         = !empty($employee->salary) ? $employee->salary : 0;
                $payslipEmployee->allowance            = Employee::allowance($employee->id);
                $payslipEmployee->commission           = Employee::commission($employee->id);
                $payslipEmployee->loan                 = Employee::loan($employee->id);
                $payslipEmployee->saturation_deduction = Employee::saturation_deduction($employee->id);
                $payslipEmployee->other_payment        = Employee::other_payment($employee->id);
                $payslipEmployee->overtime             = Employee::overtime($employee->id);
                $payslipEmployee->created_by           = Auth::user()->id;

                $payslipEmployee->save();
            }

            return redirect()->route('payslip.index')->with('success', __('Payslip Payment successfully created.'));
        } else {
            return redirect()->route('payslip.index')->with('error', __('Payslip Payment Already created.'));
        }
    }













    public function showemployee($paySlip)
    {
        $payslip = PaySlip::find($paySlip);


        return view('payslip.show', compact('payslip'));
    }


    public function search_json(Request $request)
    {

        $formate_month_year = $request->datePicker;
        $validatePaysilp    = PaySlip::where('salary_month', '=', $formate_month_year)->get()->toarray();
        if (empty($validatePaysilp)) {
            return;
        } else {
            $paylip_employee = Employee::join(
                'pay_slips',
                function ($join) use ($formate_month_year) {
                    $join->on('employees.id', '=', 'pay_slips.employee_id');
                    $join->on('pay_slips.salary_month', '=', \DB::raw("'" . $formate_month_year . "'"));
                }
            )->leftjoin('payment_types', 'payment_types.id', '=', 'employees.salary_type')->select(
                [
                    'employees.id',
                    'employees.name',
                    'payment_types.name as payroll_type',
                    'employees.salary',
                    'pay_slips.id as pay_slip_id',
                    'pay_slips.status',
                    'employees.user_id',
                ]
            )->get();
            $data            = [];
            foreach ($paylip_employee as $employee) {
                if (Auth::user()->type == 'employee') {
                    if (Auth::user()->id == $employee->user_id) {
                        $tmp   = [];
                        $tmp[] = $employee->id;
                        $tmp[] = $employee->name;
                        $tmp[] = $employee->payroll_type;
                        $tmp[] = $employee->pay_slip_id;
                        $tmp[] = $employee->salary;
                        $tmp[] = $employee->get_net_salary();
                        if ($employee->status == 1) {
                            $tmp[] = 'paid';
                        } else {
                            $tmp[] = 'unpaid';
                        }
                        $data[] = $tmp;
                    }
                } else {
                    $tmp   = [];
                    $tmp[] = $employee->id;
                    $tmp[] = Auth::user()->employeeIdFormat($employee->id);
                    $tmp[] = $employee->name;
                    $tmp[] = $employee->payroll_type;
                    $tmp[] = $employee->salary;
                    $tmp[] = $employee->get_net_salary();
                    if ($employee->status == 1) {
                        $tmp[] = 'Paid';
                    } else {
                        $tmp[] = 'UnPaid';
                    }
                    $tmp[]  = $employee->pay_slip_id;
                    $data[] = $tmp;
                }
            }

            return $data;
        }
    }

    public function paysalary($id, $date)
    {
        $employeePayslip         = PaySlip::where('employee_id', '=', $id)->where('salary_month', '=', $date)->first();
        $employeePayslip->status = 1;
        $employeePayslip->save();

        return redirect()->route('payslip.index')->with('success', __('Payslip Payment successfully.'));
    }

    public function bulk_pay_create($date)
    {
        $Employees       = PaySlip::where('salary_month', $date)->get();
        $unpaidEmployees = PaySlip::where('salary_month', $date)->where('status', '=', 0)->get();

        return view('payslip.bulkcreate', compact('Employees', 'unpaidEmployees', 'date'));
    }

    public function bulkpayment(Request $request, $date)
    {

        $unpaidEmployees = PaySlip::where('salary_month', $date)->where('status', '=', 0)->get();
        foreach ($unpaidEmployees as $employee) {
            $employee->status = 1;
            $employee->save();
        }

        return redirect()->route('payslip.index')->with('success', __('Payslip Bulk Payment successfully.'));
    }

    public function employeepayslip()
    {
        $employees = Employee::where(
            [
                'user_id' => Auth::user()->id,
            ]
        )->first();

        $payslip = PaySlip::where('employee_id', '=', $employees->id)->get();

        return view('payslip.employeepayslip', compact('payslip'));
    }


    public function pdf($id)
    {
        $payslip  = PaySlip::find($id);
        $employee = Employee::find($payslip->employee_id);

        return view('payslip.pdf', compact('payslip', 'employee'));
    }
}
