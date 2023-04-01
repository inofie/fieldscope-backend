@extends('subadmin.master')
@section('content')
<div class="container">
    <div class="row nomargin">
        <div class="col-md-12">
            <a href="{{URL::to('subadmin/questionnaire')}}"> <img class="img-responsive wd-40" src="{{asset('image/back.png')}}"/></a>
        </div>
        <div class="col-md-6">
            <h1 class="main-heading pb-3">Edit Questionnaire </h1>
        </div>
        <div class="col-md-6 ">
            <a href="{{URL::to('subadmin/questionnaire/add')}}" class="btn btn-add add_question pull-right">Add Question</a>
        </div>
        <div class="col-md-12">
        <p class="ft-bold">Select Inspection</p>
        </div>

        <form method="POST" action="{{URL::to('subadmin/questionnaire/update')}}" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="col-md-12">
                <div class="row">
                    @foreach($data['categories'] AS $catKey => $catItem)
                        <div class="col-md-2">
                            <label class="radio"><span class="radio-text">{{$catItem['name']}}</span>
                                <input value="{{$catItem['id']}}" name="category" type="radio"
                                       {{($catItem['id'] == $data['query'][0]['category_id'] ) ? 'checked' : ''}} readonly
                                       disabled/>
                                <span class="checkmark"></span>
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>
            <hr>
            <div class="questions">
                <input type="hidden" name="count" value="2"/>
                @foreach($data['query'] AS $key => $item)
                    <input value="{{$item['id']}}" type="hidden" name="query_id[]" />
                    <div class="col-md-12 question" data-question-id="{{($key+1)}}">
                    <p class="ft-bold">Your Question #{{$key+1}}</p>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <input value="{{$item['query']}}" type="text" name="question[]" class="form-control radius2"
                                    placeholder="Enter your question"/>
                            </div>


                                @if($item['image_url'])
                                <div class="form-group sample_image_container col-md-12">
                                    @php
                                        $path_info = pathinfo($item['image_url']);
                                        $ext = $path_info['extension'];
                                    @endphp
                                    @if(in_array($ext,['jpg','jpeg','png','gif']))
                                        <img class="sample_image img-thumbnail" style="width:auto; height: 100px;" src="{{env('BASE_URL').config('constants.MEDIA_IMAGE_PATH').$item['image_url']}}" alt="Sample Image"/>
                                        @else
                                        <a href="{{env('BASE_URL').config('constants.MEDIA_IMAGE_PATH').$item['image_url']}}" target="_blank">
                                            <h6 class="btn btn-info btn-sm">View File</h6>
                                        </a>
                                    @endif
                                    <div class="pt-3">
                                    <button href="/" class="image_remove_link btn btn-sm btn-remove">Remove</button>
                                    </div>
                                </div>
                                @else
                                <div class="col-md-6">
                                    <input type="file" name="sample[{{$key}}]" class="form-control radius image_input" />
                                    </div>
                                @endif

                        </div>
                        <div class="row type_container">
                            <div class="col-md-2">
                                <label class="radio"><span class="radio-text">Input Field</span>
                                    <input type="radio" name="type[{{$key}}]"
                                           value="text" {{($item['type'] == 'text') ? 'checked': ''}}>
                                    <span class="checkmark" style="/*display: block;*/"></span>
                                </label>
                            </div>
                            <div class="col-md-2">
                                <label class="radio"><span class="radio-text">Single Select</span>
                                    <input type="radio" name="type[{{$key}}]"
                                           value="radio" {{($item['type'] == 'radio') ? 'checked': ''}}>
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="col-md-2">
                                <label class="radio"><span class="radio-text">Multiple Selection</span>
                                    <input type="radio" name="type[{{$key}}]"
                                           value="checkbox" {{($item['type'] == 'checkbox') ? 'checked': ''}}>
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="col-md-2">
                                <label class="radio"><span class="radio-text">Date</span>
                                    <input type="radio" name="type[{{$key}}]"
                                           value="date" {{($item['type'] == 'date') ? 'checked': ''}}>
                                    <span class="checkmark">
                                    </span>
                                </label>
                            </div>
                            <div class="col-md-2">
                                <label class="radio"><span class="radio-text">Sign</span>
                                    <input type="radio" name="type[{{$key}}]"
                                           value="sign" {{($item['type'] == 'sign') ? 'checked': ''}}>
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                        </div>

                        <?php
                            $show = '';
                        if($item['type'] == 'text' || $item['type'] == 'date' || $item['type'] == 'sign'){
                            $show = 'display: none;';
                        }else{
                            $show = '';
                        }

                        if(is_array($item['options'])){
                            $naRule = in_array('N/A',$item['options']);
                        }else{
                            $naRule = false;
                        }

                        ?>
                        <div class="row form-group na_rule_container" style="{{$show}}">

                            <div class="col-md-6">
                                <label>Photo View</label>
                                <select name="photo_view[{{$key}}]" class="form-control inputs photo_view">
                                    <option>Select PhotoView</option>
                                    @foreach($data['subCategories'] AS $subCatKey => $subCatItem)
                                        @php
                                            $selected = $item['photo_view_id'] == $subCatItem->id ? 'selected': '';
                                        @endphp
                                        <option value="{{$subCatItem->id}}" {{$selected}}> {{$subCatItem->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 " style="padding-top: 8px;">
                                <label class="radio"><span class="radio-text">Add N.A Option</span>
                                    <input class="na_rule" type="checkbox" name="na_rule[{{$key}}]" value="1" {{ ($naRule) ? 'checked': '' }}/>
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            {{--<input value="{{$item['query_tags']['id']}} " type="hidden"
                                   name="custom_tag_id[{{$key}}]" class="form-control radius"
                                   placeholder="Enter Custom Tag"/>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input value="{{$item['query_tags']['name']}} " type="text"
                                           name="custom_tag[{{$key}}]" class="form-control radius"
                                           placeholder="Enter Custom Tag"/>
                                </div>
                            </div>--}}
                        </div>

                        <div class="row question_options" style="{{$show}}">
                            @if(!empty($item['options']) )
                                @foreach($item['options'] AS $opKey => $opItem)

                                    <div class="col-md-12 form-group pull-right question_option">
                                        <div class="input-group">
                                            <input type="text" name="option[{{$key}}][]" class="form-control inputs" placeholder="Option" value="{{($item['type'] == 'radio' || $item['type'] == 'checkbox') ? $opItem: '' }}">
                                            <span class="input-group-btn remove_option"> 
                                                <button class="btn btn-default inputs" type="button">
                                                     <i class="fas fa-times"></i>
                                                    </button>
                                                </span>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="col-md-12 form-group pull-right question_option">
                                    <div class="input-group">
                                        <input type="text" name="option[{{$key}}][]" class="form-control inputs" placeholder="Option" value="">
                                        <span class="input-group-btn remove_option"> 
                                            <button class="btn btn-default inputs" type="button"> 
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-12 form-group pull-right question_option">
                                    <div class="input-group">
                                        <input type="text" name="option[{{$key}}][]" class="form-control inputs"
                                               placeholder="Option" value="">
                                        <span class="input-group-btn remove_option"> <button class="btn btn-default inputs"
                                                                                             type="button"> <i
                                                        class="fas fa-times"></i></button></span>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="col-md-12 add_option_container pb-3" style="{{$show}}">
                            <a data-q_id="{{$key}}" class="add_option btn-add ft-left">Add Option</a>
                        </div>



                    </div>
                @endforeach
                {{--question end --}}
            </div>



                <div class="col-md-12">
                    <button type="submit" class="btn btn-add ft-left">Update</button>
                </div>

        </form>
    </div>
</div>
@endsection

@push('page_level_scripts')
    <script type="text/javascript">

        $(document).ready(function () {


            var $count = $('input[name="count"]');
            $('.questions').on('click', '.question_options span.remove_option', function () {
                //alert("clicked");
                var length = $(this).closest('.question_options').find('.question_option').length;
                if (length > 1) {
                    $(this).closest('.question_option').remove();
                }
                console.log(length);
            });

            $('.questions').on('click', '.option_type', function () {
                var type = $(this).val();

                console.log($(this));
                console.log("$(this)");

                console.log("$(this).closest('.question')");
                console.log($(this).closest('.question'));

                if (type == 'text') {
                    $(this).closest('.question').find('.question_options').hide();
                    $(this).closest('.question').find('.add_option').hide();
                } else {
                    $(this).closest('.question').find('.question_options').show();
                    $(this).closest('.question').find('.add_option').show();
                }
            });


            var opCount = $(document).find('.question_option').length;

            var question_option = $('.question_option').first().html();

            // question_option = '<div class="col-md-12 form-group pull-right question_option option_index_'+opCount+'">' + question_option + '</div>';

            $(document).on('click','.add_option', function (e) {
                var question_option2 = '<div class="col-md-12 form-group pull-right question_option option_index_'+opCount+'">' + question_option + '</div>';

                var countVal = $count.val();

                var q_id = $(this).data('q_id');
                console.log('q_id', q_id);
                question_option2 = question_option2.replace(/option\[*\d*]\[]/g,'option['+q_id+'][]');

                question_option2 = question_option2.replace(/option\[*\d*]\[]/g,'option['+countVal+'][]');
                $(this).parent().parent().find('.question_options').append(question_option2);

                console.log($(document).find('.option_index_' + opCount + ' input[type="text"]'));
                $(document).find('.option_index_'+opCount+' input[type="text"]').val('');
                opCount++;
            });
            var $question = $('.question').first().html();

            $('.add_question').on('click', function () {
                // console.log('add_question');
                // console.log($('.questions'));
                // console.log('test');

                var countVal = $('.question').length;

                $question = '<div class="col-md-12 question index_'+countVal+'">'+ $question +'</div>';

                // console.log(countVal);
                // console.log($question);
                $question = $question.replace(/(#\d)/,'#'+(parseInt(countVal)+1));
                $question = $question.replace(/type\[\d]\[]/g,'type['+countVal+'][]');
                $question = $question.replace(/option\[\d]\[]/g,'option['+countVal+'][]');

                $question = $question.replace(/data-q_id="\d"/g,'data-q_id="'+countVal+'"');

                // console.log('aa');
                // console.log($($question));
                // console.log($($question).find('input'));
                // console.log($($question).find('input[type="text"]').val('') );
                // console.log($($question).appendTo('.questions'));

                $('.questions').append($($question));
                console.log('.index_' + countVal + ' input');
                console.log($(document).find('.index_' + countVal + ' input'));
                $(document).find('.index_' + countVal + ' input').val('');
                $(document).find('.index_' + countVal + ' select option').removeAttr('selected');

                countVal++;
                $count.val(countVal);
            });


            $('.image_remove_link').on('click',function (e) {
                $(this).closest('.sample_image_container').removeClass('col-md-12').addClass('col-md-6');
                e.preventDefault();

                var $question = $(this).closest('.question');
                var question_id = parseInt($question.data('question-id')-1);
                console.log(question_id);
                var $imageInput = '<input type="file" name="sample['+question_id+']" class="form-control radius image_input"/>';

                var $container = $(this).closest('.sample_image_container');
                $container.html($imageInput);


                // $container.find('.sample_image').hide();
                // $container.find('.image_remove_link').hide();
                // $container.find('.image_input').show();
                // $container.find('.image_input').attr('disabled',false);
                $container.show();

                console.log();

            });

            $('.questions').on('click','.type_container input', function (e) {
                var val = $(this).val();
                var $question = $(this).closest('.question');
                console.log($question);
                if(val == 'radio' || val == 'checkbox'){
                    $question.find('.question_options').show();
                    $question.find('.add_option_container').show();
                    $question.find('.na_rule_container').show();
                }else{
                    $question.find('.question_options').hide();
                    $question.find('.add_option_container').hide();
                    $question.find('.na_rule_container').hide();
                }
            })
        });
    </script>
@endpush