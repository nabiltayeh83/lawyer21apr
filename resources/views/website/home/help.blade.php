@extends('layout.siteLayout')
@section('title', __('website.help'))
@section('topfixed')

<div class="page-top-fixed">
    <div class="container-fluid">
        <div class="px-3 pb-2 p-md-0 d-flex flex-column flex-md-row align-items-md-center justify-content-between">
	        <h2 class="page-header mb-1 my-md-3">{{__('website.help')}}</h2>
    	    <div class="page-options-btns"></div>
		</div>
	</div>
</div>
@endsection

@section('content')
<div class="content allprojects">
    <div class="bg-white">
        <div class="container-fluid">
            <ol class="breadcrumb breadcrumb-alt"> 
                <li class="breadcrumb-item active">{{__('website.help')}}</li>
            </ol>
        </div>
    </div>

    <div class=" container-fluid">
        <div class="row no-gutters mt-4">
            <div class="col-lg-12">
                <div class=" card m-0 no-border">
                    <div class="card-header d-flex flex-column flex-sm-row align-items-sm-start justify-content-sm-between">
					    <div><h5>{{__('website.help')}}</h5></div>
                    </div>
					<div class="card-body p-0">
					    @if(isset($items))
                        @foreach ($items as $one)
                        <div class="row">
                            <div class="col-md-12">
                                <div class="m-b-0">
                                    <div class="card-header" role="tab" id="heading{{$one->id}}">
                                        <h4 class="card-title">
                                            <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse{{$one->id}}" aria-expanded="false" aria-controls="collapse{{$one->id}}">
                                                <h6>{{@$one->question}}</h6>
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapse{{$one->id}}" class="collapse" role="tabcard" aria-labelledby="heading{{$one->id}}">
                                        <div class="card-body" style="line-height: 200%;">
                                            {{@$one->answer}}   
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        @endif
                    </div>
                </div>
	        </table>
        </div>
    </div>
</div>
</div>
</div>
</div>
</div>


@endsection

