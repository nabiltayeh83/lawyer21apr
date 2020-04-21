@if(isset($billFilter))
@foreach($billFilter as $item)
    <tr id="tr-{{$item->id}}" class="billRow">
        <td class="v-align-middle wd-5p">
            <div class="checkbox checkMain text-center">
                <input type="checkbox" value="{{$item->id}}" id="chkBox{{$item->id}}" name="chkBox" class="checkboxes chkBox deleteBill">
                <label for="chkBox{{$item->id}}" class="no-padding no-margin"></label>
                <input type="hidden" name="tabSection" id="tabSection" value="">
            </div>
        </td>
        <td class="v-align-middle wd-10p"><p>{{$item->id}}</p></td>
            <td class="v-align-middle wd-20p">
                <a href="{{url(getLocal(). '/clients/' . $item->client_id)}}">{{$item->client->name}}</a>
            </td>
            <td class="v-align-middle wd-25p">
                <a href="{{url(getLocal(). '/projects/' . $item->invoice->project_id)}}">{{$item->invoice->project->name}}</a>
            </td>
            <td class="v-align-middle wd-10p">
                <p>
                    {{Arr::get(getDates(substr($item->payment_date, 0, 10)), 'hijri_date')}}
                </p>
            </td>
            <td class="v-align-middle wd-10p">
                <span>{{$item->payment_method->name}}</span>
            </td>
            <td class="v-align-middle wd-10p">
                <p> {{$item->amount}} {{__('website.sr')}} </p>
            </td>
            <td class="v-align-middle wd-10p optionAddHours">
                <a href="{{url(getLocal(). '/bills/' . $item->id)}}">
                    <div class="note-options" data-toggle="tooltip" title="" href="#" data-original-title="{{__('website.details')}}">
                        <i class="material-icons showDitails">visibility</i>
                    </div>
                </a>
            </td>
        </tr>
@endforeach
@endif
