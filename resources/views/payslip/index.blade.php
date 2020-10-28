@extends('layouts.dashboard')
@section('page-title')
{{__('Payslip')}}
@endsection
@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>{{__('Employee Salary')}}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">{{__('Home')}}</a></div>
                <div class="breadcrumb-item">{{__('Employee Salary')}}</div>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    @can('Create Employee')
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between w-100">
                                <h4>{{__('Employee Select Month Salary')}}</h4>

                                {{Form::open(array('route'=>array('payslip.store'),'method'=>'POST','class'=>'w-50 float-left'))}}
                                <div class="float-left col-4">
                                    {{Form::select('month',$month,null,array('class'=>'form-control month select2' ))}}
                                </div>
                                <div class="float-left col-4">
                                    {{Form::select('year',$year,null,array('class'=>'form-control year select2' ))}}
                                </div>
                                {!! Form::submit('Genrate Payslip', ['class' => 'btn btn-primary btn-lg float-right
                                search']) !!}
                                {!! Form::close() !!}

                            </div>
                        </div>
                    </div>
                    @endcan
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between w-100">
                                <h4>{{__('Employee Salary')}}</h4>

                                <div class="float-right col-4">
                                    {{Form::select('month',$month,null,array('class'=>'form-control month_date select2' ))}}
                                </div>
                                <div class="float-right col-4">
                                    {{Form::select('year',$year,null,array('class'=>'form-control year_date select2' ))}}
                                </div>
                                @can('Create Employee')
                                <a href="#" class="btn btn-sm btn-primary mr-2 ml-2 pt-2"
                                    id="bulk_payment">{{__('Bulk Payment')}}</a>
                                @endcan
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped mb-0" id="dataTable1">
                                    <thead>
                                        <tr>
                                            <th>{{__('Id')}}</th>
                                            <th>{{__('Employee Id')}}</th>
                                            <th>{{__('Name')}}</th>
                                            <th>{{__('Payroll Type') }}</th>
                                            <th>{{__('Salary') }}</th>
                                            <th>{{__('Net Salary') }}</th>
                                            <th>{{__('Status') }}</th>
                                            <th>{{__('Action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@push('script-page')

<script type="text/javascript">
    var table = $('#dataTable1').DataTable({
                "aoColumnDefs": [
                    {
                        "aTargets": [6],
                        "mData": null,
                        "mRender": function (data, type, full) {
                            var month = $(".month_date").val();
                            var year = $(".year_date").val();
                            var datePicker = year + '-' + month;
                            var id = data[0];

                            if (data[6] == 'Paid')
                                return '<div class="badge badge-success"><a href="#" class="text-white">' + data[6] + '</a></div>';
                            else
                                return '<div class="badge badge-danger"><a  href="#" class="text-white">' + data[6] + '</a></div>';
                        }
                    },
                    {
                        "aTargets": [7],
                        "mData": null,
                        "mRender": function (data, type, full) {
                            var month = $(".month_date").val();
                            var year = $(".year_date").val();
                            var datePicker = year + '-' + month;

                            var id = data[0];

                            var clickToPaid = '';

                                {{--var payslip = '<a href="#" data-url="{{ url('payslip/pdf') }}/' + id + '"  class="btn btn-sm btn-warning btn-round btn-icon text-white"  data-ajax-popup="true" data-toggle="tooltip" data-original-title="{{__('Payslip Detail')}}">' + '{{__('Payslip')}}' + '</a> ';--}}
                            var payslip = '<a data-url="{{ url('payslip/pdf/') }}/' + id + '" data-size="md-pdf"  data-ajax-popup="true" data-toggle="tooltip" class="btn btn-sm btn-warning btn-round btn-icon text-white" data-title="{{__('Payslip')}}" data-original-title="{{__('Payslip')}}">' + '{{__('Payslip')}}' + '</a> ';

                            if (data[6] == "UnPaid") {
                                clickToPaid = '<a href="{{ url('payslip/paysalary/') }}/' + id + '/' + datePicker + '"  class="btn btn-sm btn-success btn-round btn-icon text-white">' + '{{__('Click To Paid')}}' + '</a>  ';
                            }
                            return '<a data-url="{{ url('payslip/showemployee/') }}/' + data[7] + '"  data-ajax-popup="true" data-toggle="tooltip" class="btn btn-sm btn-info btn-round btn-icon text-white" data-title="{{__('View Employee Detail')}}" data-original-title="{{__('View Employee Detail')}}">' + '{{__('View')}}' + '</a>  ' + payslip + clickToPaid


                        }
                    },
                ]
            });


            function callback() {
                var month = $(".month_date").val();
                var year = $(".year_date").val();
                var datePicker = year + '-' + month;

                $.ajax({
                    url: '{{route('payslip.search_json')}}',
                    type: 'POST',
                    data: {
                        "datePicker": datePicker, "_token": "{{ csrf_token() }}",
                    },
                    success: function (data) {
                        table.rows().remove().draw();
                        table.rows.add(data).draw();
                        table.column(0).visible(false);

                        if (!(data)) {
                            show_msg('error', 'Payslip Not Found!', 'error');
                        }
                    },
                    error: function (data) {

                    }
                });
            }

            $(document).on("change", ".month_date,.year_date", function () {
                callback();
            });
            // });
            $(document).load(".month_date,.year_date", function () {

                callback();
            });

            //bulkpayment Click
            $(document).on("click", "#bulk_payment", function () {
                var month = $(".month_date").val();
                var year = $(".year_date").val();
                var datePicker = year + '_' + month;

            });

            $(document).on('click', '#bulk_payment', 'a[data-ajax-popup="true"], button[data-ajax-popup="true"], div[data-ajax-popup="true"]', function () {
                var month = $(".month_date").val();
                var year = $(".year_date").val();
                var datePicker = year + '-' + month;

                var title = 'Bulk Payment';
                var size = 'md';
                var url = 'payslip/bulk_pay_create/' + datePicker;

                // return false;

                $("#commonModal .modal-title").html(title);
                $("#commonModal .modal-dialog").addClass('modal-' + size);
                $.ajax({
                    url: url,
                    success: function (data) {
                        console.log('here data' + data);
                        // alert(data);
                        // return false;
                        if (data.length) {
                            $('#commonModal .modal-body').html(data);
                            $("#commonModal").modal('show');
                            // common_bind();
                        } else {
                            show_msg('Error', 'Permission denied.');
                            $("#commonModal").modal('hide');
                        }
                    },
                    error: function (data) {
                        data = data.responseJSON;
                        show_msg('Error', data.error);
                    }
                });
            });


</script>
@endpush
@endsection