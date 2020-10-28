{{Form::model($payer,array('route' => array('payer.update', $payer->id), 'method' => 'PUT')) }}
<div class="card-body p-0">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {{Form::label('payer_name',__('Payer Name'))}}
                {{Form::text('payer_name',null,array('class'=>'form-control','placeholder'=>__('Enter Payer Name')))}}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {{Form::label('contact_number',__('Contact Number'))}}
                {{Form::number('contact_number',null,array('class'=>'form-control','placeholder'=>__('Enter Contact Number')))}}
            </div>
        </div>
    </div>

</div>
<div class="modal-footer pr-0">
    <button type="button" class="btn dark btn-outline" data-dismiss="modal">{{__('Cancel')}}</button>
    {{Form::submit(__('Update'),array('class'=>'btn btn-primary'))}}
</div>
{{Form::close()}}

