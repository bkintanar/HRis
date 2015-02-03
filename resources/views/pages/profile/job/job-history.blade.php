<div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Job History</h5>
                <div class="ibox-tools">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                </div>
            </div>
            <div class="ibox-content">
                @if(count($job_histories))
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Job Title</th>
                                <th>Department</th>
                                <th>Effective Date</th>
                                <th>Employment Status</th>
                                <th>Work Shift</th>
                                <th>Location</th>
                                <th>Comments</th>
                                <th class="action">Action</th>
                            </tr>
                        </thead>
                        <tbody id="JobHistoryBody">
                            @foreach($job_histories as $job_history)
                                <tr class="JobHistoryList" id="jobHistory_{{$job_history->id}}">
                                    <td>{{ isset($job_history->jobTitle->name) ? $job_history->jobTitle->name : '' }}</td>
                                    <td>{{ isset($job_history->department->name) ? $job_history->department->name : '' }}</td>
                                    <td>{{ isset($job_history->effective_date) ? $job_history->effective_date : '' }}</td>
                                    <td>{{ isset($job_history->employmentStatus->name) ? $job_history->employmentStatus->name : '' }}</td>
                                    <td>{{ isset($job_history->workShift->name) ? $job_history->workShift->name : '' }}</td>
                                    <td>{{ isset($job_history->location->name) ? $job_history->location->name : '' }}</td>
                                    <td>{{ isset($job_history->comments) ? $job_history->comments : '' }}</td>
                                    <td class="action">
                                        <button rel="delete" id="{{$job_history->id}}" class="btn btn-primary btn-xs btn-danger" title="Delete" type="button"><i class="fa fa-trash"></i></button>
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p>No Data</p>
                @endif
            </div>
        </div>
</div>