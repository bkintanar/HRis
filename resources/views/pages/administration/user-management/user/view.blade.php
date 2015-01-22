@extends('master.adm-master')

@section('content')
    <div class="row">
            <div class="col-lg-12">
            <div class="col-lg-12 top-nav-b"><div class="btn-group top-nav-li"><ul><li class="active"><a href="/admin/user-management/{{$user->id}}/details"><i class="fa fa-file-text-o  m-right-a"></i>User Details</a></li><li><a href="/admin/user-management/{{$user->id}}/permissions"><i class="fa fa-phone-square m-right-a"></i>Permissions</a></li></ul></div></div>
                
                <!-- start content -->
                <div class="ibox float-e-margins">
                                <div class="ibox-title">
                                    <h5>User Details</h5>
                                    <div class="ibox-tools">
                                        <a class="collapse-link">
                                            <i class="fa fa-chevron-up"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="ibox-content">
                                    <form method="POST" action="http://hris.loc/profile/personal-details" accept-charset="UTF-8" class="form-horizontal" onsubmit="checkEmployeeId()" id="personalDetailsForm"><input name="_method" type="hidden" value="PATCH"><input name="_token" type="hidden" value="SYsbwmO4pRmyQEpYPCzvZrdKmnEbKfMUAwZmGbyx">
                                   
                                    <input name="user[id]" type="hidden">
                                    <input name="id" type="hidden" value="1">

                                    <div class="form-group">
                                    <label for="first_name" class="col-md-2 control-label">Employee Name</label>
                                        <div class="col-md-4">
                                            <input class="form-control" required="required"name="first_name" type="text" value="" id="first_name">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                    <label for="first_name" class="col-md-2 control-label">User Name</label>
                                        <div class="col-md-4">
                                            <input class="form-control" required="required" name="first_name" type="text" value="" id="first_name">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                    <label for="first_name" class="col-md-2 control-label">Status</label>
                                        <div class="col-md-4">
                                            <input class="form-control" required="required" name="first_name" type="text" value="" id="first_name">
                                        </div>
                                    </div>

                                    <div class="form-group question">
                                           <label class="col-md-2 control-label" for="coupon_question">Change password?</label>
                                            <div class="col-md-4">
                                            <input class="coupon_question" type="checkbox" name="coupon_question" value="1"  value="option1" id="inlineCheckbox1">
                                            </div>
                                    </div>


                                    <div class="form-group answer">
                                        <div class="form-group no-marg-left">
                                          <label class="col-md-2 control-label" for="coupon_field">Password</label>
                                             <div class="col-md-4">
                                           <input class="form-control"  type="text" name="coupon_field" id="coupon_field"/>
                                           </div>
                                        </div>

                                        <div class="form-group no-marg-left">
                                          <label class="col-md-2 control-label" for="coupon_field">Confirm Password</label>
                                             <div class="col-md-4">
                                           <input class="form-control"  type="text" name="coupon_field" id="coupon_field"/>
                                           </div>
                                        </div>
                                    </div>



                                     <div class="hr-line-dashed"></div>

                                    <div class="form-group">
                                        <div class="col-sm-4 col-sm-offset-2">
                                            <a href="" class="btn btn-primary">Modify</a>
                                        </div>
                                    </div>

                            </form>                
                        </div>
                </div>
                <!-- start content -->


        </div>

@stop

@section('custom_css')

    {!! Html::style('/css/plugins/iCheck/custom.css') !!}

@stop

@section('custom_js')
    <!-- iCheck -->
    {!! Html::script('/js/plugins/iCheck/icheck.min.js') !!}
    <script>
        $(document).ready(function () {
            // iCheck
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green'
            });
        });

        $(".answer").hide();
        $(".coupon_question").click(function() {
            if($(this).is(":checked")) {
                $(".answer").show();
            } else {
                $(".answer").hide();
            }
        });
    </script>

@stop
