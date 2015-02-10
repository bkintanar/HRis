@extends(\Request::is('*pim/*') ? 'master.adm-master' : 'master.default')

@section('content')
    @include('partials.notification')
    @include('pages.profile.salary.form')
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

            $('.fields').change(function () {
                display();
            });

            $('.chosen-select').chosen();

        });

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
            earnings = getValues('earnings');
            deductions = getValues('deductions');

            $('.display-earnings').append(parseFloat(earnings).toFixed(2));
            $('.display-deduction').append(parseFloat(deductions).toFixed(2));
            $('.display-total').append(parseFloat(earnings - deductions).toFixed(2));
        }

    </script>

@stop

@section('action_area')
    @include('pages.profile.partials.avatar')
@stop