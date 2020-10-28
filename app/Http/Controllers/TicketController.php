<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Ticket;
use App\TicketReply;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    public function index()
    {

        if(\Auth::user()->can('Manage Ticket'))
        {
            $user = Auth::user();
            if($user->type == 'employee')
            {
                $tickets = Ticket::where('employee_id', '=', \Auth::user()->id)->get();

            }
            else
            {
                $tickets = Ticket::select('tickets.*')->join('users', 'tickets.created_by', '=', 'users.id')->where('users.created_by', '=', \Auth::user()->creatorId())->orWhere('tickets.created_by', \Auth::user()->creatorId())->get();
            }

            return view('ticket.index', compact('tickets'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function create()
    {
        if(\Auth::user()->can('Create Ticket'))
        {
            $employees = User::where('type', '=', 'employee')->get()->pluck('name', 'id');

            return view('ticket.create', compact('employees'));
        }
        else
        {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    public function store(Request $request)
    {
        if(\Auth::user()->can('Create Ticket'))
        {

            $validator = \Validator::make(
                $request->all(), [
                                   'priority' => 'required',
                                   'end_date' => 'required',
                               ]
            );
            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $rand          = date('hms');
            $ticket        = new Ticket();
            $ticket->title = $request->title;
            if(Auth::user()->type == "employee")
            {
                $ticket->employee_id = \Auth::user()->id;
            }
            else
            {
                $ticket->employee_id = $request->employee_id;
            }

            $ticket->priority    = $request->priority;
            $ticket->end_date    = $request->end_date;
            $ticket->ticket_code = $rand;
            $ticket->description = $request->description;

            if(Auth::user()->type == "employee")
            {
                $employee           = Employee::where('user_id', '=', Auth::user()->id)->first();
                $user               = User::where('id', '=', $employee->user_id)->first();
                $ticket->created_by = $user->id;
            }
            else
            {
                $ticket->created_by = \Auth::user()->creatorId();
            }
            $ticket->status = 'open';
            $ticket->save();

            return redirect()->route('ticket.index')->with('success', __('Ticket  successfully created.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function show(Ticket $ticket)
    {
        return redirect()->route('ticket.index');
    }

    public function edit($ticket)
    {
        $ticket = Ticket::find($ticket);
        if(\Auth::user()->can('Edit Ticket'))
        {
            $employees = User::where('type', '=', 'employee')->get()->pluck('name', 'id');

            return view('ticket.edit', compact('ticket', 'employees'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function update(Request $request, $ticket)
    {

        $ticket = Ticket::find($ticket);
        if(\Auth::user()->can('Edit Ticket'))
        {
            $validator = \Validator::make(
                $request->all(), [
                                   'priority' => 'required',
                                   'end_date' => 'required',
                               ]
            );
            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }


            $ticket->title = $request->title;
            if(Auth::user()->type == "employee")
            {
                $ticket->employee_id = Auth::user()->id;
            }
            else
            {
                $ticket->employee_id = $request->employee_id;
            }
            $ticket->priority    = $request->priority;
            $ticket->end_date    = $request->end_date;
            $ticket->description = $request->description;
            $ticket->status      = $request->status;
            $ticket->save();

            return redirect()->route('ticket.reply', compact('ticket'))->with('success', __('Ticket successfully updated.'));

        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function destroy(Ticket $ticket)
    {
        if(\Auth::user()->can('Delete Ticket'))
        {
            if($ticket->created_by == \Auth::user()->creatorId())
            {
                $ticket->delete();
                $ticketId = TicketReply::select('id')->where('ticket_id', $ticket->id)->get()->pluck('id');
                TicketReply::whereIn('id', $ticketId)->delete();

                return redirect()->route('ticket.index')->with('success', __('Ticket successfully deleted.'));
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

    public function reply($ticket)
    {
        $ticketreply = TicketReply::where('ticket_id', '=', $ticket)->orderBy('id', 'DESC')->get();
        $ticket      = Ticket::find($ticket);
        if(\Auth::user()->type == 'employee')
        {
            $ticketreplyRead = TicketReply:: where('ticket_id', $ticket->id)->where('created_by', '!=', \Auth::user()->id)->update(['is_read' => '1']);
        }
        else
        {
            $ticketreplyRead = TicketReply:: where('ticket_id', $ticket->id)->where('created_by', '!=', \Auth::user()->creatorId())->update(['is_read' => '1']);
        }


        return view('ticket.reply', compact('ticket', 'ticketreply'));
    }

    public function changereply(Request $request)
    {

        $validator = \Validator::make(
            $request->all(), [
                               'description' => 'required',
                           ]
        );
        if($validator->fails())
        {
            $messages = $validator->getMessageBag();

            return redirect()->back()->with('error', $messages->first());
        }

        $ticket = Ticket::find($request->ticket_id);

        $ticket_reply              = new TicketReply();
        $ticket_reply->ticket_id   = $request->ticket_id;
        $ticket_reply->employee_id = $ticket->employee_id;
        $ticket_reply->description = $request->description;
        if(\Auth::user()->type == 'employee')
        {
            $ticket_reply->created_by = Auth::user()->id;
        }
        else
        {
            $ticket_reply->created_by = Auth::user()->creatorId();
        }

        $ticket_reply->save();

        return redirect()->route('ticket.reply', $ticket_reply->ticket_id)->with('success', __('Ticket Reply successfully Send.'));
    }
}
