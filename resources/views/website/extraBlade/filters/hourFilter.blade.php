@if(isset($hourFilter))
@forelse($hourFilter as $item)
<tr id="tr-{{$item->id}}" class="hourRow">
    <td class="v-align-middle wd-5p">
		<div class="checkbox checkMain text-center">
            <input type="checkbox" class="checkboxes chkBox" value="{{$item->id}}" id="chkBox{{$item->id}}" data name="chkBox"/>
            <label for="chkBox{{$item->id}}" class="no-padding no-margin"></label>
		</div>
    </td>
    <td class="v-align-middle wd-20p name{{$item->id}}">
        @if($item->project_id)
            <a href="{{url(getLocal(). '/projects/' . $item->project_id)}}">{{$item->project->name}}</a>
        @endif
    </td>
    <td class="v-align-middle wd-20p">
        @if($item->task_id)
            <p><a href="{{url(getLocal(). '/tasks/' . $item->task_id)}}">{{$item->task->name}}</a></p>
        @endif
	</td>
    <td class="v-align-middle wd-15p typeClients">
        @if($item->responsible_lawyer)
            <p>{{$item->employee->name}}</p>
        @endif
    </td>
    <td class="v-align-middle wd-5p">
		<p>{{$item->hours_count}}</p>
    </td>
    <td class="v-align-middle wd-5p">
        <p>{{$item->price}} {{__('website.r_s')}}</p>
    </td>
    <td class="v-align-middle wd-10p">
        <p>
            {{Arr::get(getDates(substr($item->start_date, 0, 10)), 'hijri_date')}}
        </p>
    </td>
    <td class="v-align-middle wd-10p hourStatus-{{$item->id}}">
        <p>{{($item->hours_count*$item->price)}} {{__('website.r_s')}}</p>
    </td>
    <td class="v-align-middle wd-5p">
        <span class="badge badge-pill
        @if($item->hour_status == 'paid') badge-info @endif
        @if($item->hour_status == 'billable') badge-success @endif
        @if($item->hour_status == 'not_billable') badge-danger @endif " id="label-{{$item->id}}">
            {{__('website.'.$item->hour_status)}}
        </span>
    </td>
    <td class="v-align-middle wd-5p optionAddHours">
        <a href="{{url(getLocal(). '/hours/' . $item->id)}}">
            <div class="note-options" data-toggle="tooltip" title="" href="#" data-original-title="{{__('website.details')}}">
                <i class="material-icons showDitails">visibility</i>
            </div>
        </a>
    </td>
</tr>
@empty
@endforelse
@endif
