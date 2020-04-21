@extends('layout.siteLayout')
@section('title', __('website.expenses'))

@section('topfixed')

<div class="page-top-fixed">
    <div class="container-fluid">
        <div class="px-3 pb-2 p-md-0 d-flex flex-column flex-md-row align-items-md-center justify-content-between">
            <h2 class="page-header mb-1 my-md-3">{{__('website.expenses')}}</h2>
            <div class="page-options-btns">
                <div class="btn-group mb-2 m-md-3 mt-md-0 ml-2">

                    <button type="button" class="btn btn-default has-icon" onclick="window.location.href='{{url(getLocal(). '/exportAllExpensesPDF')}}'">
				        <i class="material-icons">description</i><span>{{__('website.export')}}</span>
					</button>

                    <button class="btn btn-default has-icon modalSlideLeft event cursorNODrop" href="#modalSlideLeft" data-toggle="modal" disabled>
                      <i class="material-icons">close</i><span>{{__('website.delete')}}</span>
                    </button>
			    </div>

        		<button class="btn btn-complete has-icon mb-2 m-md-0" onclick="window.location.href='{{url(app()->getLocale() . '/expenses/create')}}'">
                    <i class="material-icons">add</i> <span>{{__('website.add_new_expense')}}</span>
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
                <li class="breadcrumb-item">
                    <a href="{{url(app()->getLocale().'/expenses')}}">{{__('website.expenses')}}</a>
                </li>
                <li class="breadcrumb-item active">{{__('website.view_expenses_invoices')}}</li>
            </ol>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row no-gutters mt-4">
            <div class="col-lg-12">
                <div class=" card m-0 no-border">
                    <div class="card-header d-flex flex-column flex-sm-row align-items-sm-start justify-content-sm-between">
					    <div>
					        <h5>{{__('website.view_expenses')}}</h5>
                        </div>

						<div class="btn-group">
                            <form class="input-group" id="expenseFilterText" action="javascript:avoid(0)" method="get">
                                <input type="text" name="text" id="textKey" class="form-control" placeholder="{{__('website.search')}}">
							    <div class="input-group-append">
							        <button class="btn btn-secondary" type="submit"><i class="material-icons">search</i></button>
							    </div>
                            </form>

						    <button class="btn btn-sm btn-default filter has-icon " data-target="#filterModalExpenses" data-toggle="modal">
                                <i class="material-icons">filter_list</i><span>{{__('website.filter')}}</span>
                            </button>

                            <button class="btn btn-sm btn-default filterTabExpenses active" data-action="all">{{__('website.all')}}</button>
            			    <button class="btn btn-sm btn-default filterTabExpenses" data-action="draft">{{__('website.draft')}}</button>
                            <button class="btn btn-sm btn-default filterTabExpenses" data-action="certified">{{__('website.certified')}}</button>
                            <button class="btn btn-sm btn-default filterTabExpenses" data-action="canceled">{{__('website.canceled')}}</button>
						</div>
					</div>

                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover tableWithSearch allExpenses" id="tableWithSearch">
                                <thead>
						            <tr>
								        <th class="wd-5p no-sort">
								            <div class="checkbox checkMain text-center">
                                                <input type="checkbox" value="" id="checkboxall" name="client" class="chkBox">
									            <label for="checkboxall" class="no-padding no-margin"></label>
									        </div>
                                        </th>
                                        <th class="wd-10p">{{__('website.expense_date')}}</th>
                                        <th class="wd-15p">{{__('website.expense_aspect')}}</th>
                                        <th class="wd-20p">{{__('website.project_name')}}</th>
                                        <th class="wd-20p">{{__('website.recipient_name')}}</th>
                                        <th class="wd-10p">{{__('website.amount')}}</th>
                                        <th class="wd-10p">{{__('website.status')}}</th>
                                        <th class="wd-10p">{{__('website.action')}}</th>
                                      </tr>
							        </thead>

                                    <tbody class="viewAllExpenses">

                                    @include('website.extraBlade.filters.expenseFilter')

                                        @if(isset($items))
                                        @forelse($items as $item)

                                        <tr id="tr-{{$item->id}}" class="expenseRow">
								            <td class="v-align-middle wd-5p">
									            <div class="checkbox checkMain text-center">
                                                    <input type="checkbox" class="checkboxes chkBox" value="{{@$item->id}}" id="chkBox{{@$item->id}}" data name="chkBox"/>
                                                    <label for="chkBox{{@$item->id}}" class="no-padding no-margin"></label>
									            </div>
                                            </td>
                                            <td class="v-align-middle wd-10p name{{@$item->id}}">
                                                {{Arr::get(getDates(substr($item->expense_date, 0, 10)), 'hijri_date')}}
                                            </td>
						                    <td class="v-align-middle wd-15p"><p>{{@$item->aspect_expense->name}}</p></td>
                                            <td class="v-align-middle wd-20p typeClients">
                                                @if($item->project_id)
                                                  <a href="{{url(getLocal(). '/projects/'.$item->project_id)}}"><p>{{@$item->project->name}}</p></a>
                                                @endif
                                            </td>
        						            <td class="v-align-middle wd-20p"><p>{{@$item->employee->name}}</p></td>
                                            <td class="v-align-middle wd-10p"><p>{{@$item->total_amount}} {{__('website.r_s')}}</p></td>
							                <td class="v-align-middle wd-10p ExpenseStatus-{{$item->id}}">
                                                <span class="badge badge-pill
                                                  @if($item->expense_status == 'draft') badge-success @endif
                                                  @if($item->expense_status == 'certified') badge-info @endif
                                                  @if($item->expense_status == 'canceled') badge-danger @endif
                                                    " id="label-{{$item->id}}">
                                                  {{__('website.'.$item->expense_status)}}
                                                </span>
								            </td>
								            <td class="v-align-middle wd-10p optionAddHours">
                                                <!--@if($item->expense_status == 'draft')-->
                                                <!--    <div class="note-options canceledExpense" data-id="{{$item->id}}" data-toggle="tooltip" title="{{__('website.canceled')}}" href="#"-->
                                                <!--    data-original-title="">-->
                                                <!--    <i class="fa fa-ban" aria-hidden="true"></i>-->
                                                <!--    </div>-->
                                                <!--@endif-->

                                                <a href="{{url(getLocal(). '/expenses/' . $item->id)}}">
                                                  <div class="note-options" data-toggle="tooltip" title="" href="#" data-original-title="{{__('website.details')}}">
                                                    <i class="material-icons showDitails">visibility</i>
                                                  </div>
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


<!-- modalSlideLeft -->
<div class="modal fade slide-right" id="modalSlideLeft" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content-wrapper">
            <div class="modal-content">
                <div class="container-xs-height full-height">
                    <div class="row-xs-height">
                        <div class="modal-body col-xs-height col-middle text-center">
                            <p>{{__('website.are_you_sure_to_delete_this_expense')}}
                            <span class="block bold viewItems"></span></p>
                            <h5 class="text-danger m-t-20">{{__('website.are_you_sure')}}</h5><br>
                            <button type="button" class="btn btn-danger btn-block confirmAll" data-dismiss="modal" data-action="delete">
                                {{__('website.agree')}}
                            </button>
                            <button type="button" class="btn btn-default btn-block" data-dismiss="modal">{{__('website.cancel')}}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




<div class="modal fade slide-right" id="filterModalExpenses" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content-wrapper">
			<div class="modal-content">
				<div class="modal-header mb-3">
					<h6>{{__('website.filter')}}</h6>
				</div>
				<div class="container-xs-height full-height">
				    <div class="row-xs-height">
					    <div class="modal-body col-xs-height">
                            <form id="expenseFilterForm" action="javascript:avoid(0)" method="get">



                                <div class="form-group form-group-default form-group-default-select2">
								    <label> {{__('website.status')}} </label>
								        <select class="full-width" data-init-plugin="select2" id="expense_status" name="expense_status">
								            <optgroup label="{{__('website.status')}}">
                                                <option value=""></option>
                                                <option value="draft">{{__('website.draft')}}</option>
									            <option value="certified">{{__('website.certified')}}</option>
									            <option value="canceled">{{__('website.canceled')}}</option>

								            </optgroup>
								        </select>
							        </div>


                                <div class="form-group form-group-default form-group-default-select2">
								    <label> {{__('website.expense_aspect')}} </label>
								        <select class="full-width" data-init-plugin="select2" id="aspect_expense_id" name="aspect_expense_id">
								            <optgroup label="{{__('website.select_expense_aspect')}}">
									            <option value=""></option>
									            @if(isset($aspect_expense))
                                                @foreach($aspect_expense as $one)
                                                  <option value="{{@$one->id}}">{{@$one->name}}</option>
                                                @endforeach
                                                @endif
								            </optgroup>
								        </select>
							        </div>

							        <div class="form-group form-group-default form-group-default-select2">
								        <label>{{__('website.project')}}</label>
								        <select class="full-width" data-init-plugin="select2" id="project_id" name="project_id">
								            <optgroup label="{{__('website.select_project_name')}}">
                                                <option value=""></option>
                                                @if(isset($projects))
                                                @foreach($projects as $one)
                                                  <option value="{{@$one->id}}">{{@$one->name}}</option>
                                                @endforeach
                                                @endif
                            				</optgroup>
                            			</select>
                            		</div>

                                    <div class="form-group form-group-default form-group-default-select2">
								        <label> {{__('website.responsible_emp')}} </label>
								        <select class="full-width" data-init-plugin="select2" id="responsible_lawyer" name="responsible_lawyer">
                                            <optgroup label="{{__('website.choose_emp_name')}}">
                                                <option value=""></option>
                                                @if(isset(Auth::user()->office_employees))
                                                @foreach(Auth::user()->office_employees as $one)
                                                  <option value="{{@$one->id}}">{{@$one->name}}</option>
                                                @endforeach
                                                @endif
                        					</optgroup>
                        				</select>
                        			</div>

                                    <div class="row">
								        <div class="col-md-6">
									        <div class="form-group form-group-default">
										        <label>{{__('website.from_date')}}</label>
                                                <input type="text" class="form-control hijri-date-input" id="from_date" name="from_date">
									        </div>
								        </div>
                                        <div class="col-md-6">
        								    <div class="form-group form-group-default">
        									    <label>{{__('website.to_date')}}</label>
                                                <input type="text" class="form-control hijri-date-input" id="to_date" name="to_date">
        									</div>
        								</div>
                                    </div>
                                    <button type="submit" class="btn btn-complete btn-block">{{__('website.search')}}</button>
                                    <button type="button" class="btn btn-default btn-block" data-dismiss="modal">{{__('website.cancel')}}</button>
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


    /////////////////////// filter Tab Expenses ////////////////////
    $(document).on('click','.filterTabExpenses',function(e){
        var status = $(this).data("action");
        $('.filterTabExpenses').removeClass('active');
        $(this).addClass('active');
        var url = "{{ url(app()->getLocale().'/expenseFilterStatus/') }}";

        $.ajax({
            url: url+'/'+status,
            type: "get",
            success: function (response) {
                $(".expenseRow").hide();
                $('.viewAllExpenses').append(response.expenseFilter);
            }
        });
    });


    /////////////////////// filter Text Expenses ////////////////////
    $(document).on('submit','#expenseFilterText',function(e){
        var text = $('#textKey').val();
        var url = "{{ url(app()->getLocale().'/expenseFilterText/') }}";

        $.ajax({
            url: url+'/'+text,
            type: "get",
            success: function (response) {
                $(".expenseRow").hide();
                $('.viewAllExpenses').append(response.expenseFilter);
            }
        });
    });


    /////////////////////// filter Form Expenses ////////////////////
    $(document).on('submit','#expenseFilterForm',function(e){

        var url = "{{ url(app()->getLocale().'/expenseFilterForm/') }}";
        $.ajax({
            url: url,
            type: "get",
            data: $(this).serialize(),
            success: function (response) {
                $(".expenseRow").hide();

                $('#filterModalExpenses').fadeOut(500,function(){
                    $('#filterModalExpenses').modal('hide');
                });

                $('.viewAllExpenses').append(response.expenseFilter);

                $("#filterModalExpenses #expense_status").val('').select2();
                $("#filterModalExpenses #aspect_expense_id").val('').select2();
                $("#filterModalExpenses #project_id").val('').select2();
                $("#filterModalExpenses #responsible_lawyer").val('').select2();
                $("#expenseFilterForm").trigger("reset");
            }
        });
    });



});
</script>
@endsection
