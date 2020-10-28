<!DOCTYPE html>
<html>
@include('partial.Admin.head')
@stack('css-page')
<body>
<div id="app">
    <div class="main-wrapper main-wrapper-1">
    @include('partial.Admin.header')
    @include('partial.Admin.menu')

    @yield('content')
    </div>
</div>
@include('partial.Admin.script')
</body>
</html>
