@extends('layout.siteLayout')
@section('title', __('website.documents'))

@section('topfixed')

<div class="page-top-fixed">
    <div class="container-fluid">
        <div class="px-3 pb-2 p-md-0 d-flex flex-column flex-md-row align-items-md-center justify-content-between">
            <h2 class="page-header mb-1 my-md-3">{{__('website.documents')}}</h2>
            <div class="page-options-btns">
                <div class="btn-group mb-2 m-md-3 mt-md-0 ml-2">

                    <button type="button" class="btn btn-default has-icon" onclick="window.location.href='{{url(getLocal(). '/exportAllDocumentsPDF')}}'">
				        <i class="material-icons">description</i><span>{{__('website.export')}}</span>
					</button>

                    <button class="btn btn-default has-icon modalSlideLeft event cursorNODrop" href="#modalSlideLeft" data-toggle="modal" disabled>
                        <i class="material-icons">close</i><span>{{__('website.delete')}}</span>
                    </button>
			    </div>

                <button class="btn btn-complete has-icon mb-2 m-md-0" data-target="#modalAddDocument" data-toggle="modal">
                    <i class="material-icons">add</i><span>{{__('website.add_file')}}</span>
                </button>

                <button class="btn btn-complete has-icon mb-2 m-md-0" data-target="#modalAddFolder" data-toggle="modal">
                    <i class="material-icons">add</i><span>{{__('website.add_folder')}}</span>
                </button>

            </div>
		</div>
	</div>
</div>
@endsection



@section('content')


<div class="content allclients">

    <div class="bg-white">

        <div class="container-fluid">
            <ol class="breadcrumb breadcrumb-alt">
                <li class="breadcrumb-item"><a href="{{url(app()->getLocale().'/documents')}}">
                    {{__('website.documents')}}
                </a></li>
                <li class="breadcrumb-item active">{{__('website.view_all_documents')}}</li>
            </ol>
        </div>
    </div>

    <div class=" container-fluid">
        <div class="row no-gutters mt-4">
            <div class="col-lg-12">
                <div class=" card m-0 no-border">
                <div class="card-header d-flex flex-column flex-sm-row align-items-sm-start justify-content-sm-between">
				    <div>
					    <h5>{{__('website.view_documents')}}</h5>
						<p>{{__('website.view_all_documents')}}</p>
                    </div>
                    <div class="btn-group">
                        <form class="input-group" id="documentFilterText" action="javascript:avoid(0)" method="get">
                            <input type="text" name="text" id="textKey" class="form-control" placeholder="{{__('website.search')}}">
							<div class="input-group-append">
							    <button class="btn btn-secondary" type="submit"><i class="material-icons">search</i></button>
						    </div>
                        </form>

                        <button class="btn btn-sm btn-default filter has-icon " data-target="#filterModalDocuments" data-toggle="modal">
                            <i class="material-icons">filter_list</i><span>{{__('website.filter')}}</span>
                        </button>

                        <button class="btn btn-sm btn-default filterTabDocuments active" data-action="all"> {{__('website.all')}} </button>

                        <button class="btn btn-sm btn-default filter has-icon filterTabDocuments" data-action="deleted">
                              <i class="material-icons">delete_sweep</i> <span>{{__('website.deletes')}}</span>
                        </button>

					</div>
				</div>

            <div class="card-body p-0 allFolders">
                <div class="table-responsive">



                    <table class="table table-hover tableWithSearch allDocuments" id="tableWithSearch">
                        <thead>
							<tr>
							    <th class="wd-5p no-sort">
								    <div class="checkbox checkMain text-center">
                                        <input type="checkbox" value="" id="checkboxall" name="client" class="chkBox">
									    <label for="checkboxall" class="no-padding no-margin"></label>
								    </div>
								</th>
                                <th class="wd-25p">{{__('website.folder_title')}}</th>
        						<th class="wd-25p">{{__('website.project')}}</th>
        						<th class="wd-10p">{{__('website.date')}}</th>
                                <th class="wd-15p">{{__('website.entry_folder')}}</th>
                                <th class="wd-10p no-sort">{{__('website.action')}}</th>
                            </tr>
					    </thead>

                        <tbody class="viewAllDocuments">

                        @include('website.extraBlade.filters.documentFilter')

                            @if(isset($items))
                            @forelse($items as $item)
                            <tr id="tr-{{$item->id}}" class="documentRow">
							    <td class="v-align-middle wd-5p">
							        <div class="checkbox checkMain text-center">
                                        <input type="checkbox" class="checkboxes chkBox" value="{{@$item->id}}" id="chkBox{{@$item->id}}" data name="chkBox"/>
                                        <label for="chkBox{{@$item->id}}" class="no-padding no-margin"></label>
									</div>
                                </td>
                                <td class="v-align-middle wd-25p typeDocument" name{{@$item->id}}">
                                    <p>
                                        <i class="material-icons">folder</i><a href="{{url(getLocal(). '/documents/'.$item->id)}}"> {{@$item->title}}</a>
                                    </p>
                                </td>

                                <td class="v-align-middle wd-25p">
                                    @if($item->project_id)
                                        <a href="{{url(getLocal(). '/projects/'.$item->project_id)}}"><p>{{@$item->project->name}}</p></a>
                                    @endif
						        </td>

                                <td class="v-align-middle wd-10p typeClients"><p>
                                    {{Arr::get(getDates(substr($item->document_date, 0, 10)), 'hijri_date')}}

                                </p></td>

						        <td class="v-align-middle wd-15p documentsStatus-{{$item->id}}">
                                    <p>@if($item->responsible_lawyer) {{@$item->employee->name}} @endif</p>
                                </td>

                                <td class="v-align-middle wd-10p optionAddHours">

                                    <a class="notes-opt-btn modalToEditFolder event" data-toggle="modal" title="{{__('website.edit')}}" data-id="{{$item->id}}" href="#modalToEditFolder">
                                        <i class="material-icons">edit</i>
                                    </a>


                                </td>
							</tr>
                            @empty
                            @endforelse
                            @endif
                        </tbody>
					</table>
                  </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>



<!--     modal-->
<div class="modal fade slide-right" id="modalSlideLeft" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content-wrapper">
            <div class="modal-content">
                <div class="container-xs-height full-height">
                    <div class="row-xs-height">
                        <div class="modal-body col-xs-height col-middle tءذext-center">
                            <p>{{__('website.are_you_sure_to_delete_this_folder')}}
                            <span class="block bold viewItems"></span></p>
                            <h5 class="text-danger m-t-20">{{__('website.are_you_sure')}}</h5><br>
                            <button type="button" class="btn btn-danger btn-block confirmAll" data-dismiss="modal" data-action="delete">
                                {{__('website.agree')}}
                            </button>
                            <button type="button" class="btn btn-default btn-block" data-dismiss="modal">
                                {{__('website.cancel')}}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>





<div class="modal fade slide-right" id="filterModalDocuments" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-lg">
		  <div class="modal-content-wrapper">
			<div class="modal-content">
				<div class="modal-header mb-3"><h6>{{__('website.filter')}}</h6></div>
				<div class="container-xs-height full-height">
				    <div class="row-xs-height">
					    <div class="modal-body col-xs-height">
					        <form id="documentFilterForm" action="javascript:avoid(0)" method="get">
							<div class="form-group form-group-default form-group-default-select2 required">
								<label> {{__('website.project')}} </label>
                                <select class="full-width" data-init-plugin="select2" id="project_id" name="project_id">
                                    <optgroup label="{{__('website.project')}}">
                                        <option value=""></option>
                                        @foreach($projects as $one)
                                            <option value="{{$one->id}}">{{$one->name}}</option>
                                        @endforeach
                                    </optgroup>
                                </select>
                            </div>

							<div class="form-group form-group-default form-group-default-select2 required">
							    <label> {{__('website.entry_folder')}} </label>
                                <select class="full-width" data-init-plugin="select2" id="responsible_lawyer" name="responsible_lawyer">
                                    <optgroup label="{{__('website.choose_emp_name')}}">
                                        <option value=""></option>
                                        @foreach(Auth::user()->office_employees as $one)
                                            <option value="{{$one->id}}">{{$one->name}}</option>
                                        @endforeach
                                    </optgroup>
                                </select>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group form-group-default">
                                        <label> {{__('website.from_date')}} </label>
                                        <input type="text" class="form-control hijri-date-input" name='from_date'>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-group-default">
                                        <label> {{__('website.to_date')}} </label>
                                        <input type="text" class="form-control hijri-date-input" name='to_date'>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-complete btn-block"> {{__('website.search')}} </button>
						    <button type="button" class="btn btn-default btn-block" data-dismiss="modal"> {{__('website.cancel')}} </button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>


@endsection


@section('js')
<script>

$(document).ready(function(){

    /////////////////////// filter Tab Documents ////////////////////
    $(document).on('click','.filterTabDocuments',function(e){
        var status = $(this).data("action");
        $('.filterTabDocuments').removeClass('active');
        $(this).addClass('active');
        var url = "{{ url(app()->getLocale().'/documentFilterStatus/') }}";

        $.ajax({
            url: url+'/'+status,
            type: "get",
            success: function (response) {
                $(".documentRow").hide();
                $('.viewAllDocuments').append(response.documentFilter);
            }
        });
    });


    /////////////////////// filter Text Documents ////////////////////
    $(document).on('submit','#documentFilterText',function(e){
        var text = $('#textKey').val();
        var url = "{{ url(app()->getLocale().'/documentFilterText/') }}";

        $.ajax({
            url: url+'/'+text,
            type: "get",
            success: function (response) {
                $(".documentRow").hide();
                $('.viewAllDocuments').append(response.documentFilter);
            }
        });
    });


    /////////////////////// filter Form Documents ////////////////////
    $(document).on('submit','#documentFilterForm',function(e){

        var url = "{{ url(app()->getLocale().'/documentFilterForm/') }}";
        $.ajax({
            url: url,
            type: "get",
            data: $(this).serialize(),
            success: function (response) {
                $(".documentRow").hide();

                $('#filterModalDocuments').fadeOut(500,function(){
                    $('#filterModalDocuments').modal('hide');
                });

                $('.viewAllDocuments').append(response.documentFilter);

                $("#filterModalDocuments #project_id").val('').select2();
                $("#filterModalDocuments #responsible_lawyer").val('').select2();
                $("#documentFilterForm").trigger("reset");

            }
        });
    });


});
</script>
@endsection
