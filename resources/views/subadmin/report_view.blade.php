@extends('subadmin.master')
@section('content')
    @php
     // dd($data);
    @endphp
    <style>
        .option_list, .suboption_list{
            list-style: none
        }

        .suboption_list li {
            height: auto;
        }

        .checkbox-container{
            font-size: 1px;
        }

        .checkboxmark{
            margin-top: 0px;
        }
    </style>
    <div class="container">
        <div class="row nomargin">
            <div class="col-md-12"> <h1 class="main-heading">Report Options</h1> </div>
            <div class="col-md-12">
                <form method="POST" action="{{URL::to('subadmin/project/report').'/'.$data['project_id']}}" enctype="multipart/form-data">
                    {{ csrf_field() }}

                    {{--                <div class="form-group">--}}
                    {{--                    <label class="radio"><span class="radio-text">Checkbox 1</span>--}}
                    {{--                        <input  value="Checkbox 1" name="category" type="checkbox" />--}}
                    {{--                        <span class="checkmark"></span>--}}
                    {{--                    </label>--}}
                    {{--                </div>--}}

                    <ul class="option_list">
                        @foreach($data['options'] AS $key => $item)
                            <li class="option_list_item">
                                <div class="form-group">
                                    <label class="checkbox-container"><span
                                                class="checkbox-text">{{$item['title']}}</span>
                                        <input class="category" value="{{$item['id']}}" name="category[]" type="checkbox"/>
                                        <span class="checkboxmark"></span>
                                    </label>
                                </div>
                                <ul class="suboption_list">
                                    @if($item['has_survey'])
                                        <li class="suboption_list_item">
                                            <div class="form-group">
                                                <label class="checkbox-container"><span
                                                            class="checkbox-text">Survey</span>
                                                    <input value="{{$item['id']}}" name="survey[]" type="checkbox"/>
                                                    <span class="checkboxmark"></span>
                                                </label>
                                            </div>
                                        </li>
                                    @endif
                                    @if($item['has_estimates'])
                                        <li class="estimates_list_item">
                                            <div class="form-group">
                                                <label class="checkbox-container"><span
                                                            class="checkbox-text">Estimates</span>
                                                    <input class="estimates" value="{{$item['id']}}" name="estimates[]" type="checkbox"/>
                                                    <span class="checkboxmark"></span>
                                                </label>
                                            </div>

                                        <ul class="suboption_list">
                                            @foreach($item['estimates']['cost_breakdown'] AS $costKey => $costItem)
                                                <li>
                                                    <div class="form-group">
                                                        <label class="checkbox-container"><span
                                                                    class="checkbox-text">{{ucwords(str_replace("_"," ",$costKey))}}</span>
                                                            <input class="cost_breakdown" value="{{$item['id']}}"
                                                                   name="cost_breakdown[{{$item['id']}}][{{$costKey}}]" type="checkbox"/>
                                                            <span class="checkboxmark"></span>
                                                        </label>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                        </li>
                                    @endif
                                </ul>
                            </li>
                        @endforeach
                    </ul>

                    <div class="form-actions">
                        <input class="btn-save" type="submit" value="Create Report"/>
                    </div>
                </form>
            </div>

        </div>


    </div>

        @endsection
@push('page_level_scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            $('.delivery-product-id').on('change', function (e) {

                var $productRow = $(this).closest('.product-row');
                var $productsId = $productRow.find('.product-id');

                console.log('$(\'.delivery-product-id:checked\').length', $productRow.find('.delivery-product-id:checked').length);
                if ($productRow.find('.delivery-product-id:checked').length == 0) {
                    /**All non-seletced*/
                    $productsId.prop('checked', false);
                } else {
                    $productsId.prop('checked', true);
                }
            });

            $('input.cost_breakdown').on('change', function (e) {
                if($(this).closest('.suboption_list').find('input.cost_breakdown:checked').length > 0){
                    $(this).closest('.estimates_list_item').find('input.estimates').prop('checked',true);
                    $(this).closest('.option_list_item').find('input.category').prop('checked',true);
                }else{
                    $(this).closest('.estimates_list_item').find('input.estimates').prop('checked',false);
                    $(this).closest('.option_list_item').find('input.category').prop('checked',false);
                }
            });

            $('input.estimates').on('change', function (e) {

                if($(this).closest('.estimates_list_item').find('input.estimates').prop('checked')){
                    $(this).closest('.estimates_list_item').find('.suboption_list input.cost_breakdown').prop('checked',true);
                    $(this).closest('.option_list_item').find('input.category').prop('checked',true);
                }else{
                    $(this).closest('.estimates_list_item').find('.suboption_list input.cost_breakdown').prop('checked',false);
                    //$(this).closest('.option_list_item').find('input.category').prop('checked',false);
                }

            });

            $('.ev-select-all').on('click', function (e) {

            var checked = true;
            if ($('.product-row').find('.product-id:checked').length > 0 || $('.product-row').find('.delivery-product-id:checked').length > 0) {
                checked = false;
                $('.ev-select-all').text('Select All');
            } else {
                $('.ev-select-all').text('Unselect All');
            }

            $('.product-row').find('.product-id').prop('checked', checked);
            $('.product-row').find('.delivery-product-id').prop('checked', checked);
    });
        });
    </script>
@endpush

