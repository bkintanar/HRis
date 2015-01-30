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

    {!! Html::style('/css/plugins/chosen/chosen.css') !!}

@stop
@section('custom_js')
    <!-- Input Mask-->
    {!! Html::script('/js/plugins/jasny/jasny-bootstrap.min.js') !!}
    <!-- Chosen -->
    {!! Html::script('/js/plugins/chosen/chosen.jquery.js') !!}

    <script>
        $(document).ready(function () {

            function deleteRecord(dataId)
            {
                $.ajax({
                    type: "DELETE",
                    url: '/ajax/' + '{{\Request::path()}}',
                    data: { id: dataId, _token: $('input[name=_token]').val() }
                }).done(function( response ) {

                    if (response == 'success')
                    {
                        $('#jobHistory_' + dataId).remove();
                    }
                    else
                    {
                        // failed
                    }
                });
            }

            $('.btn-xs').click(function(){
               deleteRecord($(this).attr('id'));
            });

            $('.chosen-select').chosen();

        });
    </script>

@stop

@section('action_area')
    @include('pages.profile.partials.avatar')
@stop