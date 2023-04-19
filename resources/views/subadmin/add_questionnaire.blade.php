@extends('subadmin.master')
@section('content')

<section class="add-question-sec">
     <!-- New Work  -->
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card-title">
                    <h1 class="main-heading">Questionnaire Management</h1>
                </div>
            </div>
        </div>
        <div class="row questionnaire-row">
            <div class="col-md-12 d-flex align-items-center ">
                <div class="ledt-img">
                    <a href="{{URL::to('subadmin/questionnaire')}}">
                        <img src="{{asset('assets/images/left-arrow.png')}}" alt="...">
                    </a>
                </div>
                <div class="questionare-title">
                    <p> Add New Question</p>
                </div>
            </div>
            <form method="POST" action="{{url('subadmin/questionnaire/store')}}" id="addQuestionForm">
                {{csrf_field()}}
                <div class="col-md-12">
                    <div class="add-photo">
                        <div class="title-switch">
                            <a href="" data-toggle="modal" data-target="#addHelpPhoto">Add Help Photo</a>
                            <div class="switch-btn">
                                <span>Required</span>
                                <button type="button" class="btn btn-sm btn-toggle" data-toggle="button"
                                        aria-pressed="false" autocomplete="off">
                                    <div class="handle"></div>
                                </button>
                                <input type="hidden" name="is_required" value="false" class="test_class"/>
                            </div>
                        </div>

                        <div class="input-text">
                            <label for="basic-url">Question</label>
                            <div class="input-group">
                                <input type="text" name="question" class="form-control"
                                       placeholder="Headline or Question">
                            </div>
                        </div>
                        <div class="input-text">
                            <label for="basic-url">Inspection Area</label>
                            <div class="input-group ">
                                <select name="area" id="">
                                    <option disabled selected>Select Inspection Area</option>
                                    @foreach($data['categories'] AS $key => $item)
                                        <option value="{{$item['id']}}">{{$item['name']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="input-text photo_view " style="display: none;">
                            <label disabled>Photo View</label>
                            <div class="input-group ">
                                <select name="photo_view" id="">
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-text options" style="display: none;">
                                <label for="basic-url" class="title">Single Select</label>
                                <div class="input-group">
                                    <input type="text" name="options[]" data-index="0" class="form-control" value="N/A"
                                           placeholder="Option 1">
                                </div>
                                <div class="input-group">
                                    <input type="text" name="options[]" data-index="1" class="form-control"
                                           placeholder="Option 2">
                                </div>
                            </div>
                            <div class="add_option" style="display: none;">
                                <ul class="add-dlete">
                                    <li><a href="" class="">Add Option</a></li>
                                </ul>
                            </div>
                        </div>

                        <input type="file" style="display: none;" name="help_photo"/>

                        <div class="btn-group btn-group-toggle option_types" data-toggle="buttons">
                            <label class="btn btn-secondary active">
                                <input type="radio" name="type" id="option1" value="text" autocomplete="off" checked>
                                <ul class="input-btn">
                                <li><img src="{{asset('assets/images/plus-cion.png')}}" alt=""></li>
                                <li> Input Field</li>
                              </ul>
                               
                            </label>
                            <label class="btn btn-secondary">
                                <input type="radio" name="type" id="option2" value="radio" autocomplete="off">
                                <ul class="input-btn">
                                <li><img src="{{asset('assets/images/plus-cion.png')}}" alt=""></li>
                                <li>  Single Select</li>
                              </ul>
                               
                            </label>
                            <label class="btn btn-secondary">
                                <input type="radio" name="type" id="option3" value="checkbox" autocomplete="off"> 
                              <ul class="input-btn">
                                <li><img src="{{asset('assets/images/plus-cion.png')}}" alt=""></li>
                                <li>  Multi Select</li>
                              </ul>
                            </label>
                            <label class="btn btn-secondary">
                                <input type="radio" name="type" id="option3" value="date" autocomplete="off">
                                <ul class="input-btn">
                                <li><img src="{{asset('assets/images/plus-cion.png')}}" alt=""></li>
                                <li>   Date</li>
                              </ul>
                                
                            </label>
                            <label class="btn btn-secondary">
                                <input type="radio" name="type" id="option3" value="sign" autocomplete="off">
                                <ul class="input-btn">
                                <li><img src="{{asset('assets/images/plus-cion.png')}}" alt=""></li>
                                <li>  Sign</li>
                              </ul>
                               
                            </label>
                        </div>

                        <div class="add-cancel-bnt">
                            <button type="submit" class="btn btn-save bg-modified" data-toggle="modal"
                                    data-target="#myModal">
                                <ul class="add-cancel-btn">
                                    <li class="color-0082f1">+</li>
                                    <li>Save</li>
                                </ul>
                            </button>
                            <button type="button" id="cancelBtn" class="btn btn-close cancelButton">
                                <ul class="add-cancel-btn">
                                    <li>-</li>
                                    <li> Cancel</li>
                                </ul>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
        <!-- New Work  End -->
</section>

<!-- Alert Modal -->
<div class="modal fade" id="alertModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog add-project-modal" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="header-content">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h3 class="modal-title text-left">Updated</h3>
                </div>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="updated-title">
                            <p>Your inspection area question has been updated!</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer footer-close-button">
                <div class="add-cancel-bnt">
                    <button type="button" class="btn btn-save bg-modified" data-dismiss="modal">
                        <ul class="add-cancel-btn">
                            <li>×</li>
                            <li>Close</li>
                        </ul>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Alert Modal End -->
<div class="modal fade" id="addHelpPhoto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog add-project-modal upload-csv-modal" role="document">
        <form id="js-upload-form" method="POST" action="{{url('subadmin/report/storeLogo')}}" enctype="multipart/form-data">
            {{csrf_field()}}
            <div class="modal-content">
                <div class="modal-header">
                    <div class="header-content">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h3 class="modal-title text-left">Company Logo</h3>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="upload-drop-zone @if(!empty($report->logo_path)) hide @endif" id="drop-zone">
                                <div class="drop-cvs" >
                                    <div class="cvs-border" >
                                        <div class="img-cvs">
                                            <img src="{{asset('assets/images/csvs-img.png')}}" alt="...">
                                        </div>
                                        <div class="cvs-import-tile text-center">
                                            <p>Drag and drop to upload your CSV file </p>
                                            <p><span>Acceptable Formats:</span>jpeg, gif, png, pdf</p>

                                            <div class="fileUpload btn-broswe blue-btn btn width100">
                                                <span><ul class="add-cancel-btn">
                                                    <li class="browse-plus">+</li>
                                                    <li>Browse</li>
                                                </ul></span>
                                                <input name="logo" type="file" id="js-upload-files" class="uploadlogo @if(!empty($report->logo_path)) {{"hide"}} @endif"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- <div class="row logo_preview">
                                 <div class="col-md-12 text-center">
                                     <img  src="" class="img-thumbnail hide" style="max-height: 300px;"/>
                                 </div>
                             </div>--}}


                            <div class="row image_preview @if(empty($report->logo_path)) hide @endif" >
                                @if(!empty($report->logo_path)) <input type="hidden" name="image_set" value="true" /> @endif
                                <div class="col-md-12 text-center">
                                    <img  src="{{url("uploads/report_templates/".$report->logo_path)}}" class="img-thumbnail" style="max-height: 300px;"/>
                                </div>
                                <div class="col-md-12 text-center pt-3">
                                    <button type="button" class="btn btn-danger image_remove">Remove</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer footer-switch-btn">
                    <div class="switch-btn">
                    </div>
                    <div class="add-cancel-bnt">
                        <button type="button" class="btn btn-close cancelButton" data-dismiss="modal">
                            <ul class="add-cancel-btn">
                                <li>-</li>
                                <li> Close</li>
                            </ul>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- To be removed hide on Jan-2023 --}}
<div class="container hide">
   <div class="row nomargin">
      <div class="col-md-12">
         <a href="{{URL::to('subadmin/questionnaire')}}"> <img class="img-responsive wd-40" src="{{asset('image/back.png')}}"/>  </a>
      </div>
      <div class="col-md-8">
         <h1 class="main-heading pb-3">Add Questionnaire</h1>
      </div>
      <div class="col-md-4">
         <a class="btn btn-add add_question btn-pmadd-modified">Add Question</a>
      </div>
      <div class="col-md-12">
         <p class="ft-bold">Select Inspection</p>
      </div>
      <form method="POST" action="{{URL::to('subadmin/questionnaire/store')}}" enctype="multipart/form-data">
         {{ csrf_field() }}
         <div class="col-md-12">
            <div class="row">
               @foreach($data['categories'] AS $key => $item)
               <div class="col-md-2">
                  <label class="radio"><span class="radio-text">{{$item['name']}}</span>
                  <input value="{{$item['id']}}" name="category"
                  type="radio" {{($key == 0 ) ? 'checked' : ''}}>
                  <span class="checkmark"></span>
                  </label>
               </div>
               @endforeach
            </div>
         </div>
         <hr>
         <div class="questions">
            <input type="hidden" name="count" value="2"/>
            <div class="col-md-12 question">
               <p class="ft-bold">Your Question #1</p>
               <div class="row">
                  <div class="form-group col-md-6">
                     <input type="text" name="question[]" class="form-control radius2"
                        placeholder="Enter your Question">
                  </div>
                  <div class="form-group col-md-6">
                     <input type="file" name="sample[]" class="form-control radius">
                  </div>
               </div>
               <div class="row type_container">
                  <div class="col-md-2">
                     <label class="radio"><span class="radio-text">Input Field</span>
                     <input type="radio" name="type[0]" value="text" checked>
                     <span class="checkmark"></span>
                     </label>
                  </div>
                  <div class="col-md-2">
                     <label class="radio"><span class="radio-text">Single Select</span>
                     <input type="radio" name="type[0]" value="radio">
                     <span class="checkmark"></span>
                     </label>
                  </div>
                  <div class="col-md-2">
                     <label class="radio"><span class="radio-text">Multiple Selection</span>
                     <input type="radio" name="type[0]" value="checkbox">
                     <span class="checkmark"></span>
                     </label>
                  </div>
                  <div class="col-md-2">
                     <label class="radio"><span class="radio-text">Date</span>
                     <input type="radio" name="type[0]" value="date">
                     <span class="checkmark"></span>
                     </label>
                  </div>
                  <div class="col-md-2">
                     <label class="radio"><span class="radio-text">Sign</span>
                     <input type="radio" name="type[0]" value="sign">
                     <span class="checkmark"></span>
                     </label>
                  </div>
               </div>
               <div class="row form-group na_rule_container pb-3" style="display: none">
                  <div class="col-md-6">
                     <label>Photo View</label>
                     <select name="photo_view[0]" class="form-control inputs">
                        <option disabled selected>Select PhotoView</option>
                     </select>
                  </div>
                  <div class="col-md-6 " style="padding-top: 8px;">
                     <label class="radio"><span class="radio-text">Add N.A Option</span>
                     <input class="na_rule" type="checkbox" name="na_rule[0]" value="1"/>
                     <span class="checkmark"></span>
                     </label>
                  </div>
                  {{--
                  <div class="col-md-6">
                     <div class="form-group">
                        <input type="text" name="custom_tag[0]" class="form-control radius" placeholder="Enter Custom Tag" />
                     </div>
                  </div>
                  --}}
               </div>
               <div class="row question_options" style="display: none;">
                  <div class="col-md-12 form-group pull-right question_option">
                     <div class="input-group">
                        <input type="text" name="option[0][]" class="form-control inputs"
                           placeholder="Option">
                        <span class="input-group-btn remove_option">
                        <button class="btn btn-default inputs" type="button"> <i
                           class="fas fa-times"></i></button></span>
                     </div>
                  </div>
                  <div class="col-md-12 form-group pull-right question_option">
                     <div class="input-group">
                        <input type="text" name="option[0][]" class="form-control inputs"
                           placeholder="Option">
                        <span class="input-group-btn remove_option">
                        <button class="btn btn-default inputs" type="button"> <i class="fas fa-times"></i>
                        </button>
                        </span>
                     </div>
                  </div>
               </div>

                <div class="col-md-12 add_option_container pb-3" style="display: none;">
                    <a data-q_id="0" class="add_option btn-add ft-left">Add Option</a>
                </div>

            </div>
             <div class="col-md-12 question">
                 <p class="ft-bold">Your Question #2</p>
                 <div class="row">
                     <div class="form-group col-md-6">
                         <input type="text" name="question[]" class="form-control radius2"
                                placeholder="Enter your question" />
                     </div>
                     <div class="form-group col-md-6">
                         <input type="file" name="sample[]" class="form-control radius">
                     </div>
                 </div>
                 <div class="row type_container">
                     <div class="col-md-2">
                         <label class="radio"><span class="radio-text">Input Field</span>
                             <input type="radio" name="type[1]" value="text" checked>
                             <span class="checkmark"></span>
                         </label>
                     </div>
                     <div class="col-md-2">
                         <label class="radio"><span class="radio-text">Single Select</span>
                             <input type="radio" name="type[1]" value="radio">
                             <span class="checkmark"></span>
                         </label>
                     </div>
                     <div class="col-md-2">
                         <label class="radio"><span class="radio-text">Multiple Selection</span>
                             <input type="radio" name="type[1]" value="checkbox">
                             <span class="checkmark"></span>
                         </label>
                     </div>
                     <div class="col-md-2">
                         <label class="radio"><span class="radio-text">Date</span>
                             <input type="radio" name="type[1]" value="date">
                             <span class="checkmark"></span>
                         </label>
                     </div>
                     <div class="col-md-2">
                         <label class="radio"><span class="radio-text">Sign</span>
                             <input type="radio" name="type[1]" value="sign">
                             <span class="checkmark"></span>
                         </label>
                     </div>
                 </div>
                 <div class="row form-group na_rule_container" style="display: none">
                     <div class="col-md-6">
                         <label>Photo View</label>
                         <select name="photo_view[1]" class="form-control inputs">


                         </select>
                     </div>
                     <div class="col-md-6 " style="padding-top: 8px;">
                         <label class="radio"><span class="radio-text">Add N.A Option</span>
                             <input class="na_rule" type="checkbox" name="na_rule[1]" value="1"/>
                             <span class="checkmark"></span>
                         </label>
                     </div>
                     {{--
                     <div class="col-md-6">
                        <div class="form-group">
                           <input type="text" name="custom_tag[0]" class="form-control radius" placeholder="Enter Custom Tag" />
                        </div>
                     </div>
                     --}}
                 </div>
                 <div class="row question_options" style="display: none;">
                     <div class="col-md-12 form-group pull-right question_option">
                         <div class="input-group">
                             <input type="text" name="option[1][]" class="form-control inputs"
                                    placeholder="Option">
                             <span class="input-group-btn remove_option"> <button class="btn btn-default inputs"
                                                                                  type="button"> <i
                                             class="fas fa-times"></i></button></span>
                         </div>
                     </div>
                     <div class="col-md-12 form-group pull-right question_option">
                         <div class="input-group">
                             <input type="text" name="option[1][]" class="form-control inputs"
                                    placeholder="Option">
                             <span class="input-group-btn remove_option"> <button class="btn btn-default inputs"
                                                                                  type="button"> <i
                                             class="fas fa-times"></i></button></span>
                         </div>
                     </div>
                 </div>

                 <div class="col-md-12 add_option_container" style="display: none;">
                     <a data-q_id="1" class="add_option btn-add ft-left">Add Option</a>
                 </div>

             </div>
            {{--question end --}}
         </div>
         <div class="col-md-12">
            <button type="submit" class="btn btn-add ft-left btn-pmadd-modified">Save</button>
         </div>
      </form>
   </div>
</div>
@endsection
@push('page_level_scripts')
<script type="text/javascript">
$("#cancelBtn").click(function () {
        window.location.href = "{{url('/subadmin/questionnaire')}}";
    });
    +function ($) {
        'use strict';

        // UPLOAD CLASS DEFINITION
        // ======================

        var dropZone = document.getElementById('drop-zone');
        var uploadForm = document.getElementById('addQuestionForm');
        let help_photo;

        var startUpload = function (files) {
            console.log('startUpload', files);

        }

        uploadForm.addEventListener('submit', function (e) {
            var uploadFiles = document.getElementById('js-upload-files').files;
            e.preventDefault()

            var fd = new FormData($('#addQuestionForm')[0]);

            if (typeof (help_photo) !== 'undefined') {
                fd.append('help_photo', help_photo[0]);
            }

            $.ajax({
                type: "POST",
                enctype: 'multipart/form-data',
                url: '{{URL::to('subadmin/questionnaire/store')}}',
                data: fd,
                processData: false,
                contentType: false,
                cache: false,
                success: (response) => {
                    // console.log('ajax good', $(".alert-success.success"));
                    // $('#companyLogoModal').modal('toggle');
                    // $("div.alert-success.success").text(data.message).show();
                    // setTimeout(() => {
                    //     $("div.alert.alert-success.success").hide();
                    // }, 2000);

                    let alertTitle = response.code !== 200 ? "Error": "Success" ;
                    $("#alertModal").find(".modal-title").text(alertTitle);
                    $("#alertModal").find(".updated-title p").text(response.message);
                    $("#alertModal").modal({show: true});
                }
            });

            startUpload(uploadFiles)
        })

        dropZone.ondrop = function (e) {
            e.preventDefault();
            this.className = 'upload-drop-zone';
            help_photo = e.dataTransfer.files;
            // startUpload(e.dataTransfer.files)

            if (FileReader && help_photo && help_photo.length) {
                var fr = new FileReader();
                fr.onload = function () {
                    // document.getElementById(outImage).src = fr.result;
                    $('.image_preview').find('img.img-thumbnail').attr('src', fr.result);

                    if ($('.image_preview').hasClass('hide')) {
                        $('.image_preview').removeClass('hide');
                    }

                }
                console.log("createObjectURL: ", URL.createObjectURL(help_photo[0]));

                fr.readAsDataURL(help_photo[0]); // Initiating Reader that eventually trigger .onload
                $('.upload-drop-zone').addClass('hide');
            }
        }

        dropZone.ondragover = function () {
            this.className = 'upload-drop-zone drop';
            return false;
        }

        dropZone.ondragleave = function () {
            this.className = 'upload-drop-zone';
            return false;
        }

    }(jQuery);

    $(document).ready(function () {
        console.log('ready');

        let optionTypes = ['radio', 'checkbox'];
        let type = 'text';

        $("button.image_remove").on('click', function (e) {
            console.log('clicked')

            let $imagePreview = $(this).closest('.image_preview');
            let $modalBody = $(this).closest('.modal-body');

            console.log('$imagePreview', $imagePreview);
            console.log('$modalBody', $modalBody);
            console.log('drop-zone', $modalBody.find(".upload-drop-zone").first());

            console.log('class', $(this).attr('class'));

            /** For cover image */
            if ($(this).hasClass('cover')) {
                console.log('cover_image', $modalBody.find(".form-group.cover_image").first());
                $modalBody.find(".form-group.cover_image").first().removeClass("hide");
            }

            $modalBody.find(".upload-drop-zone").first().removeClass("hide");
            $imagePreview.addClass("hide");
            $imagePreview.find("input[name='image_set']").first().attr("disabled", true);
        });

        $('.btn-toggle').on('click', function (e) {
            let state = $(this).closest('.modal-footer').find('input[name="is_required"]').val();
            if (state === 'true') {
                $(this).closest('.switch-btn').find('input[name="is_required"]').val(false); // Toggling
            } else {
                $(this).closest('.switch-btn').find('input[name="is_required"]').val(true); // Toggling
            }
        });

        $('.option_types .btn-secondary ').on('click', function () {

            type = $(this).find("input[name='type']").val();

            if (optionTypes.includes(type)) {
                console.log('make options');
                let area = $("select[name='area']").val();
                if (area > 0) {
                    fillPhotoview($("select[name='area']").val());
                } else {
                    $("div.alert-danger.error").text("Please Select Inspection Area First.").show();
                    setTimeout(() => {
                        $("div.alert-danger.error").hide();
                    }, 5000);
                    return false;
                }
                let title = type == 'radio' ? "Single Select" : "Multi Select";
                let optionsHtml = `
                        <label for="basic-url" class="title">${title}</label>
                        <div class="input-group">
                            <input type="text" name="options[]" data-index="0"  value="N/A" class="form-control" placeholder="Option 1">
                            <span class="input-group-btn remove_option">
                                            <button class="btn btn-default inputs close-icon" type="button">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </span>
                        </div>
                        <div class="input-group">
                            <input type="text" name="options[]" data-index="1" class="form-control" placeholder="Option 2">
                            <span class="input-group-btn remove_option">
                                            <button class="btn btn-default inputs close-icon" type="button">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </span>
                        </div>`;

                $(".options").html(optionsHtml).show();
                $(".add_option").show();
            } else {
                console.log('no options');
                $(".options").hide();
                $(".add_option").hide();
                $(".photo_view").hide();
            }
        });

        $(".add_option a").on("click", function (e) {
            e.preventDefault();
            let index = $(".options").find('.form-control').last().data('index');
            let optionHtml = `<div class="input-group">
                            <input type="text" name="options[]" data-index="${index + 1}" class="form-control" placeholder="Option ${index + 2}">
                            <span class="input-group-btn remove_option">
                                            <button class="btn btn-default inputs close-icon" type="button">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </span>
                        </div>`;
            $(".options").append(optionHtml);
        });

        $("select[name='area']").on("change", function (e) {
            if (optionTypes.includes(type)) {
                fillPhotoview($(this).val())
            }
        });

        function fillPhotoview(inspectionArea) {
            $.ajax({
                type: "GET",
                enctype: 'multipart/form-data',
                url: `{{URL::to('subadmin/photo_view')}}/${inspectionArea}`,
                data: [],
                async: false,
                contentType: false,
                success: (response) => {
                    let options = `<option disabled selected>Select Photo View</option>`;
                    $.each(response.data, (i, el) => {
                        options += `<option value="${el.id}">${el.name}</option>`;
                    });
                    $("select[name='photo_view']").html(options);
                    $(".photo_view").show();
                }
            });
        }


        $(".options").on('click',".close-icon",function (){
           alert('test clsoe');

           $(this).closest('.input-group').remove();
        });
    });
</script>
@endpush