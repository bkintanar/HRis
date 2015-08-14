{!! Form::model($employee, ['method' => 'PATCH', 'url' => str_replace('/edit', '', \Request::path()), 'class' => 'form-horizontal']) !!}
    {!! Form::hidden('id') !!}

    @include('pages.profile.salary.form-earnings')
    @include('pages.profile.salary.form-deductions')

    <div class="hr-line-dashed"></div>
    <!-- End - Salary -->

    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Salary Summary</h5>
                <div class="ibox-tools">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                </div>
            </div>
            <div class="ibox-content">
                <p class="display-earnings"><span class="label-total">Total Earnings: </span><span id="total-earnings"></span></p>
                <p class="display-deduction"><span class="label-total">Total Deductions: </span><span id="total-deductions"></span></p>
                <p class="display-total"><span class="label-total">Total: </span><span id="total-salary"></span></p>
                <div class="form-group">
                    <div class="col-sm-4 col-sm-offset-2">
                    @if ($disabled == '')
                        {!! Html::link(str_replace('/edit', '', \Request::path()), 'Cancel', ['class' => 'btn btn-white btn-xs']) !!}
                        {!! Form::submit('Save changes', ['class' => 'btn btn-primary btn-xs']) !!}
                    @else
                        @if($loggedUser->hasAccess(\Request::segment(1).'.contact-details.update'))
                            {!! Html::link(\Request::path() . '/edit', 'Modify', ['class' => 'btn btn-primary btn-xs']) !!}
                        @endif
                    @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @else
        @if($loggedUser->hasAccess(\Request::segment(1).'.contact-details.update'))
        <div class="form-group">
            <div class="col-sm-4 col-sm-offset-2">
                {!! Html::link(\Request::path() . '/edit', 'Modify', ['class' => 'btn btn-primary btn-xs']) !!}
            </div>
        </div>
        @endif
    @endif

{!! Form::close() !!}
