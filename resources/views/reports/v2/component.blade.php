<style>
    .bk_border{ border: 1px solid;}
    .re_border{ border: 1px solid red;}
    .gr_border{ border: 1px solid darkgreen;}
    .bl_border{ border: 1px solid darkblue;}
    .ye_border{ border: 1px solid darkgoldenrod;}

    .bk_bg{ background-color: #777777;}
    .re_bg{ background-color: red;}
    .gr_bg{ background-color: darkgreen;}
    .bl_bg{ background-color: darkblue;}
    .ye_bg{ background-color: darkgoldenrod;}

    .query  {
        padding-left: 80px;

    }
    .response  {
        padding-right: 80px;

    }

    .tag-table{
        width: 100%;
        padding: 0px 30px 20px 30px;
        color: {{$companyDetails->secondary_color}};
    }
    .tag-table .category-label th{
        text-align: left;

    }
    .tag .name{
        /*border: 1px solid;*/
        width:65%;

        /*padding-left:40px;*/
    }

    .tag .value{
        text-align: right;
    }
</style>

{{--<table style="width:100%;padding:2rem 50px 0px 50px ;">--}}
{{--    <tr style="width:100%;">--}}
{{--        <td style="width:30%;"></td>--}}
{{--        <td style="width:40%;"><h1 style="text-align:center;color: {{$companyDetails->secondary_color}};">Component List</h1></td>--}}
{{--        <td style="width:30%;"></td>--}}
{{--    </tr>--}}
{{--</table>--}}

@foreach($categories AS $key => $item)

    @if(!empty($categories[$key]['category_name'])
        && (   $categories[$key]['media_tags'] == 't' )
        )

        <table class="" style="width:100%;">
            <tr>
                <td>
                    <h3 style="padding-bottom: 5px;padding-top:5px;color: {{$companyDetails->secondary_color}};">{{$categories[$key]['category_name']}}</h3>
                </td>
            </tr>
        </table>
    @else
        {{--<table style="padding:0px 50px;">--}}
        {{--<tr>--}}
        {{--<th>--}}
        {{--<h3 style="padding-bottom: 5px;">Else {{ '32222-' . $categories[$key]['media_tags'] }} </h3>--}}
        {{--</th>--}}
        {{--</tr>--}}
        {{--</table>--}}
    @endif

    <table class="tag-table">
        @if(!empty($categories[$key]['media']))
            {{--
                Main Cat Media
            --}}
            @foreach($categories[$key]['media'] AS $mainMediaKey => $mediaItem)
                @if(!empty($categories[$key]['media'][$mainMediaKey]['media_tags_extended'])  )

                    @foreach($categories[$key]['media'][$mainMediaKey]['media_tags_extended'] AS $tagKey => $tagItem)
                        <tr class="tag ">
                            <td class="name " style="">
                                {{  $categories[$key]['media'][$mainMediaKey]['media_tags_extended'][$tagKey]['name']}}
                            </td>
                            <td class="value " style="">
                                {{ ($categories[$key]['media'][$mainMediaKey]['media_tags_extended'][$tagKey]['has_qty'] > 0 ) ?
                                $categories[$key]['media'][$mainMediaKey]['media_tags_extended'][$tagKey]['selected_qty'] : ''}}
                            </td>
                        </tr>
                    @endforeach
                @else
                    @if($mainMediaKey == 0)
                        {{--<tr>--}}
                        {{--<td style="width:50%;padding-left:40px;font-size:18px;">No Component</td>--}}
                        {{--<td style="width:50%;padding-left:50px;font-size:18px;">0</td>--}}
                        {{--</tr>--}}
                    @endif
                @endif

            @endforeach
        @endif
    </table>

    <table class="tag-table">
        @if(!empty($categories[$key]['get_child']) )
            @foreach($categories[$key]['get_child'] AS $childKey => $childItem)
                @if(
                    !empty($categories[$key]['get_child'][$childKey]['name'])
                    && ($categories[$key]['media_tags'] == 't' && $categories[$key]['get_child'][$childKey]['media_tags'] == 't')
                )
{{--                    <tr class="category-label">--}}
{{--                        <th>--}}
{{--                            <h3 style="/*padding-left:5px;*/ padding-bottom: 5px;">{{ $categories[$key]['get_child'][$childKey]['name'] }}</h3>--}}
{{--                        </th>--}}
{{--                    </tr>--}}
                @endif

                @if(!empty($categories[$key]['get_child'][$childKey]['media']))
                    @foreach($categories[$key]['get_child'][$childKey]['media'] AS $subMediaKey => $mediaItem)
                        @if(
                            !empty($categories[$key]['get_child'][$childKey]['media'][$subMediaKey]['media_tags_extended'])
                                && $categories[$key]['media_tags'] == 't'
                            )
                            @foreach($categories[$key]['get_child'][$childKey]['media'][$subMediaKey]['media_tags_extended'] AS $tagKey => $tagItem)
                                <tr class="tag ">
                                    <td class="name" style="">{{ $categories[$key]['get_child'][$childKey]['media'][$subMediaKey]['media_tags_extended'][$tagKey]['name']}}</td>
{{--                                    @php--}}
{{--                                    p($categories[$key]['get_child'][$childKey]['media'][$subMediaKey]['media_tags_extended'][$tagKey]);--}}
{{--                                            @endphp--}}
                                    <td class="value">{{ ($categories[$key]['get_child'][$childKey]['media'][$subMediaKey]['media_tags_extended'][$tagKey]['has_qty'] > 0 ) ?
                                    $categories[$key]['get_child'][$childKey]['media'][$subMediaKey]['media_tags_extended'][$tagKey]['selected_qty'] : ''}}</td>
                                </tr>
                            @endforeach
{{--                            @php die("end;") @endphp--}}
                        @else
                            @if($subMediaKey == 0)
                                {{--<tr>--}}
                                {{--<td style="width:50%;padding-left:40px;font-size:18px;">No Component2</td>--}}
                                {{--<td style="width:50%;padding-left:50px;font-size:18px;">0</td>--}}
                                {{--</tr>--}}
                            @endif
                        @endif
                    @endforeach
                @endif

                {{--@endif--}}


            @endforeach
        @endif
    </table>
@endforeach




