{{Form::open(array('url'=>'travel','method'=>'post'))}}
<div class="card-body p-0">
    <div class="row">

        <div class="form-group col-md-12">
            {{ Form::label('employee_id', __('Employee')) }}
            {{ Form::select('employee_id', $employees,null, array('class' => 'form-control select2','required'=>'required')) }}
        </div>
        <div class="form-group col-lg-6 col-md-6">
            {{Form::label('start_date',__('Start Date'))}}
            {{Form::text('start_date',null,array('class'=>'form-control datepicker'))}}
        </div>
        <div class="form-group col-lg-6 col-md-6">
            {{Form::label('end_date',__('End Date'))}}
            {{Form::text('end_date',null,array('class'=>'form-control datepicker'))}}
        </div>
        <div class="form-group col-lg-6 col-md-6">
            {{Form::label('purpose_of_visit',__('Purpose of Visit'))}}
            {{Form::text('purpose_of_visit',null,array('class'=>'form-control'))}}
        </div>
        <div class="form-group col-md-6">
            {{Form::label('place_of_visit',__('Place Of Visit'))}}
            {{Form::text('place_of_visit',null,array('class'=>'form-control'))}}
        </div>
        <div class="form-group col-md-12">
            {{Form::label('description',__('Description'))}}
            {{Form::textarea('description',null,array('class'=>'form-control','placeholder'=>__('Enter Description')))}}
        </div>
    </div>
</div>
<div class="modal-footer pr-0">
    <button type="button" class="btn dark btn-outline" data-dismiss="modal">{{__('Cancel')}}</button>
    {{Form::submit(__('Create'),array('class'=>'btn btn-primary'))}}
</div>
{{Form::close()}}
