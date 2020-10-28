@extends('layouts.dashboard')
@section('page-title')
    {{__('Leave')}}
@endsection
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{__('Manage Leave')}}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{route('home')}}">{{__('Dashboard')}}</a></div>
                    <div class="breadcrumb-item">{{__('Leave')}}</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex justify-content-between w-100">
                                    <h4>{{__('Leave List')}}</h4>
                                    @can('Create Leave')
                                        <a href="#" data-url="{{ route('leave.create') }}" class="btn btn-sm btn-primary btn-round btn-icon" data-ajax-popup="true" data-toggle="tooltip" data-title="{{__('Create New Leave')}}" data-original-title="{{__('Create Leave')}}">
                                            <i class="fa fa-plus"></i> {{__('Create')}}
                                        </a>
                                    @endcan
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped mb-0" id="dataTable">
                                        <thead>
                                        <tr>
                                            @if(\Auth::user()->type!='employee')
                                                <th>{{__('Employee')}}</th>
                                            @endif
                                            <th>{{__('Leave Type')}}</th>
                                            <th>{{__('Applied On')}}</th>
                                            <th>{{__('Start Date')}}</th>
                                            <th>{{__('End Date')}}</th>
                                            <th>{{__('Total Days')}}</th>
                                            <th>{{__('Leave Reason')}}</th>
                                            <th>{{__('status')}}</th>
                                            <th class="text-right" width="200px">{{__('Action')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($leaves as $leave)
                                            <tr>
                                                @if(\Auth::user()->type!='employee')
                                                    <td>{{ \Auth::user()->getEmployee($leave->employee_id)->name }}</td>
                                                @endif
                                                <td>{{ \Auth::user()->getLeaveType($leave->leave_type_id)->title }}</td>
                                                <td>{{ \Auth::user()->dateFormat($leave->applied_on )}}</td>
                                                <td>{{ \Auth::user()->dateFormat($leave->start_date ) }}</td>
                                                <td>{{ \Auth::user()->dateFormat($leave->end_date )  }}</td>
                                                @php
                                                    $startDate = new \DateTime($leave->start_date);
                                                    $endDate   = new \DateTime($leave->end_date);
                                                    $total_leave_days = $startDate->diff($endDate)->days;
                                                @endphp
                                                <td>{{ $total_leave_days }}</td>
                                                <td>{{ $leave->leave_reason }}</td>
                                                <td>
                                                    @if($leave->status=="Pending")
                                                        <div class="badge badge-warning">{{ $leave->status }}</div>
                                                    @elseif($leave->status=="Approval")
                                                        <div class="badge badge-success">{{ $leave->status }}</div>
                                                    @else($leave->status=="Reject")
                                                        <div class="badge badge-danger">{{ $leave->status }}</div>
                                                    @endif
                                                </td>
                                                <td class="text-right">

                                                    @if(\Auth::user()->type == 'employee')
                                                        @if($leave->status == "approval" || $leave->status == "reject")
                                                        @else
                                                            @can('Edit Leave')
                                                                <a href="#" data-url="{{ URL::to('leave/'.$leave->id.'/edit') }}" data-size="lg" data-ajax-popup="true" data-title="{{__('Edit Leave')}}" class="btn btn-outline-primary btn-sm mr-1" data-toggle="tooltip" data-original-title="{{__('Edit')}}"><i class="fas fa-pencil-alt"></i> <span>{{__('Edit')}}</span></a>
                                                            @endcan
                                                        @endif
                                                    @else
                                                        <a href="#" data-url="{{ URL::to('leave/'.$leave->id.'/action') }}" data-size="lg" data-ajax-popup="true" data-title="{{__('Leave Action')}}" class="btn btn-outline-success btn-sm mr-1" data-toggle="tooltip" data-original-title="{{__('Leave Action')}}"><i class="fas fa-caret-right"></i> <span>{{__('Approval')}}</span></a>
                                                        @can('Edit Leave')
                                                            <a href="#" data-url="{{ URL::to('leave/'.$leave->id.'/edit') }}" data-size="lg" data-ajax-popup="true" data-title="{{__('Edit Leave')}}" class="btn btn-outline-primary btn-sm mr-1" data-toggle="tooltip" data-original-title="{{__('Edit')}}"><i class="fas fa-pencil-alt"></i> <span>{{__('Edit')}}</span></a>
                                                        @endcan
                                                    @endif

                                                    @can('Delete Leave')
                                                        <a href="#" class="btn btn-outline-danger btn-sm" data-toggle="tooltip" data-original-title="{{__('Delete')}}" data-confirm="Are You Sure?|This action can not be undone. Do you want to continue?" data-confirm-yes="document.getElementById('delete-form-{{$leave->id}}').submit();"><i class="fas fa-trash"></i> <span>{{__('Delete')}}</span></a>
                                                        {!! Form::open(['method' => 'DELETE', 'route' => ['leave.destroy', $leave->id],'id'=>'delete-form-'.$leave->id]) !!}
                                                        {!! Form::close() !!}
                                                    @endif
                                                </td>
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
        </section>
    </div>
@endsection

@push('script-page')
    <script>
        $(document).on('change', '#employee_id', function () {

            console.log($(this).val());
            var employee_id = $(this).val();

            $.ajax({
                url: '{{route('leave.jsoncount')}}',
                type: 'POST',
                data: {
                    "employee_id": employee_id, "_token": "{{ csrf_token() }}",
                },
                success: function (data) {

                    $('#leave_type_id').empty();
                    $('#leave_type_id').append('<option value="">{{__('Select Leave Type')}}</option>');

                    $.each(data, function (key, value) {

                        if (value.total_leave >= value.days) {
                            $('#leave_type_id').append('<option value="' + value.id + '" disabled>' + value.title + '&nbsp(' + value.total_leave + '/' + value.days + ')</option>');
                        } else {
                            $('#leave_type_id').append('<option value="' + value.id + '">' + value.title + '&nbsp(' + value.total_leave + '/' + value.days + ')</option>');
                        }
                    });

                }
            });
        });

    </script>
@endpush
