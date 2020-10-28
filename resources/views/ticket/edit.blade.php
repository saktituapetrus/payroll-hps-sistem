{{Form::model($ticket,array('route'=>array('ticket.update',$ticket->id),'method' => 'PUT')) }}
<div class="card-body p-0">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {{Form::label('title',__('Subject'))}}
                {{Form::text('title',null,array('class'=>'form-control','placeholder'=>__('Enter Ticket Subject')))}}
            </div>
        </div>
    </div>
    @if(\Auth::user()->type!='employee')
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    {{Form::label('employee_id',__('Ticket for Employee'))}}
                    {{Form::select('employee_id',$employees,null,array('class'=>'form-control select2'))}}
                </div>
            </div>
        </div>
    @endif
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {{Form::label('priority',__('Priority'))}}
                <select name="priority" id="" class="form-control select2">
                    <option value="low" @if($ticket->priority=='low') selected @endif>{{__('Low')}}</option>
                    <option value="medium" @if($ticket->priority=='medium') selected @endif>{{__('Medium')}}</option>
                    <option value="high" @if($ticket->priority=='high') selected @endif>{{__('High')}}</option>
                    <option value="critical" @if($ticket->priority=='critical') selected @endif>{{__('critical')}}</option>
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {{Form::label('end_date',__('End Date'))}}
                {{Form::text('end_date',null,array('class'=>'form-control datepicker'))}}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {{Form::label('description',__('Description'))}}
                {{Form::textarea('description',null,array('class'=>'form-control','placeholder'=>__('Ticket Description')))}}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {{Form::label('status',__('Status'))}}
                <select name="status" id="" class="form-control select2">
                    <option value="close" @if($ticket->status == 'close') selected @endif>{{__('Close')}}</option>
                    <option value="open" @if($ticket->status == 'open') selected @endif>{{__('Open')}}</option>
                    <option value="onhold" @if($ticket->status == 'onhold') selected @endif>{{__('On Hold')}}</option>
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

