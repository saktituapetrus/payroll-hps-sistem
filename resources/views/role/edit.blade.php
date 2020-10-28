{{Form::model($role,array('route' => array('roles.update', $role->id), 'method' => 'PUT')) }}
<div class="card-body p-0">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {{Form::label('name',__('Name'))}}
                @if($role->name == 'employee')
                    <p class="form-control">{{ $role->name }}</p>
                @else
                    {{Form::text('name',null,array('class'=>'form-control','placeholder'=>__('Enter Role Name')))}}
                @endif
                @error('name')
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
                @if(!empty($permissions))
                    <h6>{{__('Assign Permission to Roles')}} </h6>
                    <table class="table table-striped mb-0" id="dataTable-1">
                        <thead>
                        <tr>
                            <th>{{__('Module')}} </th>
                            <th>{{__('Permissions')}} </th>
                        </tr>
                        </thead>
                        <tbody>
                        @php
                            $modules=['User','Role','Award','Transfer','Resignation','Travel','Promotion','Complaint','Warning','Termination','Department','Designation','Document Type','Branch','Award Type','Termination Type','Employee','Payslip Type','Allowance Option','Loan Option','Deduction Option','Set Salary','Allowance','Commission','Loan','Saturation Deduction','Other Payment','Overtime','Pay Slip','Account List','Payee','Payer','Income Type','Expense Type','Payment Type',
                             'Deposit','Expense','Transfer Balance','Event','Announcement','Leave Type','Leave','Meeting','Ticket','Attendance','TimeSheet'];
                             if(Auth::user()->type == 'super admin'){
                                 $modules[] = 'Language';
                             }
                        @endphp
                        @foreach($modules as $module)
                            <tr>
                                <td>{{ $module }}</td>
                                <td>
                                    <div class="row">
                                        @if(in_array('Manage '.$module,(array) $permissions))
                                            @if($key = array_search('Manage '.$module,$permissions))
                                                <div class="col-md-3 custom-control custom-checkbox">
                                                    {{Form::checkbox('permissions[]',$key,$role->permission, ['class'=>'custom-control-input','id' =>'permission'.$key])}}
                                                    {{Form::label('permission'.$key,'Manage',['class'=>'custom-control-label'])}}<br>
                                                </div>
                                            @endif
                                        @endif
                                        @if(in_array('Create '.$module,(array) $permissions))
                                            @if($key = array_search('Create '.$module,$permissions))
                                                <div class="col-md-3 custom-control custom-checkbox">
                                                    {{Form::checkbox('permissions[]',$key,$role->permission, ['class'=>'custom-control-input','id' =>'permission'.$key])}}
                                                    {{Form::label('permission'.$key,'Create',['class'=>'custom-control-label'])}}<br>
                                                </div>
                                            @endif
                                        @endif
                                        @if(in_array('Edit '.$module,(array) $permissions))
                                            @if($key = array_search('Edit '.$module,$permissions))
                                                <div class="col-md-3 custom-control custom-checkbox">
                                                    {{Form::checkbox('permissions[]',$key,$role->permission, ['class'=>'custom-control-input','id' =>'permission'.$key])}}
                                                    {{Form::label('permission'.$key,'Edit',['class'=>'custom-control-label'])}}<br>
                                                </div>
                                            @endif
                                        @endif
                                        @if(in_array('Delete '.$module,(array) $permissions))
                                            @if($key = array_search('Delete '.$module,$permissions))
                                                <div class="col-md-3 custom-control custom-checkbox">
                                                    {{Form::checkbox('permissions[]',$key,$role->permission, ['class'=>'custom-control-input','id' =>'permission'.$key])}}
                                                    {{Form::label('permission'.$key,'Delete',['class'=>'custom-control-label'])}}<br>
                                                </div>
                                            @endif
                                        @endif
                                        @if(in_array('Show '.$module,(array) $permissions))
                                            @if($key = array_search('Show '.$module,$permissions))
                                                <div class="col-md-3 custom-control custom-checkbox">
                                                    {{Form::checkbox('permissions[]',$key,$role->permission, ['class'=>'custom-control-input','id' =>'permission'.$key])}}
                                                    {{Form::label('permission'.$key,'Show',['class'=>'custom-control-label'])}}<br>
                                                </div>
                                            @endif
                                        @endif
                                        @if(in_array('Move '.$module,(array) $permissions))
                                            @if($key = array_search('Move '.$module,$permissions))
                                                <div class="col-md-3 custom-control custom-checkbox">
                                                    {{Form::checkbox('permissions[]',$key,$role->permission, ['class'=>'custom-control-input','id' =>'permission'.$key])}}
                                                    {{Form::label('permission'.$key,'Move',['class'=>'custom-control-label'])}}<br>
                                                </div>
                                            @endif
                                        @endif
                                        @if(in_array('client permission '.$module,(array) $permissions))
                                            @if($key = array_search('client permission '.$module,$permissions))
                                                <div class="col-md-3 custom-control custom-checkbox">
                                                    {{Form::checkbox('permissions[]',$key,$role->permission, ['class'=>'custom-control-input','id' =>'permission'.$key])}}
                                                    {{Form::label('permission'.$key,'Client Permission',['class'=>'custom-control-label'])}}<br>
                                                </div>
                                            @endif
                                        @endif
                                        @if(in_array('invite user '.$module,(array) $permissions))
                                            @if($key = array_search('invite user '.$module,$permissions))
                                                <div class="col-md-3 custom-control custom-checkbox">
                                                    {{Form::checkbox('permissions[]',$key,$role->permission, ['class'=>'custom-control-input','id' =>'permission'.$key])}}
                                                    {{Form::label('permission'.$key,'Invite User ',['class'=>'custom-control-label'])}}<br>
                                                </div>
                                            @endif
                                        @endif
                                        @if(in_array('change password '.$module,(array) $permissions))
                                            @if($key = array_search('change password '.$module,$permissions))
                                                <div class="col-md-3 custom-control custom-checkbox">
                                                    {{Form::checkbox('permissions[]',$key,$role->permission, ['class'=>'custom-control-input','id' =>'permission'.$key])}}
                                                    {{Form::label('permission'.$key,'Change Password ',['class'=>'custom-control-label'])}}<br>
                                                </div>
                                            @endif
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
</div>
<div class="modal-footer pr-0">
    <button type="button" class="btn dark btn-outline" data-dismiss="modal">{{__('Cancel')}}</button>
    {{Form::submit(__('Update'),array('class'=>'btn btn-primary'))}}
</div>
{{Form::close()}}

