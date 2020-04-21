@if(isset($taskFilter))
@forelse($taskFilter as $item)
<tr id="tr-{{$item->id}}" class="taskRow">
    <td class="v-align-middle wd-5p">
		<div class="checkbox checkMain text-center">
            <input type="checkbox" class="checkboxes chkBox" value="{{$item->id}}" id="chkBox{{$item->id}}" data name="chkBox"/>
            <label for="chkBox{{$item->id}}" class="no-padding no-margin"></label>
		</div>
    </td>
	<td class="v-align-middle wd-15p name{{$item->id}}">
        <a href="{{url(getLocal(). '/tasks/' . $item->id)}}">{{$item->name}}</a>
    </td>
    <td class="v-align-middle wd-15p">
        @if(isset($item->project_id))
            <a href="{{url(getLocal(). '/projects/'.$item->project_id)}}">
                <p>{{$item->project->name}}</p>
            </a>
        @endif
	</td>
    <td class="v-align-middle wd-15p typeClients">
        @if(isset($item->responsible_employee))
            <p>{{$item->employee->name}}</p>
        @endif
    </td>
	<td class="v-align-middle wd-10p">
        <p>
            {{Arr::get(getDates(substr($item->end_date, 0, 10)), 'hijri_date')}}
        </p>
	</td>
    <td class="v-align-middle wd-10p">
	    <p>
            @if($item->end_date < date("Y-m-d", strtotime(Carbon\Carbon::now())))
                {{__('website.done')}}
            @else
            @if(Carbon\Carbon::now()->diffInDays($item->end_date) == 0)
            {{__('website.one_day')}}
            @endif
            @if(Carbon\Carbon::now()->diffInDays($item->end_date) == 1)
            {{__('website.two_days')}}
            @endif
            @if(Carbon\Carbon::now()->diffInDays($item->end_date) > 1 && Carbon\Carbon::now()->diffInDays($item->end_date) <= 10)
            {{Carbon\Carbon::now()->diffInDays($item->end_date)}} {{__('website.days')}}
            @endif
            @if(Carbon\Carbon::now()->diffInDays($item->end_date) > 10)
            {{Carbon\Carbon::now()->diffInDays($item->end_date)}} {{__('website.day')}}
            @endif
            @endif
        </p>    
    </td>
    <td class="v-align-middle wd-10p taskStatus-{{$item->id}}">
        <p> @if(isset($item->task_status_id)) {{$item->task_status->name}} @endif</p>
    </td>
    <td class="v-align-middle wd-5p">
        <span class="badge badge-pill {{$item->priority == 'urgent'? 'badge-success' : 'badge-info'}}" id="label-{{$item->id}}">
            {{__('website.'.$item->priority)}}
        </span>
    </td>
    
    <td class="v-align-middle wd-15p optionAddHours">
        <div class="note-options" data-toggle="tooltip" title="" href="#" data-original-title="{{__('website.add_hours')}}">
            <i data-target="#modalAddHours" data-id="{{$item->id}}" id="addHoursFromHome" data-toggle="modal" class="material-icons">add</i>
        </div>
        <div class="note-options completeTask" data-id="{{$item->id}}" data-toggle="tooltip" title="" href="#" data-original-title="{{__('website.complete_it')}}">
            <i class="material-icons">check</i>
        </div>
        <a href="{{url(getLocal(). '/tasks/' . $item->id . '/edit')}}">
            <div class="note-options" data-toggle="tooltip" title="" href="#" data-original-title="{{__('website.edit')}}">
                <i class="material-icons editTask">edit</i>
            </div>
        </a>
        <a href="{{url(getLocal(). '/tasks/' . $item->id)}}">
            <div class="note-options" data-toggle="tooltip" title="" href="#" data-original-title="{{__('website.details')}}">
                <i class="material-icons showDitails">visibility</i>
            </div>
        </a>
    </td>
</tr>
@empty
@endforelse
@endif
