@extends('master.adm-master')

@section('content')
    <div class="row">

            

            <div class="col-lg-12">
                <div class="col-lg-12 top-nav-b">
                    <div class="btn-group top-nav-li">
                        <ul>
                            <li><a href="/admin/user-management/{{$user->id}}/details"><i class="fa fa-file-text-o  m-right-a"></i>User Details</a></li>
                            <li class="active"><a href="/admin/user-management/{{$user->id}}/permissions"><i class="fa fa-phone-square m-right-a"></i>Permissions</a></li>
                        </ul>
                    </div>
                </div>



                <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Permissions</h5>
                            <div class="ibox-tools">
                                <a class="collapse-link">
                                    <i class="fa fa-chevron-up"></i>
                                </a>
                            </div>
                        </div>
                        <div class="ibox-content">
                            <form method="" action="" accept-charset="UTF-8" class="" onsubmit="" id="">

                                <div class="form-group">

                                    <label class="col-sm-2 control-label">Role</label>

                                    <div class="col-md-4">
                                    <select class="form-control m-b" name="account">
                                        <option>option 1</option>
                                        <option>option 2</option>
                                        <option>option 3</option>
                                        <option>option 4</option>
                                    </select>

                                    </div>
                                </div>

                                 <div class="form-group content-holder ">

                                    <a href="#" class="btn btn-primary expand-content-link col-sm-offset-2 ad-p-btn" id="showtable">Advanced Permissions</a>   

                                    <div class="panel blank-panel hidden-content"  id="advance_p">

                                        <div class="panel-heading">
                                            
                                            <div class="panel-options">
                                                <ul class="nav nav-tabs">
                                                    <li class="active"><a data-toggle="tab" href="#tab-2"> <i class="fa fa-user"></i>Profile</a></li>
                                                    <li class=""><a data-toggle="tab" href="#tab-10"><i class="fa fa-pie-chart"></i>Performance</a></li>
                                                    <li class=""><a data-toggle="tab" href="#tab-13"><i class="fa fa-tasks"></i>PIM</a></li>
                                                    <li class=""><a data-toggle="tab" href="#tab-15"><i class="fa fa-certificate"></i>Admin</a></li>
                                                </ul>
                                            </div>

                                        </div>

                                        <div class="panel-body">

                                            {!! Form::open(['method' => 'POST', 'url' => str_replace('/edit', '', \Request::path()), 'class' => 'form-horizontal']) !!}
                                            <div class="tab-content">
                                                {!! HRis\Eloquent\Navlink::permissionTable($user->id) !!}
                                            </div>
                                            {!! Form::close() !!}

                                        </div>
                                    </div> 
                                </div> 


                                     <div class="hr-line-dashed"></div>

                                    <div class="form-group btn-cs">
                                        <div class="col-sm-4 col-sm-offset-2">
                                            <a href="" class="btn btn-primary">Modify</a>
                                        </div>
                                    </div>
                            </form>
                        </div>
                </div>

            </div>


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

/*
        $("#advance_p").hide();
        $(document).ready(function(){
          $("#showtable").click(function(){
            $("#advance_p").toggle();
          });
        });
*/

        $(document).ready(function() { 
          $(".expand-content-link").click(function() {
                $(".content-holder").find(".hidden-content", this).toggle();
                return false;   
            });
        });

    </script>

@stop
