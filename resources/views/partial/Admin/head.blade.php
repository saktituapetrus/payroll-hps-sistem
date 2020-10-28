<!-- General CSS Files -->
<meta charset="UTF-8">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
<title>{{(Utility::getValByName('title_text')) ? Utility::getValByName('title_text') : config('app.name', 'HRLab')}} - @yield('page-title')</title>

<link rel="icon" href="{{asset(Storage::url('logo')).'/favicon.png'}}" type="image" sizes="16x16">
<link rel="stylesheet" href="{{ asset('assets/modules/bootstrap/css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/modules/fontawesome/css/all.min.css') }}">

<link href="{{ asset('assets/modules/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css"/>
<!-- CSS Libraries -->
<link rel="stylesheet" href="{{ asset('assets/modules/jqvmap/dist/jqvmap.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/modules/summernote/summernote-bs4.css') }}">
<link rel="stylesheet" href="{{ asset('assets/modules/owlcarousel2/dist/assets/owl.carousel.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/modules/owlcarousel2/dist/assets/owl.theme.default.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/modules/bootstrap-daterangepicker/daterangepicker.css') }}">
<link rel="stylesheet" href="{{ asset('assets/modules/select2/dist/css/select2.css') }}">
<!--datepciker bootstrap-->
<link rel="stylesheet" href="{{ asset('assets/modules/bootstrap-datepicker/css/bootstrap-datepicker.css') }}">
<link rel="stylesheet" href="{{ asset('assets/modules/bootstrap-datepicker/css/bootstrap-datepicker.css.map') }}">
<link rel="stylesheet" href="{{ asset('assets/modules/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/modules/bootstrap-datepicker/css/bootstrap-datepicker.standalone.css') }}">
<link rel="stylesheet" href="{{ asset('assets/modules/bootstrap-datepicker/css/bootstrap-datepicker.standalone.min.css') }}">

<!-- Template CSS -->
<link rel="stylesheet" href="{{ asset('assets/modules/bootstrap-timepicker/css/bootstrap-timepicker.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/components.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
<link rel="stylesheet" href="{{ asset('assets/default/render/bootstrap-toastr/toastr.min.css') }}">

