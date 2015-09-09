@extends(Request::is('*pim/*') ? 'master.adm-master' : 'master.default')

@section('content')
    @include('partials.notification')
    <div class="row">
        {!! Menu::profile() !!}
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Contact Details</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    {!! Form::model($employee, ['method' => 'PATCH', 'url' => Request::path(), 'class' => 'form-horizontal']) !!}
                    {!! Form::hidden('user[id]') !!}
                    {!! Form::hidden('id') !!}
                    <div class="form-group">
                        {!! Form::label('address_1', 'Address Street 1', ['class' => 'col-md-2 control-label']) !!}
                        <div class="col-md-4">
                            {!! Form::text('address_1', null, ['class' => 'form-control', 'disabled' => 'disabled']) !!}
                        </div>

                        {!! Form::label('address_2', 'Address Street 2', ['class' => 'col-md-2 control-label']) !!}
                        <div class="col-md-4">
                            {!! Form::text('address_2', null, ['class' => 'form-control', 'disabled' => 'disabled']) !!}
                        </div>

                    </div>

                    <div class="form-group">
                        {!! Form::label('address_city_id', 'City', ['class' => 'col-md-2 control-label']) !!}
                        <div class="col-md-4">
                            {!! Form::select('address_city_id', HRis\Eloquent\City::lists('name', 'id'), $employee->address_city_id, ['placeholder' => '--- Select ---', 'class' => 'form-control chosen-select', 'disabled' => 'disabled']) !!}
                        </div>

                        {!! Form::label('address_province_id', 'Province', ['class' => 'col-md-2 control-label']) !!}
                        <div class="col-md-4">
                            {!! Form::select('address_province_id', HRis\Eloquent\Province::lists('name', 'id'), $employee->address_province_id, ['placeholder' => '--- Select ---', 'class' => 'form-control chosen-select', 'disabled' => 'disabled']) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        {!! Form::label('address_postal_code', 'Zip/Postal Code', ['class' => 'col-md-2 control-label', 'data-mask' => '9999']) !!}
                        <div class="col-md-4">
                            {!! Form::text('address_postal_code', null, ['class' => 'form-control', 'disabled' => 'disabled']) !!}
                        </div>
                        {!! Form::label('address_country_id', 'Country', ['class' => 'col-md-2 control-label']) !!}
                        <div class="col-md-4">
                            {!! Form::select('address_country_id', HRis\Eloquent\Country::lists('name', 'id'), $employee->address_country_id, ['placeholder' => '--- Select ---', 'class' => 'form-control chosen-select', 'disabled' => 'disabled']) !!}
                        </div>

                    </div>

                    <div class="hr-line-dashed"></div>
                    <!-- End - Address -->

                    <div class="form-group">
                        {!! Form::label('home_phone', 'Home Telephone', ['class' => 'col-md-2 control-label']) !!}
                        <div class="col-md-4">
                            {!! Form::text('home_phone', null, ['class' => 'form-control', 'data-mask' => '099 999 9999', 'disabled' => 'disabled']) !!}
                        </div>

                        {!! Form::label('mobile_phone', 'Mobile', ['class' => 'col-md-2 control-label']) !!}
                        <div class="col-md-4">
                            {!! Form::text('mobile_phone', null, ['class' => 'form-control', 'data-mask' => '0999 999 9999', 'disabled' => 'disabled']) !!}
                        </div>
                    </div>

                    <div class="hr-line-dashed"></div>
                    <!-- End - Telephone details -->

                    <div class="form-group">
                        {!! Form::label('work_email', 'Work Email', ['class' => 'col-md-2 control-label']) !!}
                        <div class="col-md-4">
                            {!! Form::email('work_email', null, ['class' => 'form-control', 'disabled' => 'disabled']) !!}
                        </div>

                        {!! Form::label('other_email', 'Other Email', ['class' => 'col-md-2 control-label']) !!}
                        <div class="col-md-4">
                            {!! Form::email('other_email', null, ['class' => 'form-control', 'disabled' => 'disabled']) !!}
                        </div>
                    </div>

                    <div class="hr-line-dashed"></div>
                    <!-- End - Email -->

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
    @if ($custom_field_sections)
        @include('pages.profile.partials.custom-fields')
    @endif
@stop

@section('custom_js')

    {!! Html::script('/js/custom_datepicker.js') !!}
    {!! Html::script('/js/notification.js') !!}

    <script>

        $(document).ready(function () {

            function updateCityValues()
            {
                $.ajax({
                    type: "GET",
                    url: '/ajax/update-address',
                    data: {province_id : $("#address_province_id").val()}
                }).done(function (response) {

                    var city_id = $("#address_city_id").val();
                    var value = jQuery.parseJSON(response);

                    // disable the city select before updating its values
                    $("#address_city_id").attr('disabled', 'disabled');

                    $("#address_city_id").html('');
                    for ( var i = 1; i < value.length; i++ )
                    {
                        if(value[i].id == city_id)
                        {
                            $("#address_city_id").append('<option value="' + value[i].id + '" selected>' + value[i].name +'</option>');
                        }
                        else
                        {
                            $("#address_city_id").append('<option value="' + value[i].id + '">' + value[i].name +'</option>');
                        }
                    }

                    // re-enable it by removing the disabled attribute
                    $("#address_city_id").removeAttr('disabled');

                    $('#address_city_id').trigger('chosen:updated');
                });
            }

            $('.chosen-select').chosen({
                placeholder_text_single: '--- Select ---',
            });

            $("#address_province_id").change(function() {
                updateCityValues();
            });

            $('.modify-form').click(function() {
                $('.save-form').css('display', '');
                $('.modify-form').css('display', 'none');
                $('.form-control').prop('disabled', false);

                $('.chosen-select').trigger('chosen:updated');
                $('.i-checks').iCheck('enable');

            });

            $('.cancel-form').click(function() {
                $('.save-form').css('display', 'none');
                $('.modify-form').css('display', '');
                $('.form-control').prop('disabled', true);

                $('.chosen-select').trigger('chosen:updated');
                $('.i-checks').iCheck('disable');
            });
        });

    </script>

@stop

@section('action_area')
    @include('pages.profile.partials.avatar')
@stop
