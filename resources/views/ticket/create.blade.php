{{Form::open(array('url'=>'ticket','method'=>'post'))}}
<div class="card-body p-0">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {{Form::label('title',__('Subject'))}}
                {{Form::text('title',null,array('class'=>'form-control','placeholder'=>__('Enter Ticket Subject')))}}
            </div>
        </div>
    </div>
    @if(\Auth::user()->type!='employee')
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    {{Form::label('employee_id',__('Ticket for Employee'))}}
                    {{Form::select('employee_id',$employees,null,array('class'=>'form-control select2','placeholder'=>__('Select Employee')))}}
                </div>
            </div>
        </div>
    @endif
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {{Form::label('priority',__('Priority'))}}
                <select name="priority" id="" class="form-control select2">
                    <option value="low">{{__('Low')}}</option>
                    <option value="medium">{{__('Medium')}}</option>
                    <option value="high">{{__('High')}}</option>
                    <option value="critical">{{__('critical')}}</option>
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {{Form::label('end_date',__('End Date'))}}
                {{Form::text('end_date',null,array('class'=>'form-control datepicker'))}}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {{Form::label('description',__('Description'))}}
                {{Form::textarea('description',null,array('class'=>'form-control','placeholder'=>__('Ticket Description')))}}
            </div>
        </div>
    </div>
</div>
<div class="modal-footer pr-0">
    <button type="button" class="btn dark btn-outline" data-dismiss="modal">{{__('Cancel')}}</button>
    {{Form::submit(__('Create'),array('class'=>'btn btn-primary'))}}
</div>
{{Form::close()}}
