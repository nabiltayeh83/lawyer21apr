@if(isset($expenseResults))
@foreach($expenseResults as $one)
    <div>
        <div class="p-l-10 inline p-t-5">
            <h5 class="m-b-5">
                <a href="{{url(getLocal(). '/expenses/' . $one->id)}}">
                    {{__('website.expense')}} - {{@$one->aspect_expense->name}}
                </a>
            </h5>
        </div>
    </div>
@endforeach
@endif





