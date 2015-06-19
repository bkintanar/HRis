<div class="col-lg-12">
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>{{ $table['title'] }}</h5>
            <div class="ibox-tools">
                <a class="collapse-link">
                    <i class="fa fa-chevron-up"></i>
                </a>
            </div>
        </div>
        <div class="ibox-content">

            @if($table['model']['dashed'] != 'job-histories' && $logged_user->hasAccess(Request::segment(1).'.' . $table['model']['dashed']))
                <div class="">
                    <a id="add_{{ $table['model']['singular'] }}" href="javascript:void(0);" class="btn btn-primary btn-xs">Add a new row</a>
                </div>
            @endif
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        @foreach($table['headers'] as $header)
                            <th>{{ $header }}</th>
                        @endforeach
                        <th class="fix-width">Action</th>
                    </tr>
                    </thead>

                    <tbody id="{{ $table['model']['plural'] }}_body">

                        {!! $data_table !!}

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
