@extends('layouts.dashboard')

@section('page-title')
{{__('Loan Custom')}}
@endsection

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>{{__('Loan Custom')}}</h1>

            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{__('home')}}">{{__('Dashboard')}}</a></div>
                <div class="breadcrumb-item">{{__('Loan Custom')}}</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between w-100">
                                <h4>{{__('Manage Loan Custom')}}</h4>
				@can('Edit Set Salary')
                                <a href="{{ route('loancustom.create') }}" class="btn btn-icon icon-left btn-primary">
                                    <i class="fa fa-plus"></i> {{ __('Create') }}
                                </a>
				@endcan
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped mb-0" id="dataTable">
                                    <thead>
                                        <tr>
                                            <th>{{__('No')}}</th>
                                            <th>{{__('Name')}}</th>
                                            <th>{{__('Loan Type')}}</th>
                                            <th>{{__('Loan Amount') }}</th>
                                            <th>{{__('Tenor') }}</th>
                                            <th>{{__('Loan Date') }}</th>
                                            <th class="text-right" width="200px">{{__('Action')}}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                        $no = 1;
                                        @endphp

                                        @foreach ($loanCustoms as $loanCustom)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td class="font-style">{{ $loanCustom->employees->name }}</td>
                                            <td class="font-style">{{ $loanCustom->loan_type }}</td>

                                            <td class="font-style">
                                                {{ Auth::user()->priceFormat($loanCustom->loan_amount) }}
                                            </td>

                                            <td class="font-style">{{ $loanCustom->tenor }}</td>

                                            <td class="font-style">
                                                {{ Auth::user()->dateFormat($loanCustom->loan_date) }}
                                            </td>

                                            <td class="text-right">
                                                <a href="{{route('loancustom.show',$loanCustom->id)}}"
                                                    class="btn btn-outline-warning btn-sm mr-1">
                                                    <i class="fas fa-eye"> <span>{{__('View')}}</span></i>
                                                </a>
						@can('Edit Set Salary')
                                                <a href="{{ URL::to('loancustom/'.$loanCustom->id.'/edit') }}"
                                                    class="btn btn-outline-primary btn-sm mr-1">
                                                    <i class="fas fa-pencil-alt"></i> <span>{{__('Edit')}}</span>
                                                </a>

                                                <a href="#" class="btn btn-outline-danger btn-sm" data-toggle="tooltip"
                                                    data-original-title="{{__('Delete')}}"
                                                    data-confirm="Are You Sure?|This action can not be undone. Do you want to continue?"
                                                    data-confirm-yes="document.getElementById('delete-form-{{$loanCustom->id}}').submit();">
                                                    <i class="fas fa-trash"></i> <span>{{__('Delete')}}</span>
                                                </a>
						@endcan
                                                {!! Form::open(['method' => 'DELETE', 'route' =>
                                                ['loancustom.destroy',$loanCustom->id],'id'=>'delete-form-'.$loanCustom->id])
                                                !!}

                                                {!! Form::close() !!}
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
