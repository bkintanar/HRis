@extends(Request::is('*pim/*') ? 'master.adm-master' : 'master.default')

@section('content')
    @include('partials.notification')
    <div class="row">
        {!! Menu::profile() !!}
        @include('pages.profile.salary.form')
    </div>
@stop

@section('custom_js')

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
            earnings = getValues('earnings') + '{{$salary}}';
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
