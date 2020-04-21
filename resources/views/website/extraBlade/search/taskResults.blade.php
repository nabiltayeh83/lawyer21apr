@if(isset($taskResults))
@foreach($taskResults as $one)
    <div>
        <div class="p-l-10 inline p-t-5">
            <h5 class="m-b-5">
                <a href="{{url(getLocal(). '/tasks/' . $one->id)}}">
                    {{@$one->name}}
                </a>
            </h5>
        </div>
    </div>
@endforeach
@endif





