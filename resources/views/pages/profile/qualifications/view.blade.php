@extends(Request::is('*pim/*') ? 'master.adm-master' : 'master.default')

@section('content')
    @include('partials.notification')
        {!! Navlink::profileLinks($pim) !!}

@if ($logged_user->hasAccess(Request::segment(1).'.qualifications.work-experiences.view'))
    @include ('pages.profile.qualifications.partials.work-experiences')
@endif
@if ($logged_user->hasAccess(Request::segment(1).'.qualifications.educations.view'))
    @include ('pages.profile.qualifications.partials.educations')
@endif
@if ($logged_user->hasAccess(Request::segment(1).'.qualifications.skills.view'))
    @include ('pages.profile.qualifications.partials.skills')
@endif
@if ($logged_user->hasAccess(Request::segment(1).'.qualifications.languages.view'))
{{--    @include ('pages.profile.qualifications.partials.languages')--}}
@endif
@if ($custom_field_sections)
    @include('pages.profile.partials.custom-fields')
@endif

@stop

@section('custom_js')

    {!! Html::script('/js/notification.js') !!}

    <script>
        $(document).ready(function () {

            function editWorkExperience(dataId)
            {
                $.ajax({
                    type: "GET",
                    url: '/ajax/{{Request::path()}}/work-experience',
                    data: { id: dataId }
                }).done(function( response ) {

                    var work_experience = jQuery.parseJSON(response);

                    // Set fields

                    $('#work_experience_id').val(work_experience.id);
                    $('#company').val(work_experience.company);
                    $('#job_title').val(work_experience.job_title);
                    $('#work_experience_from_date').val(work_experience.from_date);
                    $('#work_experience_to_date').val(work_experience.to_date);
                    $('#comment').val(work_experience.comment);

                    $("#work_experience_form").attr("value", "PATCH");
                    $('#work_experience_modal').modal('toggle');
                });
            }

            function editEducation(dataId)
            {
                $.ajax({
                    type: "GET",
                    url: '/ajax/{{Request::path()}}/education',
                    data: { id: dataId }
                }).done(function( response ) {

                    var education = jQuery.parseJSON(response);

                    // Set fields

                    $('#education_id').val(education.id);
                    $('#education_level_id').val(education.education_level_id);
                    $('#institute').val(education.institute);
                    $('#major_specialization').val(education.major_specialization);
                    $('#education_from_date').val(education.from_date);
                    $('#education_to_date').val(education.to_date);
                    $('#gpa_score').val(education.gpa_score);

                    $('.chosen-select').trigger("chosen:updated");

                    $("#education_form").attr("value", "PATCH");
                    $('#education_modal').modal('toggle');
                });
            }

            function editSkill(dataId)
            {
                $.ajax({
                    type: "GET",
                    url: '/ajax/{{Request::path()}}/skill',
                    data: { id: dataId }
                }).done(function( response ) {

                    var skill = jQuery.parseJSON(response);

                    // Set fields

                    $('#employee_skill_id').val(skill.id);

                    $('#skill_id').val(skill.skill_id);
                    $('#years_of_experience').val(skill.years_of_experience);
                    $('#skill_comment').val(skill.comment);

                    $('.chosen-select').trigger("chosen:updated");

                    $("#skill_form").attr("value", "PATCH");
                    $('#skill_modal').modal('toggle');
                });
            }

            function deleteWorkExperience(dataId)
            {
                $.ajax({
                    type: "DELETE",
                    url: '/ajax/{{Request::path()}}/work-experience',
                    data: { id: dataId, _token: $('input[name=_token]').val() }
                }).done(function( response ) {

                    if (response == 'success')
                    {
                        $('#notification-info').show();
                        $("#notification-info").delay(5000).fadeOut();
                        $('#work_experience_' + dataId).remove();

                        if($('.work_experiences_list').length == 0)
                        {
                            $('#work_experiences_body').append('<tr><td colspan="6">No work experiences listed</td></tr>');
                        }
                    }
                    else
                    {
                        // failed
                    }
                });
            }

            function deleteEducation(dataId)
            {
                $.ajax({
                    type: "DELETE",
                    url: '/ajax/{{Request::path()}}/education',
                    data: { id: dataId, _token: $('input[name=_token]').val() }
                }).done(function( response ) {

                    if (response == 'success')
                    {
                        $('#notification-info').show();
                        $("#notification-info").delay(5000).fadeOut();
                        $('#education_' + dataId).remove();

                        if($('.educations_list').length == 0)
                        {
                            $('#educations_body').append('<tr><td colspan="4">No educations listed</td></tr>');
                        }
                    }
                    else
                    {
                        // failed
                    }
                });
            }

            function deleteSkill(dataId)
            {
                $.ajax({
                    type: "DELETE",
                    url: '/ajax/{{Request::path()}}/skill',
                    data: { id: dataId, _token: $('input[name=_token]').val() }
                }).done(function( response ) {

                    if (response == 'success')
                    {
                        $('#notification-info').show();
                        $("#notification-info").delay(5000).fadeOut();
                        $('#employee_skill_' + dataId).remove();

                        if($('.skills_list').length == 0)
                        {
                            $('#skills_body').append('<tr><td colspan="3">No skills listed</td></tr>');
                        }
                    }
                    else
                    {
                        // failed
                    }
                });
            }

            $('.btn-xs').click(function(){

                var action = $(this).attr('rel');

                switch (action) {
                    case 'edit_work_experience'   : editWorkExperience($(this).attr('id'));
                        break;
                    case 'delete_work_experience' : deleteWorkExperience($(this).attr('id'));
                        break;
                    case 'edit_education'   : editEducation($(this).attr('id'));
                        break;
                    case 'delete_education' : deleteEducation($(this).attr('id'));
                        break;
                    case 'edit_skill'   : editSkill($(this).attr('id'));
                        break;
                    case 'delete_skill' : deleteSkill($(this).attr('id'));
                        break;
                }
            });

            // Chosen
            $('.chosen-select').chosen({width:'100%'});

            $('#add_work_experience').click(function () {

                $('#work_experience_id').val('');
                $('#company').val('');
                $('#job_title').val('');
                $('#work_experience_from_date').val('');
                $('#work_experience_to_date').val('');
                $('#comment').val('');

                $("#work_experience_form").attr("value", "POST");
                $('#work_experience_modal').modal('toggle');
            });

            $('#add_education').click(function () {

                $('#education_id').val('');
                $('#education_level_id').val(0);
                $('#institute').val('');
                $('#major_specialization').val('');
                $('#education_from_date').val('');
                $('#education_to_date').val('');
                $('#gpa_score').val('');

                $('.chosen-select').trigger("chosen:updated");

                $("#education_form").attr("value", "POST");
                $('#education_modal').modal('toggle');
            });

            $('#add_skill').click(function () {

                $('#skill_id').val(0);
                $('#years_of_experience').val('');
                $('#skill_comment').val('');

                $('.chosen-select').trigger("chosen:updated");

                $("#skill_form").attr("value", "POST");
                $('#skill_modal').modal('toggle');
            });

            $('#work_experience_modal').on('shown.bs.modal', function (e) {
                // Date picker
                $('.input-daterange').datepicker({
                    format: 'yyyy-mm-dd',
                    keyboardNavigation: false,
                    forceParse: false,
                    autoclose: true
                });
            });
            $('#education_modal').on('shown.bs.modal', function (e) {
                $('.input-daterange').datepicker({
                    format: 'yyyy-mm-dd',
                    keyboardNavigation: false,
                    forceParse: false,
                    autoclose: true
                });
            });
        });
    </script>

@stop

@section('action_area')
    @include('pages.profile.partials.avatar')
@stop
