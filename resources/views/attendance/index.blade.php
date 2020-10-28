@extends('layouts.dashboard')
@section('page-title')
    {{__('Attendance')}}
@endsection
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{__('Manage Attendance')}}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{route('home')}}">{{__('Dashboard')}}</a></div>
                    <div class="breadcrumb-item">{{__('Attendance')}}</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex justify-content-between w-100">
                                    <h4>{{__('Attendance List')}}</h4>
                                    @can('Create Attendance')
                                        <a href="#" data-url="{{ route('attendanceemployee.create') }}" class="btn btn-sm btn-primary btn-round btn-icon" data-ajax-popup="true" data-toggle="tooltip" data-title="{{__('Add Attendance')}}" data-original-title="{{__('Add Attendance')}}">
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
                                            <th>{{__('Date')}}</th>
                                            <th>{{__('Status')}}</th>
                                            <th>{{__('Clock In')}}</th>
                                            <th>{{__('Clock Out')}}</th>
                                            <th>{{__('Late')}}</th>
                                            <th>{{__('Early Leaving')}}</th>
                                            <th>{{__('Overtime')}}</th>
                                            @if(Gate::check('Edit Attendance') || Gate::check('Delete Attendance'))
                                                <th>{{__('Action')}}</th>
                                            @endif
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($attendanceEmployee as $attendance)
                                            <tr>
                                                @if(\Auth::user()->type!='employee')
                                                    <td>{{\Auth::user()->getUSerEmployee($attendance->employee_id)->name }}</td>
                                                @endif
                                                <td>{{ \Auth::user()->dateFormat($attendance->date) }}</td>
                                                <td>{{ $attendance->status }}</td>
                                                <td>{{\Auth::user()->timeFormat( $attendance->clock_in) }}</td>
                                                <td>{{ ($attendance->clock_out !='00:00:00') ?\Auth::user()->timeFormat( $attendance->clock_out):'00:00' }}</td>
                                                <td>{{ $attendance->late }}</td>
                                                <td>{{ $attendance->early_leaving }}</td>
                                                <td>{{ $attendance->overtime }}</td>
                                                <td>
                                                    @can('Edit Attendance')
                                                        <a href="#" data-url="{{ URL::to('attendanceemployee/'.$attendance->id.'/edit') }}" data-size="lg" data-ajax-popup="true" data-title="{{__('Edit Attendance')}}" class="btn btn-outline-primary btn-sm mr-1" data-toggle="tooltip" data-original-title="{{__('Edit')}}"><i class="fas fa-pencil-alt"></i> <span>{{__('Edit')}}</span></a>
                                                    @endcan
                                                    @can('Delete Attendance')
                                                        <a href="#" class="btn btn-outline-danger btn-sm" data-toggle="tooltip" data-original-title="{{__('Delete')}}" data-confirm="Are You Sure?|This action can not be undone. Do you want to continue?" data-confirm-yes="document.getElementById('delete-form-{{$attendance->id}}').submit();"><i class="fas fa-trash"></i> <span>{{__('Delete')}}</span></a>
                                                        {!! Form::open(['method' => 'DELETE', 'route' => ['attendanceemployee.destroy', $attendance->id],'id'=>'delete-form-'.$attendance->id]) !!}
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
        $(document).ready(function () {
            $('.daterangepicker').daterangepicker({
                format: 'yyyy-mm-dd',
                locale: {format: 'YYYY-MM-DD'},
            });
        });
    </script>
@endpush
