@if(isset($projectFlatsFees))
<tr>
    <td class="v-align-middle wd-5p">
        <div class="checkbox checkMain text-center">
            <input type="checkbox" value="{{@$projectFlatsFees->id}}" id="projectFlatsFees{{@$projectFlatsFees->id}}"  data-id="{{@$projectFlatsFees->price}}" name="projectFlatsFees[]" class="chkBox projectFlatsFeesBox">
            <label for="projectFlatsFees{{@$projectFlatsFees->id}}" class="no-padding no-margin"></label>
        </div>
    </td>
    <td class="v-align-middle wd-70p">{{@$projectFlatsFees->description}}</td>
    <td class="v-align-middle wd-20p">{{@$projectFlatsFees->date}}</td>
    <td class="v-align-middle wd-10p">{{@$projectFlatsFees->price}}</td>
</tr>
@endif


<script>
$(document).ready(function(){
    $('input.projectFlatsFeesBox').click(function(){
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

