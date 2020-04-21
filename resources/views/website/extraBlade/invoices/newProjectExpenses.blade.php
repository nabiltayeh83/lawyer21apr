@if(isset($projectExpenses))
<tr>
    <td class="v-align-middle wd-5p">
        <div class="checkbox checkMain text-center">
            <input type="checkbox" value="{{@$projectExpenses->id}}" id="projectExpenses{{@$projectExpenses->id}}" data-id="{{@$projectExpenses->total_amount}}" name="projectExpenses[]" class="chkBox projectExpensesBox">
            <label for="projectExpenses{{@$projectExpenses->id}}" class="no-padding no-margin"></label>
        </div>
    </td>
    <td class="v-align-middle wd-25p"> {{@$projectExpenses->expense_date}} </td>
    <td class="v-align-middle wd-25p"> {{@$projectExpenses->aspect_expense->name}} </td>
    <td class="v-align-middle wd-25p"> {{@$projectExpenses->employee->name}} </td>
    <td class="v-align-middle wd-20p"> {{@$projectExpenses->total_amount}} </td>
</tr>
@enid


<script>
$(document).ready(function(){
    $('input.projectExpensesBox').click(function(){
        var sum = $('.invoiceTotalAmount').html();
        var sumint= parseInt(sum);

        if($(this).prop("checked") == true){
            sumint += Number($(this).data("id"));
            $('.invoiceTotalAmount').html(sumint);
            $('.final_total').val(sumint);
        }
        else{
            sumint -= Number($(this).data("id"));
            $('.invoiceTotalAmount').html(sumint);
            $('.final_total').val(sumint);
        }
    });
});
</script>

