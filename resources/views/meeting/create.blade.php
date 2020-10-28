{{Form::open(array('url'=>'meeting','method'=>'post'))}}
<div class="card-body p-0">

    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {{Form::label('branch_id',__('Branch'))}}
                <select class="form-control select2" name="branch_id" id="branch_id" placeholder="Select Branch">
                    <option value="">{{__('Select Branch')}}</option>
                    <option value="0">{{__('All Branch')}}</option>
                    @foreach($branch as $branch)
                        <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {{Form::label('department_id',__('Department'))}}
                <select class="form-control select2" name="department_id[]" id="department_id" placeholder="Select Department" multiple>

                </select>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {{Form::label('employee_id',__('Employee'))}}
                <select class="form-control select2" name="employee_id[]" id="employee_id" placeholder="Select Employee" multiple>

                </select>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {{Form::label('title',__('Meeting Title'))}}
                {{Form::text('title',null,array('class'=>'form-control','placeholder'=>__('Enter Meeting Title')))}}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                {{Form::label('date',__('Meeting Date'))}}
                {{Form::text('date',null,array('class'=>'form-control datepicker'))}}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{Form::label('time',__('Meeting Time'))}}
                {{Form::text('time',null,array('class'=>'form-control timepicker'))}}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {{Form::label('note',__('Meeting Note'))}}
                {{Form::textarea('note',null,array('class'=>'form-control','placeholder'=>__('Enter Meeting Note')))}}
            </div>
        </div>
    </div>


</div>
<div class="modal-footer pr-0">
    <button type="button" class="btn dark btn-outline" data-dismiss="modal">{{__('Cancel')}}</button>
    {{Form::submit(__('Create'),array('class'=>'btn btn-primary'))}}
</div>
{{Form::close()}}
