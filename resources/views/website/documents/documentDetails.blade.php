@extends('layout.siteLayout')

@section('title', __('website.clients'))

@section('topfixed')
<div class="page-top-fixed">
    <div class="container-fluid">
        <div class="px-3 pb-2 p-md-0 d-flex flex-column flex-md-row align-items-md-center justify-content-between">
            <h2 class="page-header mb-1 my-md-3">{{$item->title}}</h2>
            <div class="page-options-btns">
                <div class="btn-group mb-2 m-md-3 mt-md-0 ml-2">
                    <!--<button type="button" class="btn btn-default has-icon" data-target="#modalExport11" data-toggle="modal">-->
                    <!--    <i class="material-icons">description</i><span>{{__('website.download')}}</span>-->
                    <!--</button>-->

                    <!--<button type="button" class="btn btn-default  has-icon" data-target="#modalSlideLeft11" data-toggle="modal">-->
                    <!--    <i class="material-icons">edit</i><span>{{__('website.edit')}}</span>-->
                    <!--</button>-->

                    <button class="btn btn-default has-icon modalSlideLeft event cursorNODrop" href="#modalSlideLeft" data-toggle="modal" disabled>
                        <i class="material-icons">close</i><span>{{__('website.delete')}}</span>
                    </button>
                </div>

                <button class="btn btn-complete has-icon mb-2 m-md-0" data-target="#modalAddDocument" data-toggle="modal">
                    <i class="material-icons">add</i><span> {{__('website.add_file')}} </span>
                </button>

                <button class="btn btn-complete has-icon mb-2 m-md-0" data-target="#modalAddFolder" data-toggle="modal">
                    <i class="material-icons">add</i><span> {{__('website.add_folder')}} </span>
                </button>
            </div>
		</div>
	</div>
</div>
@endsection



@section('content')
<div class="content ">
    <div class="bg-white">
        <div class="container-fluid">
            <ol class="breadcrumb breadcrumb-alt">
                <li class="breadcrumb-item"><a href="{{url(app()->getLocale().'/documents')}}">
                    {{__('website.documents')}}</a></li>
                <li class="breadcrumb-item active">{{__('website.view_all_documents')}}</li>
              </ol>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row no-gutters mt-4">
                <div class="col-lg-12">
                    <div class=" card m-0 no-border">
                        <div class="card-header d-flex flex-column flex-sm-row align-items-sm-start justify-content-sm-between">
                            <div>
                                <h5>{{__('website.view_documents')}}</h5>
                                <p>{{__('website.view_all_documents')}}</p>
                            </div>
                         </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover tableWithSearch allDocuments" id="tableWithSearch">
                                    <thead>
                                        <tr>
                                            <th class="wd-5p no-sort">
                                                <div class="checkbox checkMain text-center">
                                                    <input type="checkbox" value="3" id="checkboxall" name="chkBox" class="chkBox">
                                                    <label for="checkboxall" class="no-padding no-margin"></label>
                                                </div>
                                            </th>
                                            <th class="wd-30p">{{__('website.document_title')}}</th>
                                            <th class="wd-30p">{{__('website.employee')}}</th>
                                            <th class="wd-15p">{{__('website.date')}}</th>
                                            <th class="wd-10p">{{__('website.download')}}</th>
                                            <th class="wd-10p no-sort">{{__('website.action')}}</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                    @if(isset($item->files))
                                    @foreach ($item->files->sortBy('document_date') as $one)
                                        <tr id="tr-{{$one->id}}">
                                            <td class="v-align-middle wd-5p">
                                                <div class="checkbox checkMain text-center">
                                                    <input type="checkbox" class="checkboxes chkBox" value="{{@$one->id}}" id="chkBox{{@$one->id}}" data name="chkBox"/>
                                                    <label for="chkBox{{@$one->id}}" class="no-padding no-margin"></label>
                                                </div>
                                            </td>

                                            <td class="v-align-middle wd-30p">{{@$one->title}}</td>

                                            <td class="v-align-middle wd-30p documentsStatus-{{@$item->id}}">
                                                <p> {{@$one->employee->name}} </p>
                                            </td>

                                            <td class="v-align-middle wd-15p typeClients"><p>
                                                {{Arr::get(getDates(substr($one->document_date, 0, 10)), 'hijri_date')}}
                                            </p></td>

                                            <td class="v-align-middle wd-10p typeDocument">
                                                <a href="{{@$one->file}}"><i class="material-icons">crop_original</i></a>
                                            </td>

                                            <td class="v-align-middle wd-10p">
                                                <a class="notes-opt-btn modalToEditDocument event" data-toggle="modal" title="{{__('website.edit')}}" data-id="{{$one->id}}" href="#modalToEditDocument">
                                                    <i class="material-icons">edit</i>
                                                </a>
                                            </td>
                                            
                                        </tr>
                                    @endforeach
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


    <div class="modal fade slide-right" id="modalToEditNote" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-lg">
	        <div class="modal-content-wrapper">
			    <div class="modal-content">
				    <div class="modal-header mb-3">
					    <h6>{{__('website.edit')}} {{__('website.note')}}</h6>
				    </div>
				    <div class="container-xs-height full-height">
				        <div class="row-xs-height">
				            <div class="modal-body col-xs-height">
                                <form id="formCalendar11" method="post" action="{{url(app()->getLocale().'/clients/note_note')}}" >
                                {{csrf_field()}}
                                <input type="hidden" name="note_id" value="">

    							<div class="form-group form-group-default required">
    								<label>{{__('website.write_note')}}</label>
    								<input type="text" class="form-control" id="note" name="note">
    							</div>

    							<div class="form-group form-group-default required">
    								<label>{{__('website.date')}}</label>
    								<input type="text" class="input-sm form-control start_date" name="note_date"  autocomplete="off" />
    							</div>

						        <button type="submit" class="btn btn-complete btn-block">{{__('website.save')}}</button>
                                <button type="button" class="btn btn-default btn-block" data-dismiss="modal">{{__('website.cancel')}}</button>
                                </form>
				            </div>
				        </div>
			        </div>
			    </div>
		    </div>
	    </div>
    </div>


    <div class="modal fade slide-right" id="modalAddNote" tabindex="-1" role="dialog" aria-hidden="true">
	    <div class="modal-dialog modal-lg">
		    <div class="modal-content-wrapper">
			    <div class="modal-content">
				    <div class="modal-header mb-3"><h6>{{__('website.add_new_note')}}</h6></div>
				    <div class="container-xs-height full-height">
				        <div class="row-xs-height">
				            <div class="modal-body col-xs-height">
                                <form id="formCalendar11" method="post" action="{{url(app()->getLocale().'/clients/create_note')}}">
                                {{csrf_field()}}
                                <input type="hidden" name="client_id" value="{{$item->id}}">
        							<div class="form-group form-group-default required">
        								<label>{{__('website.write_note')}}</label>
        								<input type="text" class="form-control" id="note" name="note">
        							</div>
        							<div class="form-group form-group-default required">
        								<label>{{__('website.date')}}</label>
        								<input type="text" class="input-sm form-control start_date" name="note_date" autocomplete="off" />
        							</div>
						            <button type="submit" class="btn btn-complete btn-block" >{{__('website.save')}}</button>
                                    <button type="button" class="btn btn-default btn-block" data-dismiss="modal">{{__('website.cancel')}}</button>
                                </form>
				            </div>
				        </div>
			        </div>
			    </div>
		    </div>
	    </div>
	</div>



<!--     modal-->
<div class="modal fade slide-right" id="modalToDeleteNote" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content-wrapper">
            <div class="modal-content">
                <div class="container-xs-height full-height">
                    <div class="row-xs-height">
                        <div class="modal-body col-xs-height col-middle text-center">
                            <p>{{__('website.are_you_sure_to_delete_this_note')}}
                            <span class="block bold viewItems"></span></p>
                            <h5 class="text-danger m-t-20">{{__('website.are_you_sure')}}</h5><br>
                            <button type="button" class="btn btn-danger btn-block deleteNote" data-dismiss="modal" data-id="0"  data-action="delete">
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






<!--     modal-->
<div class="modal fade slide-right" id="modalSlideLeft" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content-wrapper">
            <div class="modal-content">
                <div class="container-xs-height full-height">
                    <div class="row-xs-height">
                        <div class="modal-body col-xs-height col-middle text-center">
                            <p>{{__('website.are_you_sure_to_delete_this_document')}}
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



@endsection
