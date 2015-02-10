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
                data += Number($(this).val());
            });

            return data;
        }

        earnings = getValues('earnings');
        deductions = getValues('deductions');

        $('.display-earnings').append(parseFloat(earnings).toFixed(2));
        $('.display-deduction').append(parseFloat(deductions).toFixed(2));
        $('.display-total').append(parseFloat(earnings - deductions).toFixed(2));

        $('.chosen-select').chosen();

    </script>
@stop

@section('action_area')
    @include('pages.profile.partials.avatar')
@stop