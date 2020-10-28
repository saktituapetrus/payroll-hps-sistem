<footer class="main-footer ">
    <div class="footer-left">
        {{(Utility::getValByName('footer_text')) ? Utility::getValByName('footer_text') :  __('Copyright HRLab') }}
        {{ date('Y') }}
    </div>
    <div class="footer-right">
    </div>
</footer>

<div class="modal fade" id="commonModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

            </div>
        </div>
    </div>
</div>

<script src="{{ asset('assets/modules/jquery.min.js') }}"></script>
<script src="{{ asset('assets/modules/popper.js') }}"></script>
<script src="{{ asset('assets/modules/tooltip.js') }}"></script>
<script src="{{ asset('assets/modules/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/modules/bootstrap/js/bootstrap-notify.min.js') }}"></script>
<script src="{{ asset('assets/modules/nicescroll/jquery.nicescroll.min.js') }}"></script>
<script src="{{ asset('assets/modules/moment.min.js') }}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment-with-locales.min.js"></script>
<script>
    moment.locale('{{App::getLocale()}}');
</script>

<script src="{{ asset('assets/modules/select2/dist/js/select2.full.js') }}"></script>
<script src="{{ asset('assets/js/stisla.js') }}"></script>

<script src="{{ asset('assets/modules/datatables/datatables.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/modules/datatables/dataTables.bootstrap4.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/modules/bootstrap-daterangepicker/daterangepicker.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/modules/bootstrap-datepicker/js/bootstrap-datepicker.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/modules/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>



<script src="{{ asset('assets/modules/jquery.sparkline.min.js') }}"></script>
<script src="{{ asset('assets/modules/owlcarousel2/dist/owl.carousel.min.js') }}"></script>
<script src="{{ asset('assets/modules/summernote/summernote-bs4.js') }}"></script>
<script src="{{ asset('assets/modules/chocolat/dist/js/jquery.chocolat.min.js') }}"></script>
<script src="{{ asset('assets/default/render/bootstrap-toastr/toastr.min.js') }}"></script>
<script src="{{ asset('assets/modules/bootstrap-timepicker/js/bootstrap-timepicker.js') }}"></script>
@stack('script-page')
<script src="{{ asset('assets/js/scripts.js') }}"></script>
<script src="{{ asset('assets/js/custom.js') }}"></script>

<script>
    var date_picker_locale = {
        format: 'YYYY-MM-DD',
        daysOfWeek: [
            "{{__('Sun')}}",
            "{{__('Mon')}}",
            "{{__('Tue')}}",
            "{{__('Wed')}}",
            "{{__('Thu')}}",
            "{{__('Fri')}}",
            "{{__('Sat')}}"
        ],
        monthNames: [
            "{{__('January')}}",
            "{{__('February')}}",
            "{{__('March')}}",
            "{{__('April')}}",
            "{{__('May')}}",
            "{{__('June')}}",
            "{{__('July')}}",
            "{{__('August')}}",
            "{{__('September')}}",
            "{{__('October')}}",
            "{{__('November')}}",
            "{{__('December')}}"
        ],
    };

    var calender_header = {
        today: "{{__('today')}}",
        month: '{{__('month')}}',
        week: '{{__('week')}}',
        day: '{{__('day')}}',
        list: '{{__('list')}}'
    };
</script>

@if($message = Session::get('success'))
<script>
    show_msg('Success', '{{$message}}', 'success');
</script>
@endif
@if($message = Session::get('error'))
<script>
    show_msg('Error', '{{$message}}', 'error');
</script>
@endif