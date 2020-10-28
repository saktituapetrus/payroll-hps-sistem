<table class="table table-striped mb-0">
    <tr>
        <th>{{__('Basic Salary')}}</th>
        <td>{{  \Auth::user()->priceFormat( $payslip->basic_salary)}}</td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <th>{{__('Payroll Month')}}</th>
        <td>{{ \Auth::user()->dateFormat( $payslip->salary_month)}}</td>
        <td>&nbsp;</td>
    </tr>
</table>
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-4">
                <ul class="nav nav-pills flex-column" id="myTab4" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active show" id="home-tab4" data-toggle="tab" href="#allowance" role="tab" aria-controls="home" aria-selected="true">{{__('Allowance')}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="profile-tab4" data-toggle="tab" href="#commission" role="tab" aria-controls="profile" aria-selected="false">{{__('Commission')}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="contact-tab4" data-toggle="tab" href="#loan" role="tab" aria-controls="contact" aria-selected="false">{{__('Loan')}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="contact-tab4" data-toggle="tab" href="#deduction" role="tab" aria-controls="contact" aria-selected="false">{{__('Saturation Deduction')}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="contact-tab4" data-toggle="tab" href="#payment" role="tab" aria-controls="contact" aria-selected="false">{{__('Other Payment')}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="contact-tab4" data-toggle="tab" href="#overtime" role="tab" aria-controls="contact" aria-selected="false">{{__('Overtime')}}</a>
                    </li>
                </ul>
            </div>
            <div class="col-12 col-sm-12 col-md-8">
                <div class="tab-content no-padding" id="myTab2Content">
                    <div class="tab-pane fade active show" id="allowance" role="tabpanel" aria-labelledby="home-tab4">
                        @php
                            $allowances = json_decode($payslip->allowance);
                        @endphp
                        <table class="table table-bordered table-md">
                            <tbody>
                            <tr>
                                <th>{{__('Title')}}</th>
                                <th>{{__('Amount')}}</th>
                            </tr>
                            @foreach($allowances as $allownace)
                                <tr>
                                    <td>{{$allownace->title}}</td>
                                    <td>{{ \Auth::user()->priceFormat($allownace->amount)}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade" id="commission" role="tabpanel" aria-labelledby="home-tab4">
                        @php
                            $commissions = json_decode($payslip->commission);
                        @endphp
                        <table class="table table-bordered table-md">
                            <tbody>
                            <tr>
                                <th>{{__('Title')}}</th>
                                <th>{{__('Amount')}}</th>
                            </tr>
                            @foreach($commissions as $commission)
                                <tr>
                                    <td>{{$commission->title}}</td>
                                    <td>{{ \Auth::user()->priceFormat($commission->amount)}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade" id="loan" role="tabpanel" aria-labelledby="home-tab4">
                        @php
                            $loans = json_decode($payslip->loan);
                        @endphp
                        <table class="table table-bordered table-md">
                            <tbody>
                            <tr>
                                <th>{{__('Title')}}</th>
                                <th>{{__('Amount')}}</th>
                            </tr>
                            @foreach($loans as $loan)
                                <tr>
                                    <td>{{$loan->title}}</td>
                                    <td>{{ \Auth::user()->priceFormat($loan->amount)}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade" id="deduction" role="tabpanel" aria-labelledby="home-tab4">
                        @php
                            $saturation_deductions = json_decode($payslip->saturation_deduction);
                        @endphp
                        <table class="table table-bordered table-md">
                            <tbody>
                            <tr>
                                <th>{{__('Title')}}</th>
                                <th>{{__('Amount')}}</th>
                            </tr>
                            @foreach($saturation_deductions as $deduction)
                                <tr>
                                    <td>{{$deduction->title}}</td>
                                    <td>{{ \Auth::user()->priceFormat($deduction->amount)}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade" id="payment" role="tabpanel" aria-labelledby="home-tab4">
                        @php
                            $other_payments = json_decode($payslip->other_payment);
                        @endphp
                        <table class="table table-bordered table-md">
                            <tbody>
                            <tr>
                                <th>{{__('Title')}}</th>
                                <th>{{__('Amount')}}</th>
                            </tr>
                            @foreach($other_payments as $payment)
                                <tr>
                                    <td>{{$payment->title}}</td>
                                    <td>{{ \Auth::user()->priceFormat($payment->amount)}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade" id="overtime" role="tabpanel" aria-labelledby="home-tab4">
                        @php
                            $overtimes = json_decode($payslip->overtime);
                        @endphp
                        <table class="table table-bordered table-md">
                            <tbody>
                            <tr>
                                <th>{{__('Title')}}</th>
                                <th>{{__('Amount')}}</th>
                            </tr>
                            @foreach($overtimes as $overtime)
                                <tr>
                                    <td>{{$overtime->title}}</td>
                                    <td>{{ \Auth::user()->priceFormat($overtime->rate)}}</td>
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
<table class="table table-striped mb-0">
    <tr>
        <th>{{__('Net Salary')}}</th>
        <td>{{ \Auth::user()->priceFormat($payslip->net_payble)}}</td>
        <td>&nbsp;</td>
    </tr>
</table>
