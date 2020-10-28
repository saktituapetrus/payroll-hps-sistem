@extends('layouts.login-reg')
@section('page-title')
    {{__('Forgot Password')}}
@endsection
@php
    $logo=asset(Storage::url('logo/'));
@endphp
@section('content')
    <div id="app">
        <section class="section">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 pt-4">
                        <div class="changeLanguage float-right mr-1 position-relative">
                            <ul class="navbar-nav navbar-right">
                                <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown" class="nav-link notification-toggle nav-link-lg language-dd"><i class="fas fa-language lang-font"></i></a>
                                    <div class="dropdown-menu dropdown-list dropdown-menu-right">
                                        <div class="dropdown-header">{{__('Choose Language')}}
                                        </div>
                                        <div class="dropdown-list-content dropdown-list-icons lang-dropdown">
                                            @foreach(Utility::languages() as $language)
                                                <a href="{{ route('change.langPass',$language) }}" class="dropdown-item dropdown-item-unread @if($language == $lang) active-language @endif">
                                                    <span> {{Str::upper($language)}}</span>
                                                </a>
                                            @endforeach
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container mt-5">
                <div class="row">
                    <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
                        <div class="login-brand">
                            <img class="img-fluid" src="{{$logo.'/logo.png'}}" alt="" width="">
                        </div>
                        <div class="card card-primary">
                            <div class="card-header"><h4>{{ __('Forgot Password') }}</h4></div>
                            <div class="card-body">
                                <p class="text-muted">{{ __('We will send a link to reset your password') }}</p>
                                @if (session('status'))
                                    <div class="alert alert-success" role="alert">
                                        {{ session('status') }}
                                    </div>
                                @endif
                                <form method="POST" action="{{ route('password.email') }}">
                                    @csrf
                                    <div class="form-group">
                                        <label for="email">{{ __('E-Mail Address') }}</label>
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-lg btn-block">
                                            {{ __('Send Password Reset Link') }}
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="mt-5 text-muted text-center">
                            <a href="{{ route('login') }}">{{__('Login')}}</a>
                        </div>
                        <div class="simple-footer">
                            {{(Utility::getValByName('footer_text')) ? Utility::getValByName('footer_text') :  __('Copyright HRLab') }} {{ date('Y') }}
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
