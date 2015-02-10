{!! Form::model($employee, ['method' => 'PATCH', 'url' => str_replace('/edit', '', \Request::path()), 'class' => 'form-horizontal']) !!}
    {!! Form::hidden('user[id]') !!}
    {!! Form::hidden('id') !!}

    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>All Earnings</h5>
                <div class="ibox-tools">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                </div>
            </div>
            <div class="ibox-content">
                @foreach($employee->employeeSalaryComponents as $value)
                    @if($value->salaryComponent->type == 1)
                    <div class="form-group">
                        {!! Form::label('$value', $value->salaryComponent->components, ['class' => 'col-md-2 control-label']) !!}
                        <div class="col-md-4">
                        {!! Form::text('salary', $value->value, ['class' => 'form-control fields earnings', 'data-mask' => '99,999.99', $disabled]) !!}
                        </div>

                        <label for="joined_date" class="col-md-2 control-label">Effective Date</label>
                        <div class="col-md-4" id="datepicker">
                            <div class="input-group date" id="data_1">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>{!! Form::text('date', $value->effective_date, ['class' => 'form-control', 'data-mask' => '9999-99-99', $disabled]) !!}
                            </div>
                        </div>
                    </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>

    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>All Deductions</h5>
                <div class="ibox-tools">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                </div>
            </div>
            <div class="ibox-content">
                @foreach($employee->employeeSalaryComponents as $value)
                    @if($value->salaryComponent->type == 2)
                    <div class="form-group">
                        {!! Form::label('$value', $value->salaryComponent->components, ['class' => 'col-md-2 control-label']) !!}
                        <div class="col-md-4">
                        {!! Form::text('salary', $value->value, ['class' => 'form-control fields deductions', 'data-mask' => '99,999.99', $disabled]) !!}
                        </div>

                        <label for="joined_date" class="col-md-2 control-label">Effective Date</label>
                        <div class="col-md-4" id="datepicker">
                          <div class="input-group date" id="data_1">
                              <span class="input-group-addon"><i class="fa fa-calendar"></i></span>{!! Form::text('date', $value->effective_date, ['class' => 'form-control', 'data-mask' => '9999-99-99', $disabled]) !!}
                          </div>
                        </div>
                    </div>
                    @endif
                @endforeach
                    <div class="form-group">
                        {!! Form::label('tax', 'Tax', ['class' => 'col-md-2 control-label']) !!}
                        <div class="col-md-4">
                        {!! Form::text('tax', $tax, ['class' => 'form-control fields deductions', 'data-mask' => '99,999.99', $disabled]) !!}
                        </div>
                    </div>
            </div>
        </div>
    </div>

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
                <p class="display-earnings"><span class="label-total">Total Earnings: </span></p>
                <p class="display-deduction"><span class="label-total">Total Deductions: </span></p>
                <p class="display-total"><span class="label-total">Total: </span></p>
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

{!! Form::close() !!}