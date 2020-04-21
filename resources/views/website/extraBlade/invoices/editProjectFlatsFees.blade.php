@if($project_flats_fees)
@foreach($project_flats_fees as $one)
<tr>
    <td class="v-align-middle wd-5p">
        <div class="checkbox checkMain text-center">
            <input type="checkbox" value="{{@$one->id}}" class="chkBox projectFlatsFeesBox" data-id="{{@$one->price}}" id="project_flats_fees{{@$one->id}}" @if(in_array($one->id ,$invoice_flats_fees)) checked @endif name="projectFlatsFees[]">
            <label for="project_flats_fees{{@$one->id}}" class="no-padding no-margin"></label>
        </div>
    </td>
    <td class="v-align-middle wd-70p">{{@$one->description}}</td>
    <td class="v-align-middle wd-20p">{{@$one->date}}</td>
    <td class="v-align-middle wd-10p">{{@$one->price}}</td>
</tr>
@endforeach
@endif

