@if(isset($invoiceFilter))
@foreach($invoiceFilter as $item)
<tr id="tr-{{$item->id}}" class="invoiceRow">
    <td class="v-align-middle wd-5p">
        <div class="checkbox checkMain text-center">
            <input type="checkbox" class="checkboxes chkBox deleteInvoice" value="{{$item->id}}" id="chkBox{{$item->id}}" data name="chkBox"/>
            <label for="chkBox{{$item->id}}" class="no-padding no-margin"></label>
        </div>
    </td>
    <td class="v-align-middle wd-10p">
        <p>{{ $office_settings->invoices_number}}{{$item->invoice_number}}</p>
    </td>
    <td class="v-align-middle wd-20p">
        <p>{{$item->client->name}}</p>
    </td>
    <td class="v-align-middle wd-20p">
        <p>{{$item->project->name}}</p>
    </td>
    <td class="v-align-middle wd-10p">
        <p>
            {{Arr::get(getDates(substr($item->claim_date, 0, 10)), 'hijri_date')}}
        </p>
    </td>
    <td class="v-align-middle wd-10p">
        <p>{{$item->invoice_amount}} {{__('website.sr')}}</p>
    </td>
    <td class="v-align-middle wd-10p">
        <span class="badge badge-pill badge-success invoiceStatus-{{$item->id}}">
            {{__('website.' .$item->status)}}
        </span>
    </td>
    <td class="v-align-middle wd-15p optionAddHours">
        <div class="note-options completeInvoice" data-id="{{$item->id}}" data-toggle="tooltip" title="" href="#" data-original-title="إعتماد">
            <i class="material-icons">check</i>
        </div>
        <a href="{{url(getLocal(). '/bills/create')}}" class="addBill">
            <div class="note-options" data-toggle="tooltip" title="" href="#" data-original-title="{{__('website.addBill')}}">
                <i class="material-icons">add</i>
            </div>
        </a>
        <a href="{{url(getLocal(). '/invoices/' . $item->id)}}">
            <div class="note-options" data-toggle="tooltip" title="" href="#" data-original-title="{{__('website.details')}}">
                <i class="material-icons showDitails">visibility</i>
            </div>
        </a>
    </td>
</tr>
@endforeach
@endif
