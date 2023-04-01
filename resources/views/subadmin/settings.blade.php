@php // die(session('user')->image_url); $userImage = ''; $userImageBasePath = env('BASE_URL') .config('constants.USER_IMAGE_PATH'); if(!empty(session('user')->image_url)){ $userImage = $userImageBasePath.session('user')->image_url; }else{
// $userImage = env('BASE_URL').'image/default_user.png'; } @endphp @extends('subadmin.master') @section('content')

    <section class="report-management-sec">
    <div class="container">
        <div class="row nomargin">
            <div class="col-md-12">
              <div class="card-title">
              <h1 class="main-heading">Settings</h1>
              </div>
            </div>

            <form method="POST" action="{{URL::to('subadmin/settingsUpdate')}}" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="questions">
                    <input type="hidden" name="count" value="2"/>
                    <div class="col-md-12 question">
                        {{--
                        <h4>Your Question #1</h4>
                        --}} {{--
                    <div class="form-group">--}} {{--<input type="text" name="question[]" class="form-control radius" --}} {{--placeholder="Enter your question" />--}} {{--</div>
                    --}}
                        <div class="row">
                            <div class="col-md-12">
                                <p class="ft-bold">Your Logo</p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                @if(!empty($userImage) )
                                    <div class="form-group thumbnail_container">
                                        <img class="img-thumbnail" style="width: auto; height: 100px;"
                                             src="{{$userImage}}" alt="User Image"/>

                                        <div class="pt-3 pb-3">
                                            <button href="/" class="thumbnail_remove_link btn btn-sm btn-remove">
                                                Remove
                                            </button>
                                        </div>
                                    </div>
                                @else
                                    <div class="form-group setting-from-group">
                                    <label for="file">choose a file</label>
                                        <input type="file" name="logo" id="file" class="form-control input-filke"/>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <p class="ft-bold">CRM Settings</p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" name="crm_email" class="form-control input-file"
                                           placeholder="CRM Email" value="{{$data['company']['crm_employee_email']}}"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <button type="submit" class="btn btn-add ft-left">Save</button>
                </div>
            </form>
        </div>


        <div class="row mt-15">
            <div class="col-md-12">
                <h2 class="main-heading p-15">Hover</h2>
                <hr/>
                <p class="ft-bold p-15">
                    By enabling this Hover integration, your team members will be able to place Hover orders directly
                    from a Project in the FieldScope app. Once Hover completes the report, it will automatically be
                    attached to the
                    Project and measurements will be parsed to the correct quantity field.
                </p>

                @if(!empty($data['company']['hover_url']))
                    <div class="form-group col-md-12">
                        <input class="form-control radius" type="text" readonly
                               value="{{$data['company']['hover_url']}}"/>
                    </div>
                    <form method="post" action="{{url('subadmin/hover/set_details')}}">
                        {{csrf_field() }}
                        <div class="form-group col-md-6">
                            <label for="client_id">Client Id</label>
                            <input class="form-control radius" type="text" id="client_id" name="client_id"
                                   value="{{ $data['company']['hover_client_id'] }}" placeholder="Client Id"/>
                            {{--<small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>--}}
                        </div>

                        <div class="form-group col-md-6">
                            <label for="client_secret">Client Secret</label>
                            <input class="form-control radius" type="text" id="client_secret" name="client_secret"
                                   value="{{ $data['company']['hover_client_secret'] }}" placeholder="Client Secret"/>
                            {{--<small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>--}}
                        </div>

                        <input class="btn-add" type="submit" value="Save"/>
                    </form>
                @else
                    <a class="btn btn-add ft-left" href="{{url('subadmin/hover/get_redirect_url')}}">Get Hover Redirect
                        URI</a>
                @endif

            </div>
        </div>


        {{--Eagle View: Start --}}
        <div style="display: none">
            <div class="row mt-15">
                <div class="col-md-12">
                    <h2 class="main-heading">Eagleview</h2>
                    <hr/>
                    <p class="ft-bold">
                        By enabling this EagleView integration, your team members will be able to place EagleView orders
                        directly from a Project in the FieldScope app. Once EagleView completes the report, it will
                        automatically be attached to the
                        Project and measurements will be parsed to the correct quantity field. The team member who
                        placed
                        the order will receive a notification.
                    </p>

                    <p class="ft-bold">Step1: Enter your EagleView credentials and click Authorize Orders.</p>
                </div>
            </div>
            <form method="POST" action="{{URL::to('subadmin/ev/auth_user')}}" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" name="ev_email" class="form-control radius"
                                   placeholder="EagleView Email Address" value="{{$data['company']['ev_email']}}"/>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="password" name="ev_password" class="form-control radius"
                                   placeholder="EagleView Password"
                                   value="{{$data['company']['ev_password']}}"/>
                        </div>
                    </div>

                    <div class="col-md-6 mt-15">
                        <div class="checkbox">
                            <label> <input type="checkbox" name="authorize_orders"/> Place EagleView orders through this
                                account. </label>
                        </div>

                    </div>

                    <div class="col-md-12 mt-15">
                        <p class="ft-bold">I authorize Fieldscope to place orders through the EagleView account
                            above.</p>
                    </div>

                    <div class="col-md-12">
                        <button type="submit" class="btn btn-add ft-left">Authorize Orders</button>
                    </div>
                </div>
            </form>
            <div class="row" style="padding-top: 40px;">

                <div class="col-md-10 mt-15">
                    <p class="ft-bold">Step 2: Select which products and delivery options you would like to make
                        available
                        for
                        ordering through JobNimbus. Then Click "Save".</p>
                </div>
                <div class="col-md-2 mt-15">
                    <p class="text-right" style="font-weight: bold;"><a class="blue ev-select-all"
                                                                        style="cursor: pointer;">Select
                            All</a></p>
                </div>

                <form method="POST" action="{{URL::to('subadmin/ev/company_product')}}" enctype="multipart/form-data"
                      onsubmit="return confirm('Are you sure ?');"
                >
                    {{csrf_field()}}
                    <div class="col-md-12 mt-15">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Products available from EagleView</th>
                                <th>Delivery Options</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($data['evProducts'] AS $pKey => $pItem)
                                <tr class="product-row">
                                    <td>
                                        <div class="checkbox">
                                            <label> <input type="checkbox" value="{{$pItem['id']}}"
                                                           name="primary_product_id[]"
                                                           class="product-id" {{$pItem['company_selected'] ? 'checked' : ''  }}/> {{$pItem['name']}}
                                            </label>
                                        </div>
                                    </td>

                                    <td>
                                        @foreach($pItem['delivery_products'] AS $dpKey => $dpItem)
                                            <div class="checkbox">
                                                <label> <input type="checkbox" value="{{$dpItem['id']}}"
                                                               name="delivery_product_id[{{$pItem['id']}}][]"
                                                               class="delivery-product-id" {{$dpItem['company_selected'] ? 'checked' : ''  }} /> {{$dpItem['name']}}
                                                </label>
                                            </div>
                                        @endforeach

                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>

                    <div class="col-md-12">
                        <button type="submit" class="btn btn-add ft-left">Save</button>
                    </div>
                </form>
            </div>
        </div>
        {{--Eagle View: Ends--}}


        @endsection
        @push('page_level_scripts')
            <script type="text/javascript">
                $(document).ready(function () {
                    var question_option = $(".question_option").first().html();
                    question_option = '<div class="col-md-12 form-group pull-right top_search question_option">' + question_option + "</div>";
                    $(document).on("click", ".add_option", function (e) {
                        console.log($(this).parent().parent());

                        var countVal = $count.val();
                        question_option = question_option.replace(/option\[0]\[]/g, "option[" + countVal + "][]");
                        $(this).parent().parent().find(".question_options").append(question_option);

                        //  alert();
                        // console.log($(this).closest('.add_option'));
                        //  //$(this).parent().parent().find('.options_container').append(question_option);
                    });
                    var $question = $(".question").first().html();
                    $question = '<div class="col-md-12 question">' + $question + "</div>";
                    console.log($question);

                    $(".thumbnail_remove_link").on("click", function (e) {
                        e.preventDefault();
                        var $imageInput = '<input type="file" name="logo" class="form-control radius" required/>';
                        var $container = $(this).closest(".thumbnail_container");
                        $container.html($imageInput);

                        $container.show();
                        console.log();
                    });

                    $('.product-id').on('click', function (e) {

                        if (!$('.product-id').prop('checked')) {
                            /** Unchecked */
                            var $productRow = $(this).closest('.product-row');
                            var $checked_Dproducts = $productRow.find('.delivery-product-id:checked');

                            $checked_Dproducts.prop('checked', false);
                        }
                    });

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
    </div>
   </section>
