@extends('layouts.dashboard')
@section('page-title')
    {{__('Account')}}
@endsection
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{__('Manage Account List')}}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{route('home')}}">{{__('Dashboard')}}</a></div>
                    <div class="breadcrumb-item">{{__('Account List')}}</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex justify-content-between w-100">
                                    <h4>{{__('Account List')}}</h4>
                                    @can('Create Account List')
                                        <a href="#" data-url="{{ route('accountlist.create') }}" class="btn btn-sm btn-primary btn-round btn-icon" data-ajax-popup="true" data-toggle="tooltip" data-title="{{__('Create New Account')}}" data-original-title="{{__('Create Account')}}">
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
                                            <th>{{__('Account Name')}}</th>
                                            <th>{{__('Initial Balance')}}</th>
                                            <th>{{__('Account Number')}}</th>
                                            <th>{{__('Branch Code')}}</th>
                                            <th>{{__('Bank Branch')}}</th>
                                            <th class="text-right" width="200px">{{__('Action')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody class="font-style">
                                        @foreach ($accountlists as $accountlist)
                                            <tr>
                                                <td>{{ $accountlist->account_name }}</td>
                                                <td>{{  \Auth::user()->priceFormat($accountlist->initial_balance) }}</td>
                                                <td>{{ $accountlist->account_number }}</td>
                                                <td>{{ $accountlist->branch_code }}</td>
                                                <td>{{ $accountlist->bank_branch }}</td>

                                                <td class="text-right">
                                                    @can('Edit Account List')
                                                        <a href="#" data-url="{{ URL::to('accountlist/'.$accountlist->id.'/edit') }}" data-size="lg" data-ajax-popup="true" data-title="{{__('Edit Account List')}}" class="btn btn-outline-primary btn-sm mr-1" data-toggle="tooltip" data-original-title="{{__('Edit')}}"><i class="fas fa-pencil-alt"></i> <span>{{__('Edit')}}</span></a>
                                                    @endcan
                                                    @can('Delete Account List')
                                                        <a href="#" class="btn btn-outline-danger btn-sm" data-toggle="tooltip" data-original-title="{{__('Delete')}}" data-confirm="Are You Sure?|This action can not be undone. Do you want to continue?" data-confirm-yes="document.getElementById('delete-form-{{$accountlist->id}}').submit();"><i class="fas fa-trash"></i> <span>{{__('Delete')}}</span></a>
                                                        {!! Form::open(['method' => 'DELETE', 'route' => ['accountlist.destroy', $accountlist->id],'id'=>'delete-form-'.$accountlist->id]) !!}
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

