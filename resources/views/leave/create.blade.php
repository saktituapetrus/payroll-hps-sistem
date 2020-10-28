{{Form::open(array('url'=>'leave','method'=>'post'))}}
<div class="card-body p-0">
    @if(\Auth::user()->type !='employee')
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    {{Form::label('employee_id',__('Employee'))}}
                    {{Form::select('employee_id',$employees,null,array('class'=>'form-control select2','id'=>'employee_id','placeholder'=>__('Select Employee')))}}
                </div>
            </div>
        </div>
    @endif
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {{Form::label('leave_type_id',__('Leave Type'))}}
                <select name="leave_type_id" id="leave_type_id" class="form-control select2">
                    @foreach($leavetypes as $leave)
                        <option value="{{ $leave->id }}">{{ $leave->title }} (<p class="float-right pr-5">{{ $leave->days }}</p>)</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                {{Form::label('start_date',__('Start Date'))}}
                {{Form::text('start_date',null,array('class'=>'form-control datepicker'))}}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{Form::label('end_date',__('End Date'))}}
                {{Form::text('end_date',null,array('class'=>'form-control datepicker'))}}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {{Form::label('leave_reason',__('Leave Reason'))}}
                {{Form::textarea('leave_reason',null,array('class'=>'form-control','placeholder'=>__('Leave Reason')))}}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {{Form::label('remark',__('Remark'))}}
                {{Form::textarea('remark',null,array('class'=>'form-control','placeholder'=>__('Leave Remark')))}}
            </div>
        </div>
    </div>

</div>
<div class="modal-footer pr-0">
    <button type="button" class="btn dark btn-outline" data-dismiss="modal">{{__('Cancel')}}</button>
    {{Form::submit(__('Create'),array('class'=>'btn btn-primary'))}}
</div>
{{Form::close()}}


