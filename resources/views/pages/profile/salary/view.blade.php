@extends(\Request::is('*pim/*') ? 'master.adm-master' : 'master.default')

@section('content')
    @include('partials.notification')
    <div class="row">
        {!! HRis\Navlink::profileLinks($pim) !!}
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>All Earnings</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    @include('pages.profile.salary.form')
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

        function getValues(type)
        {
            var data = 0;
            $('.' + type).each(function () {
                data += Number($(this).val());
            });

            return data;
        }

        function display()
        {
            earnings = getValues('earnings') + parseFloat($('#salary').val() / 2);
            deductions = getValues('deductions') + parseFloat($('.tax').val());

            $('#total-earnings').html(parseFloat(earnings).toFixed(2));
            $('#total-deductions').html(parseFloat(deductions).toFixed(2));
            $('#total-salary').html(parseFloat(earnings - deductions).toFixed(2));
        }

        $(document).ready(function () {

            $('.chosen-select').chosen();

            display();

        });

    </script>

@stop

@section('action_area')
    @include('pages.profile.partials.avatar')
@stop
