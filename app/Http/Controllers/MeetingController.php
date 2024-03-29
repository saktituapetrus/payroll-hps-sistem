<?php

namespace App\Http\Controllers;

use App\Branch;
use App\Department;
use App\Employee;
use App\Meeting;
use App\MeetingEmployee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MeetingController extends Controller
{
    public function index()
    {
        if(\Auth::user()->can('Manage Meeting'))
        {
            $employees = Employee::get();
            if(Auth::user()->type == 'employee')
            {
                $current_employee = Employee::where('user_id', '=', \Auth::user()->id)->first();
                $meetings         = Meeting::orderBy('meetings.id', 'desc')->take(5)->leftjoin('meeting_employees', 'meetings.id', '=', 'meeting_employees.meeting_id')->where('meeting_employees.employee_id', '=', $current_employee->id)->get();
            }
            else
            {
                $meetings = Meeting::where('created_by', '=', \Auth::user()->creatorId())->get();
            }

            return view('meeting.index', compact('meetings', 'employees'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function create()
    {
        if(\Auth::user()->can('Create Meeting'))
        {
            if(Auth::user()->type == 'employee')
            {
                $employees = Employee::where('user_id', '!=', \Auth::user()->id)->get()->pluck('name', 'id');
            }
            else
            {
                $branch      = Branch::where('created_by', '=', \Auth::user()->creatorId())->get();
                $departments = Department::where('created_by', '=', Auth::user()->creatorId())->get();
                $employees   = Employee::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            }

            return view('meeting.create', compact('employees', 'departments', 'branch'));
        }
        else
        {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    public function store(Request $request)
    {

        $validator = \Validator::make(
            $request->all(), [
                               'branch_id' => 'required',
                               'department_id' => 'required',
                               'employee_id' => 'required',
                               'department_id' => 'required',
                               'title' => 'required',
                               'date' => 'required',
                               'time' => 'required',
                           ]
        );
        if($validator->fails())
        {
            $messages = $validator->getMessageBag();

            return redirect()->back()->with('error', $messages->first());
        }

        if(\Auth::user()->can('Create Meeting'))
        {
            $meeting                = new Meeting();
            $meeting->branch_id     = $request->branch_id;
            $meeting->department_id = json_encode($request->department_id);
            $meeting->employee_id   = json_encode($request->employee_id);
            $meeting->title         = $request->title;
            $meeting->date          = $request->date;
            $meeting->time          = $request->time;
            $meeting->note          = $request->note;
            $meeting->created_by    = \Auth::user()->creatorId();

            $meeting->save();

            if(in_array('0', $request->employee_id))
            {
                $departmentEmployee = Employee::whereIn('department_id', $request->department_id)->get()->pluck('id');
                $departmentEmployee = $departmentEmployee;
            }
            else
            {

                $departmentEmployee = $request->employee_id;
            }
            foreach($departmentEmployee as $employee)
            {
                $meetingEmployee              = new MeetingEmployee();
                $meetingEmployee->meeting_id  = $meeting->id;
                $meetingEmployee->employee_id = $employee;
                $meetingEmployee->created_by  = \Auth::user()->creatorId();
                $meetingEmployee->save();
            }

            return redirect()->route('meeting.index')->with('success', __('Meeting  successfully created.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function show(Meeting $meeting)
    {
        return redirect()->route('meeting.index');
    }

    public function edit($meeting)
    {
        if(\Auth::user()->can('Edit Meeting'))
        {
            $meeting = Meeting::find($meeting);
            if($meeting->created_by == Auth::user()->creatorId())
            {
                if(Auth::user()->type == 'employee')
                {
                    $employees = Employee::where('user_id', '!=', Auth::user()->id)->get()->pluck('name', 'id');
                }
                else
                {
                    $employees = Employee::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
                }

                return view('meeting.edit', compact('meeting', 'employees'));
            }
            else
            {
                return response()->json(['error' => __('Permission denied.')], 401);
            }
        }
        else
        {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    public function update(Request $request, Meeting $meeting)
    {
        if(\Auth::user()->can('Edit Meeting'))
        {
            $validator = \Validator::make(
                $request->all(), [

                                   'title' => 'required',
                                   'date' => 'required',
                                   'time' => 'required',
                               ]
            );
            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            if($meeting->created_by == \Auth::user()->creatorId())
            {
                $meeting->title = $request->title;
                $meeting->date  = $request->date;
                $meeting->time  = $request->time;
                $meeting->note  = $request->note;
                $meeting->save();

                return redirect()->route('meeting.index')->with('success', __('Meeting successfully updated.'));
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

    public function destroy(Meeting $meeting)
    {
        if(\Auth::user()->can('Delete Meeting'))
        {
            if($meeting->created_by == \Auth::user()->creatorId())
            {
                $meeting->delete();

                return redirect()->route('meeting.index')->with('success', __('Meeting successfully deleted.'));
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

    public function getdepartment(Request $request)
    {

        if($request->branch_id == 0)
        {
            $departments = Department::get()->pluck('name', 'id')->toArray();
        }
        else
        {
            $departments = Department::where('branch_id', $request->branch_id)->get()->pluck('name', 'id')->toArray();
        }

        return response()->json($departments);
    }

    public function getemployee(Request $request)
    {
        if(in_array('0', $request->department_id))
        {
            $employees = Employee::get()->pluck('name', 'id')->toArray();
        }
        else
        {
            $employees = Employee::whereIn('department_id', $request->department_id)->get()->pluck('name', 'id')->toArray();
        }

        return response()->json($employees);
    }
}
