<?php

namespace App\Http\Controllers;

use App\TimeSheet;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TimeSheetController extends Controller
{

    public function index()
    {
        if(\Auth::user()->can('Manage TimeSheet'))
        {
            if(\Auth::user()->type == 'employee')
            {
                $timeSheets = TimeSheet::where('employee_id', \Auth::user()->id)->get();
            }
            else
            {
                $timeSheets = TimeSheet::where('created_by', \Auth::user()->creatorId())->get();
            }

            return view('timeSheet.index', compact('timeSheets'));
        }
        else
        {
            return redirect()->back()->with('error', 'Permission denied.');
        }
    }

    public function create()
    {

        if(\Auth::user()->can('Create TimeSheet'))
        {
            $employees = User::where('created_by', '=', \Auth::user()->creatorId())->where('type', '=', "employee")->get()->pluck('name', 'id');

            return view('timeSheet.create', compact('employees'));
        }
        else
        {
            return redirect()->back()->with('error', 'Permission denied.');
        }
    }

    public function store(Request $request)
    {
        if(\Auth::user()->can('Create TimeSheet'))
        {
            $timeSheet = new Timesheet();
            if(\Auth::user()->type == 'employee')
            {
                $timeSheet->employee_id = \Auth::user()->id;
            }
            else
            {
                $timeSheet->employee_id = $request->employee_id;
            }

            $timeSheet->date       = $request->date;
            $timeSheet->hours      = $request->hours;
            $timeSheet->remark     = $request->remark;
            $timeSheet->created_by = \Auth::user()->creatorId();
            $timeSheet->save();

            return redirect()->route('timesheet.index')->with('success', __('Timesheet successfully created.'));
        }
        else
        {
            return redirect()->back()->with('error', 'Permission denied.');
        }

    }

    public function show(TimeSheet $timeSheet)
    {
        //
    }

    public function edit(TimeSheet $timeSheet, $id)
    {

        if(\Auth::user()->can('Edit TimeSheet'))
        {
            $employees = User::where('created_by', '=', Auth::user()->creatorId())->where('type', '=', "employee")->get()->pluck('name', 'id');
            $timeSheet = Timesheet::find($id);

            return view('timeSheet.edit', compact('timeSheet', 'employees'));
        }
        else
        {
            return redirect()->back()->with('error', 'Permission denied.');
        }
    }

    public function update(Request $request, $id)
    {
        if(\Auth::user()->can('Edit TimeSheet'))
        {

            $timeSheet = Timesheet::find($id);
            if(\Auth::user()->type == 'employee')
            {
                $timeSheet->employee_id = \Auth::user()->id;
            }
            else
            {
                $timeSheet->employee_id = $request->employee_id;
            }

            $timeSheet->date   = $request->date;
            $timeSheet->hours  = $request->hours;
            $timeSheet->remark = $request->remark;
            $timeSheet->save();

            return redirect()->route('timesheet.index')->with('success', __('TimeSheet successfully updated.'));
        }
        else
        {
            return redirect()->back()->with('error', 'Permission denied.');
        }
    }

    public function destroy($id)
    {
        if(\Auth::user()->can('Delete TimeSheet'))
        {
            $timeSheet = Timesheet::find($id);
            $timeSheet->delete();

            return redirect()->route('timesheet.index')->with('success', __('TimeSheet successfully deleted.'));
        }
        else
        {
            return redirect()->back()->with('error', 'Permission denied.');
        }
    }
}
