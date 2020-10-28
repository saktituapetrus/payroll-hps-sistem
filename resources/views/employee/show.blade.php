@extends('layouts.dashboard')
@section('page-title')
    {{__('Employee')}}
@endsection
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{__('Employee')}}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{__('home')}}">{{__('Dashboard')}}</a></div>
                    @if(\Auth::user()->type!='employee')
                        <div class="breadcrumb-item"><a href="{{route('employee.index')}}">{{__('Employee')}}</a></div>
                    @endif
                    <div class="breadcrumb-item">{{__('Create')}}</div>
                </div>
            </div>
            <div class="section-body">
                @can('Edit Employee')
                    <div class=" text-right">
                        <a href="{{ URL::to('employee/'.$employee->id.'/edit') }}" class="btn btn-icon icon-left btn-primary mb-10 ">
                            <i class="fa fa-edit"></i> {{ __('Edit') }}
                        </a>
                    </div>
                @endcan
                <div class="row">
                    <div class="col-md-6 ">
                        <div class="employee-detail-wrap">
                            <div class="card">
                                <div class="card-header">
                                    <h4>{{__('Personal Detail')}}</h4>

                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="info">
                                                <strong>{{__('EmployeeId')}}</strong>
                                                <span>{{$employeesId}}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="info font-style">
                                                <strong>{{__('Name')}}</strong>
                                                <span>{{$employee->name}}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="info font-style">
                                                <strong>{{__('Email')}}</strong>
                                                <span>{{$employee->email}}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="info">
                                                <strong>{{__('Date of Birth')}}</strong>
                                                <span>{{\Auth::user()->dateFormat($employee->dob)}}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="info">
                                                <strong>{{__('Phone')}}</strong>
                                                <span>{{$employee->phone}}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="info">
                                                <strong>{{__('Address')}}</strong>
                                                <span>{{$employee->address}}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="info">
                                                <strong>{{__('Salary Type')}}</strong>
                                                <span>{{$employee->salary_type}}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="info">
                                                <strong>{{__('Salary')}}</strong>
                                                <span>{{$employee->salary}}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 ">
                        <div class="employee-detail-wrap">
                            <div class="card">
                                <div class="card-header"><h4>{{__('Company Detail')}}</h4></div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="info">
                                                <strong>{{__('Branch')}}</strong>
                                                <span>{{!empty($employee->branch)?$employee->branch->name:''}}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="info font-style">
                                                <strong>{{__('Department')}}</strong>
                                                <span>{{!empty($employee->department)?$employee->department->name:''}}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="info font-style">
                                                <strong>{{__('Designation')}}</strong>
                                                <span>{{!empty($employee->designation)?$employee->designation->name:''}}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="info">
                                                <strong>{{__('Date Of Joining')}}</strong>
                                                <span>{{\Auth::user()->dateFormat($employee->company_doj)}}</span>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 ">
                        <div class="employee-detail-wrap">
                            <div class="card">
                                <div class="card-header"><h4>{{__('Document Detail')}}</h4></div>
                                <div class="card-body">
                                    <div class="row">
                                        @php
                                            $employeedoc = $employee->documents()->pluck('document_value',__('document_id'));
                                        @endphp
                                        @foreach($documents as $key=>$document)
                                            <div class="col-md-12">
                                                <div class="info">
                                                    <strong>{{$document->name }}</strong>
                                                    <span>{{ (!empty($employeedoc[$document->id])?$employeedoc[$document->id]:'') }}</span>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 ">
                        <div class="employee-detail-wrap">
                            <div class="card">
                                <div class="card-header"><h4>{{__('Bank Account Detail')}}</h4></div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="info">
                                                <strong>{{__('Account Holder Name')}}</strong>
                                                <span>{{$employee->account_holder_name}}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="info font-style">
                                                <strong>{{__('Account Number')}}</strong>
                                                <span>{{$employee->account_number}}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="info font-style">
                                                <strong>{{__('Bank Name')}}</strong>
                                                <span>{{$employee->bank_name}}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="info">
                                                <strong>{{__('Bank Identifier Code')}}</strong>
                                                <span>{{$employee->bank_identifier_code}}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="info">
                                                <strong>{{__('Branch Location')}}</strong>
                                                <span>{{$employee->branch_location}}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="info">
                                                <strong>{{__('Tax Payer Id')}}</strong>
                                                <span>{{$employee->tax_payer_id}}</span>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

@endsection

