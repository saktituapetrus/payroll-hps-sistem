<?php

namespace App\Http\Controllers;

use App\AttendanceEmployee;
use App\User;
use App\Utility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceEmployeeController extends Controller
{
    public function index(Request $request)
    {
        if(\Auth::user()->can('Manage Attendance'))
        {
            if(\Auth::user()->type == 'employee')
            {
                $emp                = \Auth::user()->id;
                $attendanceEmployee = AttendanceEmployee::where('employee_id', $emp);

                if(!empty($request->date))
                {
                    $date      = explode('-', $request->date);
                    $startdate = $date[0] . '-' . $date[1] . '-' . $date[2];
                    $enddate   = $date[3] . '-' . $date[4] . '-' . $date[5];
                    $attendanceEmployee->whereBetween(
                        'date', [
                                  $startdate,
                                  $enddate,
                              ]
                    );
                }
                $attendanceEmployee = $attendanceEmployee->get();

            }
            else
            {
                $emp                = \Auth::user()->userEmployee();
                $attendanceEmployee = AttendanceEmployee::whereIn('employee_id', $emp);

                if(!empty($request->date))
                {
                    $date      = explode('-', $request->date);
                    $startdate = $date[0] . '-' . $date[1] . '-' . $date[2];
                    $enddate   = $date[3] . '-' . $date[4] . '-' . $date[5];
                    $attendanceEmployee->whereBetween(
                        'date', [
                                  $startdate,
                                  $enddate,
                              ]
                    );
                }
                $attendanceEmployee = $attendanceEmployee->get();
            }

            return view('attendance.index', compact('attendanceEmployee'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function create()
    {
        if(\Auth::user()->can('Create Attendance'))
        {
            $employees = User::where('created_by', '=', Auth::user()->creatorId())->where('type', '=', "employee")->get()->pluck('name', 'id');

            return view('attendance.create', compact('employees'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }


    }

    public function store(Request $request)
    {
        if(\Auth::user()->can('Create Attendance'))
        {
            $validator = \Validator::make(
                $request->all(), [
                                   'employee_id' => 'required',
                                   'date' => 'required',
                                   'clock_in' => 'required',
                                   'clock_out' => 'required',
                               ]
            );
            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $startTime  = Utility::getValByName('company_start_time');
            $endTime    = Utility::getValByName('company_end_time');
            $attendance = AttendanceEmployee::where('employee_id', '=', $request->employee_id)->where('date', '=', $request->date)->where('clock_out', '=', '00:00:00')->get()->toArray();
            if($attendance)
            {
                return redirect()->route('attendanceemployee.index')->with('error', __('Employee Attendance Already Created.'));
            }
            else
            {
                $date             = date("Y-m-d");
                $totalLateSeconds = strtotime($request->clock_in) - strtotime($date . $startTime);

                $hours = floor($totalLateSeconds / 3600);
                $mins  = floor($totalLateSeconds / 60 % 60);
                $secs  = floor($totalLateSeconds % 60);
                $late  = sprintf('%02d:%02d:%02d', $hours, $mins, $secs);

                //early Leaving
                $totalEarlyLeavingSeconds = strtotime($date . $endTime) - strtotime($request->clock_out);
                $hours                    = floor($totalEarlyLeavingSeconds / 3600);
                $mins                     = floor($totalEarlyLeavingSeconds / 60 % 60);
                $secs                     = floor($totalEarlyLeavingSeconds % 60);
                $earlyLeaving             = sprintf('%02d:%02d:%02d', $hours, $mins, $secs);


                if(strtotime($request->clock_out) > strtotime($date . $endTime))
                {
                    //Overtime
                    $totalOvertimeSeconds = strtotime($request->clock_out) - strtotime($date . $endTime);
                    $hours                = floor($totalOvertimeSeconds / 3600);
                    $mins                 = floor($totalOvertimeSeconds / 60 % 60);
                    $secs                 = floor($totalOvertimeSeconds % 60);
                    $overtime             = sprintf('%02d:%02d:%02d', $hours, $mins, $secs);
                }
                else
                {
                    $overtime = '';
                }
                $employeeAttendance                = new AttendanceEmployee();
                $employeeAttendance->employee_id   = $request->employee_id;
                $employeeAttendance->date          = $request->date;
                $employeeAttendance->status        = 'Present';
                $employeeAttendance->clock_in      = $request->clock_in . ':00';
                $employeeAttendance->clock_out     = $request->clock_out . ':00';
                $employeeAttendance->late          = $late;
                $employeeAttendance->early_leaving = $earlyLeaving;
                $employeeAttendance->overtime      = $overtime;
                $employeeAttendance->total_rest    = '';
                $employeeAttendance->created_by    = Auth::user()->creatorId();
                $employeeAttendance->save();

                return redirect()->route('attendanceemployee.index')->with('success', __('Employee attendance successfully created.'));
            }
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }


    }

    public function edit($id)
    {

        if(\Auth::user()->can('Edit Attendance'))
        {
            $attendanceEmployee = AttendanceEmployee::where('id', $id)->first();
            $employees          = User::where('created_by', '=', Auth::user()->creatorId())->where('type', '=', "employee")->get()->pluck('name', 'id');

            return view('attendance.edit', compact('attendanceEmployee', 'employees'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function update(Request $request, $id)
    {
        $startTime = Utility::getValByName('company_start_time');
        $endTime   = Utility::getValByName('company_end_time');
        if(Auth::user()->type == 'employee')
        {

            $date = date("Y-m-d");
            $time = date("H:i:s");

            //early Leaving
            $totalEarlyLeavingSeconds = strtotime($date . $endTime) - time();
            $hours                    = floor($totalEarlyLeavingSeconds / 3600);
            $mins                     = floor($totalEarlyLeavingSeconds / 60 % 60);
            $secs                     = floor($totalEarlyLeavingSeconds % 60);
            $earlyLeaving             = sprintf('%02d:%02d:%02d', $hours, $mins, $secs);

            if(time() > strtotime($date . $endTime))
            {
                //Overtime
                $totalOvertimeSeconds = time() - strtotime($date . $endTime);
                $hours                = floor($totalOvertimeSeconds / 3600);
                $mins                 = floor($totalOvertimeSeconds / 60 % 60);
                $secs                 = floor($totalOvertimeSeconds % 60);
                $overtime             = sprintf('%02d:%02d:%02d', $hours, $mins, $secs);
            }
            else
            {
                $overtime = '';
            }

            $attendanceEmployee                = AttendanceEmployee::find($id);
            $attendanceEmployee->clock_out     = $time;
            $attendanceEmployee->early_leaving = $earlyLeaving;
            $attendanceEmployee->overtime      = $overtime;
            $attendanceEmployee->save();

            return redirect()->route('home')->with('success', __('Employee successfully clock Out.'));
        }
        else
        {
            $date = date("Y-m-d");
            //late
            $totalLateSeconds = strtotime($request->clock_in) - strtotime($date . $startTime);

            $hours = floor($totalLateSeconds / 3600);
            $mins  = floor($totalLateSeconds / 60 % 60);
            $secs  = floor($totalLateSeconds % 60);
            $late  = sprintf('%02d:%02d:%02d', $hours, $mins, $secs);

            //early Leaving
            $totalEarlyLeavingSeconds = strtotime($date . $endTime) - strtotime($request->clock_out);
            $hours                    = floor($totalEarlyLeavingSeconds / 3600);
            $mins                     = floor($totalEarlyLeavingSeconds / 60 % 60);
            $secs                     = floor($totalEarlyLeavingSeconds % 60);
            $earlyLeaving             = sprintf('%02d:%02d:%02d', $hours, $mins, $secs);


            if(strtotime($request->clock_out) > strtotime($date . $endTime))
            {
                //Overtime
                $totalOvertimeSeconds = strtotime($request->clock_out) - strtotime($date . $endTime);
                $hours                = floor($totalOvertimeSeconds / 3600);
                $mins                 = floor($totalOvertimeSeconds / 60 % 60);
                $secs                 = floor($totalOvertimeSeconds % 60);
                $overtime             = sprintf('%02d:%02d:%02d', $hours, $mins, $secs);
            }
            else
            {
                $overtime = '';
            }

            $attendanceEmployee                = AttendanceEmployee::find($id);
            $attendanceEmployee->employee_id   = $request->employee_id;
            $attendanceEmployee->date          = $request->date;
            $attendanceEmployee->clock_in      = $request->clock_in;
            $attendanceEmployee->clock_out     = $request->clock_out;
            $attendanceEmployee->late          = $late;
            $attendanceEmployee->early_leaving = $earlyLeaving;
            $attendanceEmployee->overtime      = $overtime;
            $attendanceEmployee->total_rest    = '';

            $attendanceEmployee->save();

            return redirect()->route('attendanceemployee.index')->with('success', __('Employee attendance successfully updated.'));
        }
    }

    public function destroy($id)
    {
        if(\Auth::user()->can('Delete Attendance'))
        {
            $attendance = AttendanceEmployee::where('id', $id)->first();

            if($attendance->created_by == \Auth::user()->creatorId())
            {
                $attendance->delete();

                return redirect()->route('attendanceemployee.index')->with('success', __('Attendance successfully deleted.'));
            }
            else
            {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function attendance(Request $request)
    {
        $startTime = Utility::getValByName('company_start_time');
        $endTime   = Utility::getValByName('company_end_time');

        $attendance = AttendanceEmployee::orderBy('id', 'desc')->where('employee_id', '=', \Auth::user()->id)->where('clock_out', '=', '00:00:00')->first();

        if($attendance != null)
        {
            $attendance            = AttendanceEmployee::find($attendance->id);
            $attendance->clock_out = $endTime;
            $attendance->save();
        }


        $date = date("Y-m-d");
        $time = date("H:i:s");

        //late
        $totalLateSeconds = time() - strtotime($date . $startTime);
        $hours            = floor($totalLateSeconds / 3600);
        $mins             = floor($totalLateSeconds / 60 % 60);
        $secs             = floor($totalLateSeconds % 60);
        $late             = sprintf('%02d:%02d:%02d', $hours, $mins, $secs);

        $checkDb = AttendanceEmployee::where('employee_id', '=', \Auth::user()->id)->get()->toArray();


        if(empty($checkDb))
        {
            $employeeAttendance                = new AttendanceEmployee();
            $employeeAttendance->employee_id   = Auth::user()->id;
            $employeeAttendance->date          = $date;
            $employeeAttendance->status        = 'Present';
            $employeeAttendance->clock_in      = $time;
            $employeeAttendance->clock_out     = '';
            $employeeAttendance->late          = $late;
            $employeeAttendance->early_leaving = '';
            $employeeAttendance->overtime      = '';
            $employeeAttendance->total_rest    = '';
            $employeeAttendance->created_by    = \Auth::user()->id;

            $employeeAttendance->save();

            return redirect()->route('home')->with('success', __('Employee Successfully Clock In.'));
        }
        foreach($checkDb as $check)
        {


            $employeeAttendance                = new AttendanceEmployee();
            $employeeAttendance->employee_id   = Auth::user()->id;
            $employeeAttendance->date          = $date;
            $employeeAttendance->status        = 'Present';
            $employeeAttendance->clock_in      = $time;
            $employeeAttendance->clock_out     = '';
            $employeeAttendance->late          = $late;
            $employeeAttendance->early_leaving = '';
            $employeeAttendance->overtime      = '';
            $employeeAttendance->total_rest    = '';
            $employeeAttendance->created_by    = \Auth::user()->id;

            $employeeAttendance->save();

            return redirect()->route('home')->with('success', __('Employee Successfully Clock In.'));

        }

    }

}
