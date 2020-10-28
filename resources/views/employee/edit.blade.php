@extends('layouts.dashboard')
@section('content')
@section('page-title')
    {{__('Employee')}}
@endsection
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>{{__('Employee Edit')}}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{route('home')}}">{{__('Dashboard')}}</a></div>
                <div class="breadcrumb-item active"><a href="{{route('employee.index')}}">{{__('Employee')}}</a></div>
                <div class="breadcrumb-item">{{__('Edit')}}</div>
            </div>
        </div>
        {{ Form::model($employee, array('route' => array('employee.update', $employee->id), 'method' => 'PUT' , 'enctype' => 'multipart/form-data')) }}
        @csrf
        <div class="section-body">
            <div class="row">
                <div class="col-md-6 ">
                    <div class="card">
                        <div class="card-header"><h4>{{__('Personal Detail')}}</h4></div>
                        <div class="card-body">

                            <div class="form-group">
                                {!! Form::label('name', __('Name')) !!}<span class="text-danger pl-1">*</span>
                                {!! Form::text('name', null, ['class' => 'form-control','required' => 'required']) !!}

                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {!! Form::label('dob', __('Date of Birth')) !!}
                                        {!! Form::text('dob', null, ['class' => 'form-control datepicker']) !!}
                                    </div>
                                </div>

                                <div class="col-md-6 ">
                                    <div class="form-group ">
                                        {!! Form::label('gender', __('Gender')) !!}<span class="text-danger pl-1">*</span>
                                        <div class="selectgroup w-100">
                                            <label class="selectgroup-item">
                                                <input type="radio" name="gender" value="Male" class="selectgroup-input" {{($employee->gender == 'Male')?'checked':''}}>
                                                <span class="selectgroup-button">{{__('Male')}}</span>
                                            </label>
                                            <label class="selectgroup-item">
                                                <input type="radio" name="gender" value="Female" class="selectgroup-input" {{($employee->gender == 'Female')?'checked':''}}>
                                                <span class="selectgroup-button">{{__('Female')}}</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                {!! Form::label('phone', __('Phone')) !!}<span class="text-danger pl-1">*</span>
                                {!! Form::number('phone',null, ['class' => 'form-control']) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('address', __('Address')) !!}
                                {!! Form::textarea('address',null, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 ">
                    <div class="card">
                        <div class="card-header"><h4>{{__('Company Detail')}}</h4></div>
                        <div class="card-body">

                            @csrf
                            <div class="form-group">
                                {!! Form::label('employee_id', __('Employee ID')) !!}
                                {!! Form::text('employee_id',$employeesId, ['class' => 'form-control','disabled'=>'disabled']) !!}
                            </div>

                            <div class="form-group">
                                {{ Form::label('branch_id', __('Branch')) }}
                                {{ Form::select('branch_id', $branches,null, array('class' => 'form-control select2','required'=>'required')) }}
                            </div>

                            <div class="form-group">
                                {{ Form::label('department_id', __('Department')) }}
                                {{ Form::select('department_id', $departments,null, array('class' => 'form-control select2','required'=>'required')) }}
                            </div>

                            <div class="form-group">
                                {{ Form::label('designation_id', __('Designation')) }}
                                <select class="select2 form-control select2-multiple" id="designation_id" name="designation_id" data-toggle="select2" data-placeholder="{{ __('Select Designation ...') }}">
                                    <option value="">{{__('Select any Designation')}}</option>
                                </select>
                            </div>
                            <div class="form-group">
                                {!! Form::label('company_doj', 'Company Date Of Joining') !!}
                                {!! Form::text('company_doj', null, ['class' => 'form-control datepicker','required' => 'required']) !!}
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 ">
                    <div class="card">
                        <div class="card-header"><h4>{{__('Document')}}</h4></div>
                        <div class="card-body">
                            @php
                                $employeedoc = $employee->documents()->pluck('document_value',__('document_id'));
                            @endphp
                            @foreach($documents as $key=>$document)
                                <div class="row">
                                    <div class="form-group col-10">
                                        <div class="float-left col-4">
                                            <label for="document" class="float-left pt-1">{{ $document->name }} @if($document->is_required == 1) <span class="text-danger">*</span> @endif</label>
                                        </div>
                                        <div class="float-right col-8">
                                            <input class="form-control col-6 @if(!empty($employeedoc[$document->id])) float-left @endif @error('document') is-invalid @enderror border-0" @if($document->is_required == 1 && empty($employeedoc[$document->id]) ) required @endif name="document[{{ $document->id}}]" type="file" id="document[{{ $document->id }}]" accept="image/*">
                                            @if(!empty($employeedoc[$document->id])) <a href="" class="float-right">{{ $employeedoc[$document->id] }}</a>@endif
                                        </div>

                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-md-6 ">
                    <div class="card">
                        <div class="card-header"><h4>{{__('Bank Account Detail')}}</h4></div>
                        <div class="card-body">
                            <div class="form-group">
                                {!! Form::label('account_holder_name', __('Account Holder Name')) !!}
                                {!! Form::text('account_holder_name', null, ['class' => 'form-control']) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('account_number', __('Account Number')) !!}
                                {!! Form::number('account_number', null, ['class' => 'form-control']) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('bank_name', __('Bank Name')) !!}
                                {!! Form::text('bank_name', null, ['class' => 'form-control']) !!}

                            </div>
                            <div class="form-group">
                                {!! Form::label('bank_identifier_code', __('Bank Identifier Code')) !!}
                                {!! Form::text('bank_identifier_code',null, ['class' => 'form-control']) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('branch_location', __('Branch Location')) !!}
                                {!! Form::text('branch_location',null, ['class' => 'form-control']) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('tax_payer_id', __('Tax Payer Id')) !!}
                                {!! Form::text('tax_payer_id',null, ['class' => 'form-control']) !!}
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

@push('script-page')

    <script type="text/javascript">
        function getDesignation(did) {
            $.ajax({
                url: '{{route('employee.json')}}',
                type: 'POST',
                data: {
                    "department_id": did, "_token": "{{ csrf_token() }}",
                },
                success: function (data) {
                    $('#designation_id').empty();
                    $('#designation_id').append('<option value="">Select any Designation</option>');
                    $.each(data, function (key, value) {
                        var select = '';
                        if (key == '{{ $employee->designation_id }}') {
                            select = 'selected';
                        }

                        $('#designation_id').append('<option value="' + key + '"  ' + select + '>' + value + '</option>');
                    });
                }
            });
        }

        $(document).ready(function () {
            var d_id = $('#department_id').val();
            var designation_id = '{{ $employee->designation_id }}';
            getDesignation(d_id);
        });

        $(document).on('change', 'select[name=department_id]', function () {
            var department_id = $(this).val();
            getDesignation(department_id);
        });


    </script>
@endpush
