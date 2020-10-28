@extends('layouts.dashboard')
@section('page-title')
    {{__('Resignation')}}
@endsection
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{__('Manage Resignation')}}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{__('home')}}">{{__('Dashboard')}}</a></div>
                    <div class="breadcrumb-item">{{__('Resignation')}}</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex justify-content-between w-100">
                                    <h4>{{__('Resignation List')}}</h4>
                                    @can('Create Resignation')
                                        <a href="#" data-url="{{ route('resignation.create') }}" class="btn btn-sm btn-primary btn-round btn-icon" data-ajax-popup="true" data-toggle="tooltip" data-title="{{__('Create New Resignation')}}" data-original-title="{{__('Create Resignation')}}">
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
                                            @role('company')
                                            <th>{{__('Employee Name')}}</th>
                                            @endrole
                                            <th>{{__('Notice Date')}}</th>
                                            <th>{{__('Resignation Date')}}</th>
                                            <th>{{__('Description')}}</th>
                                            <th class="text-right" width="200px">{{__('Action')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody class="font-style">
                                        @foreach ($resignations as $resignation)
                                            <tr>
                                                @role('company')
                                                <td>{{ $resignation->employee()->name }}</td>
                                                @endrole
                                                <td>{{  \Auth::user()->dateFormat($resignation->notice_date) }}</td>
                                                <td>{{  \Auth::user()->dateFormat($resignation->resignation_date) }}</td>
                                                <td>{{ $resignation->description }}</td>

                                                <td class="text-right">
                                                    @can('Edit Resignation')
                                                        <a href="#" data-url="{{ URL::to('resignation/'.$resignation->id.'/edit') }}" data-size="lg" data-ajax-popup="true" data-title="{{__('Edit Resignation')}}" class="btn btn-outline-primary btn-sm mr-1" data-toggle="tooltip" data-original-title="{{__('Edit')}}"><i class="fas fa-pencil-alt"></i> <span>{{__('Edit')}}</span></a>
                                                    @endcan
                                                    @can('Delete Resignation')
                                                        <a href="#" class="btn btn-outline-danger btn-sm" data-toggle="tooltip" data-original-title="{{__('Delete')}}" data-confirm="Are You Sure?|This action can not be undone. Do you want to continue?" data-confirm-yes="document.getElementById('delete-form-{{$resignation->id}}').submit();"><i class="fas fa-trash"></i> <span>{{__('Delete')}}</span></a>
                                                        {!! Form::open(['method' => 'DELETE', 'route' => ['resignation.destroy', $resignation->id],'id'=>'delete-form-'.$resignation->id]) !!}
                                                        {!! Form::close() !!}
                                                    @endcan
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

