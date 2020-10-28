<?php

namespace App\Http\Controllers;

use File;

use App\Branch;
use App\Department;
use App\Designation;
use App\Document;
use App\Employee;
use App\EmployeeDocument;
use App\Plan;
use App\User;
use App\Utility;
use App\Exports\EmployeeExport;
use App\Imports\EmployeeImport;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

//use Faker\Provider\File;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (\Auth::user()->can('Manage Employee')) {
            if (Auth::user()->type == 'employee') {
                $employees = Employee::where('user_id', '=', Auth::user()->id)->get();
            } else {
                $employees = Employee::where('created_by', \Auth::user()->creatorId())->get();
            }

            return view('employee.index', compact('employees'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function create()
    {
        if (\Auth::user()->can('Create Employee')) {
            $company_settings = Utility::settings();
            $documents        = Document::where('created_by', \Auth::user()->creatorId())->get();
            $branches         = Branch::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $departments      = Department::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $designations     = Designation::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $employees        = User::where('created_by', \Auth::user()->creatorId())->get();
            $employeesId      = \Auth::user()->employeeIdFormat($this->employeeNumber());

            return view('employee.create', compact('employees', 'employeesId', 'departments', 'designations', 'documents', 'branches', 'company_settings'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function store(Request $request)
    {
        if (\Auth::user()->can('Create Employee')) {
            $validator = \Validator::make(
                $request->all(),
                [
                    'name' => 'required',
                    'dob' => 'required',
                    'gender' => 'required',
                    'phone' => 'required',
                    'address' => 'required',
                    'email' => 'required',
                    'password' => 'required',
                    'department_id' => 'required',
                    'designation_id' => 'required',
                    'account_holder_name' => 'required',
                    'account_number' => 'required |numeric',
                    'bank_name' => 'required',
                    'branch_location' => 'required',
                    'bank_identifier_code' => 'required',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $objUser       = \Auth::user()->creatorId();
            $user          = User::find($objUser);
            $totalEmployee = $user->countEmployees(); {

                $user = User::create(
                    [
                        'name' => $request['name'],
                        'email' => $request['email'],
                        'password' => Hash::make($request['password']),
                        'type' => 'employee',
                        'lang' => 'en',
                        'created_by' => \Auth::user()->creatorId(),
                    ]
                );
                $user->save();
                $user->assignRole('Employee');

                if (!empty($request->document) && !is_null($request->document)) {
                    $document_implode = implode(',', array_keys($request->document));
                } else {
                    $document_implode = null;
                }


                $employee = Employee::create(
                    [
                        'user_id' => $user->id,
                        'name' => $request['name'],
                        'dob' => $request['dob'],
                        'gender' => $request['gender'],
                        'phone' => $request['phone'],
                        'address' => $request['address'],
                        'email' => $request['email'],
                        'password' => Hash::make($request['password']),
                        'employee_id' => $this->employeeNumber(),
                        'branch_id' => $request['branch_id'],
                        'department_id' => $request['department_id'],
                        'designation_id' => $request['designation_id'],
                        'company_doj' => $request['company_doj'],
                        'documents' => $document_implode,
                        'account_holder_name' => $request['account_holder_name'],
                        'account_number' => $request['account_number'],
                        'bank_name' => $request['bank_name'],
                        'bank_identifier_code' => $request['bank_identifier_code'],
                        'branch_location' => $request['branch_location'],
                        'tax_payer_id' => $request['tax_payer_id'],
                        'created_by' => \Auth::user()->creatorId(),
                    ]
                );

                if ($request->hasFile('document')) {
                    foreach ($request->document as $key => $document) {

                        $filenameWithExt = $request->file('document')[$key]->getClientOriginalName();
                        $filename        = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                        $extension       = $request->file('document')[$key]->getClientOriginalExtension();
                        $fileNameToStore = $filename . '_' . time() . '.' . $extension;
                        $dir             = storage_path('app/public/document/');
                        $image_path      = $dir . $filenameWithExt;

                        if (File::exists($image_path)) {
                            File::delete($image_path);
                        }

                        if (!file_exists($dir)) {
                            mkdir($dir, 0777, true);
                        }
                        $path              = $request->file('document')[$key]->storeAs('public/document/', $fileNameToStore);
                        $employee_document = EmployeeDocument::create(
                            [
                                'employee_id' => $employee['employee_id'],
                                'document_id' => $key,
                                'document_value' => $fileNameToStore,
                                'created_by' => Auth::user()->id,
                            ]
                        );
                        $employee_document->save();
                    }
                }
            } {
                return redirect()->back()->with('error', __('Your employee limit is over, Please upgrade plan.'));
            }

            return redirect()->route('employee.index')->with('success', 'Employee successfully created.');
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function edit($id)
    {
        if (\Auth::user()->can('Edit Employee')) {
            $documents    = Document::where('created_by', \Auth::user()->creatorId())->get();
            $branches     = Branch::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $departments  = Department::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $designations = Designation::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $employee     = Employee::find($id);
            $employeesId  = \Auth::user()->employeeIdFormat($employee->employee_id);

            return view('employee.edit', compact('employee', 'employeesId', 'branches', 'departments', 'designations', 'documents'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function update(Request $request, $id)
    {

        if (\Auth::user()->can('Edit Employee')) {
            $validator = \Validator::make(
                $request->all(),
                [
                    'name' => 'required',
                    'dob' => 'required',
                    'gender' => 'required',
                    'phone' => 'required|numeric',
                    'address' => 'required',
                    'department_id' => 'required',
                    'designation_id' => 'required',
                    'account_holder_name' => 'required',
                    'account_number' => 'required |numeric',
                    'bank_name' => 'required',
                    'branch_location' => 'required',
                    'bank_identifier_code' => 'required',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $employee = Employee::findOrFail($id);
            if ($request->document) {
                foreach ($request->document as $key => $document) {
                    if (!empty($document)) {
                        $filenameWithExt = $request->file('document')[$key]->getClientOriginalName();
                        $filename        = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                        $extension       = $request->file('document')[$key]->getClientOriginalExtension();
                        $fileNameToStore = $filename . '_' . time() . '.' . $extension;
                        $dir             = storage_path('app/public/document/');
                        $image_path      = $dir . $filenameWithExt;

                        if (File::exists($image_path)) {
                            File::delete($image_path);
                        }
                        if (!file_exists($dir)) {
                            mkdir($dir, 0777, true);
                        }
                        $path = $request->file('document')[$key]->storeAs('public/document/', $fileNameToStore);

                        $employee_document = EmployeeDocument::create(
                            [
                                'document_id' => $key,
                                'document_value' => $fileNameToStore,
                                'created_by' => Auth::user()->id,
                            ]
                        );
                        $employee_document->save();
                    }
                }
            }

            $employee = Employee::findOrFail($id);
            $input    = $request->all();
            $employee->fill($input)->save();
            if ($request->salary) {
                return redirect()->route('setsalary.index')->with('success', 'Employee successfully updated.');
            }

            if (\Auth::user()->type != 'employee') {
                return redirect()->route('employee.index')->with('success', 'Employee successfully updated.');
            } else {
                return redirect()->route('employee.show', $employee->id)->with('success', 'Employee successfully updated.');
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function destroy($id)
    {

        if (Auth::user()->can('Delete Employee')) {
            $employee      = Employee::findOrFail($id);
            $user          = User::where('id', '=', $employee->user_id)->first();
            $emp_documents = EmployeeDocument::where('employee_id', $employee->employee_id)->get();
            $employee->delete();
            $user->delete();
            $dir = storage_path('app/public/document/');
            foreach ($emp_documents as $emp_document) {
                $emp_document->delete();
                unlink($dir . $emp_document->document_value);
            }

            return redirect()->route('employee.index')->with('success', 'Employee successfully deleted.');
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function show($id)
    {

        $documents    = Document::where('created_by', \Auth::user()->creatorId())->get();
        $branches     = Branch::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
        $departments  = Department::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
        $designations = Designation::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
        $employee     = Employee::find($id);
        $employeesId  = \Auth::user()->employeeIdFormat($employee->employee_id);

        return view('employee.show', compact('employee', 'employeesId', 'branches', 'departments', 'designations', 'documents'));
    }

    public function json(Request $request)
    {
        $designations = Designation::where('department_id', $request->department_id)->get()->pluck('name', 'id')->toArray();

        return response()->json($designations);
    }

    function employeeNumber()
    {
        $latest = Employee::where('created_by', '=', \Auth::user()->creatorId())->latest()->first();
        if (!$latest) {
            return 1;
        }

        return $latest->employee_id + 1;
    }


    /**
     * Author: faaptech
     * Date: 28/04/2020
     * Description: Handle import data employees
     */
    public function import(Request $request)
    {
        // Parse excel file from request to array
        $data = Excel::toArray(new EmployeeImport, $request->file('file'));
        // Looping $data with anonymous function and callback two paramaters
        collect(head($data))->each(function ($row, $key) {
            // Check if password have encrypt, then continue
            $valCheckPassword = $row['password'][0] . $row['password'][1] . $row['password'][2] . $row['password'][3];
            $password = '';

            if ($valCheckPassword == '$2y$') {
                $password = User::where('id', $row['user_id'])->first()->password;
            } else {
                $password = \Hash::make($row['password']);
            }

            // Insert or update database users
            $userMathThese = [
                'id' => $row['user_id'],
                'email' => $row['email']
            ];

            $user = User::updateOrCreate($userMathThese, [
                'name' => $row['name'] ? $row['name'] : '',
                'email' => $row['email'] ? $row['email'] : '',
                'password' =>  $password,
                'type' => 'employee',
                'lang' => 'en',
                'created_by' => \Auth::user()->creatorId(),
            ]);

            $user->assignRole('Employee');

            // Insert or update database employees
            $employeeMathThese = [
                'id' => $row['id'],
                'user_id' => $row['user_id']
            ];

            Employee::updateOrCreate($employeeMathThese, [
                'user_id' => $row['user_id'] ? $row['user_id'] : $user->id,
                'name' => $row['name'] ? $row['name'] : '',
                'dob' => $row['dob'] ? $row['dob'] : '',
                'gender' => $row['gender'] ? $row['gender'] : '',
                'phone' => $row['phone'] ? $row['phone'] : '',
                'address' => $row['address'] ? $row['address'] : '',
                'email' => $row['email'] ? $row['email'] : '',
                'password' =>  $password,
                'employee_id' => $row['employee_id'] ? $row['employee_id'] : $this->employeeNumber(),
                'branch_id' => $row['branch_id'] ? $row['branch_id'] : '',
                'department_id' => $row['department_id'] ? $row['department_id'] : '',
                'designation_id' => $row['designation_id'] ? $row['designation_id'] : '',
                'company_doj' => $row['company_doj'] ? $row['company_doj'] : '',
                'documents' => $row['documents'] ? $row['documents'] : '',
                'account_holder_name' => $row['account_holder_name'] ? $row['account_holder_name'] : '',
                'account_number' => $row['account_number'] ? $row['account_number'] : '',
                'bank_name' => $row['bank_name'] ? $row['bank_name'] : '',
                'bank_identifier_code' => $row['bank_identifier_code'] ? $row['bank_identifier_code'] : '',
                'branch_location' => $row['branch_location'] ? $row['branch_location'] : '',
                'tax_payer_id' => $row['tax_payer_id'] ? $row['tax_payer_id'] : '',
                'salary_type' => $row['salary_type'] ? $row['salary_type'] : '',
                'salary' => $row['salary'] ? $row['salary'] : '',
                'created_by' => \Auth::user()->creatorId(),
            ]);
        });

        return back();
    }

    /**
     * Author: faaptech
     * Date: 28/04/2020
     * Description: Handle export data employees
     */
    public function export()
    {
        return Excel::download(new EmployeeExport, 'employee.xlsx');
    }
}
