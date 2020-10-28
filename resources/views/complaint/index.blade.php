@extends('layouts.dashboard')
@section('page-title')
    {{__('Complain')}}
@endsection
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{__('Manage Complaint')}}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{route('home')}}">{{__('Dashboard')}}</a></div>
                    <div class="breadcrumb-item">{{__('Complaint')}}</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex justify-content-between w-100">
                                    <h4>{{__('Complaint List')}}</h4>
                                    @can('Create Complaint')
                                        <a href="#" data-url="{{ route('complaint.create') }}" class="btn btn-sm btn-primary btn-round btn-icon" data-ajax-popup="true" data-toggle="tooltip" data-title="{{__('Create New Complaint')}}" data-original-title="{{__('Create Complaint')}}">
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
                                            <th>{{__('Complaint From')}}</th>
                                            <th>{{__('Complaint Against')}}</th>
                                            <th>{{__('Title')}}</th>
                                            <th>{{__('Complaint Date')}}</th>
                                            <th>{{__('Description')}}</th>
                                            <th class="text-right" width="200px">{{__('Action')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody class="font-style">
                                        @foreach ($complaints as $complaint)
                                         
                                            <tr>
                                                <td>{{ $complaint->complaintFrom($complaint->complaint_from)->name }}</td>
                                                <td>{{ $complaint->complaintAgainst($complaint->complaint_against)->name }}</td>
                                                <td>{{ $complaint->title }}</td>
                                                <td>{{ \Auth::user()->dateFormat( $complaint->complaint_date) }}</td>
                                                <td>{{ $complaint->description }}</td>
                                                <td class="text-right">
                                                    @can('Edit Complaint')
                                                        <a href="#" data-url="{{ URL::to('complaint/'.$complaint->id.'/edit') }}" data-size="lg" data-ajax-popup="true" data-title="{{__('Edit Complaint')}}" class="btn btn-outline-primary btn-sm mr-1" data-toggle="tooltip" data-original-title="{{__('Edit')}}"><i class="fas fa-pencil-alt"></i> <span>{{__('Edit')}}</span></a>
                                                    @endcan
                                                    @can('Delete Complaint')
                                                        <a href="#" class="btn btn-outline-danger btn-sm" data-toggle="tooltip" data-original-title="{{__('Delete')}}" data-confirm="Are You Sure?|This action can not be undone. Do you want to continue?" data-confirm-yes="document.getElementById('delete-form-{{$complaint->id}}').submit();"><i class="fas fa-trash"></i> <span>{{__('Delete')}}</span></a>
                                                        {!! Form::open(['method' => 'DELETE', 'route' => ['complaint.destroy', $complaint->id],'id'=>'delete-form-'.$complaint->id]) !!}
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

