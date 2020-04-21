<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />

        <title>{{__('website.report')}}</title>
        <link href="https://fonts.googleapis.com/css?family=Cairo" rel="stylesheet">


        <style>
            body {
                direction: rtl;
                font-family: cairo
            }
            p {
                margin: 0;
                padding: 0;
                font-size: 14px
            }
            span {
                margin:0 15px
            }
            li {
                text-align: right;
                font-size: 15px;
            }
            .span1 {
                margin-right: 0
            }
            .container {
                width: 1170px;
                margin: auto;
            }
            .text-center {
                text-align: center !important
            }
            .boxHeader {
                display: flex;
                flex-wrap: wrap;
				padding-top: 50px;
            }
            .logo {
                float: right;
                width: 20%;
                overflow: hidden;
				justify-content: flex-end;
    			display: flex;
            }
            .logo img {
                width: 120px;
            }
            .secBody .container {
                display: flex;
                flex-wrap: wrap;
				padding: 50px 0
            }
            .secHead {
                float: left;
                width: 80%
            }
			.secHead h2 {
				margin: 0;
			}
			.data-pr {
				margin: 70px 0 30px;
			}
			.name-per p {
				color: #000;
				font-size: 17px;
				font-weight: 600;
			}
			.name-per span {
				margin: 0;
				font-size: 11px;
			}
			.flex50 {
				display: flex;
                flex-wrap: wrap;
			}
			.flex50 .data-sent, .flex50 .numb-sent {
				width: 50%
			}
			.flex50 .data-sent {
				font-size: 13px
			}
			.numb-sent p {
				font-weight: bold
			}
			.numb-sent span {
				font-weight: 300
			}
			.numb-sent {
				justify-content: flex-end;
				display: flex;
			}
            .clearfix {
                clear: both
            }
			#customers {
			  border-collapse: collapse;
			  width: 100%;
			}
			#customers td, #customers th {
			  border-bottom: 1px solid #ddd;
			  padding: 8px;
			}
			#customers td p {
				font-size: 14px;
				color: #000;
				font-weight: 500;
				margin-bottom: 0px;
			}
			#customers td span {
				font-size: 10px;
				margin: 0;
				opacity: 0.7
			}
			#customers th {
			  	padding-top: 12px;
			  	padding-bottom: 12px;
				font-size: 13px;
			  	text-align: right;
			  	background-color: transparent;
			  	color: #333;
			}
			.box-det {
				margin-top: 100px;
				border: 1px solid #e1e1e2;
				display: flex;
			}
			.box-det div {
				width: 33.33334%;
				padding: 20px 15px 0;
			}
			.box-det div h1 {
				font-weight: bold;
			}
			.box-det div p {
				margin-bottom: -30px;
				opacity: 0.7
			}
			.final-pri {
				background: #000;
				color: #fff;
				text-align: left
			}
			.noti-pri {
				font-size: 12px;
				opacity: 0.7;
				margin-top: 20px;
				border-top: 1px solid #e1e1e2;
				padding: 10px 0 20px;
			}
			.footer {
				padding: 20px 0;
				overflow: hidden;

			}
			.footer  .container{
				padding-top: 20px;
				border-top: 1px solid #e1e1e2;
			}
			.footer .logo {
				float: right;
				width: auto;
				overflow: hidden;
				justify-content: flex-end;
				display: flex;
			}
			.footer span{
				color: #2c2d2f !important;
				font-size: 13px;
				margin-right: 50px;
			}



        </style>
    </head>

    <body>


        <div class="header">
            <div class="container">
              <div class="boxHeader">
                <div class="secHead">
                    <h2>{{__('website.report')}} {{__('website.project')}} {{@$item->project->name}}</h2>
                </div>
                <div class="logo">
                    <img src="{{url('assets/img/logo.svg')}}" />
                </div>
              </div>
            </div>
        </div>

        <div class="data-pr">
        	<div class="container">
        		<div class="flex50">

        			<div class="numb-sent">
        				<div>
        					<p>{{__('website.reportID')}} : <span>{{@$item->id}}</span></p>
							<p>{{__('website.reportDate')}} : <span>
                                {{Arr::get(getDates(substr($item->created_at, 0, 10)), 'hijri_date')}}
                            </span></p>
                            <p>{{__('website.sessionDate')}} : <span>
                                {{Arr::get(getDates(substr($item->next_date, 0, 10)), 'hijri_date')}}
                            </span></p>
							<p>{{__('website.time')}}  : <span>{{@$item->next_time}}</span></p>
        				</div>
        			</div>
        		</div>
        	</div>
        </div>

        <div class="clearfix"></div>

        		<div class="col-12">
					<h5>{{__('website.the_facts')}}</h5>
					<p>{{@$item->report_content}}</p>
				</div>
			    <br>
				<br>


				@if(isset($item->reportHours) && (in_array(3 ,$item->report_outputs) || in_array(1 ,$item->report_outputs)))
        <div class="secBody">
           <div class="container">
              <table id="customers">
				  <thead>
				      <tr>
					<th>{{__('website.hours')}}</th>
					<th>{{__('website.range')}}</th>
					<th>{{__('website.date')}}</th>
					<th>{{__('website.amount')}}</th>
					</tr>
				  </thead>
				  <tbody>
    			      @foreach($item->reportHours as $one)
    				  <tr>
    					<td><p>{{$one->hour->hours_count}}</p></td>
    					<td>{{$one->hour->price}} {{__('website.r_s')}}</td>
                        <td>
                            {{Arr::get(getDates(substr($one->hour->start_date, 0, 10)), 'hijri_date')}}
                        </td>
    					<td>{{($one->hour->hours_count*$one->hour->price)}} {{__('website.r_s')}}</td>
    				  </tr>
    			    @endforeach
			  </tbody>
			  </table>
          </div>
        </div>
       @endif




                  @if(isset($item->reportExpenses) && count($item->reportExpenses) >= 1 && (in_array(4 ,$item->report_outputs) || in_array(1 ,$item->report_outputs)))
        <div class="secBody">
           <div class="container">
              <table id="customers">
				  <thead>
				      <tr>
					<th>{{__('website.expenses')}}</th>
					<th>{{__('website.expense_date')}}</th>
					<th>{{__('website.recipient_name')}}</th>
					<th>{{__('website.amount')}}</th>
					</tr>
				  </thead>
				  <tbody>
    			      @foreach($item->reportExpenses as $one)
    				  <tr>
    					<td><p>{{@$one->expense->aspect_expense->name}}</p></td>
                        <td>
                            {{Arr::get(getDates(substr($one->expense->expense_date, 0, 10)), 'hijri_date')}}
                        </td>
    					<td>{{@$one->expense->employee->name}}</td>
    					<td>{{(@$one->expense->total_amount)}} {{__('website.r_s')}}</td>
    				  </tr>
    			    @endforeach
			  </tbody>
			  </table>
          </div>
        </div>
       @endif


                  @if(isset($item->reportTasks) && (in_array(6 ,$item->report_outputs) || in_array(1 ,$item->report_outputs)))
        <div class="secBody">
           <div class="container">
              <table id="customers">
				  <thead>
				      <tr>
					<th>{{__('website.tasks')}}</th>
					<th>{{__('website.date')}}</th>
					</tr>
				  </thead>
				  <tbody>
                        @foreach($item->reportTasks as $one)
    				  <tr>
    					<td><p>{{@$one->task->name}}</p></td>
                        <td>
                            {{Arr::get(getDates(substr($one->task->end_date, 0, 10)), 'hijri_date')}}
                        </td>
    				  </tr>
    			    @endforeach
			  </tbody>
			  </table>
          </div>
        </div>
       @endif



        <div class="footer">
        	<div class="container">
        		<div class="logo">
                    <img src="{url('assets/img/logo.svg')}}" />
                </div>
                <span>+34 346 4546 445</span>
                <span>support@hexacit.com</span>
        	</div>
        </div>


    </body>

</html>
