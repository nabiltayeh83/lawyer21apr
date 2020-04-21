@if(isset($project_hours))
@foreach($project_hours as $one)
<tr>
    <td class="v-align-middle wd-5p">
        <div class="checkbox checkMain text-center">
            <input type="checkbox" class="chkBox editProjectHours" value="{{@$one->id}}" id="project_hours{{@$one->id}}"  data-id="{{@$one->hours_count*$one->price}}"
            @if(in_array($one->id ,$report_hours)) checked  @endif  name="projectHours[]">
            <label for="project_hours{{@$one->id}}" class="no-padding no-margin"></label>
        </div>
    </td>
    <td class="v-align-middle wd-20p"> {{@$one->task->name}} </td>
    <td class="v-align-middle wd-20p"> {{@$one->hours_count}} </td>
    <td class="v-align-middle wd-15p"> {{@$one->price}} </td>
    <td class="v-align-middle wd-15p"> {{$one->hours_count*$one->price}} </td>
</tr>
@endforeach
@endif


