@if(isset($expenseFilter))
@forelse($expenseFilter as $item)
<tr id="tr-{{$item->id}}" class="expenseRow">
    <td class="v-align-middle wd-5p">
		<div class="checkbox checkMain text-center">
            <input type="checkbox" class="checkboxes chkBox" value="{{$item->id}}" id="chkBox{{$item->id}}" data name="chkBox"/>
            <label for="chkBox{{$item->id}}" class="no-padding no-margin"></label>
	    </div>
    </td>
    <td class="v-align-middle wd-10p name{{$item->id}}">
        {{Arr::get(getDates(substr($item->expense_date, 0, 10)), 'hijri_date')}}
    </td>
    <td class="v-align-middle wd-15p"><p>{{$item->aspect_expense->name}}</p></td>
    <td class="v-align-middle wd-20p typeClients">
        @if($item->project_id)
            <a href="{{url(getLocal(). '/projects/'.$item->project_id)}}"><p>{{$item->project->name}}</p></a>
        @endif
    </td>
    <td class="v-align-middle wd-20p"><p>{{$item->employee->name}}</p></td>
    <td class="v-align-middle wd-10p"><p>{{$item->total_amount}} {{__('website.r_s')}}</p></td>
	<td class="v-align-middle wd-10p ExpenseStatus-{{$item->id}}">
        <span class="badge badge-pill
        @if($item->expense_status == 'draft') badge-success @endif
        @if($item->expense_status == 'certified') badge-info @endif
        @if($item->expense_status == 'canceled') badge-danger @endif" id="label-{{$item->id}}">
            {{__('website.'.$item->expense_status)}}
        </span>
    </td>
    <td class="v-align-middle wd-10p optionAddHours">
        @if($item->expense_status == 'draft')
            <div class="note-options canceledExpense" data-id="{{$item->id}}" data-toggle="tooltip" title="{{__('website.canceled')}}" href="#" data-original-title="">
                <i class="fa fa-ban" aria-hidden="true"></i>
            </div>
        @endif
        <a href="{{url(getLocal(). '/expenses/' . $item->id)}}">
            <div class="note-options" data-toggle="tooltip" title="" href="#" data-original-title="{{__('website.details')}}">
                <i class="material-icons showDitails">visibility</i>
            </div>
        </a>
    </td>
</tr>
@empty
@endforelse
@endif
