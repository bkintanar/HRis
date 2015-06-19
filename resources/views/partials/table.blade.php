<div class="col-lg-12">
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>{{ $title }}</h5>
            <div class="ibox-tools">
                <a class="collapse-link">
                    <i class="fa fa-chevron-up"></i>
                </a>
            </div>
        </div>
        <div class="ibox-content">
            @if($logged_user->hasAccess(Request::segment(1).'.emergency-contacts.create'))
                <div class="">
                    <a id="add_{{ $model['singular'] }}" href="javascript:void(0);" class="btn btn-primary btn-xs">Add a new row</a>
                </div>
            @endif
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        @foreach($headers as $header)
                            <th>{{ $header }}</th>
                        @endforeach
                        <th class="fix-width">Action</th>
                    </tr>
                    </thead>

                    <tbody id="{{ $model['plural'] }}_body">
                    @if(count($emergencyContacts))
                        @foreach($emergencyContacts as $emergency_contact)
                            <tr class="{{ $model['plural'] }}_list" id="{{ $model['singular'] }}_{{$emergency_contact->id}}">
                                <td>{{ $emergency_contact->first_name }} {{$emergency_contact->middle_name}} {{ $emergency_contact->last_name }}</td>
                                <td>{{ HRis\Eloquent\Relationship::whereId($emergency_contact->relationship_id)->pluck('name') }}</td>
                                <td>{{ $emergency_contact->home_phone }}</td>
                                <td>{{ $emergency_contact->mobile_phone }}</td>
                                <td>
                                    @if($logged_user->hasAccess(Request::segment(1).'.emergency-contacts.update'))
                                        <button rel="edit" id="{{$emergency_contact->id}}" class="btn btn-primary btn-xs btn-warning" title="Edit" type="button"><i class="fa fa-edit"></i></button>
                                    @endif
                                    @if($logged_user->hasAccess(Request::segment(1).'.emergency-contacts.delete'))
                                        <button rel="delete" id="{{$emergency_contact->id}}" class="btn btn-primary btn-xs btn-danger" title="Delete" type="button"><i class="fa fa-times"></i></button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="{{ count($header) +1 }}">No emergency contacts listed</td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>