@if(isset($projectExpenses))
@foreach($projectExpenses as $one)
<tr>
    <td class="v-align-middle wd-5p">
        <div class="checkbox checkMain text-center">
            <input type="checkbox" value="{{@$one->id}}" id="projectExpenses{{@$one->id}}" data-id="{{@$one->total_amount}}" name="projectExpenses[]" class="chkBox projectExpensesBox">
            <label for="projectExpenses{{@$one->id}}" class="no-padding no-margin"></label>
        </div>
    </td>
    <td class="v-align-middle wd-25p">{{@$one->expense_date}}</td>
    <td class="v-align-middle wd-25p">{{@$one->aspect_expense->name}}</td>
    <td class="v-align-middle wd-25p">{{@$one->employee->name}}</td>
    <td class="v-align-middle wd-20p">{{@$one->total_amount}}</td>
</tr>
@endforeach
@endif


