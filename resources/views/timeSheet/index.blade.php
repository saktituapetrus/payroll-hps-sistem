@extends('layouts.dashboard')
@section('page-title')
    {{__('TimeSheet')}}
@endsection
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{__('Manage TimeSheet')}}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{route('home')}}">{{__('Dashboard')}}</a></div>
                    <div class="breadcrumb-item">{{__('TimeSheet')}}</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex justify-content-between w-100">
                                    <h4>{{__('TimeSheet List')}}</h4>
                                    @can('Create TimeSheet')
                                        <a href="#" data-url="{{ route('timesheet.create') }}" class="btn btn-sm btn-primary btn-round btn-icon" data-ajax-popup="true" data-toggle="tooltip" data-title="{{__('Create New')}}" data-original-title="{{__('Create TimeSheet')}}">
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
                                            @if(\Auth::user()->type!='employee')
                                                <th>{{__('Employee')}}</th>
                                            @endif
                                            <th>{{__('Date')}}</th>
                                            <th>{{__('Hours')}}</th>
                                            <th>{{__('Description')}}</th>
                                            <th width="200px">{{__('Action')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody class="font-style">
                                        @foreach ($timeSheets as $timeSheet)
                                            <tr>
                                                @if(\Auth::user()->type!='employee')
                                                    <td>{{\Auth::user()->getUSerEmployee($timeSheet->employee_id)->name }}</td>
                                                @endif
                                                <td>{{  \Auth::user()->dateFormat($timeSheet->date) }}</td>
                                                <td>{{ $timeSheet->hours }}</td>
                                                <td>{{ $timeSheet->remark }}</td>
                                                <td>
                                                    @can('Delete TimeSheet')
                                                        <a href="#" data-url="{{route('timesheet.edit',$timeSheet->id)}}" data-size="lg" data-ajax-popup="true" data-title="{{__('Edit Termination')}}" class="btn btn-outline-primary btn-sm mr-1" data-toggle="tooltip" data-original-title="{{__('Edit')}}">
                                                            <i class="fas fa-pencil-alt"></i> <span>{{__('Edit')}}</span>
                                                        </a>
                                                    @endcan
                                                    @can('Delete TimeSheet')
                                                        <a href="#" class="btn btn-outline-danger btn-sm" data-toggle="tooltip" data-original-title="{{__('Delete')}}" data-confirm="Are You Sure?|This action can not be undone. Do you want to continue?" data-confirm-yes="document.getElementById('delete-form-{{$timeSheet->id}}').submit();"><i class="fas fa-trash"></i> <span>{{__('Delete')}}</span></a>
                                                        {!! Form::open(['method' => 'DELETE', 'route' => ['timesheet.destroy', $timeSheet->id],'id'=>'delete-form-'.$timeSheet->id]) !!}
                                                        {!! Form::close() !!}
                                                    @endcan
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

