{{Form::model($leavetype,array('route' => array('leavetype.update', $leavetype->id), 'method' => 'PUT')) }}
<div class="card-body p-0">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {{Form::label('title',__('Leave Type'))}}
                {{Form::text('title',null,array('class'=>'form-control','placeholder'=>__('Enter Leave Type Name')))}}
                @error('title')
                <span class="invalid-name" role="alert">
                    <strong class="text-danger">{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {{Form::label('days',__('Days Per Year'))}}
                {{Form::number('days',null,array('class'=>'form-control','placeholder'=>__('Enter Days / Year')))}}
            </div>
        </div>
    </div>

</div>
<div class="modal-footer pr-0">
    <button type="button" class="btn dark btn-outline" data-dismiss="modal">{{__('Cancel')}}</button>
    {{Form::submit(__('Update'),array('class'=>'btn btn-primary'))}}
</div>
{{Form::close()}}

