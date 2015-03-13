<div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Work Shift History</h5>
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
                                <th>Work Shift</th>
                                <th>In</th>
                                <th>Out</th>
                                <th>Effective Date</th>
                                <th class="action">Action</th>
                            </tr>
                        </thead>
                        <tbody id="JobHistoryBody">
                        @if(count($workshift_history))
                            @foreach($workshift_history as $workShift)
                                <tr class="WorkShiftList" id="workshift_{{$workShift->id}}">
                                    <td>{{ $workShift->WorkShift->name or ''}}</td>
                                    <td>{{ $workShift->WorkShift->from_time or '' }}</td>
                                    <td>{{ $workShift->WorkShift->to_time or '' }}</td>
                                    <td>{{ $workShift->effective_date or '' }}</td>
                                    <td class="action">
                                        <button rel="delete" id="{{$workShift->id}}" class="btn btn-primary btn-xs btn-danger" title="Delete" type="button">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr><td colspan="5">No work shift listed</td></tr>
                        @endif
                        </tbody>
                    </table>
            </div>
        </div>
</div>