@extends('layouts.dashboard')

@section('content')
@section('page-title')
{{__('Yearly Bonus')}}
@endsection

<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>{{__('Yearly Bonus Edit')}}</h1>

            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{route('home')}}">{{__('Dashboard')}}</a></div>
                <div class="breadcrumb-item active"><a href="{{route('yearlybonus.index')}}">{{__('Yearly Bonus')}}</a></div>
                <div class="breadcrumb-item">{{__('Edit')}}</div>
            </div>
        </div>

        {{ Form::model($yearlyBonus, array('route' => array('yearlybonus.update', $yearlyBonus->id), 'method' => 'PUT')) }}
        @csrf

        <div class="section-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>{{__('Edit Employee Early Bonus')}}</h4>
                        </div>

                        <div class="card-body">
                            <div class="form-group">
                                {!! Form::label('employee_id', __('Employee')) !!}<span
                                    class="text-danger pl-1">*</span>
                                {{ Form::select('employee_id', $employees, null, array('class' => 'form-control select2', 'required' => 'required')) }}
                            </div>

                            <div class="form-group">
                                {!! Form::label('bonus_type', __('Bonus Type')) !!}
                                {!! Form::text('bonus_type', old('bonus_type'), ['class' => 'form-control',
                                'required' => 'required'])
                                !!}
                            </div>

                            <div class="form-group">
                                {!! Form::label('bonus_amount', __('Bonus Amount')) !!}<span
                                    class="text-danger pl-1">*</span>
                                {!! Form::number('bonus_amount', old('bonus_amount'), ['class' => 'form-control',
                                'required' => 'required'])
                                !!}
                            </div>

                            <div class="form-group">
                                {!! Form::label('date_disbursement', __('Date Disbursement')) !!}
                                {!! Form::text('date_disbursement', old('date_disbursement'), ['class' =>
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
