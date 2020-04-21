        <tr>
            <td class="v-align-middle wd-5p">
                <div class="checkbox checkMain text-center">
                    <input type="checkbox" class="chkBox projectHoursBox" value="{{@$projectHours->id}}" data-id="{{$projectHours->hours_count*$projectHours->price}}"
                    id="projectHoursBox{{@$projectHours->id}}" name="projectHours[]">
                    <label for="projectHoursBox{{@$projectHours->id}}" class="no-padding no-margin"></label>
                </div>
            </td>
            <td class="v-align-middle wd-20p"> {{@$projectHours->task->name}} </td>
            <td class="v-align-middle wd-20p"> {{@$projectHours->hours_count}} </td>
            <td class="v-align-middle wd-15p"> {{@$projectHours->price}} </td>
            <td class="v-align-middle wd-15p"> {{$projectHours->hours_count*$projectHours->price}} </td>
        </tr>




<script>

$(document).ready(function(){

    $('input.projectHoursBox').click(function(){
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