{{Form::open(array('url'=>'deposit','method'=>'post'))}}
<div class="card-body p-0">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {{Form::label('account_id',__('Account'))}}
                {{Form::select('account_id',$accounts,null,array('class'=>'form-control select2','placeholder'=>__('Choose Account')))}}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                {{Form::label('amount',__('Amount'))}}
                {{Form::number('amount',null,array('class'=>'form-control','placeholder'=>__('Amount'),'step'=>'0.01'))}}
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                {{Form::label('date',__('Date'))}}
                {{Form::text('date',null,array('class'=>'form-control datepicker'))}}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                {{Form::label('income_category_id',__('Category'))}}
                {{Form::select('income_category_id',$incomeCategory,null,array('class'=>'form-control select2','placeholder'=>__('Choose A Category')))}}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{Form::label('payer_id',__('Payer'))}}
                {{Form::select('payer_id',$payers,null,array('class'=>'form-control select2'))}}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                {{Form::label('payment_type_id',__('Payment Method'))}}
                {{Form::select('payment_type_id',$paymentTypes,null,array('class'=>'form-control select2','placeholder'=>__('Choose Payment Method')))}}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{Form::label('referal_id',__('Ref#'))}}
                {{Form::text('referal_id',null,array('class'=>'form-control'))}}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {{Form::label('description',__('Description'))}}
                {{Form::textarea('description',null,array('class'=>'form-control','placeholder'=>__('Description')))}}
            </div>
        </div>
    </div>

</div>
<div class="modal-footer pr-0">
    <button type="button" class="btn dark btn-outline" data-dismiss="modal">{{__('Cancel')}}</button>
    {{Form::submit(__('Create'),array('class'=>'btn btn-primary'))}}
</div>
{{Form::close()}}
