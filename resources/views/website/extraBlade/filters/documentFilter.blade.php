@if(isset($documentFilter))
@forelse($documentFilter as $item)
<tr id="tr-{{$item->id}}" class="documentRow">
    <td class="v-align-middle wd-5p">
		<div class="checkbox checkMain text-center">
            <input type="checkbox" class="checkboxes chkBox" value="{{$item->id}}" id="chkBox{{$item->id}}" data name="chkBox"/>
            <label for="chkBox{{$item->id}}" class="no-padding no-margin"></label>
		</div>
    </td>
        <td class="v-align-middle wd-25p typeDocument" name{{$item->id}}">
            <p>
                <i class="material-icons">folder</i><a href="{{url(getLocal(). '/documents/'.$item->id)}}"> {{$item->title}}</a>
            </p>
        </td>
        <td class="v-align-middle wd-25p">
            @if($item->project_id)
                <a href="{{url(getLocal(). '/projects/'.$item->project_id)}}"><p>{{$item->project->name}}</p></a>
            @endif
		</td>
        <td class="v-align-middle wd-10p typeClients">
            <p>
                {{Arr::get(getDates(substr($item->document_date, 0, 10)), 'hijri_date')}}
            </p>
        </td>
		<td class="v-align-middle wd-15p documentsStatus-{{$item->id}}">
            <p>@if($item->responsible_lawyer) {{$item->employee->name}} @endif</p>
        </td>
        <td class="v-align-middle wd-10p optionAddHours">
            <a class="notes-opt-btn modalToEditFolder event" data-toggle="modal" title="{{__('website.edit')}}" data-id="{{$item->id}}" href="#modalToEditFolder">
                <i class="material-icons">edit</i>
            </a>
        </td>
	</tr>
@empty
@endforelse
@endif
