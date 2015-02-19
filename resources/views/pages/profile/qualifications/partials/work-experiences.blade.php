<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Work Experience</h5>
                <div class="ibox-tools">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                </div>
            </div>

            <div class="ibox-content">
                @if($loggedUser->hasAccess(\Request::segment(1).'.qualifications.work-experiences.create'))
                <div class="">
                    <a id="addWorkExperience" href="javascript:void(0);" class="btn btn-primary btn-xs">Add a new row</a>
                </div>
                @endif
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Company</th>
                                <th>Job Title</th>
                                <th>From</th>
                                <th>To</th>
                                <th>Comment</th>
                                <th class="fix-width">Action</th>
                            </tr>
                        </thead>

                        <tbody id="workExperiencesBody">
                            @if(count($workExperiences))
                                @foreach($workExperiences as $workExperience)
                                <tr class="workExperiencesList" id="workExperience_{{$workExperience->id}}">
                                    <td>{{ $workExperience->company }}</td>
                                    <td>{{ $workExperience->job_title }}</td>
                                    <td>{{ $workExperience->from_date }}</td>
                                    <td>{{ $workExperience->to_date }}</td>
                                    <td>{{ $workExperience->comment }}</td>
                                    <td>
                                        @if($loggedUser->hasAccess(\Request::segment(1).'.qualifications.work-experiences.update'))
                                        <button rel="editWorkExperience" id="{{$workExperience->id}}" class="btn btn-primary btn-xs btn-warning" title="Edit" type="button"><i class="fa fa-paste"></i></button>
                                        @endif
                                        @if($loggedUser->hasAccess(\Request::segment(1).'.qualifications.work-experiences.delete'))
                                        <button rel="deleteWorkExperience" id="{{$workExperience->id}}" class="btn btn-primary btn-xs btn-danger" title="Delete" type="button"><i class="fa fa-trash"></i></button>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="6">No work experiences listed</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div><!-- Modal -->

    <div class="modal fade" id="workExperienceModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" data-dismiss="modal" type="button">&times;</button>

                    <h4 class="modal-title" id="myModalLabel">Work Experience Details</h4>
                </div>

                <div class="modal-body">
                    <!--Add form-->
                    {!! Form::open(['method' => 'POST', 'url' => str_replace('/edit', '', \Request::path()).'/work-experiences', 'class' => 'form-horizontal']) !!}
                        {!! Form::hidden('employee_id', $employee->id) !!}
                        {!! Form::hidden('work_experience_id', '', ['id' => 'work_experience_id']) !!}
                        {!! Form::hidden('_method', 'POST', ['id' => 'workExperienceForm']) !!}
                        <div class="form-group">
                            {!! Form::label('company', 'Company', ['class' => 'col-md-3 control-label']) !!}
                            <div class="col-md-9">
                                {!! Form::text('company', null, ['class' => 'form-control']) !!}
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label('job_title', 'Job Title', ['class' => 'col-md-3 control-label']) !!}
                            <div class="col-md-9">
                                {!! Form::text('job_title', null, ['class' => 'form-control']) !!}
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label('workExperienceDateRange', 'Year', ['class' => 'col-md-3 control-label']) !!}
                            <div class="col-md-9">
                                <div class="input-daterange input-group input-full-width" id="datepicker">
                                    {!! Form::text('from_date', null, ['class' => 'input-sm form-control', 'data-mask' => '9999-99-99', 'id' => 'work_experience_from_date']) !!}
                                    <span class="input-group-addon">to</span>
                                    {!! Form::text('to_date', null, ['class' => 'input-sm form-control', 'data-mask' => '9999-99-99', 'id' => 'work_experience_to_date']) !!}
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label('comment', 'Comment', ['class' => 'col-md-3 control-label']) !!}
                            <div class="col-md-9">
                                {!! Form::textarea('comment', null, ['class' => 'form-control', 'size' => '30x5']) !!}
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
