@if(isset($project_tasks))
@foreach($project_tasks as $one)
<tr>
    <td class="v-align-middle wd-5p">
        <div class="checkbox checkMain text-center">
            <input type="checkbox" value="{{@$one->id}}" id="project_tasks{{@$one->id}}" 
            @if(in_array($one->id ,$report_tasks)) checked  @endif data-id="{{@$one->price}}" name="projectTasks[]" class="chkBox projectTasksBox">
            <label for="project_tasks{{@$one->id}}" class="no-padding no-margin"></label>
        </div>
    </td>
    <td class="v-align-middle wd-25p">{{@$one->name}}</td>
    <td class="v-align-middle wd-25p"> {{@$one->employee->name}} </td>
    <td class="v-align-middle wd-25p">{{@$one->end_date}}</td>
    <td class="v-align-middle wd-20p">{{@$one->task_status->name}}</td>
</tr>
@endforeach
@endif





