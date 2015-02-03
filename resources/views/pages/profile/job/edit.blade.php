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
    @include('pages.profile.job.job-history')
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

            function deleteAction()
            {
                if($('.JobHistoryList').length < 2){
                    $('.action').remove();
                }
            }

            deleteAction();

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
                    url: '/ajax/' + '{{\Request::path()}}',
                    data: { id: dataId, _token: $('input[name=_token]').val() }
                }).done(function( response ) {

                    if (response == 'success')
                    {
                        $('#notification-info').show();
                        $("#notification-info").delay(5000).fadeOut();
                        $('#jobHistory_' + dataId).remove();

                        if($('.JobHistoryList').length == 0){
                          $('#JobHistoryBody').append('<tr><td colspan="5">No job history listed</td></tr>');
                        }

                        location.reload();

                        deleteAction();
                    }
                    else
                    {
                      // failed
                    }
                });

            });
        });

    </script>

@stop

@section('action_area')
    @include('pages.profile.partials.avatar')
@stop
