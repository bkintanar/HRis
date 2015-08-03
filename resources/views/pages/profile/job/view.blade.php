@extends(Request::is('*pim/*') ? 'master.adm-master' : 'master.default')

@section('content')
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
@stop

@section('custom_js')

    {!! Html::script('/js/notification.js') !!}

    <script>
        $(document).ready(function () {

            $('.action').remove();

            $('.chosen-select').chosen();

        });
    </script>

@stop

@section('action_area')
    @include('pages.profile.partials.avatar')
@stop
