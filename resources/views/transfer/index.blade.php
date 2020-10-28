@extends('layouts.dashboard')
@section('page-title')
    {{__('Transfer')}}
@endsection
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{__('Manage Transfer')}}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{route('home')}}">{{__('Dashboard')}}</a></div>
                    <div class="breadcrumb-item">{{__('Transfer')}}</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex justify-content-between w-100">
                                    <h4>{{__('Transfer List')}}</h4>
                                    @can('Create Transfer')
                                        <a href="#" data-url="{{ route('transfer.create') }}" class="btn btn-sm btn-primary btn-round btn-icon" data-ajax-popup="true" data-toggle="tooltip" data-title="{{__('Create New Transfer')}}" data-original-title="{{__('Create Transfer')}}">
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
                                            <th>{{__('Branch')}}</th>
                                            <th>{{__('Department')}}</th>
                                            <th>{{__('Transfer Date')}}</th>
                                            <th>{{__('Description')}}</th>
                                            @role('company')
                                            <th class="text-right" width="200px">{{__('Action')}}</th>
                                            @endrole
                                        </tr>
                                        </thead>
                                        <tbody class="font-style">
                                        @foreach ($transfers as $transfer)
                                            <tr>
                                                @role('company')
                                                <td>{{ $transfer->employee()->name }}</td>
                                                @endrole
                                                <td>{{ $transfer->branch()->name }}</td>
                                                <td>{{ $transfer->department()->name }}</td>
                                                <td>{{  \Auth::user()->dateFormat($transfer->transfer_date) }}</td>
                                                <td>{{ $transfer->description }}</td>
                                                @role('company')
                                                <td class="text-right">
                                                    @can('Edit Transfer')
                                                        <a href="#" data-url="{{ URL::to('transfer/'.$transfer->id.'/edit') }}" data-size="lg" data-ajax-popup="true" data-title="{{__('Edit Transfer')}}" class="btn btn-outline-primary btn-sm mr-1" data-toggle="tooltip" data-original-title="{{__('Edit')}}"><i class="fas fa-pencil-alt"></i> <span>{{__('Edit')}}</span></a>
                                                    @endcan
                                                    @can('Delete Transfer')
                                                        <a href="#" class="btn btn-outline-danger btn-sm" data-toggle="tooltip" data-original-title="{{__('Delete')}}" data-confirm="Are You Sure?|This action can not be undone. Do you want to continue?" data-confirm-yes="document.getElementById('delete-form-{{$transfer->id}}').submit();"><i class="fas fa-trash"></i> <span>{{__('Delete')}}</span></a>
                                                        {!! Form::open(['method' => 'DELETE', 'route' => ['transfer.destroy', $transfer->id],'id'=>'delete-form-'.$transfer->id]) !!}
                                                        {!! Form::close() !!}
                                                    @endcan
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
@endsection

