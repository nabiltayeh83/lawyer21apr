@if(isset($clientFilter))
@forelse($clientFilter as $item)
<tr id="tr-{{$item->id}}" class="clientRow">
	<td class="v-align-middle wd-5p">
		<div class="checkbox checkMain text-center">
            <input type="checkbox" class="checkboxes chkBox" value="{{$item->id}}" id="chkBox{{$item->id}}" data name="chkBox"/>
            <label for="chkBox{{$item->id}}" class="no-padding no-margin"></label>
		</div>
    </td>
    <td class="v-align-middle wd-20p name{{$item->id}}">
        <a href="{{url(getLocal(). '/clients/' . $item->id)}}">{{$item->name}}</a>
    </td>
    <td class="v-align-middle wd-10p">
        <p> {{$office_settings->clients_number}}{{$item->client_number}}</p>
    </td>
    <td class="v-align-middle wd-5p typeClients">
        @if($item->type == 1)
            <i class="material-icons">perm_identity</i>
        @else
            <i class="material-icons">apartment</i>
        @endif
        <span>
            {{$item->type == '1'? __('website.person') : __('website.company') }}
        </span>
    </td>
    <td class="v-align-middle wd-20p"><p>{{$item->address}}</p></td>
    <td class="v-align-middle wd-15p"><p>{{$item->email}}</p></td>
    <td class="v-align-middle wd-10p"><p>{{$item->mobile}}</p></td>
    <td class="v-align-middle wd-5p">
        <span class="badge badge-pill {{$item->status == 'active'? 'badge-success' : 'badge-info'}}" id="label-{{$item->id}}">
            {{__('website.'.$item->status)}}
        </span>
    </td>

    <td class="v-align-middle wd-5p optionAddHours">
        <a href="{{url(getLocal(). '/clients/' . $item->id)}}">
            <div class="note-options" data-toggle="tooltip" title="" href="{{url(getLocal(). '/clients/' . $item->id)}}" data-original-title="التفاصيل">
                <i class="material-icons showDitails">visibility</i>
            </div>
        </a>
    </td>
</tr>
@empty
@endforelse
@endif
