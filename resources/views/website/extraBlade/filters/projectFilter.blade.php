@if(isset($projectFilter))
@forelse($projectFilter as $item)
<tr id="tr-{{$item->id}}" class="projectRow">
    <td class="v-align-middle wd-5p">
        <div class="checkbox checkMain text-center">
            <input type="checkbox" class="checkboxes chkBox" value="{{$item->id}}" id="chkBox{{$item->id}}" data name="chkBox"/>
            <label for="chkBox{{$item->id}}" class="no-padding no-margin"></label>
        </div>
    </td>
    <td class="v-align-middle wd-25p">
        <a href="{{url(getLocal(). '/projects/' . $item->id)}}">{{$item->name}}</a>
    </td>
    <td class="v-align-middle wd-15p">
        @if($item->client_id)
            <a href="{{url(getLocal(). '/clients/' . $item->client_id)}}">{{$item->client->name}}</a>
        @endif
    </td>
    <td class="v-align-middle wd-15p">
        @if($item->responsible_lawyer)
            {{$item->project_manager->name}}
        @endif
    </td>
    <td class="v-align-middle wd-10p">
        <p>
            @if($item->type == 1)
            {{__('website.issue')}}
            @elseif($item->type == 2)
            {{__('website.consultation')}}
            @else
            {{__('website.other')}}
            @endif
        </p>
    </td>
    <td class="v-align-middle wd-10p">
        <p>
            {{Arr::get(getDates(substr($item->created_at, 0, 10)), 'hijri_date')}}
        </p>
	</td>
    <td class="v-align-middle wd-5p">
        <span class="badge badge-pill
        {{$item->project_status->id == '1'? 'badge-success':''}}
        {{$item->project_status->id == '2'? 'badge-info':''}}
        {{$item->project_status->id == '3'? 'badge-danger':''}}"
        id="label-{{$item->id}}">
        {{ $item->project_status->name }}</span>
    </td>
    <td class="v-align-middle wd-5p optionAddHours">
        <a href="{{url(getLocal(). '/projects/' . $item->id)}}">
            <div class="note-options" data-toggle="tooltip" title="" href="#" data-original-title="{{__('website.details')}}">
                <i class="material-icons showDitails">visibility</i>
            </div>
        </a>
    </td>
</tr>
@empty
@endforelse
@endif
