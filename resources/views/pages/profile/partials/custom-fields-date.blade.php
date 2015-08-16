<!-- Start - {{$custom_field->name }} -->
{!! Form::label('custom_field_'.$custom_field->id, $custom_field->name, ['class' => 'col-md-2 control-label']) !!}
<div class="col-sm-4"  id="custom_datepicker">
    <div class="input-group date">
        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>{!! Form::text('custom_field_'.$custom_field->id, isset($custom_field_values[$custom_field->id]) ? $custom_field_values[$custom_field->id] : null, ['class' => 'form-control', 'data-mask' => '9999-99-99', $custom_field->required ? 'required' : '', $disabled]) !!}
    </div>
</div>
<!-- End - {{$custom_field->name }} -->


