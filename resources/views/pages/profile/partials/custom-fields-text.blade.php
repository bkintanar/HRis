<!-- Start - {{$custom_field->name }} -->
{!! Form::label('custom_field_'.$custom_field->id, $custom_field->name, ['class' => 'col-md-2 control-label']) !!}
<div class="col-sm-4">
    {!! Form::text('custom_field_'.$custom_field->id, isset($custom_field_values[$custom_field->id]) ? $custom_field_values[$custom_field->id] : null, ['class' => 'form-control', $custom_field->required ? 'required' : '', 'disabled' => 'disabled']) !!}
</div>
<!-- End - {{$custom_field->name }} -->
