{{Form::model($document,array('route' => array('document.update', $document->id), 'method' => 'PUT')) }}
<div class="card-body p-0">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {{Form::label('name',__('Name'))}}
                {{Form::text('name',null,array('class'=>'form-control','placeholder'=>__('Enter Department Name')))}}
                @error('name')
                <span class="invalid-name" role="alert">
                    <strong class="text-danger">{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group">
                {{ Form::label('is_required', __('Required Field')) }}
                <select class="form-control select2" required name="is_required" >
                    <option value="0" @if($document->is_required == 0) selected  @endif>Not Required</option>
                    <option value="1" @if($document->is_required == 1) selected  @endif>Is Required</option>
                </select>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer pr-0">
    <button type="button" class="btn dark btn-outline" data-dismiss="modal">{{__('Cancel')}}</button>
    {{Form::submit(__('Update'),array('class'=>'btn btn-primary'))}}
</div>
{{Form::close()}}

