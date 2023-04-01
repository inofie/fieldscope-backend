@extends('subadmin.master')
@section('content')
    <div class="row nomargin" id="top">
        <div class="col-md-9">
        <h1 class="main-heading">Re-Subscribe</h1>
        </div>
    </div>
    <div class="container">
        {{--<div class="col-md-12 form-group pull-right top_search" id="search-bar">--}}
        {{--<div class="input-group">--}}
        {{--<input value="{{\Request::input('keyword')}}" id="search-input" type="text" class="form-control " placeholder="Search for...">--}}
        {{--<span class="input-group-btn">--}}
        {{--<button id="search-btn" class="btn btn-default search-btn" type="button">--}}
        {{--<i class="fas fa-search"></i>--}}
        {{--</button>--}}
        {{--</span>--}}
        {{--</div>--}}
        {{--</div>--}}
        <div class="row nomargin">
            <form id="resub_form" method="POST" action="{{URL::to('subadmin/re_subscription')}}">
                {{csrf_field()}}
                <div class="col-md-12 col-sm-12 col-xs-12">

                    {{--                <div class="form-group col-md-6">--}}
                    {{--                    <input type="text" name="question[]" class="form-control radius"--}}
                    {{--                           placeholder="Enter your question">--}}
                    {{--                </div>--}}
                    <div class="form-group col-md-6">
                        <label for="plan">Subscripion Plan</label>
                        <select id="plan" name="plan" class="form-control inputs">
                            <option disabled selected>Select Subscription Plan</option>
                            @foreach($data['subs'] AS $key => $item)
                                <option value="{{$item->id}}">{{ucfirst($item->type)}} - {{ucfirst($item->title)}} -
                                    {{ucfirst($item->per_user_amount)}} per user - ({{$item->duration}} {{ucfirst($item->duration_unit)}})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="card-element">Credit Card Details</label>
                        <div id="card-element" style="    margin-top: 20px;">
                            <!-- A Stripe Element will be inserted here. -->
                        </div>
                        <!-- Used to display form errors. -->
                        <div id="card-errors" role="alert"></div>
                    </div>


                    <div class="col-md-12">
                        <button type="submit" class="btn btn-add ft-left btn-pmadd-modified">Re-subscribe</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection


@push('page_level_css')
    {{--    <style>--}}
    {{--        /**--}}
    {{--     * The CSS shown here will not be introduced in the Quickstart guide, but shows--}}
    {{--     * how you can use CSS to style your Element's container.--}}
    {{--     */--}}
    {{--        .StripeElement {--}}
    {{--            box-sizing: border-box;--}}

    {{--            height: 40px;--}}

    {{--            padding: 10px 12px;--}}

    {{--            border: 1px solid transparent;--}}
    {{--            border-radius: 4px;--}}
    {{--            background-color: white;--}}

    {{--            box-shadow: 0 1px 3px 0 #e6ebf1;--}}
    {{--            -webkit-transition: box-shadow 150ms ease;--}}
    {{--            transition: box-shadow 150ms ease;--}}
    {{--        }--}}

    {{--        .StripeElement--focus {--}}
    {{--            box-shadow: 0 1px 3px 0 #cfd7df;--}}
    {{--        }--}}

    {{--        .StripeElement--invalid {--}}
    {{--            border-color: #fa755a;--}}
    {{--        }--}}

    {{--        .StripeElement--webkit-autofill {--}}
    {{--            background-color: #fefde5 !important;--}}
    {{--        }--}}
    {{--    </style>--}}
@endpush

@push('page_level_scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            $('.select2').select2({
                placeholder: "Select Your Option"
            });

            var updateUrl = "{{URL::to('subadmin/project/update')}}";
            var $editModal = $('#editModal');

            $("td a.delete").on('click', function (e) {
                return confirm("Are you sure ?");
            });

            $('#search-btn').on('click', function (e) {
                var keyword = $('#search-input').val();
                search(keyword);
            });

            $('.stateInput').on('change', function (e) {
                var id = $(this).val();
                var $input = $(this);
                $.getJSON('{{URL::to('subadmin/cities')}}/' + id, function (response) {
                    var items = [];
                    $.each(response.data, function (key, val) {
                        items.push("<option value='" + val.id + "'>" + val.name + "</option>");
                    });
                    // console.log($('.stateInput').closest('.row').find('.cityInput'));
                    $input.closest('.row').find('.cityInput').append(items.join(""));
                });
                //search(keyword);
            });

            function search(keyword) {
                var url = new URL(window.location.href);
                url.searchParams.set('keyword', keyword);
                url.searchParams.set('page', 1);
                console.log(url.href);
                window.location.href = url.href;
            }

            $("td a.edit_form").on('click', function (e) {
                e.preventDefault();
                console.log('edit');
                var id = $(this).data('id');
                $.ajax({
                    url: "{{URL::to('subadmin/project/editProjectDetails/')}}/" + id,
                    method: "GET",
                    data: '',
                    success: function (response) {
                        var data = response.data;
                        $('#update_form').attr('action', updateUrl + '/' + response.data.id);
                        console.log(response.data);
                        console.log($('#update_form input[name="name"]'));

                        $('#update_form input[name="name"]').val(response.data.name);
                        $('#update_form input[name="address1"]').val(response.data.address1);
                        $('#update_form input[name="address2"]').val(response.data.address2);
                        $('#update_form input[name="postal_code"]').val(response.data.postal_code);
                        $('#update_form input[name="claim_num"]').val(response.data.claim_num);
                        $('#update_form input[name="inspection_date"]').val(response.data.inspection_date);

                        $('#update_form select[name="state_id"] option').each(function (key, item) {
                            if ($(item).val() == response.data.state_id) {
                                $(item).prop('selected', true);
                            }
                        });
                        $('#update_form select[name="state_id"]').trigger('change');

                        // console.log('city_id');
                        // console.log($(document).find('#update_form select[name="city_id"] option'));
                        $('#update_form select[name="city_id"] option').each(function (key, item) {
                            // console.log('city_id');
                            if ($(item).val() == response.data.city_id) {
                                $(item).prop('selected', true);
                            }
                        });

                        $('#update_form select[name="assigned_user_id"] option').each(function (key, item) {
                            if ($(item).val() == response.data.assigned_user_id) {
                                $(item).prop('selected', true);
                            }
                        });


                        $editModal.modal('show');
                    },
                    error: function () {
                        alert("No Network");
                    }
                });
            });
        });
    </script>

    <script src="https://js.stripe.com/v3/"></script>
    <script type="text/javascript">
        // Create a Stripe client.
        var stripe = Stripe('{{config('app.stripe_pub_key')}}');

        // Create an instance of Elements.
        var elements = stripe.elements();

        // Custom styling can be passed to options when creating an Element.
        // (Note that this demo uses a wider set of styles than the guide below.)
        var style = {
            base: {
                color: '#32325d',
                fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                fontSmoothing: 'antialiased',
                fontSize: '16px',
                '::placeholder': {
                    color: '#aab7c4'
                }
            },
            invalid: {
                color: '#fa755a',
                iconColor: '#fa755a'
            }
        };

        // Create an instance of the card Element.
        var card = elements.create('card', {style: style});

        // Add an instance of the card Element into the `card-element` <div>.
        card.mount('#card-element');

        // Handle real-time validation errors from the card Element.
        card.addEventListener('change', function (event) {
            var displayError = document.getElementById('card-errors');
            if (event.error) {
                displayError.textContent = event.error.message;
            } else {
                displayError.textContent = '';
            }
        });

        // Handle form submission.
        var form = document.getElementById('resub_form');
        form.addEventListener('submit', function (event) {
            event.preventDefault();

            stripe.createToken(card).then(function (result) {
                if (result.error) {
                    // Inform the user if there was an error.
                    var errorElement = document.getElementById('card-errors');
                    errorElement.textContent = result.error.message;
                } else {
                    // Send the token to your server.
                    stripeTokenHandler(result.token);
                }
            });
        });

        // Submit the form with the token ID.
        function stripeTokenHandler(token) {
            // Insert the token ID into the form so it gets submitted to the server
            var form = document.getElementById('resub_form');
            var hiddenInput = document.createElement('input');
            hiddenInput.setAttribute('type', 'hidden');
            hiddenInput.setAttribute('name', 'stripeToken');
            hiddenInput.setAttribute('value', token.id);
            form.appendChild(hiddenInput);

            // Submit the form
            form.submit();
        }
    </script>
@endpush