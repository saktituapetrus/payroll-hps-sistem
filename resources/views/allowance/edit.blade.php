{{Form::model($allowance,array('route' => array('allowance.update', $allowance->id), 'method' => 'PUT')) }}
<div class="card-body p-0">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {{ Form::label('allowance_option', __('Allowance Options*')) }}
                {{ Form::select('allowance_option',$allowance_options,null, array('class' => 'form-control select2','required'=>'required')) }}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {{ Form::label('title', __('Title')) }}
                {{ Form::text('title',null, array('class' => 'form-control ','required'=>'required')) }}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {{ Form::label('amount', __('Amount')) }}
                {{ Form::number('amount',null, array('class' => 'form-control ','required'=>'required')) }}
            </div>
        </div>
    </div>

</div>
<div class="modal-footer pr-0">
    <button type="button" class="btn dark btn-outline" data-dismiss="modal">{{__('Cancel')}}</button>
    {{Form::submit(__('Update'),array('class'=>'btn btn-primary'))}}
</div>
{{Form::close()}}


