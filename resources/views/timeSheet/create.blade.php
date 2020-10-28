{{ Form::open(array('route' => array('timesheet.store'))) }}
<div class="row">
    @if(\Auth::user()->type != 'employee')
        <div class="form-group col-md-12">
            {{ Form::label('employee_id', __('Employee')) }}
            {!! Form::select('employee_id', $employees, null,array('class' => 'form-control font-style select2','required'=>'required')) !!}
        </div>
    @endif
    <div class="form-group col-md-6">
        {{ Form::label('date', __('Date')) }}
        {{ Form::text('date', '', array('class' => 'form-control datepicker','required'=>'required')) }}
    </div>
    <div class="form-group col-md-6">
        {{ Form::label('hours', __('Hours')) }}
        {{ Form::number('hours', '', array('class' => 'form-control','required'=>'required','step'=>'0.01')) }}
    </div>
</div>
<div class="row">
    <div class="form-group  col-md-12">
        {{ Form::label('remark', __('Remark')) }}
        {!! Form::textarea('remark', null, ['class'=>'form-control','rows'=>'2']) !!}
    </div>
    <div class="col-md-12 text-right">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Cancel')}}</button>
        {{Form::submit(__('Create'),array('class'=>'btn btn-primary'))}}
    </div>
</div>
{{ Form::close() }}
