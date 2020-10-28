@php
    $logo=asset(Storage::url('logo/'));
@endphp
<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="#">
                <img class="img-fluid" src="{{$logo.'/logo.png'}} " alt="" width="">
            </a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{route('home')}}"> <img class="img-fluid" src="{{$logo.'/small_logo.png'}} " alt=""></a>
        </div>
        <ul class="sidebar-menu">
            <li class="dropdown {{ request()->is('home*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('home') }}"> <i class="fas fa-tachometer-alt"></i> <span>{{ __('Dashboard') }}</span></a>
            </li>
            @role('super admin')
            <li class="dropdown ">
            <li class="{{ request()->is('user*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('user.index') }}"><i class="fas fa-user"></i>{{ __('User') }}</a></li>
            </li>
            @endrole

            @role('company')
            @if( Gate::check('Manage User') || Gate::check('Manage Role'))
                <li class="dropdown {{ (Request::route()->getName() == 'user.index' || Request::route()->getName() == 'roles.index' || Request::route()->getName() == 'permissions.index') ? 'active' : '' }}">
                    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i> <span>{{ __('Staff') }}</span></a>
                    <ul class="dropdown-menu">
                        @can('Manage User')
                            <li class="{{ request()->is('user*') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('user.index') }}">{{ __('User') }}</a>
                            </li>
                        @endcan
                        @can('Manage Role')
                            <li class="{{ request()->is('roles*') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('roles.index') }}">{{ __('Role') }}</a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endif
            @endrole


            @if(Gate::check('Manage Employee'))
                @if(\Auth::user()->type =='employee')
                    @php
                        $employee=App\Employee::where('user_id',\Auth::user()->id)->first();
                    @endphp
                    <li class="{{ request()->is('employee*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{route('employee.show',$employee->id)}}"><i class="fas fa-users"></i> <span>{{ __('Employee') }}</span></a>
                    </li>
                @else
                    <li class="{{ request()->is('employee*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{route('employee.index')}}"><i class="fas fa-users"></i> <span>{{ __('Employee') }}</span></a>
                    </li>
                @endif
            @endif
            @if(Gate::check('Manage Set Salary') || Gate::check('Manage Pay Slip'))
                <li class="{{ (Request::route()->getName() == 'setsalary.index' || Request::route()->getName() == 'setsalary.show' ||  Request::route()->getName() == 'payslip.index' || Request::route()->getName() == 'payslip.employeepayslip' || Request::route()->getName() == 'setsalary.edit' || Request::route()->getName() == 'employeesalary' || Request::route()->getName() == 'payslip.employeepayslip' || Request::route()->getName() == 'payslip.pdf') ? 'active' : '' }}">
                    <a class="nav-link has-dropdown" data-toggle="dropdown" href="#"><i class="fas fa-receipt"></i> <span>{{ __('Payroll') }}</span></a>
                    <ul class="dropdown-menu">
                        @can('Manage Set Salary')
                            <li class="{{ request()->is('setsalary*') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('setsalary.index') }}">{{ __('Set Salary') }}</a>
                            </li>
                        @endcan
                        @can('Manage Pay Slip')
                            <li class="{{ request()->is('payslip*') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('payslip.index') }}">{{ __('Payslip') }}</a>
                            </li>
                        @endcan

                        <li class="{{ request()->is('loancustom*') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('loancustom.index') }}">{{ __('Loan Custom') }}</a>
                        </li>

                        <li class="{{ request()->is('yearlybonus*') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('yearlybonus.index') }}">{{ __('Yearly Bonus') }}</a>
                        </li>
                    </ul>
                </li>
            @endif

            @if(\Auth::user()->type=='employee')
                <li class="{{ (Request::route()->getName() == 'employeesalary' || Request::route()->getName() == 'payslip.employeepayslip' ||  Request::route()->getName() == 'setsalary.show') ? 'active' : '' }}">
                    <a class="nav-link has-dropdown" data-toggle="dropdown" href="#"><i class="fas fa-receipt"></i> <span>{{ __('Payroll') }}</span></a>
                    <ul class="dropdown-menu">
                        <li class="{{ (Request::segment(2) == 'employeeSalary' || Request::segment(1) == 'setsalary') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('employeesalary') }}">{{ __('My Salary') }}</a>
                        </li>
                        <li class="{{ (Request::segment(2) == 'employeepayslip') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('payslip.employeepayslip') }}">{{ __('Payslip') }}</a>
                        </li>
			<li class="{{ request()->is('loancustom*') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('loancustom.index') }}">{{ __('Loan Custom') }}</a>
                        </li>
                        <li class="{{ request()->is('yearlybonus*') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('yearlybonus.index') }}">{{ __('Yearly Bonus') }}</a>
                        </li>
                    </ul>
                </li>
            @endif
            @if( Gate::check('Manage Attendance') || Gate::check('Manage Leave') || Gate::check('Manage TimeSheet'))
                <li class="dropdown {{ (Request::route()->getName() == 'attendanceemployee.index' || Request::route()->getName() == 'leave.index'  || Request::route()->getName() == 'timesheet.index') ? 'active' : '' }}">
                    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i> <span>{{ __('Timesheet') }}</span></a>
                    <ul class="dropdown-menu">
                        @can('Manage TimeSheet')
                            <li class="{{ request()->is('timesheet*') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('timesheet.index') }}">{{ __('Timesheet') }}</a>
                            </li>
                        @endcan
                        @can('Manage Attendance')
                            <li class="{{ request()->is('attendanceemployee*') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('attendanceemployee.index') }}">{{ __('Attendance') }}</a>
                            </li>
                        @endcan
                        @can('Manage Leave')
                            <li class="{{ request()->is('leave*') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('leave.index') }}">{{ __('Manage Leave') }}</a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endif




            @can('Manage Ticket')
                <li class="{{ request()->is('ticket*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{route('ticket.index')}}"><i class="fas fa-ticket-alt"></i> <span>{{ __('Ticket') }}</span></a>
                </li>
            @endcan
            @can('Manage Event')
                <li class="{{ request()->is('event*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{route('event.index')}}"><i class="fas fa-calendar-alt"></i> <span>{{ __('Event') }}</span></a>
                </li>
            @endcan
            @can('Manage Meeting')
                <li class="{{ request()->is('meeting*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{route('meeting.index')}}"><i class="fas fa-handshake"></i> <span>{{ __('Meeting') }}</span></a>
                </li>
            @endcan

            @if(Gate::check('Manage Account List') || Gate::check('Manage Payee')  || Gate::check('Manage Payer')  || Gate::check('Manage Deposit') || Gate::check('Manage Expense') || Gate::check('Manage Transfer Balance'))
                <li class="{{ (Request::route()->getName() == 'accountlist.index' || Request::route()->getName() == 'accountbalance' || Request::route()->getName() == 'payees.index' || Request::route()->getName() == 'payer.index' || Request::route()->getName() == 'deposit.index' || Request::route()->getName() == 'expense.index' || Request::route()->getName() == 'transferbalance.index' || Request::route()->getName() == 'viewtransaction.index') ? 'active' : '' }}">
                    <a class="nav-link has-dropdown" data-toggle="dropdown" href="#"><i class="fas fa-wallet"></i> <span>{{ __('Finance') }}</span></a>
                    <ul class="dropdown-menu">
                        @can('Manage Account List')
                            <li class="{{ request()->is('accountlist*') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('accountlist.index') }}">{{ __('Account List') }}</a>
                            </li>
                        @endcan
                        @can('View Balance Account List')
                            <li class="{{ request()->is('accountbalance*') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('accountbalance') }}">{{ __('Account Balance') }}</a>
                            </li>
                        @endcan

                        @can('Manage Payee')
                            <li class="{{ request()->is('payees*') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('payees.index') }}">{{ __('Payees') }}</a>
                            </li>
                        @endcan
                        @can('Manage Payer')
                            <li class="{{ request()->is('payer*') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('payer.index') }}">{{ __('Payers') }}</a>
                            </li>
                        @endcan
                        @can('Manage Deposit')
                            <li class="{{ request()->is('deposit*') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('deposit.index') }}">{{ __('Deposit') }}</a>
                            </li>
                        @endcan
                        @can('Manage Expense')
                            <li class="{{ request()->is('expense*') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('expense.index') }}">{{ __('Expense') }}</a>
                            </li>
                        @endcan
                        @can('Manage Transfer Balance')
                            <li class="{{ request()->is('transferbalance*') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('transferbalance.index') }}">{{ __('Transfer Balance') }}</a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endif

            @if(Gate::check('Manage Awards') || Gate::check('Manage Transfer')  || Gate::check('Manage Resignation')  || Gate::check('Manage Travels') || Gate::check('Manage Promotion') || Gate::check('Manage Complaint')|| Gate::check('Manage Warning') || Gate::check('Manage Termination') || Gate::check('Manage Announcement'))
                <li class="dropdown {{ (Request::route()->getName() == 'award.index' ||  Request::route()->getName() == 'transfer.index' || Request::route()->getName() == 'resignation.index' || Request::route()->getName() == 'travel.index' ||  Request::route()->getName() == 'promotion.index' || Request::route()->getName() == 'complaint.index' || Request::route()->getName() == 'warning.index' || Request::route()->getName() == 'termination.index' || Request::route()->getName() == 'announcement.index') ? 'active' : '' }}">
                    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-user-cog"></i> <span>{{ __('HR') }}</span></a>
                    <ul class="dropdown-menu">
                        @can('Manage Award')
                            <li class="{{ request()->is('award*') ? 'active' : '' }}">
                                <a class="nav-link " href="{{ route('award.index') }}">{{ __('Award') }}</a>
                            </li>
                        @endcan
                        @can('Manage Transfer')
                            <li class="{{ request()->is('transfer*') ? 'active' : '' }}">
                                <a class="nav-link " href="{{ route('transfer.index') }}">{{ __('Transfer') }}</a>
                            </li>
                        @endcan
                        @can('Manage Resignation')
                            <li class="{{ request()->is('resignation*') ? 'active' : '' }}">
                                <a class="nav-link " href="{{ route('resignation.index') }}">{{ __('Resignation') }}</a>
                            </li>
                        @endcan
                        @can('Manage Travel')
                            <li class="{{ request()->is('travel*') ? 'active' : '' }}">
                                <a class="nav-link " href="{{ route('travel.index') }}">{{ __('Trip') }}</a>
                            </li>
                        @endcan
                        @can('Manage Promotion')
                            <li class="{{ request()->is('promotion*') ? 'active' : '' }}">
                                <a class="nav-link " href="{{ route('promotion.index') }}">{{ __('Promotion') }}</a>
                            </li>
                        @endcan
                        @can('Manage Complaint')
                            <li class="{{ request()->is('complaint*') ? 'active' : '' }}">
                                <a class="nav-link " href="{{ route('complaint.index') }}">{{ __('Complaints') }}</a>
                            </li>
                        @endcan
                        @can('Manage Warning')
                            <li class="{{ request()->is('warning*') ? 'active' : '' }}">
                                <a class="nav-link " href="{{ route('warning.index') }}">{{ __('Warning') }}</a>
                            </li>
                        @endcan
                        @can('Manage Termination')
                            <li class="{{ request()->is('termination*') ? 'active' : '' }}">
                                <a class="nav-link " href="{{ route('termination.index') }}">{{ __('Termination') }}</a>
                            </li>
                        @endcan
                        @can('Manage Announcement')
                            <li class="{{ request()->is('announcement*') ? 'active' : '' }}">
                                <a class="nav-link " href="{{ route('announcement.index') }}">{{ __('Announcement') }}</a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endif

            @if(Gate::check('Manage Department') || Gate::check('Manage Designation')  || Gate::check('Manage Document Type')  || Gate::check('Manage Branch') || Gate::check('Manage Award Type') || Gate::check('Manage Termination Types')|| Gate::check('Manage Payslip Type') || Gate::check('Manage Allowance Option') || Gate::check('Manage Loan Options')  || Gate::check('Manage Deduction Options') || Gate::check('Manage Expense Type')  || Gate::check('Manage Income Type') || Gate::check('Manage Payment Type')  || Gate::check('Manage Leave Type'))
                <li class="dropdown {{ (Request::route()->getName() == 'department.index' || Request::route()->getName() == 'designation.index' || Request::route()->getName() == 'document.index' || Request::route()->getName() == 'branch.index' || Request::route()->getName() == 'awardtype.index' || Request::route()->getName() == 'terminationtype.index' || Request::route()->getName() == 'paysliptype.index' || Request::route()->getName() == 'allowanceoption.index' || Request::route()->getName() ==
            'loanoption.index' || Request::route()->getName() == 'deductionoption.index' || Request::route()->getName() == 'expensetype.index' || Request::route()->getName() == 'incometype.index'|| Request::route()->getName() == 'paymenttype.index'|| Request::route()->getName() == 'leavetype.index') ? 'active' : '' }}">
                    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-external-link-alt"></i> <span>{{ __('Constant') }}</span></a>
                    <ul class="dropdown-menu">
                        @can('Manage Branch')
                            <li class="{{ request()->is('branch*') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('branch.index') }}">{{ __('Branch') }}</a>
                            </li>
                        @endcan
                        @can('Manage Department')
                            <li class="{{ request()->is('department*') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('department.index') }}">{{ __('Department') }}</a>
                            </li>
                        @endcan
                        @can('Manage Designation')
                            <li class="{{ request()->is('designation*') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('designation.index') }}">{{ __('Designation') }}</a>
                            </li>
                        @endcan
                        @can('Manage Document Type')
                            <li class="{{ request()->is('document*') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('document.index') }}">{{ __('Document Type') }}</a>
                            </li>
                        @endcan

                        @can('Manage Award Type')
                            <li class="{{ request()->is('awardtype*') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('awardtype.index') }}">{{ __('Award Type') }}</a>
                            </li>
                        @endcan
                        @can('Manage Termination Types')
                            <li class="{{ request()->is('terminationtype*') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('terminationtype.index') }}">{{ __('Termination Type') }}</a>
                            </li>
                        @endcan
                        @can('Manage Payslip Type')
                            <li class="{{ request()->is('paysliptype*') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('paysliptype.index') }}">{{ __('Payslip Type') }}</a>
                            </li>
                        @endcan
                        @can('Manage Allowance Option')
                            <li class="{{ request()->is('allowanceoption*') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('allowanceoption.index') }}">{{ __('Allowance Option') }}</a>
                            </li>
                        @endcan
                        @can('Manage Loan Option')
                            <li class="{{ request()->is('loanoption*') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('loanoption.index') }}">{{ __('Loan Option') }}</a>
                            </li>
                        @endcan
                        @can('Manage Deduction Option')
                            <li class="{{ request()->is('deductionoption*') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('deductionoption.index') }}">{{ __('Deduction Option') }}</a>
                            </li>
                        @endcan
                        @can('Manage Expense Type')
                            <li class="{{ request()->is('expensetype*') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('expensetype.index') }}">{{ __('Expense Type') }}</a>
                            </li>
                        @endcan
                        @can('Manage Income Type')
                            <li class="{{ request()->is('incometype*') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('incometype.index') }}">{{ __('Income Type') }}</a>
                            </li>
                        @endcan
                        @can('Manage Payment Type')
                            <li class="{{ request()->is('paymenttype*') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('paymenttype.index') }}">{{ __('Payment Type') }}</a>
                            </li>
                        @endcan
                        @can('Manage Leave Type')
                            <li class="{{ request()->is('leavetype*') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('leavetype.index') }}">{{ __('Leave Type') }}</a>
                            </li>
                        @endcan
                        @can('Manage Termination Type')
                            <li class="{{ request()->is('terminationtype*') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('terminationtype.index') }}">{{ __('Termination Type') }}</a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endif

            @if(Gate::check('Manage Company Settings') || Gate::check('Manage System Settings'))
                <li class="{{ request()->is('settings*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{route('settings.index')}}"><i class="fas fa-sliders-h"></i> <span>{{ __('System Setting') }}</span></a>
                </li>
            @endif
        </ul>
    </aside>
</div>
