<style>

    table {
        /*margin: auto;*/
        /*border-collapse: collapse;*/
        padding: 0;
        margin: 0;
    }
    .page6-inspection > p {
        margin-top: 5rem;
        font-size: 2.5rem;
        text-transform: uppercase;
        color: #0000FF;
    }

    .bk_border{ border: 1px solid;}
    .re_border{ border: 1px solid red;}
    .gr_border{ border: 1px solid darkgreen;}
    .bl_border{ border: 1px solid darkblue;}
    .ye_border{ border: 1px solid darkgoldenrod;}

    .bk_bg{ background-color: #777777;}
    .re_bg{ background-color: #ff6767;}
    .gr_bg{ background-color: #78ce5c;}
    .bl_bg{ background-color: #7575ff;}
    .ye_bg{ background-color: #f8c665;}

    .container_table, .container_table > td {
        width: 100%;
    }

    .estimate_table {
        margin: 0;
        padding: 0;
        /*border: solid 1px;*/
        width: 100%;
        border-collapse: collapse;
    }

    .page6-finner-table-row{
        width: 100%;
    }

    .estimate_table .tag .firstpara {
        {{--color: {{$companyDetails->secondary_color}};--}}
        color: red;
    }

    .page6-finner-table-header, .page6-sinner-table-header {
        /*background: rgb(231,231,231);*/
        width: 100%;
    }

    .page6-finner-table-header > tr > td,
    .page6-sinner-table-header > td {
        padding-top: 1rem;
    }
    .page6-finner-table-header > tr > .first-child > p,
    .page6-sinner-table-header > .first-child > p {
        font-size: 2px;
        text-transform: uppercase;
        font-weight: bold;
        color: {{$companyDetails->secondary_color}};
        margin-left: 10px ;
        letter-spacing: 2px;
    }

    .page6-finner-table-header td {
        color: {{$companyDetails->secondary_color}};
        font-size: 11px;
        font-weight: bold;
        background-color: #e7e7e7;
    }

    .page6-finner-table-header .value{
        padding: 8px 0px;
        font-weight: normal;
    }

    .page6-finner-table-header .tag_title{
        font-size: 14px;
        font-weight: bold;
        padding-left: 10px;
    }

    .page6-finner-table-row.data .value{
        border-bottom: solid 1px #ededed;
        /*min-width: 200px;*/
        width: 70px;
        font-size: 9px;
        color: {{$companyDetails->secondary_color}};
        padding-bottom: 5px;
        /*border: solid 1px;*/
    }

    /*Commented at 13-Jun-2022*/
    {{--.page6-finner-table-row > td > .firstpara {--}}
    {{--    margin: 1rem 0 0.25rem 1rem;--}}
    {{--    font-size: 1.5rem;--}}
    {{--    color: {{$companyDetails->secondary_color}};--}}
    {{--}--}}

    {{--.page6-finner-table-row > td > .secondpara{--}}
    {{--    margin-left: 2.75rem;--}}
    {{--    font-weight: bold;--}}
    {{--    margin-bottom: 2rem;--}}
    {{--    color: {{$companyDetails->secondary_color}};--}}
    {{--}--}}

    .area .title{
        font-size: 10px;
        letter-spacing: 2px;
    }

    .area .title, .area .annotation{
        color: {{$companyDetails->secondary_color}};
    }

    .page6-finner-table-hrrow > td > hr{
        border-top: 3px solid #eee;
        margin: 0;
/*       width:120%; */
    }

    .page6-finner-table-finalrow > td >p {
        margin: 2rem 0 10rem 0;
        text-transform: uppercase;
        font-weight:  bold;
        color: {{$companyDetails->secondary_color}};
    }

    .subtotal_table {
        margin-bottom: 30px;
        width: 100%;
        border-collapse: collapse;
    }

    .subtotal td {
        padding-top: 5px;
        color: {{$companyDetails->secondary_color}};
        font-size: 11px;
        font-weight: bold;
    }

    .summary {
        border-collapse: collapse;
    }

    .summary .title{
        /*font-size: 14px;*/
        /*font-weight: bold;*/
        background-color: #f8b242;
    }

    .summary .label, .summary .value {
        color: {{$companyDetails->secondary_color}};
    }

    .summary .value {
        width: 110px;
    }

</style>

<table class="container_table bl_border" style="border-collapse: collapse; ">
    <tr class="" style="padding: 0; margin: 0;">
        <td  style="padding: 0; margin: 0;padding-top: 2rem;">
      
            @if(!empty($estimates))
                @php
                    $subTotalSummary = [];
                    $grandTotal = 0;
                @endphp
                @foreach($estimates AS $eKey  => $eItem)
                    @php


                        $estimatesTotal[$eItem['inspectionAreaId']] = [
                                'name' =>  $eItem['inspectionArea'],
                                'materialTotal' =>  0,
                                'laborTotal' =>  0,
                                'equipmentTotal' =>  0,
                                'supervisionTotal' =>  0,
                                'margin' =>  0,
                                'salesTaxTotal' =>  0,
                                'lineItemTotal' =>  0,
                                'breakdown' =>  $eItem['cost_breakdown']
                            ];
                        $totalCols = 8;
                        $colCount = 0;
                        // $tagRowColSpan needs to be full width
                        // $totalCols-$colCount =
                        // 8-8                  = showing:0 >> 0+2;
                        // 8-6                  = showing:2 >> 2+2;
                        // 8-4                  = showing:4 >> 4+2;
                        // Should be: ($totalCols-$colCount)+2
                        $tagRowColSpan = 0;


                        // $totalCols-$colCount =
                        // 8-8                  = showing:0 >> 0+1;
                        // 8-6                  = showing:2 >> 2+1;
                        // 8-4                  = showing:4 >> 4+2;
                        $breakdownRowColSpan = 0;


                        $summaryRowColSpan = 0;

                        $selectedBreakdowns =$eItem['cost_breakdown'];

                        $colCount += !empty($selectedBreakdowns['units_of_measure']) ? 1 : 0;
                        $colCount += !empty($selectedBreakdowns['material_cost']) ? 1 : 0;
                        $colCount += !empty($selectedBreakdowns['labor_cost']) ? 1 : 0;
                        $colCount += !empty($selectedBreakdowns['equipment_cost']) ? 1 : 0;
                        $colCount += !empty($selectedBreakdowns['supervision_cost']) ? 1 : 0;
                        $colCount += !empty($selectedBreakdowns['margin_%']) ? 1 : 0;
                        $colCount += !empty($selectedBreakdowns['sales_tax']) ? 1 : 0;
                        $colCount += !empty($selectedBreakdowns['line_item_total']) ? 1 : 0;

                        // dd($selectedBreakdowns,$colCount);

                        // max cols are 8 including title
                        if($colCount<1){
                            $width = "width=100%;";
                        }else{
                            $width = "width=500px;";
                        }


                        $tagRowColSpan = $colCount+2;

                        $tagCounter = 0;

                        $materialTotal = 0;
                        $laborTotal = 0;
                        $equipmentTotal = 0;
                        $supervisionTotal = 0;
                        $salesTaxTotal = 0;
                        $subtotal = 0;
                    @endphp
                    <table class="estimate_table" style="padding-bottom: 20px;">
                        <thead class="page6-finner-table-header">
                            <tr class="page6-finner-table-row odd" style="margin: 0; padding: 0;">
                                                                                                            <td class="tag_title" ><p style="text-transform:uppercase;">{{ucfirst($eItem['inspectionArea'])}}</p></td>
                                                                                                            <td class="value" style="width: 30px; font-size:9px; "><p >Qty</p></td>
                                @if($eItem['cost_breakdown']['units_of_measure'])                           <td class="value" style="width: 65px; font-size:9px;"><p style="">UOM</p></td>@endif
                                @if($eItem['cost_breakdown']['material_cost'])                              <td class="value" style="width: 65px; font-size:9px;"> <p style="">Material</p> </td>@endif
                                @if($eItem['cost_breakdown']['labor_cost'])                                 <td class="value" style="width: 65px; font-size:9px;"> <p style="">Labor</p> </td> @endif
                                @if($eItem['cost_breakdown']['equipment_cost'])                             <td class="value" style="width: 65px; font-size:9px;"> <p style="">Equipment</p> </td> @endif
                                @if($eItem['cost_breakdown']['supervision_cost'])                           <td class="value" style="width: 65px; font-size:9px;"> <p style="">Supervision</p> </td> @endif
                                @if($eItem['cost_breakdown']['margin_%'])                                   <td class="value" style="width: 45px; font-size:9px;"> <p style="">Margin %</p> </td> @endif
                                @if($eItem['project_sales_tax'] AND $eItem['cost_breakdown']['sales_tax'])  <td class="value" style="width: 65px; font-size:9px;"> <p style="">Sales Tax</p> </td> @endif
                                @if($eItem['cost_breakdown']['line_item_total'])                            <td class="value" style="width: 80px; font-size:9px;padding-right:20px;"><p style="">Total</p></td>@endif
                            </tr>
                        </thead>

                        <tbody >
                        @php

                        @endphp
                        @foreach($eItem['tags'] AS $tKey => $tItem )
                            @php
                                $salesTaxAmount = number_format(($tItem['material_cost']/100) * $eItem['project_sales_tax'] ,2);
                            @endphp

                            {{--Tag Row--}}
                            <tr class="page6-finner-table-row tag " style="">
                                <td  class="" colspan="{{$colCount+2}}">
                                    <table class="area" style="width: 100%;border-collapse: collapse;">
                                        <tr style="width: 100%;"> <td class="title"><p>{{ $tItem['name'] }}</p></td> </tr>
                                        <tr style="width: 100%;">
                                            @if(!empty($tItem['annotation']))
                                                <td class="annotation" style="padding: 0 0 0 20px; font-size: 9px; font-weight: bold;"><p class="secondpara">{{ $tItem['annotation'] }}</p></td>
                                            @else
                                                <td style="padding: 0 0 0 20px; font-size: 9px; font-weight: bold; font-style: italic; ">N.A</td>
                                            @endif
                                        </tr>
                                    </table>
                                </td>
                            </tr>

                            {{--Cost Breakdown Row --}}
                            <tr class="page6-finner-table-row data " style="">
                                <td class="offset_col value" colspan="" style=""></td>
                                                                                                            <td class="value" style="width:30px;"><p>{{  !empty($tItem['selected_qty']) ? $tItem['selected_qty'] : 0}}</p></td>
                                @if($eItem['cost_breakdown']['units_of_measure'])                           <td class="value" style="width:65px;"> <p style="margin-bottom: 10px">{{    !empty($tItem['uom'])               ? $tItem['uom'] : 'N.A'}}</p></td>@endif
                                @if($eItem['cost_breakdown']['material_cost'])                              <td class="value" style="width:65px;"> <p style="margin-bottom: 10px">$ {{  !empty($tItem['material_cost'])     ? number_format($tItem['material_cost'],2) : "0.00"}}</p></td>@endif
                                @if($eItem['cost_breakdown']['labor_cost'])                                 <td class="value" style="width:65px;"> <p style="margin-bottom: 10px">$ {{  !empty($tItem['labor_cost'])        ? number_format($tItem['labor_cost'],2) : "0.00"}}</p></td> @endif
                                @if($eItem['cost_breakdown']['equipment_cost'])                             <td class="value" style="width:65px;"> <p style="margin-bottom: 10px">$ {{  !empty($tItem['equipment_cost'])    ? number_format($tItem['equipment_cost'],2) : "0.00"}}</p></td> @endif
                                @if($eItem['cost_breakdown']['supervision_cost'])                           <td class="value" style="width:65px;"> <p style="margin-bottom: 10px">$ {{  !empty($tItem['supervision_cost'])  ? number_format($tItem['supervision_cost'],2) : "0.00"}}</p> </td> @endif
                                @if($eItem['cost_breakdown']['margin_%'])                                   <td class="value" style="width:45px;"> <p style="margin-bottom: 10px">{{    !empty($tItem['margin'])            ? number_format($tItem['margin'],2) : "0.00"}}%</p></td>@endif
                                @if($eItem['project_sales_tax'] AND $eItem['cost_breakdown']['sales_tax'])  <td class="value" style="width:35px;"> <p style="margin-bottom: 10px">$ {{  !empty($eItem['project_sales_tax']) ? number_format($salesTaxAmount,2) : "0.00"}}</p></td>@endif
                                @if($eItem['cost_breakdown']['line_item_total'])                            <td class="value" style="width:80px;"> <p> $ {{ number_format((($tItem['price']+$salesTaxAmount) * $tItem['selected_qty']),2) }}</p> </td> @endif
                            </tr>
                            @php
                                $tagCounter ++;
                                if( $tItem['price'] > 0 && $tItem['selected_qty'] > 0){

                                    $estimatesTotal[$eItem['inspectionAreaId']]['materialTotal']    += $tItem['material_cost'];
                                    $estimatesTotal[$eItem['inspectionAreaId']]['laborTotal']       += $tItem['labor_cost'];
                                    $estimatesTotal[$eItem['inspectionAreaId']]['equipmentTotal']   += $tItem['equipment_cost'];
                                    $estimatesTotal[$eItem['inspectionAreaId']]['supervisionTotal'] += $tItem['supervision_cost'];
                                    $estimatesTotal[$eItem['inspectionAreaId']]['margin']           = $tItem['margin'];
                                    $estimatesTotal[$eItem['inspectionAreaId']]['salesTaxTotal']    += number_format($tItem['price']+$salesTaxAmount,2) > 0 ? number_format($tItem['price']+$salesTaxAmount,2) : 0 ;
                                    $estimatesTotal[$eItem['inspectionAreaId']]['lineItemTotal']    += ($tItem['price']* $tItem['selected_qty']);


                                    $materialTotal      += $tItem['material_cost'];
                                    $laborTotal         += $tItem['labor_cost'];
                                    $equipmentTotal     += $tItem['equipment_cost'];
                                    $supervisionTotal   += $tItem['supervision_cost'];
                                    $margin = $tItem['margin'];
                                    $salesTaxTotal += number_format($tItem['price']+$salesTaxAmount,2) > 0 ? number_format($tItem['price']+$salesTaxAmount,2) : 0 ;

                                    $subtotal  += ($tItem['price']* $tItem['selected_qty']);
                                    $grandTotal += ($tItem['price']* $tItem['selected_qty']);
                                }
                            @endphp
                        @endforeach

                        @php
                            $subTotalSummary[$eKey]['label']  = ucfirst($eItem['inspectionArea'])." Estimate Total";
                            $subTotalSummary[$eKey]['amount'] = $subtotal;
                        @endphp

                        </tbody>
                    </table>
                @endforeach

                <table class="summary" style="width:100%;">
                    <tr class="">
                        <td colspan="2" class="" style="padding-top:35px;"></td>
                    </tr>

                    <tr class="">
                        <td colspan="2" class="" style="padding-left: 10px; background-color: #e7e7e7">
                            <p class="title" style="font-size: 14px;font-weight: bold;">Estimation Summary</p>
                        </td>
                    </tr>
                    @foreach($subTotalSummary AS $sKey => $sItem )
                        <tr class="subtotals">
                            <td class="label " style="text-align: right; padding-right: 50px;">{{$sItem['label']}}</td>
                            <td class="value " ><p>${{ number_format(($sItem['amount']),2)  }}</p></td>
                        </tr>
                    @endforeach

                    <tr class="">
                        <td style="padding-top: 5px;" class=""></td>
                        <td style="padding-top: 5px;" class=""></td>
                    </tr>

                    <tr class="grand_total">
                        <td class="label" style="text-align: right; padding-right: 50px;">Estimate Grand Total</td>
                        <td class="value" >${{ number_format(($grandTotal),2)  }}</td>
                    </tr>
                </table>
            @else
                <table style="width:100%; padding:0px 50px; ">
                    <tr>
                        <td style="padding-left:50px;padding-top:4rem;">
                            <p>No Estimates</p>
                        </td>
                    </tr>
                </table>
            @endif

        </td>
    </tr>
</table>
<pagebreak/>
@php
// dd('$ownerAuthorization',$ownerAuthorization);
@endphp
@include("reports.v2.owner_authorization",['subTotals' => $estimatesTotal ])