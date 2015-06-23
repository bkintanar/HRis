@extends('master.adm-master')

@section('content')
    @include('partials.notification')
    <div class="row">

        {!! TablePresenter::display($logged_user, $table) !!}

        <!-- Modal -->
        <div class="modal fade" id="pay_grade_modal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button class="close" data-dismiss="modal" type="button">&times;</button>

                        <h4 class="modal-title" id="my_modal_label">Pay Grade Details</h4>
                    </div>

                    <div class="modal-body">
                        <!--Add form-->
                        {!! Form::open(['method' => 'POST', 'url' => Request::path(), 'class' => 'form-horizontal']) !!}
                            {!! Form::hidden('pay_grade_id', '', ['id' => 'pay_grade_id']) !!}
                            {!! Form::hidden('_method', 'POST', ['id' => 'pay_grade_form']) !!}

                            <div class="form-group">
                                {!! Form::label('name', 'Name', ['class' => 'col-md-3 control-label']) !!}
                                <div class="col-md-9">
                                    {!! Form::text('name', null, ['class' => 'form-control', 'required']) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                {!! Form::label('min_salary', 'Minimum Salary', ['class' => 'col-md-3 control-label']) !!}
                                <div class="col-md-9">
                                    {!! Form::text('min_salary', null, ['class' => 'form-control', 'required' => '', 'pattern' => '[0-9]{6}', 'maxlength' => '6', 'min' => '1', 'max' => '999999', 'onkeyup' => 'javascript: this.value = this.value.replace(/[^0-9]/g,\'\');']) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                {!! Form::label('max_salary', 'Maximum Salary', ['class' => 'col-md-3 control-label']) !!}
                                <div class="col-md-9">
                                    {!! Form::text('max_salary', null, ['class' => 'form-control', 'required' => '', 'pattern' => '[0-9]{6}', 'maxlength' => '6', 'min' => '1', 'max' => '999999', 'onkeyup' => 'javascript: this.value = this.value.replace(/[^0-9]/g,\'\');']) !!}
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button class="btn btn-white btn-xs" data-dismiss="modal" type="button">Close</button>
                                {!! Form::submit('Save changes', ['class' => 'btn btn-primary btn-xs']) !!}
                            </div>
                        {!! Form::close() !!}<!--// form-->
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
    </div>
@stop

@section('custom_js')

    <!-- Input Mask -->
    {!! Html::script('/js/plugins/jasny/jasny-bootstrap.min.js') !!}

    {!! Html::script('/js/notification.js') !!}

    <script>
        $(document).ready(function () {

            function editRecord(dataId)
            {
                $.ajax({
                    type: "GET",
                    url: '/ajax/get-pay-grade',
                    data: { id: dataId }
                }).done(function( response ) {

                    var pay_grade = jQuery.parseJSON(response);

                    // Set fields

                    $('#pay_grade_id').val(pay_grade.id);
                    $('#name').val(pay_grade.name);
                    $('#min_salary').val(pay_grade.min_salary);
                    $('#max_salary').val(pay_grade.max_salary);

                    $("#pay_grade_form").attr("value", "PATCH");
                    $('#pay_grade_modal').modal('toggle');
                });
            }

            function deleteRecord(dataId)
            {
                $.ajax({
                    type: "DELETE",
                    url: '/ajax/delete-pay-grade',
                    data: { id: dataId, _token: $('input[name=_token]').val() }
                }).done(function( response ) {

                    if (response == 'success')
                    {
                        $('#notification-info').show();
                        $("#notification-info").delay(5000).fadeOut();
                        $('#pay_grade_' + dataId).remove();

                        if($('.pay_grades_list').length == 0){
                            $('#pay_grades_body').append('<tr><td colspan="5">No pay grades listed</td></tr>');
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
                    case 'edit'   : editRecord($(this).attr('id'));
                        break;
                    case 'delete' : deleteRecord($(this).attr('id'));
                        break;
                }
            });

            $('#add_pay_grade').click(function () {

                $('#name').val('');
                $('#min_salary').val('');
                $('#max_salary').val('');

                $("#pay_grade_form").attr("value", "POST");
                $('#pay_grade_modal').modal('toggle');
            });
        });
    </script>

@stop
