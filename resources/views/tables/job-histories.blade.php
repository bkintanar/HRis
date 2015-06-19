@if(count($table['items']))
@foreach($table['items'] as $item)
<tr class="{{ $table['model']['plural'] }}_list" id="{{ $table['model']['singular'] }}_{{$item->id}}">

    <td>{{ $item->jobTitle->name or '' }}</td>
    <td>{{ $item->department->name or '' }}</td>
    <td>{{ $item->effective_date ? $item->effective_date->format('F j, Y') : '' }}</td>
    <td><span class="label {{ $item->employmentStatus->class or '' }}"> {{ $item->employmentStatus->name or '' }}</span></td>
    <td>{{ $item->location->name or '' }}</td>
    <td>{{ $item->comments }}</td>
    <td>
        <button rel="delete" id="{{$item->id}}" class="btn btn-primary btn-xs btn-danger" title="Delete" type="button"><i class="fa fa-times"></i></button>
    </td>
</tr>
@endforeach
@else
<tr>
    <td colspan="{{ count($headers) +1 }}">No job histories listed</td>
</tr>
@endif
