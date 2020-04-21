<!DOCTYPE html>
<html dir="rtl">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta charset="utf-8" />


    <style>
        body {
            direction: rtl;
            font-family: 'tahoma';
            line-height: 190%;
        }

        @page {
            size: landscape;
            header: page-header;
            footer: page-footer;
            margin-header: -7mm;
            margin-footer: -1mm;
            marks: none;
        }

        @page :right {
            margin-top: 3cm;
            margin-bottom: 3cm;
            padding-top: 3cm;
            padding-bottom: 3cm;
            header: html_myHeader;
        }


        @page rotated {
            size: landscape;
        }

        div.onitsside {
            page: rotated;
            page-break-before: right;
        }


        p {
            margin: 0;
            padding: 0;
            font-size: 14px
        }
        span {
            float: left;
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
            margin-bottom: 50px;
        }
        .logo {
            float: left;
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
            margin-top: 30px;
            margin-bottom: 30px;
        }
        .secHead {
            float: right;
            width: 80%
        }
        .secHead h3 {
            margin: 0;
        }
        .data-pr {
            padding-top: 50px;
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
            clear: both;
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
            margin-top: 30px;
            border: 1px solid #e1e1e2;
            display: flex;
        }
        .box-det div {
            padding: 10px 5px 0;
        }
        .box-det div h3 {
            font-weight: bold;
        }
        .box-det div p {
            margin-bottom: 30px;
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
            padding-top: 50px;
            margin-top: 50px;
        }
        .footer  .container{
            padding-top: 50px;
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



    <htmlpageheader name="page-header">
        <div class="header">
            <div class="container">
              <div class="boxHeader">
                <div class="secHead">
                    <h3>{{__('website.project_receivables_invoice')}} {{$project}}</h3>
                </div>
                <div class="logo" style="float: left !mportant;">
                    <img src="{{$logo}}" width="120" />
                </div>
              </div>
            </div>
        </div>
    </htmlpageheader>




    <div class="data-pr">
        <div class="container">
            <div class="flex50">
                <div class="data-sent" style="float:right;">
                    <div class="name-per">
                        <span>{{__('website.required_from')}} :</span>
                        <p>{{$client}}</p>
                    </div>
                    <p>{{$client_address}}</p>
                </div>
                <div class="numb-sent" style="float:left;">
                    <div>
                        <p>{{__('website.invoiceID')}} : <span>{{$invoice_number}}</span></p>
                        <p>{{__('website.tax_number')}} : <span>15245008</span></p>
                        <p>{{__('website.invoice_date')}} : <span>
                            {{@Arr::get(getDates(substr($release_date, 0, 10)), 'hijri_date')}}
                        </span></p>
                        <p> {{__('website.claim_date')}} : <span>
                            {{@Arr::get(getDates(substr($claim_date, 0, 10)), 'hijri_date')}}
                        </span></p>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="clearfix"></div>



    @if(isset($invoiceHours) && (in_array(3 ,$invoice_outputs) || in_array(1 ,$invoice_outputs)))
    <div class="secBody">
        <div class="container">
            <table id="customers">
                <thead>
                    <tr>
                        <th>{{__('website.amount')}}</th>
                        <th>{{__('website.date')}}</th>
                        <th>{{__('website.range')}}</th>
                        <th>{{__('website.hours')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($invoiceHours as $one)
                    <tr>
                        <td><span>{{($one->hour->hours_count*$one->hour->price)}} {{__('website.r_s')}}</span></td>
                        <td>
                            {{@Arr::get(getDates(substr($one->hour->start_date, 0, 10)), 'hijri_date')}}
                        </td>
                        <td>{{$one->hour->price}} {{__('website.r_s')}}</td>
                        <td>{{$one->hour->hours_count}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif



    <div class="clearfix"></div>



    @if(isset($invoiceExpenses) && (in_array(4 ,$invoice_outputs) || in_array(1 ,$invoice_outputs)))
    <div class="secBody">
        <div class="container">
            <table id="customers">
                <thead>
                    <tr>
                        <th>{{__('website.amount')}}</th>
                        <th>{{__('website.recipient_name')}}</th>
                        <th>{{__('website.expense_date')}}</th>
                        <th>{{__('website.expenses')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($invoiceExpenses as $one)
                    <tr>
                        <td style="text-align: center;">{{(@$one->expense->total_amount)}} {{__('website.r_s')}}</td>
                        <td style="text-align: center;">{{@$one->expense->employee->name}}</td>
                        <td style="text-align: center;">
                            {{@Arr::get(getDates(substr($one->expense->expense_date, 0, 10)), 'hijri_date')}}
                        </td>
                        <td style="text-align: center;">{{@$one->expense->aspect_expense->name}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif



    <div class="clearfix"></div>



    @if(isset($invoiceFlatsFees) && (in_array(5 ,$invoice_outputs) || in_array(1 ,$invoice_outputs)))
    <div class="secBody">
        <div class="container">
            <table id="customers">
                <thead>
                    <tr>
                        <th>{{__('website.amount')}}</th>
                        <th>{{__('website.date')}}</th>
                        <th>{{__('website.flats_fees')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($invoiceFlatsFees as $one)
                    <tr>
                        <td style="text-align: center;">{{(@$one->flatFee->price)}} {{__('website.r_s')}}</td>
                        <td style="text-align: center;">
                            {{@Arr::get(getDates(substr($one->flatFee->date, 0, 10)), 'hijri_date')}}
                        </td>
                        <td style="text-align: center;">{{@$one->flatFee->description}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif


    <div class="clearfix"></div>


    <div class="det-inv" style="width:100%; margin-bottom:30px;">
        <div class="container">
        	<div class="box-det row">

                <div style="width:64%; float:right;">
                    <div style="float:right; width:45%;">
                        <p> {{__('website.total_with_vat')}}</p>
                        <h3>{{ $invoice_amount }} {{__('website.sr')}}</h3>
                    </div>

                    <div style="float:left; width:45%;">
                        <p>{{__('website.vat')}}</p>
                        <h3>   @if(isset($vat))
                            {{$vat}}%
                        @else
                            {{__('website.not_found')}}
                        @endif</h3>
                    </div>
                </div>


                <div class="final-pri" style="width:31%; float:left;">
                    <p>{{__('website.total_without_vat')}}</p>
                    <h3>{{$final_total}} {{__('website.sr')}}</h3>
                </div>

        	</div>
            <p class="noti-pri">{{__('website.invoice_entitlement')}}</p>
        </div>
    </div>


    <div class="clearfix"></div>



    <htmlpagefooter name="page-footer">
        <div class="footer">
        	<div class="container">
        		<div class="logo">
                    <img src="{{$logo}}" width="120" />
                </div>
                <span>+34 346 4546 445</span>
                <span>support@hexacit.com</span>
        	</div>
        </div>
    </htmlpagefooter>







</body>
