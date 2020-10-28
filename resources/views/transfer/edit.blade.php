{{Form::model($transfer,array('route' => array('transfer.update', $transfer->id), 'method' => 'PUT')) }}
<div class="card-body p-0">
    <div class="row">
        <div class="form-group col-lg-6 col-md-6 ">
            {{ Form::label('employee_id', __('Employee')) }}
            {{ Form::select('employee_id', $employees,null, array('class' => 'form-control select2','required'=>'required')) }}
        </div>
        <div class="form-group col-lg-6 col-md-6">
            {{Form::label('branch_id',__('Branch'))}}
            {{Form::select('branch_id',$branches,null,array('class'=>'form-control select2'))}}
        </div>
        <div class="form-group col-lg-6 col-md-6">
            {{Form::label('department_id',__('Department'))}}
            {{Form::select('department_id',$departments,null,array('class'=>'form-control select2'))}}
        </div>
        <div class="form-group col-lg-6 col-md-6">
            {{Form::label('transfer_date',__('Transfer Date'))}}
            {{Form::text('transfer_date',null,array('class'=>'form-control datepicker'))}}
        </div>
        <div class="form-group col-lg-12">
            {{Form::label('description',__('Description'))}}
            {{Form::textarea('description',null,array('class'=>'form-control','placeholder'=>__('Enter Description')))}}
        </div>

    </div>
</div>
<div class="modal-footer pr-0">
    <button type="button" class="btn dark btn-outline" data-dismiss="modal">{{__('Cancel')}}</button>
    {{Form::submit(__('update'),array('class'=>'btn btn-primary'))}}
</div>
{{Form::close()}}

