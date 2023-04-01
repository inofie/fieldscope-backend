<style>
    /*.page3-header-fcol > p {*/
    /*    font-size: 2.5rem;*/
    /*    text-transform: uppercase;*/
    /*    margin-left: 10rem;*/
    /*    line-height: 0.5;*/
    /*    color: rgb(73,73,75);*/
    /*}*/
    /*.page3-header-fcol {*/
    /*    position: relative;*/
    /*}*/
    /*.page3-header-fcol .page3-head-dynamic-text{*/
    /*    margin: 2rem 0 0 10rem;*/
    /*}*/
    /*.page3-head-dynamic-text::before {*/
    /*    content: "03";*/
    /*    left: 16.25%;*/
    /*    top: 77%;*/
    /*    position: absolute;*/
    /*    color: rgb(73,73,75);*/
    /*}*/
    /*.page3-head-dynamic-text::after {*/
    /*    content: "";*/
    /*    left: -11%;*/
    /*    top: 80%;*/
    /*    height: 3px;*/
    /*    width: 26%;*/
    /*    background: rgb(138,186,43);*/
    /*    position: absolute;*/
    /*}*/
    /*.page3-header-scol > img {*/
    /*    width: 480px;*/
    /*    height: 120px;*/
    /*    margin: 4rem 0 0 0;*/
    /*}*/
    table {
        margin: auto;
    }
    tbody > tr > td  > img {
        width: 500px;
        height: 600px;
/*         margin: 8rem 3rem 1rem 3rem; */
    }
    .page3-tbody-data{
        padding: 10px 10px 10px 40px;
        width: 49%;
       text-align: right;
      font-size: 28px;
      color: rgb(162,162,163);
    }
    .page3-tbody-data > p {
        text-align: right;
        margin-right: 4rem;
        font-size: 18px;
        color: rgb(73,73,75);

    }
    .page3-footer-heading > p {
        color: rgb(88,90,90);
        font-size: 3rem;
        font-weight: bold;
        margin: 5rem 0 1rem 2rem;
    }
    /*.page3-footer-text > p {*/
    /*    color: rgb(88,90,90);*/
    /*    font-size: 2rem;*/
    /*    line-height: 1.125;*/
    /*    margin-left: 2rem;*/
    /*}*/
    /*.page3-footer-text {*/
    /*    margin-top: 1rem;*/
    /*}*/
    /*.page3-footer-text .page3-footertext-floatleft {*/
    /*    width: 21%;*/
    /*    line-height: 1.125;*/
    /*    display: block;*/
    /*    float: left;*/
    /*    margin-right: 5rem;*/
    /*}*/
    /*.page3-footer-text > h1 {*/
    /*    color: rgb(88,90,90);*/
    /*    font-size: 3rem;*/
    /*    font-weight: bold;*/
    /*    margin: 5rem 0 1.5rem 2rem;*/
    /*}*/
    hr {
        margin: 0 auto;
        border-top: 5px solid rgb(176,210,76);
        width: 96%;
        margin-left: 2rem;
        margin-top: 1rem;
    }

</style>
<table class="images" style="padding-top: 2rem;">
    <tbody>
    @php
        $mediaCount = 1;
        $subMediaCount = 1;
    @endphp
    @foreach($category AS $catKey => $catItem)

        @if(!empty($catItem['media']))
            @foreach($catItem['media'] AS $mediaKey => $mediaItem)
                {{--@if( (2 % 2) > 0 )--}}
                @if( ($mediaCount % 2) > 0 )
                    {{--If odd open TR--}}
                    <tr>
                        @endif

                        <td class="page3-tbody-data" >

                            <img data-url="{{ config('constants.MEDIA_IMAGE_PATH').$mediaItem['image_url']  }}"
                                 data-id="{{$mediaItem['id']}}" src="{{ $mediaItem['image_url']  }}"
                               
                                 />
                            <p>Photo: {{($mediaKey+1). ' of '.$catItem['media_count']}}</p>
                        </td>

                        @if( ($mediaCount % 2) <= 0 )
                            {{--If odd open TR--}}
                    </tr>
                @endif

                @php
                    $mediaCount++;
                @endphp

            @endforeach {{--Media Loop End--}}
        @endif {{--IF Media Exists End--}}

        @if(!empty($catItem['get_child']))

            @foreach($catItem['get_child'] AS $subCatKey => $subCatItem)

                @if(!empty($subCatItem['media']))
                    @foreach($subCatItem['media'] AS $mediaKey => $mediaItem)
                        {{--@if( (2 % 2) > 0 )--}}
                        @if( ($subMediaCount % 2) > 0 )
                            {{--If odd open TR--}}
                            <tr>
                                @endif

                                {{--Image Cell--}}
                                <td class="page3-tbody-data" >
{{--                                    <p>{{$catItem['category_name']}}</p>--}}
                                    <img class="media"
                                     
                                         data-url="{{ config('constants.MEDIA_IMAGE_PATH').$mediaItem['image_url']  }}"
                                         data-id="{{$mediaItem['id']}}" src="{{ $mediaItem['image_url']  }}" />

                                    <p>Photo: {{($mediaKey+1). ' of '.$subCatItem['media_count']}}</p>
                                </td>

                                @if( ($subMediaCount % 2) <= 0 )
                                    {{--If odd open TR--}}
                            </tr>
                        @endif
                        @php
                            $subMediaCount++;
                        @endphp

                    @endforeach {{-- Sub Media Loop End--}}
                @endif {{--IF Sub Media Exists End--}}

            @endforeach {{--Sub Cat Loop End--}}
        @endif {{--If Sub cat exists end--}}

    @endforeach {{--Main Cat Loop End--}}


{{--        <td class="page3-tbody-data">--}}
{{--            <img src="{{asset('assets/images/pdf-03-img.png')}}" alt="body-image" >--}}
{{--            <p>Photo 2 of 4</p>--}}
{{--        </td>--}}
{{--    </tr>--}}
{{--                    --}}
{{--                    --}}
{{--                    --}}
{{--    <tr>--}}
{{--        <td class="page3-tbody-data">--}}
{{--            <img src="{{asset('assets/images/pdf-03-img.png')}}" alt="body-image" >--}}
{{--            <p>Photo 3 of 4</p>--}}
{{--        </td>--}}
{{--        <td class="page3-tbody-data">--}}
{{--            <img src="{{asset('assets/images/pdf-03-img.png')}}" alt="body-image" >--}}
{{--            <p>Photo 4 of 4</p>--}}
{{--        </td>--}}
{{--    </tr>--}}
    </tbody>
</table>

