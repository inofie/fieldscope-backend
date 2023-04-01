<table style="width:100%;/*padding:0px 50px 0px 50px ; */">
    <tr>
        <td style="padding: 50px 0px 50px 0px; text-align: center">
            <h2 >Inspection Details: {{$category_name}}</h2>
        </td>
    </tr>
</table>

<style>
    .query  {
        padding-left: 80px;

    }
    .response  {
        padding-right: 80px;
    }

    .query-table tr{
        border: 1px solid;
    }
    .query-table .query{
        /*border: 1px solid;*/
        width: 70%;
    }
    .query-table .response{
        /*border: 1px solid;*/
        width: 30%;
    }
</style>


@if(!empty($survey))
    @foreach($survey AS $sKey => $sItem)
        <table class="query-table" style="width:100%; /*padding:0px 50px;*/ ">
            <tr style="border: 1px solid">
                <td class=" query" >
                    <h4 style="margin-bottom: 10px">{{$sItem['query']}}</h4>
                </td>


                @if($sItem['type'] == 'text' || $sItem['type'] == 'date')
                    <td  class="response  " >{{ $sItem['response'] }}</td>
                @elseif($sItem['type'] == 'sign' )
                    <td class="response " >
                        <img style="width: 200px; border: #808080 solid 1px;" src="{{ $sItem['user_response'] }}">
                    </td>
                @else
                    @if(!empty($sItem['options']))
                        <td class="response ">
                            <p>
                                @php $selectedOps = []; @endphp
                                @foreach($sItem['options'] AS $opKey => $opItem)
                                    @if($opItem['is_selected'])
                                        @php
                                            $selectedOps[] = $opItem['title'];
                                        @endphp
                                        {{--@if(!$loop->last)
                                            {{$opItem['title'].", "}}
                                            @else
                                            {{$opItem['title']}}
                                        @endif
                                        <td style="width:50%;">
                                        <p>{{(!empty($opItem['is_selected'])) ? 'Selected': ''}}</p>
                                        </td>--}}
                                    @endif
                                @endforeach
                                @php
                                    echo implode(', ',$selectedOps);
                                @endphp
                            </p>
                        </td>
                    @elseif($sItem['response'])
                        {{--ELSE Block--}}
                        <td class="response "><p>{{$sItem['response']}}</p></td>
                    @endif

                @endif
            </tr>

        </table>


    @endforeach
    @else
        <table style="width:100%; padding:0px 50px; ">
            <tr>
                <td style="padding-left:50px;padding-top: 70px;">
                    <p>No Survey</p>
                </td>
            </tr>
        </table>
    @endif


