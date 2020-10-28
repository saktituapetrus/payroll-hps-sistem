@extends('layouts.dashboard')
@section('page-title')
    {{__('Ticket Reply')}}
@endsection
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{__('Ticket Reply')}}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{route('home')}}">{{__('Dashboard')}}</a></div>
                    <div class="breadcrumb-item active"><a href="{{route('ticket.index')}}">{{__('Ticket')}}</a></div>
                    <div class="breadcrumb-item">{{__('Ticket Reply')}}</div>
                </div>

            </div>

            <div class="section-body">
                <div class="row">
                    <div class=" col-md-12 pb-4">
                        <div class="float-right">
                            @if(\Auth::user()->type=='employee')
                                @if($ticket->created_by==\Auth::user()->id)
                                    @can('Edit Ticket')
                                        <a href="#" data-url="{{ URL::to('ticket/'.$ticket->id.'/edit') }}" data-size="lg" data-ajax-popup="true" data-title="{{__('Edit Ticket')}}" class="btn btn-outline-primary btn-sm mr-1" data-toggle="tooltip" data-original-title="{{__('Edit')}}"><i class="fas fa-pencil-alt"></i> <span>{{__('Edit')}}</span></a>
                                    @endcan
                                @endif
                            @else
                                @can('Edit Ticket')
                                    <a href="#" data-url="{{ URL::to('ticket/'.$ticket->id.'/edit') }}" data-size="lg" data-ajax-popup="true" data-title="{{__('Edit Ticket')}}" class="btn btn-outline-primary btn-sm mr-1" data-toggle="tooltip" data-original-title="{{__('Edit')}}"><i class="fas fa-pencil-alt"></i> <span>{{__('Edit')}}</span></a>
                                @endcan
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        @foreach($ticketreply as $reply)
                            <div class="card">
                                <div class="card-header">
                                    <div class="d-flex justify-content-between w-100">
                                        <h4>{{\Auth::user()->getUser($reply->created_by)->name }} </h4>
                                        <p class="text-small text-gray">{{$reply->created_at->diffForHumans()}}</p>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <p>{{ $reply->description }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @if($ticket->status=='open')
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <div class="d-flex justify-content-between w-100">
                                        <h4>{{__('Add Reply')}}</h4>
                                    </div>
                                </div>
                                <div class="card-body">
                                    {{Form::open(array('url'=>'ticket/changereply','method'=>'post'))}}
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                {{Form::label('description',__('Description'))}}
                                                {{Form::textarea('description',null,array('class'=>'form-control','placeholder'=>__('Ticket Reply')))}}
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" value="{{$ticket->id}}" name="ticket_id">

                                    <div class="modal-footer pr-0">
                                        {{Form::submit(__('Send'),array('class'=>'btn btn-primary'))}}
                                    </div>
                                    {{Form::close()}}
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

            </div>
        </section>
    </div>
@endsection

