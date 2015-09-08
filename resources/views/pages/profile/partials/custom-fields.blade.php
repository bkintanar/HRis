@foreach($custom_field_sections as $custom_field_section)
@if($custom_field_section->customFields->count())
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>{{ $custom_field_section->name }}</h5>

                <div class="ibox-tools">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                </div>
            </div>
            <div class="ibox-content">
                {!! Form::model($employee, ['method' => 'PATCH', 'url' => str_replace('/edit', '', Request::path()) . '/custom-fields', 'class' => 'form-horizontal', 'onSubmit' => 'checkEmployeeId()', 'id' => 'personalDetailsForm']) !!}
                {!! Form::hidden('id') !!}

                @foreach($custom_field_section->customFields as $index => $custom_field)

                    @if($index % 2 == 0)
                        <div class="form-group">
                    @endif

                    @if($custom_field->type->name == 'Text')
                        @include('pages.profile.partials.custom-fields-text')
                    @elseif($custom_field->type->name == 'Drop Down')
                        @include('pages.profile.partials.custom-fields-drop-down')
                    @elseif($custom_field->type->name == 'Number')
                    @elseif($custom_field->type->name == 'Email')
                    @elseif($custom_field->type->name == 'Text Area')
                    @elseif($custom_field->type->name == 'Date')
                        @include('pages.profile.partials.custom-fields-date')
                    @elseif($custom_field->type->name == 'Drop Down')
                    @elseif($custom_field->type->name == 'Drop Down')
                    @endif

                    @if(($index+1 <= $custom_field_section->customFields->count() and ($index+1) % 2 == 0) or $custom_field_section->customFields->count() == $index+1)
                        </div>
                    @endif
                @endforeach

                <div class="hr-line-dashed"></div>
                <div class="form-group save-form" style="display:none;">
                    <div class="col-sm-4 col-sm-offset-2">
                        {!! Html::link('#0', 'Cancel', ['class' => 'btn btn-white btn-xs cancel-form']) !!}
                        {!! Form::submit('Save changes', ['class' => 'btn btn-primary btn-xs']) !!}
                    </div>
                </div>
                @if($logged_user->hasAccess(Request::segment(1).'.personal-details.update'))
                    <div class="form-group modify-form">
                        <div class="col-sm-4 col-sm-offset-2">
                            {!! Html::link('#0', 'Modify', ['class' => 'btn btn-primary btn-xs']) !!}
                        </div>
                    </div>
                @endif
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endif
@endforeach
