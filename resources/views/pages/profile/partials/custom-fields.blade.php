@foreach($custom_field_sections as $custom_field_section)
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

                <div class="form-group">
                @foreach($custom_field_section->customFields as $custom_field)
                    @if($custom_field->type->name == 'Text')
                        @include('pages.profile.partials.custom-fields-text')
                    @elseif($custom_field->type->name == 'Drop Down')
                        @include('pages.profile.partials.custom-fields-drop-down')
                    @elseif($custom_field->type->name == 'Number')
                    @elseif($custom_field->type->name == 'Email')
                    @elseif($custom_field->type->name == 'Text Area')
                    @elseif($custom_field->type->name == 'Drop Down')
                    @elseif($custom_field->type->name == 'Drop Down')
                    @elseif($custom_field->type->name == 'Drop Down')
                    @endif
                @endforeach
                </div>

                <div class="hr-line-dashed"></div>

                @if ($disabled == '')
                    <div class="form-group">
                        <div class="col-sm-4 col-sm-offset-2">
                            {!! Html::link(str_replace('/edit', '', Request::path()), 'Cancel', ['class' => 'btn btn-white btn-xs']) !!}
                            {!! Form::submit('Save changes', ['class' => 'btn btn-primary btn-xs']) !!}
                        </div>
                    </div>
                @else
                    @if($logged_user->hasAccess(Request::segment(1).'.personal-details.update'))
                        <div class="form-group">
                            <div class="col-sm-4 col-sm-offset-2">
                                {!! Html::link(Request::path().'/edit', 'Modify', ['class' => 'btn btn-primary btn-xs']) !!}
                            </div>
                        </div>
                    @endif
                @endif
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endforeach
