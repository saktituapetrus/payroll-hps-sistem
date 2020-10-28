@php
use App\Utility;
$users=\Auth::user();
$currantLang = $users->currentLanguage();
$languages=Utility::languages();
$profile=asset(Storage::url('avatar/'));
@endphp
<div class="navbar-bg"></div>
<nav class="navbar navbar-expand-lg main-navbar">
    <form class="form-inline mr-auto">
        <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
        </ul>
        <div class="search-element">

        </div>
    </form>
    <ul class="navbar-nav navbar-right">
        @can('Manage Language')
        <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown"
                class="nav-link notification-toggle nav-link-lg language-dd"><i class="fas fa-language"></i></a>
            <div class="dropdown-menu dropdown-list dropdown-menu-right" style="height: 150px">
                <div class="dropdown-header">{{__('Choose Language')}}</div>

                @can('Create Language')
                <a href="{{route('manage.language',[$currantLang])}}" class="dropdown-item btn manage-language-btn">
                    <span> {{ __('Create & Customize') }}</span>
                </a>
                @endcan

                <div class="dropdown-list-content dropdown-list-icons">
                    &nbsp;
                    @foreach($languages as $language)
                    <a href="{{route('change.language',$language)}}"
                        class="dropdown-item dropdown-item-unread @if($language == $currantLang) active-language @endif">
                        <span>{{Str::upper($language)}}</span>
                    </a>
                    @endforeach
                </div>
            </div>
        </li>
        @endcan
        <li class="dropdown"><a href="#" data-toggle="dropdown"
                class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                <img alt=""
                    src="{{(!empty($users->avatar)? $profile.'/'.$users->avatar : $profile.'/avatar3_small.jpg')}}"
                    class="rounded-circle mr-1">
                <div class="d-sm-none d-lg-inline-block">{{__('Hi')}}, {{\Auth::user()->name}}</div>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <div class="dropdown-title">{{__('Welcome!')}}</div>

                @can('Manage Profile')
                <a href="{{route('profile')}}" class="dropdown-item has-icon">
                    <i class="far fa-user"></i> {{__('My profile')}}
                </a>
                @endcan
                <div class="dropdown-divider"></div>
                <a href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('frm-logout').submit();"
                    class="dropdown-item has-icon text-danger">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>{{__('Logout')}}</span>
                </a>
                <form id="frm-logout" action="{{ route('logout') }}" method="POST" class="d-none">
                    {{ csrf_field() }}
                </form>
            </div>
        </li>
    </ul>
</nav>
