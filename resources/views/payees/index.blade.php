@extends('layouts.dashboard')
@section('page-title')
    {{__('Payee')}}
@endsection
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{__('Manage Payee')}}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{route('home')}}">{{__('Dashboard')}}</a></div>
                    <div class="breadcrumb-item">{{__('Payee')}}</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex justify-content-between w-100">
                                    <h4>{{__('Payee List')}}</h4>
                                    @can('Create Payee')
                                        <a href="#" data-url="{{ route('payees.create') }}" class="btn btn-sm btn-primary btn-round btn-icon" data-ajax-popup="true" data-toggle="tooltip" data-title="{{__('Create New Payee')}}" data-original-title="{{__('Create Payee')}}">
                                            <i class="fa fa-plus"></i>  {{__('Create')}}
                                        </a>
                                    @endcan
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped mb-0" id="dataTable">
                                        <thead>
                                        <tr>
                                            <th>{{__('Payee Name')}}</th>
                                            <th>{{__('Contact Number')}}</th>
                                            <th class="text-right" width="200px">{{__('Action')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody class="font-style">
                                        @foreach ($payees as $payee)
                                            <tr>
                                                <td>{{ $payee->payee_name }}</td>
                                                <td>{{ $payee->contact_number }}</td>

                                                <td class="text-right">
                                                    @can('Edit Payee')
                                                        <a href="#" data-url="{{ URL::to('payees/'.$payee->id.'/edit') }}" data-size="lg" data-ajax-popup="true" data-title="{{__('Edit Payee')}}" class="btn btn-outline-primary btn-sm mr-1" data-toggle="tooltip" data-original-title="{{__('Edit')}}"><i class="fas fa-pencil-alt"></i> <span>{{__('Edit')}}</span></a>
                                                    @endcan
                                                    @can('Delete Payee')
                                                        <a href="#" class="btn btn-outline-danger btn-sm" data-toggle="tooltip" data-original-title="{{__('Delete')}}" data-confirm="Are You Sure?|This action can not be undone. Do you want to continue?" data-confirm-yes="document.getElementById('delete-form-{{$payee->id}}').submit();"><i class="fas fa-trash"></i> <span>{{__('Delete')}}</span></a>
                                                        {!! Form::open(['method' => 'DELETE', 'route' => ['payees.destroy', $payee->id],'id'=>'delete-form-'.$payee->id]) !!}
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

