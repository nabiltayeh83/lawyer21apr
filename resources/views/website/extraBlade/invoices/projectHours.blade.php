@if(isset($projectHours))
@foreach($projectHours as $one)
<tr>
    <td class="v-align-middle wd-5p">
        <div class="checkbox checkMain text-center">
            <input type="checkbox" class="chkBox projectHoursBox" value="{{@$one->id}}" data-id="{{$one->hours_count*$one->price}}" id="{{@$one->id}}" name="projectHours[]">
            <label for="{{@$one->id}}" class="no-padding no-margin"></label>
        </div>
    </td>
    <td class="v-align-middle wd-20p">{{@$one->task->name}}</td>
    <td class="v-align-middle wd-20p">{{@$one->hours_count}}</td>
    <td class="v-align-middle wd-15p">{{@$one->price}}</td>
    <td class="v-align-middle wd-15p">{{$one->hours_count*$one->price}}</td>
</tr>
@endforeach
@endif



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
