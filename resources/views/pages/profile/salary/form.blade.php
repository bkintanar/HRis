{!! Form::model($employee, ['method' => 'PATCH', 'url' => str_replace('/edit', '', \Request::path()), 'class' => 'form-horizontal']) !!}
    {!! Form::hidden('user[id]') !!}
    {!! Form::hidden('id') !!}

    <h5 style="width: 100%; text-indent: 30px; background-color: #D1FFEF; line-height: 28px;">All Earnings</h5>
    @foreach($employee->employeeSalaryComponents as $value)
        @if($value->salaryComponent->type == 1)
        <div class="form-group">
                {!! Form::label('$value', $value->salaryComponent->components, ['class' => 'col-md-2 control-label']) !!}
                <div class="col-md-4">
                {!! Form::text('salary', $value->value, ['class' => 'form-control', 'data-mask' => '99,999.99', $disabled]) !!}
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
    <div class="hr-line-dashed"></div>

    <h5 style="width: 100%; text-indent: 30px; background-color: #FFD7D1; line-height: 28px;">All Deductions</h5>
    @foreach($employee->employeeSalaryComponents as $value)
        @if($value->salaryComponent->type == 2)
        <div class="form-group">
                {!! Form::label('$value', $value->salaryComponent->components, ['class' => 'col-md-2 control-label']) !!}
                <div class="col-md-4">
                {!! Form::text('salary', $value->value, ['class' => 'form-control', 'data-mask' => '99,999.99', $disabled]) !!}
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
    <div class="hr-line-dashed"></div>

    <!-- End - Salary -->

    @if ($disabled == '')
    <div class="form-group">
        <div class="col-sm-4 col-sm-offset-2">
            {!! Html::link(str_replace('/edit', '', \Request::path()), 'Cancel', ['class' => 'btn btn-white btn-xs']) !!}
            {!! Form::submit('Save changes', ['class' => 'btn btn-primary btn-xs']) !!}
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