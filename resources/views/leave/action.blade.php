{{Form::open(array('url'=>'leave/changeaction','method'=>'post'))}}
<div class="card-body p-0">
    <table class="table table-striped mb-0 dataTable no-footer">
        <tr role="row">
            <th>{{__('Employee')}}</th>
            <td>{{ $employee->name }}</td>
        </tr>
        <tr>
            <th>{{__('Leave Type ')}}</th>
            <td>{{ $leavetype->title }}</td>
        </tr>
        <tr>
            <th>{{__('Appplied On')}}</th>
            <td>{{\Auth::user()->dateFormat( $leave->applied_on) }}</td>
        </tr>
        <tr>
            <th>{{__('Start Date')}}</th>
            <td>{{ \Auth::user()->dateFormat($leave->start_date) }}</td>
        </tr>
        <tr>
            <th>{{__('End Date')}}</th>
            <td>{{ \Auth::user()->dateFormat($leave->end_date) }}</td>
        </tr>
        <tr>
            <th>{{__('Leave Reason')}}</th>
            <td>{{ $leave->leave_reason }}</td>
        </tr>
        <tr>
            <th>{{__('Status')}}</th>
            <td>{{ $leave->status }}</td>
        </tr>
        <input type="hidden" value="{{ $leave->id }}" name="leave_id">
    </table>
</div>
<div class="modal-footer pr-0">
    <input type="submit" class="btn btn-success" value="Approval" name="status">
    <input type="submit" class="btn btn-danger" value="Reject" name="status">
</div>
{{Form::close()}}
