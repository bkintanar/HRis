{!! Form::model($employee, ['method' => 'PATCH', 'url' => str_replace('/edit', '', \Request::path()), 'class' => 'form-horizontal']) !!}
    {!! Form::hidden('user[id]') !!}
    {!! Form::hidden('id') !!}
    <div class="form-group">
            {!! Form::label('address_1', 'Address Street 1', ['class' => 'col-md-2 control-label']) !!}
            <div class="col-md-4">
                {!! Form::text('address_1', null, ['class' => 'form-control', $disabled]) !!}
            </div>

            {!! Form::label('address_2', 'Address Street 2', ['class' => 'col-md-2 control-label']) !!}
            <div class="col-md-4">
                {!! Form::text('address_2', null, ['class' => 'form-control', $disabled]) !!}
            </div>

    </div>

    <div class="form-group">
            {!! Form::label('address_city_id', 'City', ['class' => 'col-md-2 control-label']) !!}
            <div class="col-md-4">
                {!! Form::select('address_city_id', HRis\Eloquent\City::lists('name', 'id'), $employee->address_city_id, ['class' => 'form-control chosen-select', $disabled]) !!}
            </div>

            {!! Form::label('address_province_id', 'Province', ['class' => 'col-md-2 control-label']) !!}
            <div class="col-md-4">
                {!! Form::select('address_province_id', HRis\Eloquent\Province::lists('name', 'id'), $employee->address_province_id, ['class' => 'form-control chosen-select', $disabled]) !!}
            </div>
    </div>

    <div class="form-group">
            {!! Form::label('address_postal_code', 'Zip/Postal Code', ['class' => 'col-md-2 control-label', 'data-mask' => '9999']) !!}
            <div class="col-md-4">
                {!! Form::text('address_postal_code', null, ['class' => 'form-control', $disabled]) !!}
            </div>
            {!! Form::label('address_country_id', 'Country', ['class' => 'col-md-2 control-label']) !!}
            <div class="col-md-4">
                {!! Form::select('address_country_id', HRis\Eloquent\Country::whereId(185)->lists('name', 'id'), $employee->address_country_id, ['class' => 'form-control chosen-select', $disabled]) !!}
            </div>

    </div>

    <div class="hr-line-dashed"></div>
    <!-- End - Address -->

        <div class="form-group">
                {!! Form::label('home_phone', 'Home Telephone', ['class' => 'col-md-2 control-label']) !!}
                <div class="col-md-4">
                {!! Form::text('home_phone', null, ['class' => 'form-control', 'data-mask' => '099 999 9999', $disabled]) !!}
                </div>

                {!! Form::label('mobile_phone', 'Mobile', ['class' => 'col-md-2 control-label']) !!}
                <div class="col-md-4">
                {!! Form::text('mobile_phone', null, ['class' => 'form-control', 'data-mask' => '0999 999 9999', $disabled]) !!}
                </div>
        </div>

    <div class="hr-line-dashed"></div>
    <!-- End - Telephone details -->

        <div class="form-group">
                {!! Form::label('work_email', 'Work Email', ['class' => 'col-md-2 control-label']) !!}
                <div class="col-md-4">
                    {!! Form::email('work_email', null, ['class' => 'form-control', $disabled]) !!}
                </div>

                {!! Form::label('other_email', 'Other Email', ['class' => 'col-md-2 control-label']) !!}
                <div class="col-md-4">
                    {!! Form::email('other_email', null, ['class' => 'form-control', $disabled]) !!}
                </div>
        </div>

    <div class="hr-line-dashed"></div>
    <!-- End - Email -->

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