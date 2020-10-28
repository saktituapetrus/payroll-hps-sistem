@extends('layouts.dashboard')

@section('content')
@section('page-title')
{{__('Loan Custom')}}
@endsection

<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>{{__('Loan Custom Edit')}}</h1>

            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{route('home')}}">{{__('Dashboard')}}</a></div>
                <div class="breadcrumb-item active"><a href="{{route('loancustom.index')}}">{{__('Loan Custom')}}</a>
                </div>
                <div class="breadcrumb-item">{{__('Edit')}}</div>
            </div>
        </div>

        {{ Form::model($loanCustom, array('route' => array('loancustom.update', $loanCustom->id), 'method' => 'PUT')) }}
        @csrf

        <div class="section-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>{{__('Edit Employee Loan Custom')}}</h4>
                        </div>

                        <div class="card-body">
                            <div class="form-group">
                                {!! Form::label('employee_id', __('Employee')) !!}<span
                                    class="text-danger pl-1">*</span>
                                {{ Form::select('employee_id', $employees, null, array('class' => 'form-control select2', 'required' => 'required')) }}
                            </div>

                            <div class="form-group">
                                {!! Form::label('loan_type', __('Loan Type')) !!}
                                {{ Form::select('loan_type', ['salary' => 'Deducted from salary', 'bonus' => 'Deducted from bonus'], null, array('class' => 'form-control select2', 'required' => 'required')) }}
                            </div>

                            <div class="form-group">
                                {!! Form::label('loan_amount', __('Loan Amount')) !!}<span
                                    class="text-danger pl-1">*</span>
                                {!! Form::number('loan_amount', old('loan_amount'), ['class' => 'form-control',
                                'required' => 'required'])
                                !!}
                            </div>

                            <div class="form-group">
                                {!! Form::label('tenor', __('Tenor')) !!}<span class="text-danger pl-1">*</span>
                                {!! Form::number('tenor', old('tenor'), ['class' => 'form-control',
                                'required' => 'required'])
                                !!}
                            </div>

                            <div class="form-group">
                                {!! Form::label('loan_date', __('Loan Date')) !!}
                                {!! Form::text('loan_date', old('loan_date'), ['class' =>
                                'form-control datepicker', 'required' => 'required']) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        {!! Form::submit('Update', ['class' => 'btn btn-primary btn-lg float-right']) !!}
        {!! Form::close() !!}
    </section>
</div>
@endsection
