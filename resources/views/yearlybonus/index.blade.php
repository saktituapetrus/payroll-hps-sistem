@extends('layouts.dashboard')

@section('page-title')
{{__('Yearly Bonus')}}
@endsection

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>{{__('Yearly Bonus')}}</h1>

            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{__('home')}}">{{__('Dashboard')}}</a></div>
                <div class="breadcrumb-item">{{__('Yearly Bonus')}}</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between w-100">
                                <h4>{{__('Manage Yearly Bonus')}}</h4>
				@can('Edit Set Salary')
                                <a href="{{ route('yearlybonus.create') }}" class="btn btn-icon icon-left btn-primary">
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
                                            <th>{{__('Bonus Type')}}</th>
                                            <th>{{__('Bonus Amount') }}</th>
                                            <th>{{__('Date Disbursement') }}</th>
                                            {{-- <th>{{__('Status') }}</th> --}}
					    @can('Edit Set Salary')
                                            <th class="text-right" width="200px">{{__('Action')}}</th>
					    @endcan
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                        $no = 1;
                                        @endphp

                                        @foreach ($yearlyBonuses as $yearlyBonus)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td class="font-style">{{ $yearlyBonus->employees->name }}</td>
                                            <td class="font-style">{{ $yearlyBonus->bonus_type }}</td>

                                            <td class="font-style">
                                                {{ Auth::user()->priceFormat($yearlyBonus->bonus_amount) }}
                                            </td>

                                            <td class="font-style">
                                                {{ Auth::user()->dateFormat($yearlyBonus->date_disbursement) }}
                                            </td>

                                            {{-- <td class="font-style">{{ $yearlyBonus->getBonusStatus() }}</td> --}}
					    @can('Edit Set Salary')
                                            <td class="text-right">
                                                <a href="{{ URL::to('yearlybonus/'.$yearlyBonus->id.'/edit') }}"
                                                    class="btn btn-outline-primary btn-sm mr-1">
                                                    <i class="fas fa-pencil-alt"></i> <span>{{__('Edit')}}</span>
                                                </a>

                                                <a href="#" class="btn btn-outline-danger btn-sm" data-toggle="tooltip"
                                                    data-original-title="{{__('Delete')}}"
                                                    data-confirm="Are You Sure?|This action can not be undone. Do you want to continue?"
                                                    data-confirm-yes="document.getElementById('delete-form-{{$yearlyBonus->id}}').submit();">
                                                    <i class="fas fa-trash"></i> <span>{{__('Delete')}}</span>
                                                </a>

                                                {!! Form::open(['method' => 'DELETE', 'route' =>
                                                ['yearlybonus.destroy',$yearlyBonus->id],'id'=>'delete-form-'.$yearlyBonus->id])
                                                !!}

                                                {!! Form::close() !!}
                                            </td>
					    @endcan
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
