
<table style="width:100%; padding:25px 50px;">
    <tr style="width:100%;">
        <td><h1 style="font-family: 'myFirstFont';">{{$title}}:</h1></td>
    </tr>
</table>
<table style="width:100%; margin-left:60px;margin-top:20px; padding:0px 50px;">
    @php
        $count = 0;
    @endphp
    @if(!empty($categories))
        @foreach($categories AS $key => $item)
            @if($count == 0)
                <tr>
                    @endif
                    <td style="width:20%;padding-left:10px;">
                        @if( in_array($item['id'] ,$selectedCategories)  )
                            <img style="width:10px;height: auto;" src="{{base_path('public/assets/images/radio_on.png')}}"/>
                        @else
                            <img style="width:10px;height: auto;"  src="{{base_path('public/assets/images/radio.png')}}"/>
                        @endif

                        {{--<input type="radio"
                               name="select_{{$item['id']}}" {{(in_array($item['id'] ,$selectedCategories)) ?  'checked="checked"':'' }}>--}}
                        {{$item['category_name']}}
                    </td>
                <?php
                $count++;
                if ($count == 3) {
                    echo "</tr>";
                    $count = 0;
                }
                ?>
                {{--@if($count == 3)--}}
                {{--</tr>--}}
                {{--@endif--}}
                @endforeach
            @endif
</table>

{{--<table style="padding:0px 50px;">--}}
    {{--<tr>--}}
        {{--<td style="padding: 50px 0px 20px 0px;">--}}
            {{--<img style="/*width:700px; height:auto;*/"--}}
                 {{--src="{{ $map }}"></td>--}}
    {{--</tr>--}}
{{--</table>--}}


