@if(count($table['items']))
    @foreach($table['items'] as $item)
        <tr class="{{ $table['model']['plural'] }}_list" id="{{ $table['model']['singular'] }}_{{$item->id}}">

            <td>{{ $item->id }}</td>
            <td>{{ $item->name }}</td>
            <td>{{ number_format($item->min_salary, 2, '.', ',') }}</td>
            <td>{{ number_format($item->max_salary, 2, '.', ',') }}</td>
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
        <td colspan="{{ count($table['headers']) +1 }}">No pay grades listed</td>
    </tr>
@endif
