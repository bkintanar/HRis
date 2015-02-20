@extends(\Request::is('*pim/*') ? 'master.adm-master' : 'master.default')

@section('content')
    @include('partials.notification')
    <div class="row">
        {!! HRis\Navlink::profileLinks($pim) !!}
        @include('pages.profile.salary.form')
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
                data += parseFloat($(this).val());
            });

            return data;
        }

        function display()
        {
            earnings = getValues('earnings') + parseFloat($('#salary').val() / 2);
            deductions = getValues('deductions') + parseFloat($('.tax').html());

            console.log($('.tax').html());

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