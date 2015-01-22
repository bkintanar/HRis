@if (\Session::has('success'))
    <div id="notification-success" class="alert alert-success alert-dismissable">
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
        {{\Session::get('success')}}
    </div>
@elseif(\Session::has('danger'))
    <div id="notification-danger" class="alert alert-danger alert-dismissable">
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
        {{\Session::get('danger')}}
    </div>
@endif
    <div id="notification-info" style="display:none;" class="alert alert-info alert-dismissable">
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
        Record successfully deleted.
    </div>
