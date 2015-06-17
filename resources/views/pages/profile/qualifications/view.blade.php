@extends(Request::is('*pim/*') ? 'master.adm-master' : 'master.default')

@section('content')
    @include('partials.notification')
        {!! HRis\Eloquent\Navlink::profileLinks($pim) !!}

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

@stop

@stop

@section('custom_css')

    {!! Html::style('/css/plugins/datepicker/datepicker3.css') !!}
    {!! Html::style('/css/plugins/chosen/chosen.css') !!}

@stop

@section('custom_js')
    <!-- Data picker -->
    {!! Html::script('/js/plugins/datepicker/bootstrap-datepicker.js') !!}
    <!-- Input Mask-->
    {!! Html::script('/js/plugins/jasny/jasny-bootstrap.min.js') !!}
    <!-- Chosen -->
    {!! Html::script('/js/plugins/chosen/chosen.jquery.js') !!}

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

                    var workExperience = jQuery.parseJSON(response);

                    // Set fields

                    $('#work_experience_id').val(workExperience.id);
                    $('#company').val(workExperience.company);
                    $('#job_title').val(workExperience.job_title);
                    $('#work_experience_from_date').val(workExperience.from_date);
                    $('#work_experience_to_date').val(workExperience.to_date);
                    $('#comment').val(workExperience.comment);

                    $("#workExperienceForm").attr("value", "PATCH");
                    $('#workExperienceModal').modal('toggle');
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

                    $("#educationForm").attr("value", "PATCH");
                    $('#educationModal').modal('toggle');
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

                    $("#skillForm").attr("value", "PATCH");
                    $('#skillModal').modal('toggle');
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
                        $('#workExperience_' + dataId).remove();

                        if($('.workExperiencesList').length == 0)
                        {
                            $('#workExperiencesBody').append('<tr><td colspan="6">No work experiences listed</td></tr>');
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

                        if($('.educationsList').length == 0)
                        {
                            $('#educationsBody').append('<tr><td colspan="4">No educations listed</td></tr>');
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

                        if($('.skillsList').length == 0)
                        {
                            $('#skillsBody').append('<tr><td colspan="3">No skills listed</td></tr>');
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
                    case 'editWorkExperience'   : editWorkExperience($(this).attr('id'));
                        break;
                    case 'deleteWorkExperience' : deleteWorkExperience($(this).attr('id'));
                        break;
                    case 'editEducation'   : editEducation($(this).attr('id'));
                        break;
                    case 'deleteEducation' : deleteEducation($(this).attr('id'));
                        break;
                    case 'editSkill'   : editSkill($(this).attr('id'));
                        break;
                    case 'deleteSkill' : deleteSkill($(this).attr('id'));
                        break;
                }
            });

            // Chosen
            $('.chosen-select').chosen({width:'100%'});

            $('#addWorkExperience').click(function () {

                $('#work_experience_id').val('');
                $('#company').val('');
                $('#job_title').val('');
                $('#work_experience_from_date').val('');
                $('#work_experience_to_date').val('');
                $('#comment').val('');

                $("#workExperienceForm").attr("value", "POST");
                $('#workExperienceModal').modal('toggle');
            });

            $('#addEducation').click(function () {

                $('#education_id').val('');
                $('#education_level_id').val(0);
                $('#institute').val('');
                $('#major_specialization').val('');
                $('#education_from_date').val('');
                $('#education_to_date').val('');
                $('#gpa_score').val('');

                $('.chosen-select').trigger("chosen:updated");

                $("#educationForm").attr("value", "POST");
                $('#educationModal').modal('toggle');
            });

            $('#addSkill').click(function () {

                $('#skill_id').val(0);
                $('#years_of_experience').val('');
                $('#skill_comment').val('');

                $('.chosen-select').trigger("chosen:updated");

                $("#skillForm").attr("value", "POST");
                $('#skillModal').modal('toggle');
            });

            // Date picker
            $('#workExperienceDateRange .input-daterange').datepicker({
                format: 'yyyy-mm-dd',
                keyboardNavigation: false,
                forceParse: false,
                autoclose: true
            });
            $('#educationDateRange .input-daterange').datepicker({
                format: 'yyyy-mm-dd',
                keyboardNavigation: false,
                forceParse: false,
                autoclose: true
            });
        });
    </script>

@stop

@section('action_area')
    @include('pages.profile.partials.avatar')
@stop
