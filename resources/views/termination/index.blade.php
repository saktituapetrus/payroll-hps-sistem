@extends('layouts.dashboard')
@section('page-title')
    {{__('Termination')}}
@endsection
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{__('Manage Termination')}}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{route('home')}}">{{__('Dashboard')}}</a></div>
                    <div class="breadcrumb-item">{{__('Termination')}}</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex justify-content-between w-100">
                                    <h4>{{__('Termination List')}}</h4>
                                    @can('Create Termination')
                                        <a href="#" data-url="{{ route('termination.create') }}" class="btn btn-sm btn-primary btn-round btn-icon" data-ajax-popup="true" data-toggle="tooltip" data-title="{{__('Create New Termination')}}" data-original-title="{{__('Create Termination')}}">
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
                                            <th>{{__('Termination Type')}}</th>
                                            <th>{{__('Notice Date')}}</th>
                                            <th>{{__('Termination Date')}}</th>
                                            <th>{{__('Description')}}</th>
                                            @role('company')
                                            <th class="text-right" width="200px">{{__('Action')}}</th>
                                            @endrole
                                        </tr>
                                        </thead>
                                        <tbody class="font-style">
                                        @foreach ($terminations as $termination)
                                            <tr>
                                                @role('company')
                                                <td>{{ $termination->employee()->name }}</td>
                                                @endrole

                                                <td>{{ $termination->terminationType()->name }}</td>
                                                <td>{{  \Auth::user()->dateFormat($termination->notice_date) }}</td>
                                                <td>{{  \Auth::user()->dateFormat($termination->termination_date) }}</td>
                                                <td>{{ $termination->description }}</td>
                                                @role('company')
                                                <td class="text-right">
                                                    @can('Edit Termination')
                                                        <a href="#" data-url="{{ URL::to('termination/'.$termination->id.'/edit') }}" data-size="lg" data-ajax-popup="true" data-title="{{__('Edit Termination')}}" class="btn btn-outline-primary btn-sm mr-1" data-toggle="tooltip" data-original-title="{{__('Edit')}}"><i class="fas fa-pencil-alt"></i> <span>{{__('Edit')}}</span></a>
                                                    @endcan
                                                    @can('Delete Termination')
                                                        <a href="#" class="btn btn-outline-danger btn-sm" data-toggle="tooltip" data-original-title="{{__('Delete')}}" data-confirm="Are You Sure?|This action can not be undone. Do you want to continue?" data-confirm-yes="document.getElementById('delete-form-{{$termination->id}}').submit();"><i class="fas fa-trash"></i> <span>{{__('Delete')}}</span></a>
                                                        {!! Form::open(['method' => 'DELETE', 'route' => ['termination.destroy', $termination->id],'id'=>'delete-form-'.$termination->id]) !!}
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

