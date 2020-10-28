@extends('layouts.dashboard')
@section('page-title')
    {{__('Account')}}
@endsection
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{__('Manage Account Balances')}}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="index.html">{{__('Home')}}</a></div>
                    <div class="breadcrumb-item">{{__('List All Account Balances')}}</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex justify-content-between w-100">
                                    <h4>{{__('List All  Account Balances')}}</h4>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped mb-0" id="dataTable">
                                        <thead>
                                        <tr>
                                            <th>{{__('Account Name')}}</th>
                                            <th>{{__('Initial Balance')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody class="font-style">
                                        @php $totalInitialBalance = 0; @endphp
                                        @foreach ($accountLists as $accountlist)
                                            @php
                                                $totalInitialBalance = $accountlist->initial_balance + $totalInitialBalance;
                                            @endphp
                                            <tr>
                                                <td>{{ $accountlist->account_name }}</td>
                                                <td>{{  \Auth::user()->priceFormat($accountlist->initial_balance) }}</td>
                                            </tr>
                                        @endforeach
                                            <tr>
                                                <td class="text-left text-dark">{{__('Total')}}</td>
                                                <td>{{ \Auth::user()->priceFormat($totalInitialBalance)   }}</td>
                                            </tr>

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

