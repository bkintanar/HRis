@if(count($table['items']))
    @foreach($table['items'] as $item)
        <tr class="{{ $table['model']['plural'] }}_list" id="{{ $table['model']['singular'] }}_{{$item->id}}">

            <td>{{ $item->id }}</td>
            <td><a href="/pim/configuration/custom-field-sections/{{ $item->id }}">{{ $item->name }}</a></td>
            <td>{{ $item->screen->name }}</td>
            <td>
                @if($logged_user->hasAccess($table['permission'].'.update'))
                    <button rel="edit" id="{{$item->id}}" class="btn btn-primary btn-xs btn-warning" name="edit"
                            title="Edit" type="button"><i class="fa fa-edit"></i></button>
                @endif
                @if($logged_user->hasAccess($table['permission'].'.delete'))
                    <button rel="delete" id="{{$item->id}}" class="btn btn-primary btn-xs btn-danger" name="delete"
                            title="Delete" type="button"><i class="fa fa-times"></i></button>
                @endif
            </td>
        </tr>
    @endforeach
@else
    <tr>
        <td colspan="{{ count($table['headers']) +1 }}">No custom field sections listed</td>
    </tr>
@endif
