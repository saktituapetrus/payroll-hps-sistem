@extends('layouts.dashboard')
@section('page-title')
    {{__('Travel')}}
@endsection
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{__('Manage Trip')}}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{route('home')}}">{{__('Dashboard')}}</a></div>
                    <div class="breadcrumb-item">{{__('Trip')}}</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex justify-content-between w-100">
                                    <h4>{{__('Trip List')}}</h4>
                                    @can('Create Travel')
                                        <a href="#" data-url="{{ route('travel.create') }}" class="btn btn-sm btn-primary btn-round btn-icon" data-ajax-popup="true" data-toggle="tooltip" data-title="{{__('Create New Trip')}}" data-original-title="{{__('New Trip')}}">
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
                                            <th>{{__('Start Date')}}</th>
                                            <th>{{__('End Date')}}</th>
                                            <th>{{__('Purpose of Visit')}}</th>
                                            <th>{{__('Place Of Visit')}}</th>
                                            <th>{{__('Description')}}</th>
                                            @role('company')
                                            <th class="text-right" width="200px">{{__('Action')}}</th>
                                            @endrole
                                        </tr>
                                        </thead>
                                        <tbody class="font-style">
                                        @foreach ($travels as $travel)
                                            <tr>
                                                @role('company')
                                                <td>{{ $travel->employee()->name }}</td>
                                                @endrole
                                                <td>{{ \Auth::user()->dateFormat( $travel->start_date) }}</td>
                                                <td>{{ \Auth::user()->dateFormat( $travel->end_date) }}</td>
                                                <td>{{ $travel->purpose_of_visit }}</td>
                                                <td>{{ $travel->place_of_visit }}</td>
                                                <td>{{ $travel->description }}</td>
                                                @role('company')
                                                <td class="text-right">
                                                    @can('Edit Travel')
                                                        <a href="#" data-url="{{ URL::to('travel/'.$travel->id.'/edit') }}" data-size="lg" data-ajax-popup="true" data-title="{{__('Edit Trip')}}" class="btn btn-outline-primary btn-sm mr-1" data-toggle="tooltip" data-original-title="{{__('Edit Trip')}}"><i class="fas fa-pencil-alt"></i> <span>{{__('Edit ')}}</span></a>
                                                    @endcan
                                                    @can('Delete Travel')
                                                        <a href="#" class="btn btn-outline-danger btn-sm" data-toggle="tooltip" data-original-title="{{__('Delete')}}" data-confirm="Are You Sure?|This action can not be undone. Do you want to continue?" data-confirm-yes="document.getElementById('delete-form-{{$travel->id}}').submit();"><i class="fas fa-trash"></i> <span>{{__('Delete')}}</span></a>
                                                        {!! Form::open(['method' => 'DELETE', 'route' => ['travel.destroy', $travel->id],'id'=>'delete-form-'.$travel->id]) !!}
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

