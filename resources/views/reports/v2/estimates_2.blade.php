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
        color: rgb(73,73,75);
    }

    .bk_border{ border: 1px solid;}
    .re_border{ border: 1px solid red;}
    .gr_border{ border: 1px solid darkgreen;}
    .bl_border{ border: 1px solid darkblue;}
    .ye_border{ border: 1px solid darkgoldenrod;}

    .container_table, .container_table > td {
        width: 100%;
    }

    .estimate_table{ margin: 0; padding: 0;}

    .estimate_table td.tag_title{
        width: 150px;
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
        color: rgb(70, 70, 72);
        margin-left: 10px ;
        letter-spacing: 2px;
    }

    .page6-finner-table-header td {
        color: rgb(70, 70, 72);
        font-size: 11px;
        font-weight: bold;
        background-color: #e7e7e7;
    }

    .page6-finner-table-header .value{
        padding: 8px 0px;
    }

    .page6-finner-table-header .tag_title{
        font-size: 14px;
        font-weight: bold;
        padding-left: 10px;
    }

    .page6-finner-table-row.data .value{
        border-bottom: solid 1px #9f9f9f;
        /*min-width: 200px;*/
        width: 70px;
        font-size: 10px;
        color: rgb(70,70,72);
        padding-bottom: 5px;
        /*border: solid 1px;*/
    }

    .page6-finner-table-row > td > .firstpara {
        margin: 1rem 0 0.25rem 1rem;
        font-size: 1.5rem;
        color: rgb(19, 19, 210);
    }
    .page6-finner-table-row > td > .secondpara{
        margin-left: 2.75rem;
        font-weight: bold;
        margin-bottom: 2rem;
        color: rgb(70,70,72);
    }

    .page6-finner-table-hrrow > td > hr{
        border-top: 3px solid #eee;
        margin: 0;
    }
    .page6-finner-table-finalrow > td >p {
        margin: 2rem 0 10rem 0;
        text-transform: uppercase;
        font-weight:  bold;
        color: rgb(70,70,72);
    }

    /** Commented On 17-Sep-22 */
    /*.subtotal_table {*/
    /*    margin-bottom: 30px;*/
    /*    width: 100%;*/
    /*    border-collapse: collapse;*/
    /*}*/

    /*.subtotal td {*/
    /*    padding-top: 5px;*/
    /*    color: #464648;*/
    /*    font-size: 11px;*/
    /*    font-weight: bold;*/
    /*}*/

    /*.subtotal .label {*/
    /*    !*text-align: right;*!*/
    /*    !*width: 10px;*!*/
    /*}*/
    /*.subtotal .value {*/
    /*    !*text-align: right;*!*/
    /*    !*border: solid 1px;*!*/
    /*    width: 70px;*/
    /*}*/
</style>

<table class="container_table" style="border-collapse: collapse;">
    <tr class="" style="padding: 0; margin: 0;">
        <td  style="padding: 0; margin: 0;">
            <?php
                $subTotalSummary = [];
                $grandTotal = 0;
                $estimatesTotal = [];
                $testHead = 'heading from estimate blade';
            ?>

            @if(!empty($estimates))
                @foreach($estimates AS $eKey  => $eItem)
                    @php
                        // pd($eItem['cost_breakdown']['project_sales_tax'],'$eItem');

                            $estimatesTotal[$eItem['inspectionAreaId']] = [];

                            $estimatesTotal[$eItem['inspectionAreaId']]['name'] = $eItem['inspectionArea'];
                            $estimatesTotal[$eItem['inspectionAreaId']]['materialTotal']    = 0;
                            $estimatesTotal[$eItem['inspectionAreaId']]['laborTotal']       = 0;
                            $estimatesTotal[$eItem['inspectionAreaId']]['equipmentTotal']   = 0;
                            $estimatesTotal[$eItem['inspectionAreaId']]['supervisionTotal'] = 0;
                            $estimatesTotal[$eItem['inspectionAreaId']]['margin']           = 0;
                            $estimatesTotal[$eItem['inspectionAreaId']]['salesTaxTotal']    = 0;
                            $estimatesTotal[$eItem['inspectionAreaId']]['lineItemTotal']    = 0;

                            $estimatesTotal[$eItem['inspectionAreaId']]['breakdown']    = $eItem['cost_breakdown'];

                            $tagCounter = 0;

                            $materialTotal = 0;
                            $laborTotal = 0;
                            $equipmentTotal = 0;
                            $supervisionTotal = 0;
                            $salesTaxTotal = 0;
                            $subtotal = 0;
                    @endphp
                    <table class="estimate_table " style="width:100%; border-collapse: collapse;">
                        <thead class="page6-finner-table-header ">
                            <tr class="header odd" style="margin: 0; padding: 0;">
                            <td class="tag_title">
                                <p > {{ucfirst($eItem['inspectionArea'])}}</p>
                            </td>
                            <td class="value" colspan="">
                                <p style="; ">Qty</p>
                            </td>
                            @if($eItem['cost_breakdown']['units_of_measure'])
                                <td class=" value" colspan="">
                                    <p style="">UOM</p>
                                </td>
                            @endif

                            @php
                                //pd($eItem['cost_breakdown'],"cost_breakdown");
                            @endphp
                            @if($eItem['cost_breakdown']['material_cost'])
                                <td class=" value" colspan="">
                                    <p style="">Material</p>
                                </td>
                            @endif

                            @if($eItem['cost_breakdown']['labor_cost'])
                                <td class=" value" colspan="">
                                    <p style="">Labor</p>
                                </td>
                            @endif


                            @if($eItem['cost_breakdown']['equipment_cost'])
                                <td class=" value" colspan="">
                                    <p style="">Equipment</p>
                                </td>
                            @endif

                            @if($eItem['cost_breakdown']['supervision_cost'])
                                <td class=" value" colspan="">
                                    <p style="">Supervision</p>
                                </td>
                            @endif

                            @if($eItem['cost_breakdown']['margin_%'])
                                <td class=" value" colspan="">
                                    <p style="">Margin %</p>
                                </td>
                            @endif


                            @if($eItem['project_sales_tax'] AND $eItem['cost_breakdown']['sales_tax'])
                                <td class=" value" colspan="">
                                    <p style="">Sales Tax</p>
                                </td>
                            @endif

{{--                            <td class=" value" colspan="">--}}
{{--                                <p style="">Price</p>--}}
{{--                            </td>--}}
                            @if($eItem['cost_breakdown']['line_item_total'])
                                <td class=" value" colspan="">
                                    <p style="">Total</p>
                                </td>
                            @endif
                        </tr>
                        </thead>
                        <tbody>
                        @php
                            // p($eItem['tags'],'tags');
                        @endphp
                        @foreach($eItem['tags'] AS $tKey => $tItem )
                            @php
                                $salesTaxAmount = number_format(($tItem['material_cost']/100) * $eItem['project_sales_tax'] ,2);
                            @endphp

                            <tr class="page6-finner-table-row tag" >
                                <td class="area" colspan="11">
                                    <table style="width: 100%;border-collapse: collapse;" class="">
                                        <tr>
                                            <td style="font-size: 11px"> <p class="firstpara">{{ $tItem['name'] }}</p></td>
                                        </tr>
                                        <tr>
                                            @if(!empty($tItem['annotation']))
                                                <td style="padding: 0 0 0 20px; font-size: 9px; font-weight: bold"><p class="secondpara">{{ $tItem['annotation'] }}</p></td>
                                            @else
                                                <td style="padding: 0 0 0 20px; font-size: 9px; font-weight: bold; font-style: italic; ">N.A</td>
                                            @endif
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr class="page6-finner-table-row data">
                                <td class="offset_col value" style="width: 10px;">

                                </td>
                                <td class=" value">
                                    <p>{{  !empty($tItem['selected_qty']) ? $tItem['selected_qty'] : 0}}</p>
                                </td>

                                @if($eItem['cost_breakdown']['Units_Of_Measure'])
                                    <td class=" value" colspan="">
                                        <p style="margin-bottom: 10px">{{  !empty($tItem['uom']) ? $tItem['uom'] : 'N.A'}}</p>
                                    </td>
                                @endif

                                @if($eItem['cost_breakdown']['material_cost'])
                                    <td class=" value" colspan="">
                                        <p style="margin-bottom: 10px">${{  !empty($tItem['material_cost']) ? $tItem['material_cost'] : 0}}</p>
                                    </td>
                                @endif

                                @if($eItem['cost_breakdown']['labor_cost'])
                                    <td class=" value" colspan="">
                                        <p style="margin-bottom: 10px">${{  !empty($tItem['labor_cost']) ? $tItem['labor_cost'] : 0}}</p>
                                    </td>
                                @endif

                                @if($eItem['cost_breakdown']['equipment_cost'])
                                    <td class=" value" colspan="">
                                        <p style="margin-bottom: 10px">${{  !empty($tItem['equipment_cost']) ? $tItem['equipment_cost'] : 0}}</p>
                                    </td>
                                @endif

                                @if($eItem['cost_breakdown']['supervision_cost'])
                                    <td class=" value" colspan="">
                                        <p style="margin-bottom: 10px">${{  !empty($tItem['supervision_cost']) ? $tItem['supervision_cost'] : 0}}</p>
                                    </td>
                                @endif

                                @if($eItem['cost_breakdown']['margin_%'])
                                    <td class=" value" colspan="">
                                        <p style="margin-bottom: 10px">{{  !empty($tItem['margin']) ? $tItem['margin'] : 0}}</p>
                                    </td>
                                @endif

                                @if($eItem['project_sales_tax'] AND $eItem['cost_breakdown']['sales_tax'])
                                    <td class=" value" colspan="">
                                        <p style="margin-bottom: 10px">${{  !empty($eItem['project_sales_tax']) ? $salesTaxAmount : 0}} </p>
                                    </td>
                                @endif
{{--                                <td class=" value">--}}
{{--                                    <p>${{ !empty($tItem['price']) ? number_format($tItem['price']+$salesTaxAmount,2)  : number_format(0,2)   }}</p>--}}
{{--                                </td>--}}
                                @if($eItem['cost_breakdown']['line_item_total'])
                                    <td class=" value">
                                        <p>
                                            ${{ number_format((($tItem['price']+$salesTaxAmount) * $tItem['selected_qty']),2)  }}</p>
                                    </td>
                                @endif
                            </tr>
                            @php
                                $tagCounter ++;
                                if( $tItem['price'] > 0 && $tItem['selected_qty'] > 0){

                                    $estimatesTotal[$eItem['inspectionAreaId']]['materialTotal']    += $tItem['material_cost'];
                                    $estimatesTotal[$eItem['inspectionAreaId']]['laborTotal']       += $tItem['labor_cost'];
                                    $estimatesTotal[$eItem['inspectionAreaId']]['equipmentTotal']   += $tItem['equipment_cost'];
                                    $estimatesTotal[$eItem['inspectionAreaId']]['supervisionTotal'] += $tItem['supervision_cost'];
                                    $estimatesTotal[$eItem['inspectionAreaId']]['margin'] = $tItem['margin'];
                                    $estimatesTotal[$eItem['inspectionAreaId']]['salesTaxTotal']    += number_format($tItem['price']+$salesTaxAmount,2) > 0 ? number_format($tItem['price']+$salesTaxAmount,2) : 0 ;
                                    $estimatesTotal[$eItem['inspectionAreaId']]['lineItemTotal']    += ($tItem['price']* $tItem['selected_qty']);

                                    $materialTotal      += $tItem['material_cost'];
                                    $laborTotal         += $tItem['labor_cost'];
                                    $equipmentTotal     += $tItem['equipment_cost'];
                                    $supervisionTotal += $tItem['supervision_cost'];
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
                        {{--                        <tr class="subtotal" >--}}
                        {{--                            <td style="border: solid 1px;">--}}
                        {{--                               --}}
                        {{--                            </td>--}}
                        {{--                        </tr>--}}
                        </tbody>
                    </table>
                    <table class="subtotal_table" style="border-collapse: collapse;">
                        <tbody>
                        <tr class="subtotal">
                            <td class="label" colspan="2" style="">{{ucfirst($eItem['inspectionArea'])}} Estimate Total </td>
                            <td class="value">${{ number_format(($materialTotal),2)  }}</td>
                            <td class="value">${{ number_format(($laborTotal),2)  }}</td>
                            <td class="value">${{ number_format(($equipmentTotal),2)  }}</td>
                            <td class="value">${{ number_format(($supervisionTotal),2)  }}</td>
                            <td class="value">${{ $margin  }}</td>
                            <td class="value">{{ number_format(($salesTaxTotal),2)  }}</td>
                            <td class="value">${{ number_format(($subtotal),2)  }}</td>
                        </tr>
                        </tbody>
                    </table>
                @endforeach

                <table class="summary" style="width:100%;display:none;" >

                    @foreach($subTotalSummary AS $sKey => $sItem )
                        <tr class="subtotals">
                            <td class="label" style="text-align: right; padding-right: 50px;">{{$sItem['label']}}</td>
                            <td class="value">${{ number_format(($sItem['amount']),2)  }}</td>
                        </tr>
                    @endforeach

                    <tr class="">
                        <td style="padding-top: 5px;" class=""></td>
                        <td style="padding-top: 5px;" class=""></td>
                    </tr>

                    <tr class="grand_total">
                        <td class="label" style="text-align: right; padding-right: 50px;">Estimate Grand Total</td>
                        <td class="value">${{ number_format(($grandTotal),2)  }}</td>
                    </tr>
                </table>
            @else
                <table style="width:100%; padding:0px 50px; ">
                    <tr>
                        <td style="padding-left:50px;padding-top: 70px;">
                            <p>No Estimates</p>
                        </td>
                    </tr>
                </table>
            @endif

        </td>
    </tr>
</table>
@include("reports.v2.owner_authorization",['subTotals' => $estimatesTotal])






