@extends('layouts.dashboard')
@section('page-title')
    {{__('Promotion')}}
@endsection
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{__('Manage Promotion')}}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{route('home')}}">{{__('Dashboard')}}</a></div>
                    <div class="breadcrumb-item">{{__('Promotion')}}</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex justify-content-between w-100">
                                    <h4>{{__('Promotion List')}}</h4>
                                    @can('Create Promotion')
                                        <a href="#" data-url="{{ route('promotion.create') }}" class="btn btn-sm btn-primary btn-round btn-icon" data-ajax-popup="true" data-toggle="tooltip" data-title="{{__('Create New Promotion')}}" data-original-title="{{__('Create Promotion')}}">
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
                                            <th>{{__('Designation')}}</th>
                                            <th>{{__('Promotion Title')}}</th>
                                            <th>{{__('Promotion Date')}}</th>
                                            <th>{{__('Description')}}</th>
                                            @role('company')
                                            <th class="text-right" width="200px">{{__('Action')}}</th>
                                            @endrole

                                        </tr>
                                        </thead>
                                        <tbody class="font-style">
                                        @foreach ($promotions as $promotion)
                                            <tr>
                                                @role('company')
                                                <td>{{ $promotion->employee()->name }}</td>
                                                @endrole
                                                <td>{{ $promotion->designation()->name }}</td>
                                                <td>{{ $promotion->promotion_title }}</td>
                                                <td>{{  \Auth::user()->dateFormat($promotion->promotion_date) }}</td>
                                                <td>{{ $promotion->description }}</td>
                                                @role('company')
                                                <td class="text-right">
                                                    @can('Edit Promotion')
                                                        <a href="#" data-url="{{ URL::to('promotion/'.$promotion->id.'/edit') }}" data-size="lg" data-ajax-popup="true" data-title="{{__('Edit Promotion')}}" class="btn btn-outline-primary btn-sm mr-1" data-toggle="tooltip" data-original-title="{{__('Edit')}}"><i class="fas fa-pencil-alt"></i> <span>{{__('Edit')}}</span></a>
                                                    @endcan
                                                    @can('Delete Promotion')
                                                        <a href="#" class="btn btn-outline-danger btn-sm" data-toggle="tooltip" data-original-title="{{__('Delete')}}" data-confirm="Are You Sure?|This action can not be undone. Do you want to continue?" data-confirm-yes="document.getElementById('delete-form-{{$promotion->id}}').submit();"><i class="fas fa-trash"></i> <span>{{__('Delete')}}</span></a>
                                                        {!! Form::open(['method' => 'DELETE', 'route' => ['promotion.destroy', $promotion->id],'id'=>'delete-form-'.$promotion->id]) !!}
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
@endsection

