@extends('subadmin.master')

@push('page_level_css')

@endpush

@section('content')
{{--    {{dd($data->toArray())}}--}}
    <style>
        .select2-container {
            width: 100% !important;
        }

        .select2-container--default .select2-search--inline .select2-search__field {
            width: 100% !important;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            border-radius: 13px;
            color: white;
            background-color: #00aee7;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
            color: white;
        }

/*         .canvas_container{
            overflow: scroll;
            width: 1080px;
            height: 600px;
        } */

        /** Range Slider Css */
        .slidecontainer {
            width: 100%;
        }

        .slider {
            -webkit-appearance: none;
            width: 100%;
            height: 10px;
            background: #d3d3d3;
            outline: none;
            opacity: 0.7;
            -webkit-transition: .2s;
            transition: opacity .2s;
            padding: 0px;
            border-radius: 10px;
            /* padding: 0px 7px; */
            margin-top: 5px;
        }

        .slider:hover {
            opacity: 1;
        }

        .slider::-webkit-slider-thumb {
            -webkit-appearance: none;
            appearance: none;
            width: 20px;
            height: 20px;
            background: #00aee7;
            cursor: pointer;
        }

        .slider::-moz-range-thumb {
            width: 20px;
            height: 20px;
            background: #00aee7;
            cursor: pointer;
        }
        .d-none {
            display:none;
            width: fit-content;
            background: #ECECEA;
            padding: 10px;
            margin-bottom: 10px;
            margin-left: -1px;
        }
        .d-none-sepcial {
            display: none;
        }
        .toolbar-btn {
            display: inline-block;
            background: #ffffff;
            border-radius: 6px;
        }
        .p-custom-1 {
            padding: 12px;
            margin-top: 6px;
            margin-left: 5px;
        }
        .p-custom-2 {
            padding: 10px;
        }
        .btn-customize-pencil {
            font-size: 14px;
            margin-right: 10px;
        }
        .btn-customize-color {
            font-size: 14px;
            margin-right: 10px;
            margin-top: 4px;
        }
        .custom-input {
            border: 1px solid #ccc;
        }
        .margin-custom-ls{
            margin-right: 10px;
        }
        .custom-btn-toolbar {
            background: #EFEFEF;
            width: fit-content;
            margin-left: 0px;
        }
        .p-custom {
            padding: 5px;
        }
        .btn-inside-style {
            background: #ffff;
            border-radius: 5px !important;
            margin-right: 10px !important;
        }
        .size-custom {
            font-size: 16px;
        }
        :root {
        --background-color: #F06292;
        --cell-color: #F48FB1;
        --cell-color-hover: rgba(255, 255, 255, .3);
        --emoji-size: 20px;
        --column-number: 5;
        --transition: .3s;
        }

        .grid {
        display: grid;
        position: relative;
        width: 30%;
        grid-template-columns: repeat(var(--column-number), 1fr);
        background: #EFEFEF;
        margin-bottom: 41px
        }

        .grid > div {
        position: relative;
        height: 0;
        overflow: hidden;
        text-align: center;
        padding-bottom: 90%;
        transition: var(--transition);
        border-radius: 0px;
        cursor: pointer;
        }

        .emoji {
        position: absolute;
        font-size: var(--emoji-size);
        top: 8%;
        left: 8%;
        }
        .grid::before     
        {
            content: "";
            background: #EFEFEF;
            position: absolute;

            height: 40px;
            width: 40px;
            right: 0;
            top: 100%;
            border-radius: 0px 0px 100px 0px;
        }
        #pencil {
            margin-bottom: 5px;
        }
        .emoji-grid-div {
            display: none;
        }
        .emoji-dims {
            width: 50px;
            height: 50px;
            object-fit: contain;
        }
        .toolbarbefore {
            position: relative;
            margin-bottom: 40px;
            transition: all 1s ease-in;
        }
        .toolbarbefore::before {
            /*content: "";*/
            /*background: #EFEFEF;*/
            /*position: absolute;*/
            /*height: 40px;*/
            /*width: 40px;*/
            /*left: 5%;*/
            /*top: 98.5%;*/
            /*border-radius: 0px 0px 100px 0px;*/
        }
      .img-box-area {
    padding: 24px 24px 80px;
    border-radius: 24px;
    background-color: #161617;
    max-width: 1280px;
    position: relative;
}

.img-box-area .img-box {}

.img-box-area .img-box img {
    display: block;
    
}

.img-box-area button#openEditor {
   position: absolute;
    bottom: -50px;
    background: transparent;
    color: #fff;
    border: 2px solid #5bc0de;
    display: flex;
    height: 40px;
    padding: 0 24px;
    align-items: center;
    justify-content: center;
    border-radius: 30px;
    transition: all .5s ease;
}
      .img-box-area button#openEditor:hover {
    background: #5bc0de;
}
      .img-box-area .canvas-container {
    display: block;
    margin: 0 auto;
}
      .btn-group.p-custom {
    margin-left: 0;
    position: absolute;
    
}
.img-box-area::before {
    content: "";
    position: absolute;
    bottom: 0;
    background: #242424;
    height: 80px;
    width: 100%;
    right: 0;
    left: 0;
    margin: 0 auto;
}
.btn-group.p-custom button {
    color: #fff;
    border: 2px solid #5bc0de;
    display: flex;
    height: 40px;
    padding: 0 24px;
    align-items: center;
    justify-content: center;
    border-radius: 30px !important;
    transition: all .5s ease;
    background: transparent;
}
.btn-group.p-custom button i {
    margin-left: 10px;
}

.btn-group.p-custom button:hover {
    background: #5bc0de;
}
.btn-group.p-custom button:not(:last-child) {
    margin-right: 10px !important;
}
      #toolbarCont {
    background: transparent;
    position: absolute;
    right: 5px;
    bottom: -77px;
}

.toolbar-btn {
    background: transparent;
}
.btn-group p {
    color: #fff;
}

.btn-group.btn-customize-color {
    color: #fff;
}
      .emoji-grid-div {
    position: absolute;
    bottom: 0;
    width: 100%;
  
}
    </style>
    <div class="row nomargin">
        <div class="col-md-9">
            <h1>Edit Photo Info</h1>
        </div>
        <div class="col-md-3">
            <div class="container">
                <!-- Trigger the modal with a button -->
{{--                <button type="button" class="btn btn-info add" data-toggle="modal" data-target="#myModal">Add Inspection Area</button>--}}
            </div>
        </div>
    </div>

    <form id="photo_feed_update">
    <div class="container">
{{--        <div class="col-md-12 form-group pull-right top_search" id="search-bar">--}}
{{--            <div class="input-group">--}}
{{--                <input value="{{\Request::input('keyword')}}" id="search-input" name="keyword" type="text"--}}
{{--                       class="form-control " placeholder="Search for...">--}}
{{--                <span class="input-group-btn">--}}
{{--                    <button id="search-btn" class="btn btn-default search-btn" type="button"> <i--}}
{{--                                class="fas fa-search"></i></button>--}}
{{--                </span>--}}
{{--            </div>--}}
{{--        </div>--}}
        <div class="row pt-4">
            <div class="col-md-12 col-sm-12 col-xs-12 canvas_container" style="">
              <div class="img-box-area">
                <div class="img-box">
                <img src="{{URL::to('uploads/media/'.$data['pMedia']['path']."?".$data['pMedia']['updated_at'] )}}" id="my-image" style="/*display: none;*/ max-width: 1080px;" >
                </div>
                <canvas id="c" height="0" style="display: none;"></canvas>
                <input type="file" id="imageLoader" name="imageLoader"  style="display: none;"/>
                <div class="col-md-12 mt-15">
                <div class="row">
                    <div class="col-md-4">
                        <button type="button" class="btn btn-default" id="openEditor">Open Editor</button>
                    </div>
                </div>

                <div class="row tool-controls d-none" id="toolbarCont">
                    <div class="col-md-12 pencil_controls">
                        <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                            <div class="toolbar-btn p-custom-1 margin-custom-ls">
                                <div class="btn-group mr-2 btn-customize-pencil" role="group" aria-label="Second group">

                                <p style="display: inline">Pen Size</p>
                            </div>
                            <div class="btn-group mr-2" role="group" aria-label="Second group">
                                <div class="slidecontainer">
                                    <input type="range" min="1" max="15" value="50" class="form-control slider" id="pencil_size"/>
                                </div>
                            </div>
                            </div>
                            <div class="toolbar-btn p-custom-2">
                                <div class="btn-group btn-customize-color" role="group" aria-label="Third group">
                                    Pen Color
                                </div>
                                <div class="btn-group" role="group" aria-label="Fourth group">
                                    <input class="custom-input " data-jscolor="{}" value="#3399FF" id="pencil_color"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="emoji-grid-div" id="emoji-grid">
                    <div class="grid" >
                        @foreach($data['stickers'] AS $item)
                            <div class="item">
                                <div class="emoji"><img class="emoji-dims sticker" src="{{url("image/stickers/".$item['path'])}}"/></div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="row tool-bar" style="display: none;">
                    <div class="col-md-12">
                        <div class="btn-toolbar custom-btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                            <div class="btn-group p-custom" role="group" aria-label="Basic example">
                                <button type="button" class="btn btn-secondary btn-inside-style" id="pencil">Select Brush <i class="fas fa-pencil-alt"></i></button>
                                <button type="button" class="btn btn-secondary btn-inside-style special-btn" id="icons-id">Sticky Note <i class="far fa-sticky-note size-custom"></i></button>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
              </div>
            </div>
        </div>
<!--         <div class="row pt-4">
            <div class="col-md-12 mt-15">
                <div class="row">
                    <div class="col-md-4">
                        <button type="button" class="btn btn-default" id="openEditor">Open Editor</button>
                    </div>
                </div>

                <div class="row tool-controls d-none" id="toolbarCont">
                    <div class="col-md-12 pencil_controls">
                        <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                            <div class="toolbar-btn p-custom-1 margin-custom-ls">
                                <div class="btn-group mr-2 btn-customize-pencil" role="group" aria-label="Second group">

                                <p style="display: inline">Pen Size</p>
                            </div>
                            <div class="btn-group mr-2" role="group" aria-label="Second group">
                                <div class="slidecontainer">
                                    <input type="range" min="1" max="15" value="50" class="form-control slider" id="pencil_size"/>
                                </div>
                            </div>
                            </div>
                            <div class="toolbar-btn p-custom-2">
                                <div class="btn-group btn-customize-color" role="group" aria-label="Third group">
                                    Pen Color
                                </div>
                                <div class="btn-group" role="group" aria-label="Fourth group">
                                    <input class="custom-input " data-jscolor="{}" value="#3399FF" id="pencil_color"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="emoji-grid-div" id="emoji-grid">
                    <div class="grid" >
                        @foreach($data['stickers'] AS $item)
                            <div class="item">
                                <div class="emoji"><img class="emoji-dims sticker" src="{{url("image/stickers/".$item['path'])}}"/></div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="row tool-bar" style="display: none;">
                    <div class="col-md-12">
                        <div class="btn-toolbar custom-btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                            <div class="btn-group p-custom" role="group" aria-label="Basic example">
                                <button type="button" class="btn btn-secondary btn-inside-style" id="pencil"><i class="fas fa-pencil-alt"></i></button>
                                <button type="button" class="btn btn-secondary btn-inside-style special-btn" id="icons-id"><i class="far fa-sticky-note size-custom"></i></button>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->

        <div class="row pt-4">
            <div class="col-md-12 textarea">
                <label>Annotation</label>
                <textarea class="form-control" rows="6" name="note" >{{$data['pMedia']['note']}}</textarea>
            </div>
        </div>
        <div class="row pt-3">
            @foreach($data['pMedia']['tags_data'] AS $key => $item)
                <div class="col-md-3 form-group">
                    <label title="Tag title">{{$item->name}}</label>
                    <input type="hidden" name="pmt_tag_id[]" value="{{$item->tag_id}}" />
                    <input type="hidden" name="pmt_target_id[]" value="{{$item->target_id}}" />
                    <input type="text" name="pmt_qty[]" class="form-control"
                           @if(!empty($item->qty))
                           value="{{$item->qty}}"
                            @endif
                    />
                </div>
            @endforeach
        </div>
        <div class="row pt-3">
            <div class="col-md-3 form-group">
                <input type="button" class="btn btn-info" name="save" id="save" value="Save"/>
            </div>
        </div>
    </div>
</form>

{{--    <div class="modal fade" id="editModal" role="dialog">--}}
{{--        <div class="modal-dialog modal-sm">--}}

{{--            <form id="update_form" action="{{URL::to('subadmin/inspect_area/update')}}" method="POST">--}}
{{--                {{csrf_field()}}--}}
{{--                <input type="hidden" name="page" value="{{\Request::input('page',1)}}">--}}
{{--                <!-- Modal content-->--}}
{{--                <div class="modal-content">--}}
{{--                    <div class="modal-header">--}}
{{--                        <button type="button" class="close" data-dismiss="modal">&times;</button>--}}
{{--                        <h4 class="modal-title">Edit Inspector User</h4>--}}
{{--                    </div>--}}
{{--                    <div class="modal-body">--}}
{{--                        <div class="form-group">--}}
{{--                            <input name="name" type="text" class="form-control input"--}}
{{--                                   placeholder="Inspection Area Name">--}}
{{--                        </div>--}}
{{--                        <div class="form-group">--}}
{{--                            <select name="company_group_id[]" class="select2 form-control " multiple>--}}
{{--                                @foreach($data['pMedia']['companyGroups'] AS $key => $item)--}}
{{--                                    <option value="{{$item->id}}">{{$item->title}}</option>--}}
{{--                                @endforeach--}}
{{--                            </select>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="modal-footer text-center">--}}
{{--                        <button type="submit" class="btn btn-info bt-save">Update</button>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </form>--}}

{{--        </div>--}}
{{--    </div>--}}
@endsection


@push('page_level_scripts')
    <script type="text/javascript" src="{{asset('assets/fabric-3.6.3/fabric.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/jscolor-picker-2.4.5/jscolor.min.js')}}"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            // console.clear();

            var canvas, editor = false,fImage ;
            var imageUrl = "{{URL::to('uploads/media/'.$data['pMedia']['path']."?".$data['pMedia']['updated_at'] )}}";

            console.log(imageUrl);

            $('#pencil_size').on('input',function(){
                //$(this).val();
                console.log('pencil_size',$(this).val());
                canvas.freeDrawingBrush.width = parseInt($(this).val());
            });

            $('#pencil_color').on('input',function(){
                //$(this).val();
                canvas.freeDrawingBrush.color = $(this).val();
                console.log('pencil_color', $(this).val());

            });


            $('#openEditor').on('click', function (e) {

                $('canvas#c').show();


                // var imgElement = document.getElementById('my-image');
                // var fImage = new fabric.Image(imgElement);

                var imgElement = $('#my-image');
                imgElement.parent().addClass("canvas_container");

                fImage = new fabric.Image(imgElement[0]);
                // var fImage = new fabric.Image.fromURL(imgElement.attr('src'));

                // console.log(imgElement.attr('src'),'imgElement.attr(src)');
                // console.log(imgElement[0],'imgElement[0]');

                console.log('fImage.width', fImage.width);
                console.log('fImage.height', fImage.height);

                //region Fabric JS
                // $('#c').prop('display','block');
                canvas = new fabric.Canvas('c', {
                    hoverCursor: 'pointer',
                    // selection: true,
                    // selectionBorderColor: 'black',
                    // backgroundColor: 'black',
                    // isDrawingMode: true,
                    // width:'800'
                    // backgroundImage:fImage,
                    // overlayImage: fImage,
                });

                console.log('canvas.width', canvas.width);
                console.log('canvas.height', canvas.height);
                console.log('canvas.width / fImage.width', canvas.width / fImage.width);
                console.log('Scaled height of canvas as per image', (fImage.height / 100) * ((canvas.width / fImage.width) * 100));

                $('#my-image').hide();
                // $('#brushSize').show();
                // $('#brushColor').show();
                $(this).parent().hide();

                $(".tool-bar").toggle();


                /** Photo with scaling down*/
                // canvas.setDimensions({
                //     width: 800,
                //     height: (fImage.height / 100) * ((800 / fImage.width) * 100)
                // });
                //
                // canvas.setBackgroundImage(imageUrl, canvas.renderAll.bind(canvas), {
                //     scaleX: canvas.width / fImage.width,
                //     scaleY: canvas.width / fImage.width, /** USing width on Y-axis to maintain aspect ratio*/
                // });


                /** Photo as Image instead of background*/
                // fabric.Image.fromURL(imageUrl, function(img){
                //     canvas.add(img.set({ left: 0, top: 0, angle: 0 ,selectable:false }).scale(0.5));
                //     // canvas.renderAll();
                //     console.log('canvas.getObjects() 1',canvas.getObjects());
                //     // img.on('moving', function() { positionBtn(img) });
                //     // img.on('scaling', function() { positionBtn(img) });
                //     // positionBtn(img);
                // });

                /** With scroll*/
                canvas.setDimensions({
                    width: fImage.width,
                    height: fImage.height
                });

                canvas.setBackgroundImage(imageUrl, canvas.renderAll.bind(canvas));
                editor = true;
            });/** Open editor ends*/

            $('#icons-id').on('click',function(e){
                $('#toolbarCont').hide();
                $('#emoji-grid').toggle();
                canvas.isDrawingMode = false;
            });

            $('#pencil').on('click',function(){

                let toolbarPen = $('#toolbarCont');
                $('#emoji-grid').hide();
                toolbarPen.toggle();

                canvas.isDrawingMode = !canvas.isDrawingMode;

                if(canvas.isDrawingMode){
                    console.log('pencil on');
                    canvas.freeDrawingBrush.width = parseInt($('#pencil_size').val());
                    canvas.freeDrawingBrush.color = $('#pencil_color').val();
                    console.log('canvas.freeDrawingBrush.width',canvas.freeDrawingBrush.width);
                    console.log('canvas.freeDrawingBrush.color',canvas.freeDrawingBrush.color);
                }

            });

            $('img.sticker').on('click',function(){
                /** Sticker */
                console.log('Adding Image',$(this).attr('src'));
                var imgSrc = $(this).attr('src')

                var rect = new fabric.Rect();
                canvas.add(rect); // add object


                //canvas.uniformScaling  = false;

                fabric.Image.fromURL(imgSrc, function(img){
                    canvas.add(img.set({ left: 250, top: 250, angle: 0 }).scale(0.10));

                    // canvas.renderAll();
                    console.log('canvas.getObjects() 1',canvas.getObjects());
                    // img.on('moving', function() { positionBtn(img) });
                    // img.on('scaling', function() { positionBtn(img) });
                    // positionBtn(img);
                });


                /** PUG */
                // var imgURL = 'http://i.imgur.com/8rmMZI3.jpg';
                // var pugImg = new Image();
                // pugImg.src = imgURL;
                //
                // pugImg.onload = function (img) {
                //     var pug = new fabric.Image(pugImg, {
                //         angle: 0,
                //         width: 500,
                //         height: 500,
                //         left: 50,
                //         top: 70,
                //         scaleX: .25,
                //         scaleY: .25
                //     });
                //     canvas.add(pug);
                // };
                //
                // var imgUri = canvas.toDataURL({
                //     format: 'png',
                //     quality: 0.8
                // });
                //console.log('imgUri',imgUri);
                /** PUG End */

                canvas.renderAll();
            });

            $('#save').on('click', function (e) {
                console.log('Saving');


                // console.log('canvas.getObjects() 2',canvas.getObjects());
                $(this).prop('disabled', true);

                var fd = new FormData($('#photo_feed_update')[0]);

                if(editor){
                    //$('#my-image').show();



                    // canvas.setDimensions({
                    //     width: fImage.width,
                    //     height: fImage.height
                    // });
                    //
                    // canvas.setBackgroundImage(imageUrl,canvas.renderAll.bind(canvas),{
                    //     scaleX: 1,
                    //     scaleY: 1,
                    //
                    // });
                    //canvas2.renderAll();

                    console.log('canvas2 height:',canvas.height);
                    console.log('canvas2 width:',canvas.width);

                    var imgUri = canvas.toDataURL({
                        format: 'png',
                        quality: 1.0

                    });

                    console.log('imgUri',imgUri);
                    var blob = dataURLtoBlob(imgUri);
                    fd.append("image", blob);
                }


                $.ajax({
                    type: "POST",
                    enctype: 'multipart/form-data',
                    url: '{{URL::to('subadmin/photo_feed/update/'.$data['pMedia']['id'])}}',
                    data: fd,
                    processData: false,
                    contentType: false,
                    cache: false,
                    success: (data) => {

                        console.log(data.code);

                        $(this).prop('disabled', false);
                        if(data.code == 200){
                            alert(data.message);
                            window.location.href = "{{URL::to('subadmin/photo_feed')}}";
                        }else{
                            alert("Update Failed");
                        }

                        // Same as clicking on a link
                        // Same as HTTP redirecting
                        // window.location.replace(window.location.href);

                        // window.location.reload();
                    },
                    error: function (xhr, status, error) {
                        alert(xhr.responseText);
                    }
                });

                $('#imageLoader').val()
            });

            $('.canvas-container').prop('display','none');

            $('#brushSize').on('change', function (e) {
                canvas.freeDrawingBrush.width = parseInt($(this).val());
                console.log(canvas.freeDrawingBrush.width, 'canvas.freeDrawingBrush.width');
            });

            $('#brushColor').on('change', function (e) {
                canvas.freeDrawingBrush.color = $(this).val();
                console.log(canvas.freeDrawingBrush.color, 'canvas.freeDrawingBrush.color' +
                    '');
            });
        });

        function dataURLtoBlob(dataurl) {
            var arr = dataurl.split(','), mime = arr[0].match(/:(.*?);/)[1],
                bstr = atob(arr[1]), n = bstr.length, u8arr = new Uint8Array(n);
            while(n--){
                u8arr[n] = bstr.charCodeAt(n);
            }
            return new Blob([u8arr], {type:mime});
        }

    </script>
@endpush




