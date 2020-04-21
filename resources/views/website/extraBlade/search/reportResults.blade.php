@if(isset($reportResults))
@foreach($reportResults as $one)
    <div>
        <div class="p-l-10 inline p-t-5">
            <h5 class="m-b-5">
                <a href="{{url(getLocal(). '/reports/' . $one->id)}}">
                    {{__('website.report')}} # {{@$one->id}}
                </a>
            </h5>
        </div>
    </div>
@endforeach
@endif





