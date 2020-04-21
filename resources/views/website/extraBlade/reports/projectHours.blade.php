@if(isset($projectHours))
@foreach($projectHours as $one)
<tr>
    <td class="v-align-middle wd-5p">
        <div class="checkbox checkMain text-center">
            <input type="checkbox" class="chkBox projectHoursBox" value="{{@$one->id}}" data-id="{{$one->hours_count*$one->price}}" id="projectHours{{@$one->id}}" name="projectHours[]">
            <label for="projectHours{{@$one->id}}" class="no-padding no-margin"></label>
        </div>
    </td>
    <td class="v-align-middle wd-20p">{{@$one->task->name}}</td>
    <td class="v-align-middle wd-20p">{{@$one->hours_count}}</td>
    <td class="v-align-middle wd-15p">{{@$one->price}}</td>
    <td class="v-align-middle wd-15p">{{$one->hours_count*$one->price}}</td>
</tr>
@endforeach
@endif


