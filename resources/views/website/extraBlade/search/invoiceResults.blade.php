@if(isset($invoiceResults))
@foreach($invoiceResults as $one)
    <div>
        <div class="p-l-10 inline p-t-5">
            <h5 class="m-b-5">
                <a href="{{url(getLocal(). '/invoices/' . $one->id)}}">
                     {{__('website.invoice')}} - {{@$one->invoice_number}}
                </a>
            </h5>
        </div>
    </div>
@endforeach
@endif





