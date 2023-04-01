<table data-image="true" style="width:100%; padding:0px 50px;">
    <tr>
        <td style="width:70%;">
            <table style="width:100%;">
                <tr>
                    <td style="padding-left:50px;padding-top: 70px;">
                        <img
                                data-url="{{ config('constants.MEDIA_IMAGE_PATH').$media['image_url']  }}"
                                data-id="{{$media['id']}}" src="{{ $media['image_url']  }}"
                                style="width:485px; height:auto" />
                    </td>
                </tr>
            </table>
        </td>
        <td style="width:30%;">
            <table>
                <tr>
                    <td style="width: 50%;padding-top: 70px;font-size:15px;padding-bottom:20px;padding-left:30px; "><strong>Area: </strong>{{$category['area']}}</td>
                </tr>
                <tr>
                    <td style="font-size:15px;padding-bottom:20px;padding-left:30px;"><strong>Photo Tag: </strong>{{$mediaTags}}</td>
                </tr>
                <tr>
                    <td style="font-size:15px;padding-bottom:20px;padding-left:30px;"><strong>Annotation: </strong>{{$media['note']}}</td>
                </tr>
                <tr>
                    <td style="font-size:15px;padding-bottom:20px;padding-left:30px;"><strong>Photo #: </strong>{{$current}} of {{$totalMedia}}</td>
                </tr>
            </table>
        </td>
    </tr>
</table>
