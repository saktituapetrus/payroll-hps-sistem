@extends('layouts.dashboard')
@section('page-title')
    {{__('Expense')}}
@endsection
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{__('Manage Expense')}}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{route('home')}}">{{__('Dashboar')}}</a></div>
                    <div class="breadcrumb-item">{{__('Expense')}}</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex justify-content-between w-100">
                                    <h4>{{__('Expense List')}}</h4>
                                    @can('Create Expense')
                                        <a href="#" data-url="{{ route('expense.create') }}" class="btn btn-sm btn-primary btn-round btn-icon" data-ajax-popup="true" data-toggle="tooltip" data-title="{{__('Create New Expense')}}" data-original-title="{{__('Create Expense')}}">
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
                                            <th>{{__('Account')}}</th>
                                            <th>{{__('Payee')}}</th>
                                            <th>{{__('Amount')}}</th>
                                            <th>{{__('Category')}}</th>
                                            <th>{{__('Ref#')}}</th>
                                            <th>{{__('Payment')}}</th>
                                            <th>{{__('Date')}}</th>
                                            <th class="text-right" width="200px">{{__('Action')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($expenses as $expense)
                                            <tr>
                                                <td>{{ $expense->account($expense->account_id)->account_name }}</td>
                                                <td>{{ $expense->payee($expense->payee_id)->payee_name }}</td>
                                                <td>{{ \Auth::user()->priceFormat( $expense->amount) }}</td>
                                                <td>{{ $expense->expense_category($expense->expense_category_id)->name }}</td>
                                                <td>{{ $expense->referal_id }}</td>
                                                <td>{{ $expense->payment_type($expense->payment_type_id)->name }}</td>
                                                <td>{{  \Auth::user()->dateFormat($expense->date) }}</td>

                                                <td class="text-right">
                                                    @can('Edit Expense')
                                                        <a href="#" data-url="{{ URL::to('expense/'.$expense->id.'/edit') }}" data-size="lg" data-ajax-popup="true" data-title="{{__('Edit Expense')}}" class="btn btn-outline-primary btn-sm mr-1" data-toggle="tooltip" data-original-title="{{__('Edit')}}"><i class="fas fa-pencil-alt"></i> <span>{{__('Edit')}}</span></a>
                                                    @endcan
                                                    @can('Delete Expense')
                                                        <a href="#" class="btn btn-outline-danger btn-sm" data-toggle="tooltip" data-original-title="{{__('Delete')}}" data-confirm="Are You Sure?|This action can not be undone. Do you want to continue?" data-confirm-yes="document.getElementById('delete-form-{{$expense->id}}').submit();"><i class="fas fa-trash"></i> <span>{{__('Delete')}}</span></a>
                                                        {!! Form::open(['method' => 'DELETE', 'route' => ['expense.destroy', $expense->id],'id'=>'delete-form-'.$expense->id]) !!}
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

