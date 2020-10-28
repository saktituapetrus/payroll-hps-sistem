@extends('layouts.dashboard')
@section('page-title')
{{__('Salary')}}
@endsection
@section('content')

<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>{{__('Employee Salary')}}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{route('home')}}">{{__('Dashboard')}}</a></div>
                <div class="breadcrumb-item">{{__('Employee Salary')}}</div>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between w-100">
                                <h4>{{__('Employee Salary')}}</h4>
                            </div>

                            @can('Edit Set Salary')
                                <a href="javascript:void(0);" data-target="#staticBackdrop" data-toggle="modal"
                                    class="btn btn-icon icon-left btn-success mr-1">
                                    <i class="fas fa-file-import"></i> {{ __('Import') }}
                                </a>

                                <a href="{{ route('setsalary.export') }}" class="btn btn-icon icon-left btn-danger">
                                    <i class="fas fa-file-export"></i> {{ __('Export') }}
                                </a>
                            @endcan
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped mb-0" id="dataTable">
                                    <thead>
                                        <tr>
                                            <th>{{__('Employee Id')}}</th>
                                            <th>{{__('Name')}}</th>
                                            <th>{{__('Payroll Type') }}</th>
                                            <th>{{__('Salary') }}</th>
                                            <th>{{__('Net Salary') }}</th>
                                            <th class="text-right" width="200px">{{__('Action')}}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($employees as $employee)

                                        <tr>
                                            <td>{{ \Auth::user()->employeeIdFormat($employee->employee_id) }}</td>
                                            <td>{{ $employee->name }}</td>
                                            <td>{{ $employee->salary_type() }}</td>
                                            <td>{{  \Auth::user()->priceFormat($employee->salary) }}</td>
                                            <td>{{  \Auth::user()->priceFormat($employee->get_net_salary()) }}</td>
                                            <td class="text-right">
                                                <a href="{{route('setsalary.show',$employee->id)}}"
                                                    class="btn btn-outline-warning btn-sm mr-1">
                                                    <i class="fas fa-eye"> <span>{{__('View')}}</span></i>
                                                </a>
                                                @can('Edit Set Salary')
                                                <a href="{{ URL::to('setsalary/'.$employee->id.'/edit') }}"
                                                    class="btn btn-outline-primary btn-sm mr-1">
                                                    <i class="fas fa-pencil-alt"></i> <span>{{__('Edit')}}</span>
                                                </a>
                                                @endcan
                                                @can('Delete Set Salary')
                                                <a href="#" class="btn btn-outline-danger btn-sm" data-toggle="tooltip"
                                                    data-original-title="{{__('Delete')}}"
                                                    data-confirm="Are You Sure?|This action can not be undone. Do you want to continue?"
                                                    data-confirm-yes="document.getElementById('delete-form-{{$employee->id}}').submit();"><i
                                                        class="fas fa-trash"></i> <span>{{__('Delete')}}</span></a>
                                                {!! Form::open(['method' => 'DELETE', 'route' => ['setsalary.destroy',
                                                $employee->id],'id'=>'delete-form-'.$employee->id]) !!}
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

<!-- Modal Import -->
<div class="modal fade" id="staticBackdrop" data-backdrop="static" tabindex="-1" role="dialog"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Import Salary</h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form method="POST" action="{{ route('setsalary.import') }}" enctype="multipart/form-data">
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
