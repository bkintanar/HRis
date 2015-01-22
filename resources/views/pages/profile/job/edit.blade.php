@extends(\Request::is('*pim/*') ? 'master.adm-master' : 'master.default')

@section('content')

<div class="row">
        {!! HRis\Navlink::profileLinks($pim) !!}
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Job Details</h5>
                <div class="ibox-tools">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                </div>
            </div>
            <div class="ibox-content">
                @include('pages.profile.job.form')
            </div>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Job History</h5>
                <div class="ibox-tools">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                </div>
            </div>
            <div class="ibox-content">
            </div>
        </div>
    </div>
</div>

@stop

@section('custom_css')

    {!! Html::style('/css/plugins/iCheck/custom.css') !!}
    {!! Html::style('/css/plugins/chosen/chosen.css') !!}
    {!! Html::style('/css/plugins/datepicker/datepicker3.css') !!}

@stop

@section('custom_js')
    <!-- Input Mask-->
    {!! Html::script('/js/plugins/jasny/jasny-bootstrap.min.js') !!}
    <!-- iCheck -->
    {!! Html::script('/js/plugins/iCheck/icheck.min.js') !!}
    <!-- Chosen -->
    {!! Html::script('/js/plugins/chosen/chosen.jquery.js') !!}
    <!-- Date Picker -->
    {!! Html::script('js/plugins/datepicker/bootstrap-datepicker.js') !!}

    <script>
        $(document).ready(function () {

            // Date picker
            $('#datepicker .input-group.date').datepicker({
                todayBtn: "linked",
                format: 'yyyy-mm-dd',
                keyboardNavigation: false,
                forceParse: false,
                calendarWeeks: true,
                autoclose: true
            });

            $('.chosen-select').chosen();
        });

    </script>

@stop

@section('action_area')
    @include('pages.profile.partials.avatar')
@stop