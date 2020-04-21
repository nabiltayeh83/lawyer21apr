@if(isset($projectFlatsFees))
@foreach($projectFlatsFees as $one)
<tr>
    <td class="v-align-middle wd-5p">
        <div class="checkbox checkMain text-center">
            <input type="checkbox" value="{{@$one->id}}" id="projectFlatsFees{{@$one->id}}" data-id="{{@$one->price}}" name="projectFlatsFees[]" class="chkBox projectFlatsFeesBox">
            <label for="projectFlatsFees{{@$one->id}}" class="no-padding no-margin"></label>
        </div>
    </td>
    <td class="v-align-middle wd-70p"> {{@$one->description}} </td>
    <td class="v-align-middle wd-20p"> {{@$one->date}} </td>
    <td class="v-align-middle wd-10p"> {{@$one->price}}</td>
</tr>
@endforeach
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

