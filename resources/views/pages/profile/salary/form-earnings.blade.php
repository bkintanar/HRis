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
            @foreach($employee->employeeSalaryComponent as $value)
            @if($value->salaryComponent->type == 1)
                <div class="form-group">
                    {!! Form::label($value->salaryComponent->name, $value->salaryComponent->name, ['class' => 'col-md-2 control-label']) !!}
                    <div class="col-md-4">
                    {!! Form::hidden($value->salaryComponent->name . '[component_id]', $value->component_id) !!}
                        @if($value->component_id == 1)
                            {!! Form::text($value->salaryComponent->name . '[value]', $value->value, ['id' => 'salary', 'class' => 'form-control', 'data-mask' => '99999.99', $disabled]) !!}
                        @else
                            {!! Form::text($value->salaryComponent->name . '[value]', $value->value, ['class' => 'form-control fields earnings', 'data-mask' => '99999.99', $disabled]) !!}
                        @endif
                    </div>

                    <label for="joined_date" class="col-md-2 control-label">Effective Date</label>
                    <div class="col-md-4" id="datepicker">
                        <div class="input-group date" id="data_1">
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                            {!! Form::text($value->salaryComponent->name . '[effective_date]', $value->effective_date ? $value->effective_date->toDateString() : null, ['class' => 'form-control', 'data-mask' => '9999-99-99', $disabled]) !!}
                        </div>
                    </div>
                </div>
                @endif
            @endforeach
        </div>
    </div>
</div>