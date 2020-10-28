{{Form::open(array('url'=>'event','method'=>'post'))}}
<div class="card-body p-0">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {{Form::label('branch_id',__('Branch'))}}
                <select class="form-control select2" name="branch_id" id="branch_id" placeholder="{{__('Select Branch')}}">
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
                <select class="form-control select2" name="department_id[]" id="department_id" placeholder="{{__('Select Department')}}" multiple>

                </select>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {{Form::label('employee_id',__('Employee'))}}
                <select class="form-control select2" name="employee_id[]" id="employee_id" placeholder="{{__('Select Employee')}}" multiple>

                </select>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {{Form::label('title',__('Event Title'))}}
                {{Form::text('title',null,array('class'=>'form-control','placeholder'=>__('Enter Event Title')))}}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                {{Form::label('start_date',__('Event start Date'))}}
                {{Form::text('start_date',null,array('class'=>'form-control datepicker'))}}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{Form::label('end_date',__('Event End Date'))}}
                {{Form::text('end_date',null,array('class'=>'form-control datepicker'))}}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="form-group">
                {{Form::label('color',__('Event Select Color'))}}
                <div class="row gutters-xs">
                    <div class="col-auto">
                        <label class="colorinput">
                            <input name="color" type="radio" value="#6777ef" class="colorinput-input"/>
                            <span class="colorinput-color bg-primary"></span>
                        </label>
                    </div>
                    <div class="col-auto">
                        <label class="colorinput">
                            <input name="color" type="radio" value="#cdd3d8" class="colorinput-input"/>
                            <span class="colorinput-color bg-secondary"></span>
                        </label>
                    </div>
                    <div class="col-auto">
                        <label class="colorinput">
                            <input name="color" type="radio" value="#fc544b" class="colorinput-input"/>
                            <span class="colorinput-color bg-danger"></span>
                        </label>
                    </div>
                    <div class="col-auto">
                        <label class="colorinput">
                            <input name="color" type="radio" value="#ffa426" class="colorinput-input"/>
                            <span class="colorinput-color bg-warning"></span>
                        </label>
                    </div>
                    <div class="col-auto">
                        <label class="colorinput">
                            <input name="color" type="radio" value="#3abaf4" class="colorinput-input"/>
                            <span class="colorinput-color bg-info"></span>
                        </label>
                    </div>
                    <div class="col-auto">
                        <label class="colorinput">
                            <input name="color" type="radio" value="#63ed7a" class="colorinput-input"/>
                            <span class="colorinput-color bg-success"></span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {{Form::label('description',__('Event Description'))}}
                {{Form::textarea('description',null,array('class'=>'form-control','placeholder'=>__('Enter Event Description')))}}
            </div>
        </div>
    </div>
</div>
<div class="modal-footer pr-0">
    <button type="button" class="btn dark btn-outline" data-dismiss="modal">{{__('Cancel')}}</button>
    {{Form::submit(__('Create'),array('class'=>'btn btn-primary'))}}
</div>
{{Form::close()}}
