@extends('layouts.dashboard')
@section('content')

<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>{{__('Employee Set Salary')}}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">{{__('Dashboard')}}</a></div>
                <div class="breadcrumb-item">{{__('Employee Set Salary')}}</div>
            </div>
        </div>

        @csrf
        <div class="row">
            <div class="col-12">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h4>{{__('Employee Salary')}}</h4>
                            </div>
                            <div class="card-body">
                                <div class="project-info d-flex">
                                    <div class="project-info-inner mr-3 col-6">
                                        <b class="m-0"> {{__('Payslip Type') }} </b>
                                        <div class="project-amnt pt-1">{{ $employee->salary_type() }}</div>
                                    </div>
                                    <div class="project-info-inner mr-3 col-6">
                                        <b class="m-0"> {{__('Salary') }} </b>
                                        <div class="project-amnt pt-1">{{ $employee->salary }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h4>{{__('Allowance')}}</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped mb-0">
                                        <thead>
                                            <tr>
                                                <th>{{__('Employee Name')}}</th>
                                                <th>{{__('Allownace Option')}}</th>
                                                <th>{{__('Title')}}</th>
                                                <th>{{__('Amount')}}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($allowances as $allowance)
                                            <tr>
                                                <td>{{ $allowance->employee()->name }}</td>
                                                <td>{{ $allowance->allowance_option()->name }}</td>
                                                <td>{{ $allowance->title }}</td>
                                                <td>{{  \Auth::user()->priceFormat($allowance->amount) }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h4>{{__('Commission')}}</h4>
                            </div>
                            <div class="card-body">

                                <div class="table-responsive">
                                    <table class="table table-striped mb-0">
                                        <thead>
                                            <tr>
                                                <th>{{__('Employee Name')}}</th>
                                                <th>{{__('Title')}}</th>
                                                <th>{{__('Amount')}}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($commissions as $commission)
                                            <tr>
                                                <td>{{ $commission->employee()->name }}</td>
                                                <td>{{ $commission->title }}</td>
                                                <td>{{ \Auth::user()->priceFormat( $commission->amount) }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h4>{{__('Loan')}}</h4>
                            </div>
                            <div class="card-body">

                                <div class="table-responsive">
                                    <table class="table table-striped mb-0">
                                        <thead>
                                            <tr>
                                                <th>{{__('employee')}}</th>
                                                <th>{{__('Loan Options')}}</th>
                                                <th>{{__('Title')}}</th>
                                                <th>{{__('Loan Amount')}}</th>
                                                <th>{{__('Start Date')}}</th>
                                                <th>{{__('End Date')}}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($loans as $loan)
                                            <tr>
                                                <td>{{ $loan->employee()->name }}</td>
                                                <td>{{ $loan->loan_option()->name }}</td>
                                                <td>{{ $loan->title }}</td>
                                                <td>{{  \Auth::user()->priceFormat($loan->amount) }}</td>
                                                <td>{{  \Auth::user()->dateFormat($loan->start_date) }}</td>
                                                <td>{{ \Auth::user()->dateFormat( $loan->end_date) }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h4>{{__('Saturation Deduction')}}</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped mb-0">
                                        <thead>
                                            <tr>
                                                <th>{{__('Employee Name')}}</th>
                                                <th>{{__('Deduction Option')}}</th>
                                                <th>{{__('Title')}}</th>
                                                <th>{{__('Amount')}}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($saturationdeductions as $saturationdeduction)
                                            <tr>
                                                <td>{{ $saturationdeduction->employee()->name }}</td>
                                                <td>{{ $saturationdeduction->deduction_option()->name }}</td>
                                                <td>{{ $saturationdeduction->title }}</td>
                                                <td>{{ \Auth::user()->priceFormat( $saturationdeduction->amount) }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h4>{{__('Other Payment')}}</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped mb-0">
                                        <thead>
                                            <tr>
                                                <th>{{__('employee')}}</th>
                                                <th>{{__('Title')}}</th>
                                                <th>{{__('Amount')}}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($otherpayments as $otherpayment)
                                            <tr>
                                                <td>{{ $otherpayment->employee()->name }}</td>
                                                <td>{{ $otherpayment->title }}</td>
                                                <td>{{  \Auth::user()->priceFormat($otherpayment->amount) }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h4>{{__('Overtime')}}</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped mb-0">
                                        <thead>
                                            <tr>
                                                <th>{{__('Employee Name')}}</th>
                                                <th>{{__('Overtime Title')}}</th>
                                                <th>{{__('Number of days')}}</th>
                                                <th>{{__('Hours')}}</th>
                                                <th>{{__('Rate')}}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($overtimes as $overtime)
                                            <tr>
                                                <td>{{ $overtime->employee()->name }}</td>
                                                <td>{{ $overtime->title }}</td>
                                                <td>{{ $overtime->number_of_days }}</td>
                                                <td>{{ $overtime->hours }}</td>
                                                <td>{{  \Auth::user()->priceFormat($overtime->rate) }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
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

@push('script-page')

<script type="text/javascript">
    $(document).ready(function () {
            var d_id = $('#department_id').val();
            var designation_id = '{{ $employee->designation_id }}';
            getDesignation(d_id);


            $("#allowance-dataTable").dataTable({
                "columnDefs": [
                    {"sortable": false, "targets": [1]}
                ]
            });

            $("#commission-dataTable").dataTable({
                "columnDefs": [
                    {"sortable": false, "targets": [1]}
                ]
            });

            $("#loan-dataTable").dataTable({
                "columnDefs": [
                    {"sortable": false, "targets": [1]}
                ]
            });

            $("#saturation-deduction-dataTable").dataTable({
                "columnDefs": [
                    {"sortable": false, "targets": [1]}
                ]
            });

            $("#other-payment-dataTable").dataTable({
                "columnDefs": [
                    {"sortable": false, "targets": [1]}
                ]
            });

            $("#overtime-dataTable").dataTable({
                "columnDefs": [
                    {"sortable": false, "targets": [1]}
                ]
            });
        });

        $(document).on('change', 'select[name=department_id]', function () {
            var department_id = $(this).val();
            getDesignation(department_id);
        });

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

</script>
@endpush