@extends(Request::is('*pim/*') ? 'master.adm-master' : 'master.default')

@section('content')
@include('partials.notification')
<div class="row">
        {!! Navlink::profileLinks($pim) !!}
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
    {!! TablePresenter::display($logged_user, $table) !!}
</div>
@if ($custom_field_sections)
    @include('pages.profile.partials.custom-fields')
@endif

@stop

@section('custom_js')

    {!! Html::script('/js/custom_datepicker.js') !!}

    <script>

        function deleteAction()
        {
            if($('.job_history_list').length < 2){
                $('.action').remove();
            }
        }

        function disableButton(status)
        {
            $('#save-button').attr('disabled', status);
        }

        function getValues()
        {
            searchIDs = new Array();
            var i = 0;
            $('.form-fields').each(function () {
                searchIDs[i] = $(this).val();
                i++;
            });

            return searchIDs.toString();
        }

        $(document).ready(function () {

            var defaults;

            defaults = getValues();
            deleteAction();
            disableButton(true);

            $('.form-fields').change(function(){
                var changes = getValues();
                if(changes !== defaults)
                {
                    disableButton(false);
                }
                else
                {
                    disableButton(true);
                }
            });

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

            $('.btn-xs').click(function(){

                var dataId = $(this).attr('id');

                $.ajax({
                    type: "DELETE",
                    url: '/ajax/' + '{{Request::path()}}',
                    data: { id: dataId, _token: $('input[name=_token]').val() }
                }).done(function( response ) {

                    if (response == 'success')
                    {
                        window.location = "?success=1";
                    }
                });

            });
        });

    </script>

@stop

@section('action_area')
    @include('pages.profile.partials.avatar')
@stop
