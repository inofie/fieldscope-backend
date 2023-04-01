<style>
    .images {
        width: 100%;
        padding: 0px 50px;
    }

    .images tbody td {
        padding-top: 25px ;
        text-align: center;
    }

    .images tbody td:nth-child(odd){
        padding-right: 10px;
    }

    .images td .media_num {
        /*padding-top: 500px;*/
    }

    .media {
        width: 50%;
        height: auto;
        max-height: 293px;

    }
</style>

<table class="images" data-image="true" style="">
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

                        <td style="">
                            <img class="media"
                                 data-url="{{ config('constants.MEDIA_IMAGE_PATH').$mediaItem['image_url']  }}"
                                 data-id="{{$mediaItem['id']}}" src="{{ $mediaItem['image_url']  }}"/>
                            <div class="media_num" >
                                <br>
                                Photo #: {{($mediaKey+1). ' of '.$catItem['media_count']}}
                            </div>
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
                                <td>
                                    <img class="media"
                                         data-url="{{ config('constants.MEDIA_IMAGE_PATH').$mediaItem['image_url']  }}"
                                         data-id="{{$mediaItem['id']}}" src="{{ $mediaItem['image_url']  }}"/>

                                    <div class="media_num">
                                        <br>
                                        Photo #: {{($mediaKey+1). ' of '.$subCatItem['media_count']}}

                                    </div>
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
    </tbody>
</table>








