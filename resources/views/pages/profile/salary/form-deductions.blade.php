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
                    {!! Form::label($value, $value->salaryComponent->name, ['class' => 'col-md-2 control-label']) !!}
                    <div class="col-md-4">
                    {!! Form::hidden($value->salaryComponent->name . '[component_id]', $value->component_id) !!}
                        @if($value->component_id == 2)
                            {!! Form::text($value->salaryComponent->name . '[value]', $value->value, ['id' => 'sss', 'class' => 'form-control fields deductions', 'data-mask' => '99999.99', $disabled]) !!}
                            @if($disabled == '')
                                <input type="button" value="Refresh" id="rfrsh-sss" class="btn btn-white btn-xs" />
                            @endif
                        @else
                            {!! Form::text($value->salaryComponent->name . '[value]', $value->value, ['class' => 'form-control fields deductions', 'data-mask' => '99999.99', $disabled]) !!}
                        @endif
                    </div>

                    <label for="joined_date" class="col-md-2 control-label">Effective Date</label>
                    <div class="col-md-4" id="datepicker">
                      <div class="input-group date" id="data_1">
                          <span class="input-group-addon"><i class="fa fa-calendar"></i></span>{!! Form::text($value->salaryComponent->name . '[effective_date]', $value->effective_date, ['class' => 'form-control', 'data-mask' => '9999-99-99', $disabled]) !!}
                      </div>
                    </div>
                </div>
                @endif
            @endforeach
                <div class="form-group">
                    {!! Form::label('tax', 'Tax', ['class' => 'col-md-2 control-label']) !!}
                    <div class="col-md-4">
                    {!! Form::text('tax', $tax, ['class' => 'form-control fields tax', 'data-mask' => '99999.99', $disabled]) !!}
                    </div>
                </div>
        </div>
    </div>
</div>