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
                        <div class="row">
                            <div class="col-md-12">
                                <div class="image-crop">
                                    <img src='/img/profile/{!! isset($employee->avatar) ? $employee->avatar : "default/0.png" !!}'>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="btn-zoom">
                                <button class="btn btn-danger btn-xs" id="zoomOut" type="button">-</button>
                                <button class="btn btn-warning btn-xs" id="zoomIn" type="button">+</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <div class="row">
                            <div class="col-md-12">
                                <button type="button" class="modal-close btn-sm" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">Cancel</span></button>

                                <label title="Upload image file" for="inputImage" class="btn btn-white btn-sm">
                                    <input type="file" accept="image/*" name="file" id="inputImage" class="hide">
                                    Upload new image
                                </label>
                                
                                <button class="btn btn-primary btn-sm" id="crop" type="button">Crop And Save</button>

                            </div>
                        </div>
                    </div>
                        <!--//Cropper-->
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
    {!! Html::style('/css/plugins/cropper/cropper.min.css') !!}

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
    <!-- Cropper -->
    {!! Html::script('/js/plugins/cropper/cropper.min.js') !!}

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

            // Cropper
            var $image = $(".image-crop > img");
            $($image).cropper({
              aspectRatio: 1,
              strict: false,
              guides: false,
              highlight: false,
              dragCrop: false,
              movable: true,
              resizable: true,
              zoom: 0.2,
            });

            var $inputImage = $("#inputImage");
            if (window.FileReader) {
                $inputImage.change(function() {
                    var fileReader = new FileReader(),
                             files = this.files,
                             file;

                    if (!files.length) {
                        return;
                    }

                    file = files[0];

                    if (/^image\/\w+$/.test(file.type)) {
                        fileReader.readAsDataURL(file);
                        fileReader.onload = function () {
                            $inputImage.val("");
                            $image.cropper("reset", true).cropper("replace", this.result);
                        };
                    } else {
                        showMessage("Please choose an image file.");
                    }
                });
            } else {
                $inputImage.addClass("hide");
            }

            $("#crop").click(function() {
                $.ajax({
                    "type": "POST",
                    "url": "/ajax/upload-profile-image",
                    "data": {
                        "employeeId": {!! $employee->id !!},
                    "imageData": $image.cropper("getDataURL"),
                    "_token": $('input[name=_token]').val()
                    }
                }).done(function(o) {

                    $('#avatarModal').modal('toggle');

                    // If changing own photo, change photo in the navigation as well
                    @if ($employee->id == $logged_user->employee->id)
                        $('#profile-image-nav').delay(1000).attr('src', '/img/profile/' + o);
                    @endif

                    // Change the employee's photo with the uploaded one
                    $('#profile-image').delay(1000).attr('src', '/img/profile/' + o);
                });
            });

            $("#zoomIn").click(function() {
                $image.cropper("zoom", 0.1);
            });

            $("#zoomOut").click(function() {
                $image.cropper("zoom", -0.1);
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