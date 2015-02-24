@extends(\Request::is('*pim/*') ? 'master.adm-master' : 'master.default')

@section('content')
    @include('partials.notification')
    <div class="row">
        {!! \HRis\Eloquent\Navlink::profileLinks($pim) !!}
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Contact Details</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    @include('pages.profile.contact-details.form')
                </div>
            </div>
        </div>
    </div>
@stop

@section('custom_css')

    {!! Html::style('/css/plugins/chosen/chosen.css') !!}

@stop
@section('custom_js')
    <!-- Input Mask-->
    {!! Html::script('/js/plugins/jasny/jasny-bootstrap.min.js') !!}
    <!-- Chosen -->
    {!! Html::script('/js/plugins/chosen/chosen.jquery.js') !!}

    {!! Html::script('/js/notification.js') !!}

    <script>
        $(document).ready(function () {

            var address_province_id = $("#address_province_id").val();

            if (address_province_id == 0)
            {
                $("#address_city_id").html("");
                $("#address_city_id").append('<option value="0" selected>--- Select ---</option>');

                $('.chosen-select').trigger("chosen:updated");
            }
        });

        $('.chosen-select').chosen();

    </script>

@stop

@section('action_area')
    @include('pages.profile.partials.avatar')
@stop