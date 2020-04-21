@if(isset($projectTasks))
<tr>
    <td class="v-align-middle wd-5p">
        <div class="checkbox checkMain text-center">
            <input type="checkbox" value="{{@$projectTasks->id}}" id="projectTasks{{@$projectTasks->id}}"  data-id="{{@$projectTasks->price}}" name="projectTasks[]" class="chkBox projectTasksBox">
            <label for="projectTasks{{@$projectTasks->id}}" class="no-padding no-margin"></label>
        </div>
    </td>
    <td class="v-align-middle wd-25p">{{@$projectTasks->name}}</td>
    <td class="v-align-middle wd-25p">{{@$projectTasks->employee->name}}</td>
    <td class="v-align-middle wd-25p">{{@$projectTasks->end_date}}</td>
    <td class="v-align-middle wd-20p">{{@$projectTasks->task_status->name}}</td>
</tr>
@enid





