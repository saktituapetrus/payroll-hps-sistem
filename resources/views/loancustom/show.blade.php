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
                <div class="breadcrumb-item active"><a href="#">{{__('Dashboard')}}</a></div>
                <div class="breadcrumb-item active"><a href="{{ route('loancustom.index') }}">{{__('Loan Custom')}}</a>
                </div>
                <div class="breadcrumb-item">{{__('Detail')}}</div>
            </div>
        </div>

        @csrf
        <div class="row">
            <div class="col-12">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>{{__('Employee Loan Custom Detail')}}</h4>
                            </div>

                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped mb-0">
                                        <tbody>
                                            <tr>
                                                <th>{{__('Employee Name')}}</th>

                                                <td>
                                                    {{ $loanCustom->employees->name ? $loanCustom->employees->name : '-' }}
                                                </td>
                                            </tr>

                                            <tr>
                                                <th>{{__('Employee Salary')}}</th>

                                                <td>
                                                    {{ $loanCustom->employees->salary ? Auth::user()->priceFormat($loanCustom->employees->salary) : '-' }}
                                                </td>
                                            </tr>

                                            <tr>
                                                <th>{{__('*Yearly Bonus')}}</th>

                                            <tr>
                                                <td>Bonus Type</td>

                                                <td>
                                                    @foreach ($yearlyBonuses as $yearlyBonus)
                                                    -&nbsp;{{ $yearlyBonus->bonus_type ? $yearlyBonus->bonus_type : '-' }}<br />
                                                    @endforeach
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>Bonus Amount</td>

                                                <td>
                                                    @foreach ($yearlyBonuses as $yearlyBonus)
                                                    -&nbsp;{{ $yearlyBonus->bonus_amount ? Auth::user()->priceFormat($yearlyBonus->bonus_amount) : '-' }}<br />
                                                    @endforeach
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>Bonus Date Disbursement</td>

                                                <td>
                                                    @foreach ($yearlyBonuses as $yearlyBonus)
                                                    -&nbsp;{{ $yearlyBonus->date_disbursement ? Auth::user()->dateFormat($yearlyBonus->date_disbursement) : '-'}}<br />
                                                    @endforeach
                                                </td>
                                            </tr>
                                            </tr>

                                            <tr>
                                                <th>*Loan</th>

                                            <tr>
                                                <td>Loan Type</td>

                                                <td>
                                                    @foreach ($loanCustomsss as $loanCustomss)
                                                    -&nbsp;{{ $loanCustom->loan_type ? $loanCustom->loan_type : '-' }}<br />
                                                    @endforeach
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>Loan Amount</td>

                                                <td>
                                                    @foreach ($loanCustomsss as $loanCustomss)
                                                    -&nbsp;{{ $loanCustom->loan_amount ? Auth::user()->priceFormat($loanCustom->loan_amount) : '-' }}<br />
                                                    @endforeach
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>Loan Tenor</td>

                                                <td>
                                                    @foreach ($loanCustomsss as $loanCustomss)
                                                    -&nbsp;{{ $loanCustom->tenor ? $loanCustom->tenor : '-' }}<br />
                                                    @endforeach
                                                </td>
                                            </tr>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
