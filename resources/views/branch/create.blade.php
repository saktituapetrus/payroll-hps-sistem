{{Form::open(array('url'=>'branch','method'=>'post'))}}
<div class="card-body p-0">
    <div class="row font-style">
        <div class="col-md-12">
            <div class="form-group">
                {{Form::label('name',__('Name'))}}
                {{Form::text('name',null,array('class'=>'form-control','placeholder'=>__('Enter Branch Name')))}}
                @error('name')
                <span class="invalid-name" role="alert">
                    <strong class="text-danger">{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
    </div>

</div>
<div class="modal-footer pr-0">
    <button type="button" class="btn dark btn-outline" data-dismiss="modal">{{__('Cancel')}}</button>
    {{Form::submit(__('Create'),array('class'=>'btn btn-primary'))}}
</div>
{{Form::close()}}
