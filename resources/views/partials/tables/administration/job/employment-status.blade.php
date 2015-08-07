@if(count($table['items']))
    @foreach($table['items'] as $item)
        <tr class="{{ $table['model']['plural'] }}_list" id="{{ $table['model']['singular'] }}_{{$item->id}}">

            <td>{{ $item->id }}</td>
            <td><span class="label {{ $item->class }}">{{ $item->name }}</span></td>
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
        <td colspan="{{ count($table['headers']) +1 }}">No employment status listed</td>
    </tr>
@endif
