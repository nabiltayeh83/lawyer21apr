@if(isset($reportFilter))
@forelse($reportFilter as $item)
<tr id="tr-{{$item->id}}" class="reportRow">
    <td class="v-align-middle wd-5p">
        <div class="checkbox checkMain text-center">
            <input type="checkbox" class="checkboxes chkBox" value="{{$item->id}}" id="chkBox{{$item->id}}" data name="chkBox"/>
            <label for="chkBox{{$item->id}}" class="no-padding no-margin"></label>
        </div>
    </td>
    <td class="v-align-middle wd-15p name{{$item->id}}">
        <a href="{{url(getLocal(). '/projects/' . $item->project_id)}}">{{$item->project->name}}</a>
    </td>
    <td class="v-align-middle wd-15p">
        <a href="{{url(getLocal(). '/tasks/'.$item->task_id)}}">
            <p>{{$item->task->name}}</p>
        </a>
    </td>
    <td class="v-align-middle wd-10p">
        <p>
            {{Arr::get(getDates(substr($item->created_at, 0, 10)), 'hijri_date')}}
        </p>
    </td>
    <td class="v-align-middle wd-10p reportStatus-{{$item->id}}">
        <p>{{ __('website.' . $item->status) }}</p>
    </td>
    <td class="v-align-middle wd-15p optionAddHours">
  	    <div class="note-options" data-toggle="tooltip" title="" href="#" data-original-title="تحميل الملف">
			<i class="material-icons showDitails">picture_as_pdf</i>
	    </div>
        <a href="{{url(getLocal(). '/reports/' . $item->id)}}" class="addBill">
            <div class="note-options" data-toggle="tooltip" title="" href="#" data-original-title="التفاصيل">
                <i class="material-icons showDitails">visibility</i>
            </div>
        </a>
    </td>
</tr>
@empty
@endforelse
@endif
