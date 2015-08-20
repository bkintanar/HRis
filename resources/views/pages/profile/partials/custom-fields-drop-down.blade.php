<!-- Start - {{$custom_field->name }} -->
{!! Form::label('custom_field_'.$custom_field->id, $custom_field->name, ['class' => 'col-md-2 control-label']) !!}
<div class="col-sm-4">
    {!! Form::select('custom_field_'.$custom_field->id, $custom_field->options->lists('name', 'id'), isset($custom_field_values[$custom_field->id]) ? $custom_field_values[$custom_field->id] : null, ['placeholder' => '--- Select ---', 'class' => 'form-control chosen-select', $disabled]) !!}
</div>
<!-- End - {{$custom_field->name }} -->
