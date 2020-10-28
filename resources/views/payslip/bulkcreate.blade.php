{{Form::open(array('url'=>'payslip/bulkpayment/'.$date,'method'=>'post'))}}
<div class="card-body p-0">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {{ __('Total Unpaid Employee') }} <b>{{ count($unpaidEmployees) }}</b> {{_('out of')}} <b>{{ count($Employees) }}</b>
            </div>

        </div>
    </div>
</div>
<div class="modal-footer pr-0">
    <button type="button" class="btn dark btn-outline" data-dismiss="modal">{{__('Cancel')}}</button>
    {{Form::submit(__('Bulk Payment'),array('class'=>'btn btn-primary'))}}
</div>
{{Form::close()}}
