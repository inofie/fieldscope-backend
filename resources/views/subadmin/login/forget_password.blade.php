@include('subadmin.login.head')
   <body>
      <section class="container">
         <div class="row py-5">
            <div class="col-md-12 text-right">
               <a href="{{URL::to('subadmin/login')}}"><button class="btn btn-add">Login</button></a>
            </div>
         </div>
         <div class="row section">
            <div class="col-md-5">
               <div class="text-center">
                  <img src="{{asset('image/logo.png')}}" class="img-fluid">
                  <p class="mt-4">Enter the email address associated with your account</p>
               </div>
               @include('subadmin.login.error')
                <form method="post" class="login">
                    {{ csrf_field() }}
                    <input type="hidden" class="submit_url"  value="{{ URL::to('user/forgot/password') }}" />
                    <div class="input-group mb-3">
                     <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1"><i class="fa fa-envelope-o" aria-hidden="true"></i></span>
                     </div>
                     <input type="email" name="email" class="form-control" placeholder="Email" id="custom-input1" required="required" autocomplete="off">
                  </div>
                    <button class="btn btn-lg btn-add ft-16 btn-block" id="submit-btn">Submit</button>
                </form>
            </div>
            <div class="col-md-7 text-center">
               <img src="{{asset('image/house.png')}}" class="img-fluid house">
            </div>
         </div>
      </section>
      @include('subadmin.login.footer')
      <script src="{{asset('assets/js/tenant-js/common.js')}}"></script>
{{--      <script src="{{asset('assets/js/tenant-js/login.js')}}"></script>--}}
</html>