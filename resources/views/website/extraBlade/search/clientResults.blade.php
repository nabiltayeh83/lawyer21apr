@if(isset($clientResults))
@foreach($clientResults as $one)
    <div>
        <div class="p-l-10 inline p-t-5">
            <h5 class="m-b-5">
                <a href="{{url(getLocal(). '/clients/' . $one->id)}}">
                    {{@$one->name}}
                </a>
            </h5>
        </div>
    </div>
@endforeach
@endif





