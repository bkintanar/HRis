@extends(\Request::is('*pim/*') ? 'master.adm-master' : 'master.default')

@section('content')

<div class="row">
        {!! HRis\Eloquent\Navlink::profileLinks($pim) !!}
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
    <!-- iCheck -->
    {!! Html::script('/js/plugins/iCheck/icheck.min.js') !!}
    <!-- Chosen -->
    {!! Html::script('/js/plugins/chosen/chosen.jquery.js') !!}

    <script>
        $(document).ready(function () {

            function updateCityValues()
            {
                $.ajax({
                    type: "GET",
                    url: '/ajax/update-address',
                    data: {province_id : $("#address_province_id").val()}
                }).done(function (response) {

                    var city_id = $("#address_city_id").val();
                    var value = jQuery.parseJSON(response);

                    // disable the city select before updating its values
                    $("#address_city_id").attr('disabled', 'disabled');

                    $("#address_city_id").html("");
                    $("#address_city_id").append('<option value="0" selected>--- Select ---</option>');
                    for ( var i = 1; i < value.length; i++ )
                    {
                        if(value[i].id == city_id)
                        {
                            $("#address_city_id").append('<option value="' + value[i].id + '" selected>' + value[i].name +'</option>');
                        }
                        else
                        {
                            $("#address_city_id").append('<option value="' + value[i].id + '">' + value[i].name +'</option>');
                        }
                    }

                    // re-enable it by removing the disabled attribute
                    $("#address_city_id").removeAttr('disabled');

                    $('.chosen-select').trigger("chosen:updated");
                });
            }

            $('.chosen-select').chosen();

            updateCityValues();

            $("#address_province_id").change(function() {
                updateCityValues();
            });
        });

    </script>

@stop

@section('action_area')
    @include('pages.profile.partials.avatar')
@stop