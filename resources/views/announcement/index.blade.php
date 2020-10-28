@extends('layouts.dashboard')
@section('page-title')
    {{__('Announcement')}}
@endsection
@push('css-page')
    <link rel="stylesheet" href="{{ asset('assets/modules/fullcalendar/fullcalendar.min.css') }}">
@endpush
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{__('Manage Announcement')}}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{route('home')}}">{{__('Dashboard')}}</a></div>
                    <div class="breadcrumb-item">{{__('Announcement')}}</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex justify-content-between w-100">
                                    <h4>{{__('Announcement List')}}</h4>
                                    @can('Create Announcement')
                                        <a href="#" data-url="{{ route('announcement.create') }}" class="btn btn-sm btn-primary btn-round btn-icon" data-ajax-popup="true" data-toggle="tooltip" data-title="{{__('Create New Announcement')}}" data-original-title="{{__('Create Announcement')}}">
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
                                            <th>{{__('Title')}}</th>
                                            <th>{{__('Start Date')}}</th>
                                            <th>{{__('End Date')}}</th>
                                            <th>{{__('description')}}</th>
                                            @role('company')
                                            <th width="200px">{{__('Action')}}</th>
                                            @endrole
                                        </tr>
                                        </thead>
                                        <tbody class="font-style">
                                        @foreach ($announcements as $announcement)
                                            <tr>
                                                <td>{{ $announcement->title }}</td>
                                                <td>{{  \Auth::user()->dateFormat($announcement->start_date) }}</td>
                                                <td>{{  \Auth::user()->dateFormat($announcement->end_date) }}</td>
                                                <td>{{ $announcement->description }}</td>
                                                @role('company')
                                                <td>
                                                    @can('Edit Announcement')
                                                        <a href="#" data-url="{{ URL::to('announcement/'.$announcement->id.'/edit') }}" data-size="lg" data-ajax-popup="true" data-title="{{__('Edit Announcement')}}" class="btn btn-outline-primary btn-sm mr-1" data-toggle="tooltip" data-original-title="{{__('Edit')}}"><i class="fas fa-pencil-alt"></i> <span>{{__('Edit')}}</span></a>
                                                    @endcan
                                                    @can('Delete Announcement')
                                                        <a href="#" class="btn btn-outline-danger btn-sm" data-toggle="tooltip" data-original-title="{{__('Delete')}}" data-confirm="Are You Sure?|This action can not be undone. Do you want to continue?" data-confirm-yes="document.getElementById('delete-form-{{$announcement->id}}').submit();"><i class="fas fa-trash"></i> <span>{{__('Delete')}}</span></a>
                                                        {!! Form::open(['method' => 'DELETE', 'route' => ['announcement.destroy', $announcement->id],'id'=>'delete-form-'.$announcement->id]) !!}
                                                        {!! Form::close() !!}
                                                    @endif
                                                </td>
                                                @endrole
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
    @push('script-page')
        <script>

            //Branch Wise Deapartment Get
            $(document).ready(function () {
                var b_id = $('#branch_id').val();
                getDepartment(b_id);
            });

            $(document).on('change', 'select[name=branch_id]', function () {
                var branch_id = $(this).val();
                getDepartment(branch_id);
            });

            function getDepartment(bid) {

                $.ajax({
                    url: '{{route('announcement.getdepartment')}}',
                    type: 'POST',
                    data: {
                        "branch_id": bid, "_token": "{{ csrf_token() }}",
                    },
                    success: function (data) {
                        console.log(data);
                        $('#department_id').empty();
                        $('#department_id').append('<option value="">{{__('Select Department')}}</option>');

                        $('#department_id').append('<option value="0"> {{__('All Department')}} </option>');
                        $.each(data, function (key, value) {
                            $('#department_id').append('<option value="' + key + '">' + value + '</option>');
                        });
                    }
                });
            }

            $(document).on('change', '#department_id', function () {
                var department_id = $(this).val();
                getEmployee(department_id);
            });

            function getEmployee(did) {

                $.ajax({
                    url: '{{route('announcement.getemployee')}}',
                    type: 'POST',
                    data: {
                        "department_id": did, "_token": "{{ csrf_token() }}",
                    },
                    success: function (data) {

                        $('#employee_id').empty();
                        $('#employee_id').append('<option value="">{{__('Select Employee')}}</option>');
                        $('#employee_id').append('<option value="0"> {{__('All Employee')}} </option>');

                        $.each(data, function (key, value) {
                            $('#employee_id').append('<option value="' + key + '">' + value + '</option>');
                        });
                    }
                });
            }
        </script>

    @endpush

@endsection

