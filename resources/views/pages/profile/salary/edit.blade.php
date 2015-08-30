@extends(Request::is('*pim/*') ? 'master.adm-master' : 'master.default')

@section('content')
    @include('partials.notification')
    <div class="row">
        {!! Menu::profile() !!}
        @include('pages.profile.salary.form')
    </div>
@stop

@section('custom_js')

    <script>

        function getValues(type)
        {
            var data = 0;
            $('.' + type).each(function () {
                data += parseFloat($(this).val());
            });

            return data;
        }

        function display(values)
        {
            earnings = getValues('earnings') + values.salary;
            deductions = getValues('deductions') + parseFloat($('.tax').html());

            $('#total-earnings').html(parseFloat(earnings).toFixed(2));
            $('#total-deductions').html(parseFloat(deductions).toFixed(2));
            $('#total-salary').html(parseFloat(earnings - deductions).toFixed(2));
        }

        function updateSalary(type)
        {
            var datas = { salary: $('#salary').val(), status: '{{$tax_status}}', deductions: getValues('deductions'), sss: $('#sss').val(), type: type }
                $.ajax({
                    type: "GET",
                    url: '/ajax/' + '{{Request::path()}}',
                    data: datas
                }).done(function( response ) {
                    var values = jQuery.parseJSON(response);
                    $('#sss').val(parseFloat(values.sss).toFixed(2));
                    $('.tax').html(parseFloat(values.tax).toFixed(2));
                    display(values);
                });
        }

        $(document).ready(function () {

            $('#salary').change(function () {
                updateSalary();
            });

            $('#rfrsh-sss').click(function () {
                updateSalary('sss');
            });

            $('.fields').change(function () {
                $(this).val(parseFloat($(this).val()).toFixed(2));
                updateSalary();
            });

            updateSalary();

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
