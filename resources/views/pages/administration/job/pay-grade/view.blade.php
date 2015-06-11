@extends('master.adm-master')

@section('content')
    @include('partials.notification')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Pay Grades</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>

                <div class="ibox-content">
                    @if($logged_user->hasAccess('admin.job.pay-grades.create'))
                    <div class="">
                        <a id="addPayGrade" href="javascript:void(0);" class="btn btn-primary btn-xs">Add a new row</a>
                    </div>
                    @endif
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Pay Grade</th>
                                    <th>Minimum Salary</th>
                                    <th>Maximum Salary</th>
                                    <th class="fix-width">Action</th>
                                </tr>
                            </thead>

                            <tbody id="payGradesBody">
                                @if(count($payGrades))
                                    @foreach($payGrades as $payGrade)
                                    <tr class="payGradesList" id="payGrade_{{$payGrade->id}}">
                                        <td>{{ $payGrade->id }}</td>
                                        <td>{{ $payGrade->name }}</td>
                                        <td>{{ number_format($payGrade->min_salary, 2, '.', ',') }}</td>
                                        <td>{{ number_format($payGrade->max_salary, 2, '.', ',') }}</td>
                                        <td>
                                            @if($logged_user->hasAccess('admin.job.pay-grades.update'))
                                            <button rel="edit" id="{{$payGrade->id}}" class="btn btn-primary btn-xs btn-warning" data-toggle="tooltip" data-placement="bottom" title="Edit" type="button"><i class="fa fa-paste"></i></button>
                                            @endif
                                            @if($logged_user->hasAccess('admin.job.pay-grades.delete'))
                                            <button rel="delete" id="{{$payGrade->id}}" class="btn btn-primary btn-xs btn-danger" data-toggle="tooltip" data-placement="bottom" title="Delete" type="button"><i class="fa fa-trash"></i></button>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="5">No pay grades listed</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div><!-- Modal -->
        <div class="modal fade" id="payGradeModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button class="close" data-dismiss="modal" type="button">&times;</button>

                        <h4 class="modal-title" id="myModalLabel">Pay Grade Details</h4>
                    </div>

                    <div class="modal-body">
                        <!--Add form-->
                        {!! Form::open(['method' => 'POST', 'url' => \Request::path(), 'class' => 'form-horizontal']) !!}
                            {!! Form::hidden('pay_grade_id', '', ['id' => 'pay_grade_id']) !!}
                            {!! Form::hidden('_method', 'POST', ['id' => 'payGradeForm']) !!}

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

                    $("#payGradeForm").attr("value", "PATCH");
                    $('#payGradeModal').modal('toggle');
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
                        $('#payGrade_' + dataId).remove();

                        if($('.payGradesList').length == 0){
                            $('#payGradesBody').append('<tr><td colspan="5">No pay grades listed</td></tr>');
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

            $('#addPayGrade').click(function () {

                $('#name').val('');
                $('#min_salary').val('');
                $('#max_salary').val('');

                $("#payGradeForm").attr("value", "POST");
                $('#payGradeModal').modal('toggle');
            });
        });
    </script>

@stop