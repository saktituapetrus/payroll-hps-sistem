@extends('layouts.dashboard')

@section('page-title')
{{__('Employee')}}
@endsection

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>{{__('Employee')}}</h1>

            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{__('home')}}">{{__('Dashboard')}}</a></div>
                <div class="breadcrumb-item">{{__('Employee')}}</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between w-100">
                                <h4>{{__('Manage Employee')}}</h4>
                            </div>      
                            @can('Create Employee')
                                <a href="javascript:void(0);" data-target="#staticBackdrop" data-toggle="modal"
                                    class="btn btn-icon icon-left btn-success">
                                    <i class="fas fa-file-import"></i> {{ __('Import') }}
                                </a>
                                &nbsp;
                                <a href="{{ route('employee.export') }}" class="btn btn-icon icon-left btn-danger">
                                    <i class="fas fa-file-export"></i> {{ __('Export') }}
                                </a>
                                &nbsp;
                                <a href="{{ route('employee.create') }}" class="btn btn-icon icon-left btn-primary">
                                    <i class="fa fa-plus"></i> {{ __('Create') }}
                                </a>
                            @endcan
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped mb-0" id="dataTable">
                                    <thead>
                                        <tr>
                                            <th>{{__('Employee ID')}}</th>
                                            <th>{{__('Name')}}</th>
                                            <th>{{__('Email')}}</th>
                                            <th>{{__('Branch') }}</th>
                                            <th>{{__('Department') }}</th>
                                            <th>{{__('Designation') }}</th>
                                            <th>{{__('Date Of Joining') }}</th>
                                            @if(Gate::check('Edit Employee') || Gate::check('Delete Employee'))
                                            <th class="text-right" width="200px">{{__('Action')}}</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($employees as $employee)
                                        <tr>
                                            <td><a href="{{route('employee.show',$employee->id)}}"
                                                    class="btn btn-sm btn-primary">{{ \Auth::user()->employeeIdFormat($employee->employee_id) }}</a>
                                            </td>
                                            <td class="font-style">{{ $employee->name }}</td>
                                            <td>{{ $employee->email }}</td>
                                            <td class="font-style">
                                                {{\Auth::user()->getBranch($employee->branch_id )->name}}</td>
                                            <td class="font-style">
                                                {{\Auth::user()->getDepartment($employee->department_id )->name}}</td>
                                            <td class="font-style">
                                                {{\Auth::user()->getDesignation($employee->designation_id )->name}}</td>
                                            <td class="font-style">
                                                {{ \Auth::user()->dateFormat($employee->company_doj )}}</td>
                                            @if(Gate::check('Edit Employee') || Gate::check('Delete Employee'))
                                            <td class="text-right">
                                                @if($employee->is_active==1)
                                                @can('Edit Employee')
                                                <a href="{{ URL::to('employee/'.$employee->id.'/edit') }}"
                                                    class="btn btn-outline-primary btn-sm mr-1"><i
                                                        class="fas fa-pencil-alt"></i> <span>{{__('Edit')}}</span></a>
                                                @endcan
                                                @can('Delete Employee')
                                                <a href="#" class="btn btn-outline-danger btn-sm" data-toggle="tooltip"
                                                    data-original-title="{{__('Delete')}}"
                                                    data-confirm="Are You Sure?|This action can not be undone. Do you want to continue?"
                                                    data-confirm-yes="document.getElementById('delete-form-{{$employee->id}}').submit();"><i
                                                        class="fas fa-trash"></i> <span>{{__('Delete')}}</span></a>
                                                {!! Form::open(['method' => 'DELETE', 'route' => ['employee.destroy',
                                                $employee->id],'id'=>'delete-form-'.$employee->id]) !!}
                                                {!! Form::close() !!}
                                                @endcan
                                                @else
                                                <i class="fas fa-lock"></i>
                                                @endif
                                            </td>
                                            @endif
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

<!-- Modal Import -->
<div class="modal fade" id="staticBackdrop" data-backdrop="static" tabindex="-1" role="dialog"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Import Employee</h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form method="POST" action="{{ route('employee.import') }}" enctype="multipart/form-data">
                <div class="modal-body">
                    @csrf

                    <div class="custom-file">
                        <input type="file" name="file" class="custom-file-input" id="customFile" required>
                        <label class="custom-file-label" for="customFile">Choose file</label>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('script-page')
<script>
    $('#customFile').on('change', function() {
        // Get file name
        let fileName = $(this).val();

        // Replace the "Choose a file" label
        $(this).next('.custom-file-label').html(fileName);
    });
</script>
@endpush
