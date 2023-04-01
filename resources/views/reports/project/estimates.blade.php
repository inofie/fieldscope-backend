<table style="width:100%;/*padding:0px 50px 0px 50px ; */">
    <tr>
        <td style="padding: 10px 50px 10px 50px; color: #00ade6; ">
            <h2>Estimate Details </h2>
        </td>
    </tr>
</table>

<style>
    .container_table {
        width: 100%;
        padding-left: 50px;
        padding-right: 50px;
        /*border: solid 1px;*/
    }

    .estimate_table {

    }

    .estimate_table .header td {
        font-weight: bold;
    }

    .estimate_table, .estimate_table td {
        /*border: solid 1px;*/

    }

    .estimate_table .area {
        width: 50%;
    }

    .estimate_table .area .annotation {
        border: solid 2px;
    }

    .estimate_table td {
        padding: 3px 5px;
    }

    .estimate_table .odd td {
        background-color: #d2d2d2;
    }

    .estimate_table .even td {
        background-color: #ebebeb;
    }

    .estimate_table tbody .value,
    .estimate_table .header .value,
    .estimate_table .subtotal .value {
        text-align: right;
    }

    .estimate_table thead {
        text-align: left;
    }

    .summary {
        border-collapse: collapse;
    }

    .summary .grand_total {
        background-color: #00ade6;
    }

    .summary .grand_total .label,
    .summary .grand_total .value {
        font-size: 18px;
        margin-top: 10px;
        color: #ffffff;
    }


    .summary .subtotals {
        /*background-color: white;*/

    }

    .summary .subtotals .label,
    .summary .subtotals .value {
        font-size: 12px;
        color: #00ade6;
    }

    .summary .label,
    .summary .value {
        text-align: right;
    }

    .subtotal_table {
        margin-bottom: 30px;
        width: 100%;
    }

    .subtotal td {
        padding-top: 5px;
        color: #00ade6;
    }

    .subtotal .label {
        text-align: right;
    }
    .subtotal .value {
        text-align: right;
    }
</style>


<table class="container_table">

    <tr>
        <td>

            @if(!empty($estimates))
                @php
                    $subTotalSummary = [];
                    $grandTotal = 0;
                @endphp
                @foreach($estimates AS $eKey  => $eItem)
                    @php
                     // pd($eItem['cost_breakdown']['project_sales_tax'],'$eItem');
                        $tagCounter = 0;

                        $materialTotal = 0;
                        $laborTotal = 0;
                        $equipmentTotal = 0;
                        $supervisionTotal = 0;
                        $salesTaxTotal = 0;
                        $subtotal = 0;

                    @endphp
                    <table class="estimate_table" style="width:100%; border-collapse: collapse;">
                        <tr class="header odd">
                            <td class=" " colspan="">
                                <h4 style="margin-bottom: 10px">{{ucfirst($eItem['inspectionArea'])}}</h4>
                            </td>
                            <td class=" value" colspan="">
                                <h4 style="margin-bottom: 10px">Qty</h4>
                            </td>
                            @if($eItem['cost_breakdown']['uom'])
                            <td class=" value" colspan="">
                                <h4 style="margin-bottom: 10px">UOM</h4>
                            </td>
                            @endif

                            @php
                                //pd($eItem['cost_breakdown'],"cost_breakdown");
                                    @endphp
                            @if($eItem['cost_breakdown']['material_cost'])
                                <td class=" value" colspan="">
                                    <h4 style="margin-bottom: 10px">Material</h4>
                                </td>
                            @endif

                            @if($eItem['cost_breakdown']['labor_cost'])
                                <td class=" value" colspan="">
                                    <h4 style="margin-bottom: 10px">Labor</h4>
                                </td>
                            @endif


                            @if($eItem['cost_breakdown']['equipment_cost'])
                            <td class=" value" colspan="">
                                <h4 style="margin-bottom: 10px">Equipment</h4>
                            </td>
                            @endif

                            @if($eItem['cost_breakdown']['supervision_cost'])
                            <td class=" value" colspan="">
                                <h4 style="margin-bottom: 10px">Supervision</h4>
                            </td>
                            @endif

                            @if($eItem['cost_breakdown']['margin'])
                            <td class=" value" colspan="">
                                <h4 style="margin-bottom: 10px">Margin %</h4>
                            </td>
                            @endif


                            @if($eItem['project_sales_tax'])
                            <td class=" value" colspan="">
                                <h4 style="margin-bottom: 10px">Sales Tax</h4>
                            </td>
                            @endif

                            <td class=" value" colspan="">
                                <h4 style="margin-bottom: 10px">Price</h4>
                            </td>
                            <td class=" value" colspan="">
                                <h4 style="margin-bottom: 10px">Total</h4>
                            </td>
                        </tr>

                        <tbody>
                        @php
                         // p($eItem['tags'],'tags');
                        @endphp
                        @foreach($eItem['tags'] AS $tKey => $tItem )
                            @php
                            $salesTaxAmount = number_format(($tItem['material_cost']/100) * $eItem['project_sales_tax'] ,2);

                            @endphp
                            @if((($tagCounter) % 2 ) > 0 )
                                @php
                                    $class = 'odd';
                                @endphp
                            @else
                                @php
                                    $class = 'even';
                                @endphp
                            @endif
                            <tr class="data {{$class}}" >
                                <td class="area" >
                                    <table style="border-collapse: collapse;">
                                        <tr>
                                            <td style="font-size: 11px">{{ $tItem['name'] }}</td>
                                        </tr>
                                        <tr>
                                            @if(!empty($tItem['annotation']))
                                                <td style="padding: 0 0 0 20px; font-size: 9px; font-weight: bold">{{ $tItem['annotation'] }}</td>
                                            @else
                                                <td style="padding: 0 0 0 20px; font-size: 9px; font-weight: bold; font-style: italic; ">N.A</td>
                                            @endif
                                        </tr>
                                    </table>
                                </td>

                            <td class=" value">
                                    {{  !empty($tItem['selected_qty']) ? $tItem['selected_qty'] : 0}}
                                </td>

                                @if($eItem['cost_breakdown']['uom'])
                                <td class=" value" colspan="">
                                    <h4 style="margin-bottom: 10px">{{  !empty($tItem['uom']) ? $tItem['uom'] : 'N.A'}}</h4>
                                </td>
                                @endif

                                @if($eItem['cost_breakdown']['material_cost'])
                                <td class=" value" colspan="">
                                    <h4 style="margin-bottom: 10px">{{  !empty($tItem['material_cost']) ? $tItem['material_cost'] : 0}}</h4>
                                </td>
                                @endif

                                @if($eItem['cost_breakdown']['labor_cost'])
                                <td class=" value" colspan="">
                                    <h4 style="margin-bottom: 10px">{{  !empty($tItem['labor_cost']) ? $tItem['labor_cost'] : 0}}</h4>
                                </td>
                                @endif

                                @if($eItem['cost_breakdown']['equipment_cost'])
                                <td class=" value" colspan="">
                                    <h4 style="margin-bottom: 10px">{{  !empty($tItem['equipment_cost']) ? $tItem['equipment_cost'] : 0}}</h4>
                                </td>
                                @endif

                                @if($eItem['cost_breakdown']['supervision_cost'])
                                <td class=" value" colspan="">
                                    <h4 style="margin-bottom: 10px">{{  !empty($tItem['supervision_cost']) ? $tItem['supervision_cost'] : 0}}</h4>
                                </td>
                                @endif

                                @if($eItem['cost_breakdown']['margin'])
                                <td class=" value" colspan="">
                                    <h4 style="margin-bottom: 10px">{{  !empty($tItem['margin']) ? $tItem['margin'] : 0}}</h4>
                                </td>
                                @endif

                                @if($eItem['project_sales_tax'])
                                <td class=" value" colspan="">
                                    <h4 style="margin-bottom: 10px">{{  !empty($eItem['project_sales_tax']) ? $salesTaxAmount : 0}} </h4>
                                </td>
                                @endif

                                <td class=" value">
                                    ${{ !empty($tItem['price']) ? number_format($tItem['price']+$salesTaxAmount,2)  : number_format(0,2)   }}
                                </td>

                                <td class=" value">
                                    ${{ number_format((($tItem['price']+$salesTaxAmount) * $tItem['selected_qty']),2)  }}
                                </td>
                            </tr>
                            @php
                                $tagCounter ++;
                                if( $tItem['price'] > 0 && $tItem['selected_qty'] > 0){
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
                    <table class="subtotal_table" style="/*border: solid 1px;*/ ">
                        <tbody>
                        <tr class="subtotal">
                            <td class="label" colspan="" style="">{{ucfirst($eItem['inspectionArea'])}} Estimate Total </td>
                            <td class="value">${{ number_format(($subtotal),2)  }}</td>
                        </tr>
                        </tbody>
                    </table>
                @endforeach

                <table class="summary" style="width:100%;">

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




