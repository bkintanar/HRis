@if(count($table['items']))
    @foreach($table['items'] as $item)
        <tr class="{{ $table['model']['plural'] }}_list" id="{{ $table['model']['singular'] }}_{{$item->id}}">

            <td>{{ $item->first_name }} {{$item->middle_name}} {{ $item->last_name }}</td>
            <td>{{ HRis\Eloquent\Relationship::whereId($item->relationship_id)->pluck('name') }}</td>
            <td>{{ $item->home_phone }}</td>
            <td>{{ $item->mobile_phone }}</td>
            <td>
                @if($logged_user->hasAccess($table['permission'].'.update'))
                    <button rel="edit" id="{{$item->id}}" class="btn btn-primary btn-xs btn-warning" title="Edit" type="button"><i class="fa fa-edit"></i></button>
                @endif
                @if($logged_user->hasAccess($table['permission'].'.delete'))
                    <button rel="delete" id="{{$item->id}}" class="btn btn-primary btn-xs btn-danger" title="Delete" type="button"><i class="fa fa-times"></i></button>
                @endif
            </td>
        </tr>
    @endforeach
@else
    <tr>
        <td colspan="{{ count($table['headers']) +1 }}">No emergency contacts listed</td>
    </tr>
@endif
