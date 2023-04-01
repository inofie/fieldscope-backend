<!DOCTYPE html>
<html lang="en">
<head>
    <title>Fieldscope</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    {{--<link rel="icon" href="images/icon.png" type="image/gif" sizes="16x16">--}}
    <link rel="icon" href="{{ asset('image/logo.png') }}" type="image/gif" sizes="16x16">
    {{--<link rel="stylesheet" href="style.css">--}}
    <link href="{{asset('assets/css/web-page/style.css')}}" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <script src="https://js.stripe.com/v3/"></script>
    <style>
        /**
     * The CSS shown here will not be introduced in the Quickstart guide, but shows
     * how you can use CSS to style your Element's container.
     */
        .StripeElement {
            box-sizing: border-box;

            height: 40px;

            padding: 10px 12px;

            border: 1px solid transparent;
            border-radius: 4px;
            background-color: white;

            box-shadow: 0 1px 3px 0 #e6ebf1;
            -webkit-transition: box-shadow 150ms ease;
            transition: box-shadow 150ms ease;
        }

        .StripeElement--focus {
            box-shadow: 0 1px 3px 0 #cfd7df;
        }

        .StripeElement--invalid {
            border-color: #fa755a;
        }

        .StripeElement--webkit-autofill {
            background-color: #fefde5 !important;
        }
    </style>
</head>
<body id="signup">
<div class="container" id="signup-1">
    <div class="text-right">
        <span id="text-color">Already have an Account?<a href="{{URL::to('subadmin/login')}}"
                                                         class="btn">Login</a></span>
    </div>
</div>
<div class="row">
    <div class="col-md-12 test" style="/*background-color: #00aee7;*/
    margin: 20px 0px;">
        {{--<img src="images/logo.png" class="img-responsive" style="margin:50px auto;">--}}
        <img src="{{asset('assets/web-images/logo.png')}}" class="img-responsive" style="margin:50px auto;">
    </div>
</div>
@include('web.error')
<div class="row" style="min-height:500px;">
    <div class="col-md-8 col-md-offset-2">
        <div class="card">
            <div class="row r1" style="background: #00aee7;color:white;">
                <h1 class="text-center">Sign Up</h1>
            </div>
            <div class="row">
                <form action="{{URL::to('register').'/'.$data['plan_type']}}" method="POST" style="padding:30px;"
                      id="register-form" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <div class="row">
{{--                        <div class="col-md-12">--}}
{{--                            <div class="form-group">--}}
{{--                                <label>Package</label>--}}
{{--                                <select name="plan" class="form-control" id="sel1">--}}
{{--                                    @foreach($data['subs'] AS $key  => $item)--}}
{{--                                        <option value="{{$item['id']}}">{{$item['title']}}</option>--}}
{{--                                    @endforeach--}}
{{--                                </select>--}}
{{--                            </div>--}}
{{--                        </div>--}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Name</label>
                                <input name="name" type="text" class="form-control" placeholder="Enter Name">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Email</label>
                                <input name="email" type="email" class="form-control" placeholder="Enter Email">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Password</label>
                                <input name="password" type="password" class="form-control"
                                       placeholder="Enter Password">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Confirm Password</label>
                                <input name="password_confirmation" type="password" class="form-control"
                                       placeholder="Confirm Password">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Contact Number</label>
                                <input name="mobile_no" type="text" class="form-control"
                                       placeholder="Enter Mobile Number">
                            </div>
                        </div>
{{--                        <div class="col-md-6">--}}
{{--                            <div class="form-group">--}}
{{--                                <label for="card-element">Credit Card Details</label>--}}
{{--                                <div id="card-element">--}}
{{--                                    <!-- A Stripe Element will be inserted here. -->--}}
{{--                                </div>--}}
{{--                                <!-- Used to display form errors. -->--}}
{{--                                <div id="card-errors" role="alert"></div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
                        {{--<div class="col-md-6">--}}
                        {{--<div class="form-group">--}}
                        {{--<label>Logo</label>--}}
                        {{--<input name="image_url" type="file" class="form-control" />--}}
                        {{--</div>--}}
                        {{--</div>--}}
                        <div class="col-md-12">
                            <div class="form-group">
                                <input type="submit" class="btn form-control"
                                       style="background: #00aee7;color:white;margin-top:25px;">
                            </div>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
<div class="row" id="footer">
    <div class="col-md-12">
        <p class="text-center">Copyright FieldScope. All rights Reserved 2019</p>
    </div>
</div>
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
    var form = document.getElementById('register-form');
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
        var form = document.getElementById('register-form');
        var hiddenInput = document.createElement('input');
        hiddenInput.setAttribute('type', 'hidden');
        hiddenInput.setAttribute('name', 'stripeToken');
        hiddenInput.setAttribute('value', token.id);
        form.appendChild(hiddenInput);

        // Submit the form
        form.submit();
    }
</script>

</body>
</html>