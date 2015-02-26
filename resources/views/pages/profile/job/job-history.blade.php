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
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Job Title</th>
                                <th>Department</th>
                                <th>Effective Date</th>
                                <th>Employment Status</th>
                                <th>Location</th>
                                <th>Comments</th>
                                <th class="action">Action</th>
                            </tr>
                        </thead>
                        <tbody id="JobHistoryBody">
                        @if(count($job_histories))
                            @foreach($job_histories as $job_history)
                                <tr class="JobHistoryList" id="jobHistory_{{$job_history->id}}">
                                    <td>{{ $job_history->jobTitle->name or ''}}</td>
                                    <td>{{ $job_history->department->name or '' }}</td>
                                    <td>{{ $job_history->effective_date ? $job_history->effective_date->format('F j, Y') : '' }}</td>
                                    <td><span class="label {{ $job_history->employmentStatus->class or '' }}"> {{ $job_history->employmentStatus->name or '' }}</span></td>
                                    <td>{{ $job_history->location->name or '' }}</td>
                                    <td>{{ $job_history->comments }}</td>
                                    <td class="action">
                                        <button rel="delete" id="{{$job_history->id}}" class="btn btn-primary btn-xs btn-danger" title="Delete" type="button"><i class="fa fa-trash"></i></button>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr><td colspan="5">No job history listed</td></tr>
                        @endif
                        </tbody>
                    </table>
            </div>
        </div>
</div>