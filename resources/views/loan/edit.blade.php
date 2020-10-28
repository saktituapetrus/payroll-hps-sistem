{{Form::model($loan,array('route' => array('loan.update', $loan->id), 'method' => 'PUT')) }}
<div class="card-body p-0">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {{ Form::label('loan_option', __('Loan Options*')) }}
                {{ Form::select('loan_option',$loan_options,null, array('class' => 'form-control select2','required'=>'required')) }}
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
                {{ Form::label('amount', __('Loan Amount')) }}
                {{ Form::number('amount',null, array('class' => 'form-control ','required'=>'required')) }}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {{ Form::label('start_date', __('Start Date')) }}
                {{ Form::text('start_date',null, array('class' => 'form-control datepicker','required'=>'required')) }}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {{ Form::label('end_date', __('End Date')) }}
                {{ Form::text('end_date',null, array('class' => 'form-control datepicker','required'=>'required')) }}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {{ Form::label('reason', __('Reason')) }}
                {{ Form::textarea('reason',null, array('class' => 'form-control ','required'=>'required')) }}
            </div>
        </div>
    </div>

</div>
<div class="modal-footer pr-0">
    <button type="button" class="btn dark btn-outline" data-dismiss="modal">{{__('Cancel')}}</button>
    {{Form::submit(__('Update'),array('class'=>'btn btn-primary'))}}
</div>
{{Form::close()}}


