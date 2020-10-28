{{Form::model($event,array('route' => array('event.update', $event->id), 'method' => 'PUT')) }}
<div class="card-body p-0">
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
                            <input name="color" type="radio" @if($event->color == "#6777ef") checked="" @endif  value="#6777ef" class="colorinput-input" />
                            <span class="colorinput-color bg-primary"></span>
                        </label>
                    </div>
                    <div class="col-auto">
                        <label class="colorinput">
                            <input name="color" type="radio" @if($event->color == "#cdd3d8") checked="" @endif value="#cdd3d8" class="colorinput-input" />
                            <span class="colorinput-color bg-secondary"></span>
                        </label>
                    </div>
                    <div class="col-auto">
                        <label class="colorinput">
                            <input name="color" type="radio" @if($event->color == "#fc544b") checked="" @endif value="#fc544b" class="colorinput-input" />
                            <span class="colorinput-color bg-danger"></span>
                        </label>
                    </div>
                    <div class="col-auto">
                        <label class="colorinput">
                            <input name="color" type="radio" @if($event->color == "#ffa426") checked="" @endif value="#ffa426" class="colorinput-input" />
                            <span class="colorinput-color bg-warning"></span>
                        </label>
                    </div>
                    <div class="col-auto">
                        <label class="colorinput">
                            <input name="color" type="radio" @if($event->color == "#3abaf4") checked="" @endif value="#3abaf4" class="colorinput-input" />
                            <span class="colorinput-color bg-info"></span>
                        </label>
                    </div>
                    <div class="col-auto">
                        <label class="colorinput">
                            <input name="color" type="radio" @if($event->color == "#63ed7a") checked="" @endif value="#63ed7a" class="colorinput-input" />
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
    {{Form::submit(__('Update'),array('class'=>'btn btn-primary'))}}
</div>
{{Form::close()}}

