<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Education</h5>
                <div class="ibox-tools">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                </div>
            </div>

            <div class="ibox-content">
                @if($logged_user->hasAccess(\Request::segment(1).'.qualifications.educations.create'))
                <div class="">
                    <a id="addEducation" href="javascript:void(0);" class="btn btn-primary btn-xs">Add a new row</a>
                </div>
                @endif
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Level</th>
                                <th>Year</th>
                                <th>GPA/Score</th>
                                <th class="fix-width">Action</th>
                            </tr>
                        </thead>

                        <tbody id="educationsBody">
                            @if(count($educations))
                                @foreach($educations as $education)
                                <tr class="educationsList" id="education_{{$education->id}}">
                                    <td>{{ HRis\Eloquent\EducationLevel::whereId($education->education_level_id)->pluck('name') }}</td>
                                    <td>{{ $education->from_date }} - {{ $education->to_date }}</td>
                                    <td>{{ $education->gpa_score }}</td>
                                    <td>
                                        @if($logged_user->hasAccess(\Request::segment(1).'.qualifications.educations.update'))
                                        <button rel="editEducation" id="{{$education->id}}" class="btn btn-primary btn-xs btn-warning" title="Edit" type="button"><i class="fa fa-paste"></i></button>
                                        @endif
                                        @if($logged_user->hasAccess(\Request::segment(1).'.qualifications.educations.delete'))
                                        <button rel="deleteEducation" id="{{$education->id}}" class="btn btn-primary btn-xs btn-danger" title="Delete" type="button"><i class="fa fa-trash"></i></button>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="4">No educations listed</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div><!-- Modal -->

    <div class="modal fade" id="educationModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" data-dismiss="modal" type="button">&times;</button>

                    <h4 class="modal-title" id="myModalLabel">Education Details</h4>
                </div>

                <div class="modal-body">
                    <!--Add form-->
                    {!! Form::open(['method' => 'POST', 'url' => str_replace('/edit', '', \Request::path()).'/educations', 'class' => 'form-horizontal']) !!}
                        {!! Form::hidden('employee_id', $employee->id) !!}
                        {!! Form::hidden('education_id', '', ['id' => 'education_id']) !!}
                        {!! Form::hidden('_method', 'POST', ['id' => 'educationForm']) !!}

                        <div class="form-group">
                            {!! Form::label('level', 'Level', ['class' => 'col-md-3 control-label']) !!}
                            <div class="col-md-9">
                                {!! Form::select('education_level_id', HRis\Eloquent\EducationLevel::listsWithPlaceholder('name', 'id'), null, ['class' => 'form-control chosen-select', 'id' => 'education_level_id']) !!}
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label('institute', 'Institute', ['class' => 'col-md-3 control-label']) !!}
                            <div class="col-md-9">
                                {!! Form::text('institute', null, ['class' => 'form-control']) !!}
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label('major_specialization', 'Major/Specialization', ['class' => 'col-md-3 control-label']) !!}
                            <div class="col-md-9">
                                {!! Form::text('major_specialization', null, ['class' => 'form-control']) !!}
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label('educationDateRange', 'Year', ['class' => 'col-md-3 control-label']) !!}
                            <div class="col-md-9">
                                <div class="input-daterange input-group input-full-width" id="datepicker">
                                    {!! Form::text('from_date', null, ['class' => 'input-sm form-control', 'data-mask' => '9999-99-99', 'id' => 'education_from_date']) !!}
                                    <span class="input-group-addon">to</span>
                                    {!! Form::text('to_date', null, ['class' => 'input-sm form-control', 'data-mask' => '9999-99-99', 'id' => 'education_to_date']) !!}
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label('gpa_score', 'GPA/Score', ['class' => 'col-md-3 control-label']) !!}
                            <div class="col-md-9">
                                {!! Form::text('gpa_score', null, ['class' => 'form-control']) !!}
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
