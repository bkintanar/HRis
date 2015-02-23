@extends(\Request::is('*pim/*') ? 'master.adm-master' : 'master.default')

@section('content')
    <div class="row">
        {!! HRis\Eloquent\Navlink::profileLinks($pim) !!}
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Personal Details</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    @include('pages.profile.personal-details.form')
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="avatarModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button class="close" data-dismiss="modal" type="button">&times;</button>

                        <h4 class="modal-title" id="myModalLabel">Add Avatar</h4>
                    </div>

                    <div class="modal-body">
                        <!--Cropbox-->
                        <div class="imageBox">
                            <div class="thumbBox"></div>
                            <div class="spinner" style="display: none">Loading...</div>
                        </div>
                        <div class="action" id="cus-input">
                            <input type="file" id="file" style="float:left; width: 270px">
                            <input type="button" class="btn btn-danger btn-xs" id="btnZoomOut" value="-">&nbsp;
                            <input type="button" class="btn btn-warning btn-xs" id="btnZoomIn" value="+">&nbsp;
                            <input type="button" class="btn btn-primary btn-xs" id="btnCrop" value="Crop">
                        </div>
                        <div class="cropped">

                        </div>
                        <!--//Cropbox-->
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
    </div>


@stop

@stop

@section('custom_css')

    {!! Html::style('/css/plugins/iCheck/custom.css') !!}
    {!! Html::style('/css/plugins/datepicker/datepicker3.css') !!}
    {!! Html::style('/css/plugins/chosen/chosen.css') !!}

@stop

@section('custom_js')
    <!-- Data picker -->
    {!! Html::script('/js/plugins/datepicker/bootstrap-datepicker.js') !!}
    <!-- Input Mask-->
    {!! Html::script('/js/plugins/jasny/jasny-bootstrap.min.js') !!}
    <!-- iCheck -->
    {!! Html::script('/js/plugins/iCheck/icheck.min.js') !!}
    <!-- Chosen -->
    {!! Html::script('/js/plugins/chosen/chosen.jquery.js') !!}
    <!-- Cropbox -->
    {!! Html::script('/js/plugins/cropbox/cropbox.js') !!}

    <script>
        function checkEmployeeId (){

            var employee_id = $('#employee_id').val();
            var original_employee_id = '{!! $employee->employee_id !!}';

            // pim/employee-list/{id}/personal-details
            if (original_employee_id != employee_id && (window.location.pathname).indexOf('/pim/') >= 0)
            {
                var action = $('#personalDetailsForm').attr('action');
                var action_array = action.split('/');

                action_array[action_array.length-2] = employee_id;

                $('#personalDetailsForm').attr('action', action_array.join('/'));
            }

        }

        $(document).ready(function () {

            // iCheck
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green'
            });

            // Date picker
            $('#datepicker_birth_date .input-group.date').datepicker({
                todayBtn: "linked",
                format: 'yyyy-mm-dd',
                keyboardNavigation: false,
                forceParse: false,
                calendarWeeks: true,
                autoclose: true
            });

            //Cropbox
            $(window).load(function() {
                var options =
                {
                    thumbBox: '.thumbBox',
                    spinner: '.spinner',
                    imgSrc: '/img/profile/{!! isset($employee->avatar) ? $employee->avatar : "default/0.png" !!}'
                }
                var cropper = $('.imageBox').cropbox(options);
                $('#file').on('change', function(){
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        options.imgSrc = e.target.result;
                        cropper = $('.imageBox').cropbox(options);
                    }
                    reader.readAsDataURL(this.files[0]);
                    this.files = [];
                })
                $('#btnCrop').on('click', function(){
                    var img = cropper.getDataURL();
                    $.ajax({
                        "type": "POST",
                        "url": "/ajax/upload-profile-image",
                        "data": { 
                            "employeeId": {!! $employee->id !!},
                            "imageData": img,
                            "_token": $('input[name=_token]').val()
                        }
                    }).done(function(o) {

                        $('#avatarModal').modal('toggle');

                        @if ($employee->id == $loggedUser->employee->id)
                        $('#profile-image-nav').delay(1000).attr('src', '/img/profile/' + o);
                        @endif
                        $('#profile-image').delay(1000).attr('src', '/img/profile/' + o);
                    });
                })
                $('#btnZoomIn').on('click', function(){
                    cropper.zoomIn();
                })
                $('#btnZoomOut').on('click', function(){
                    cropper.zoomOut();
                })
            });

            // Chosen
            $('.chosen-select').chosen({width:'100%'});

            $('#addAvatar').click(function () {

                $('#avatarModal').modal('toggle');
            });
        });
    </script>

@stop

@section('action_area')
    @include('pages.profile.partials.avatar')
@stop