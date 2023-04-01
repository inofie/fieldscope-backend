@include('subadmin.login.head')
   <body>
      <main>
         <!-- <div class="row py-5">
            <div class="col-md-12 text-right">
               <a href="{{URL::to('signup')}}" class="pr-3 theme">Don’t have an account?</a>
               <button class="btn btn-add">Get Started</button>
            </div>
         </div>
         <div class="row section">
            <div class="col-md-5">
               <div class="text-center">
                  <img src="{{asset('image/logo.png')}}" class="img-fluid">
                  <p class="mt-4">Login or sign up to continue.</p>
               </div>
               @include('subadmin.error')
               <form action="{{ url('/subadmin/login') }}" method="post" class="login" autocomplete="off">
                  {{ csrf_field() }}
                  <div class="input-group mb-3">
                     <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1"><i class="fa fa-envelope-o" aria-hidden="true"></i></span>
                     </div>
                     <input type="email" name="email" class="form-control" placeholder="Email" id="custom-input1" required="required" autocomplete="off">
                  </div>
                  <div class="input-group mb-3">
                     <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1"><i class="fa fa-lock" aria-hidden="true"></i></span>
                     </div>
                     <input type="Password" name="password" class="form-control" placeholder="Password" id="custom-input2" required="required">
                  </div>
                  <label>
                  <input name="remember_me" value="1" type="checkbox"> Remember me
                  </label>
                  <input type="submit"  name="submit" value="Login" class="btn btn-lg btn-add ft-16 btn-block" id="login-btn">
               </form>
               <p class="mt-4 text-center"><a class="theme" href="{{URL::to('subadmin/login/forget_password')}}">Forgot Password?</a></p>
            </div>
            <div class="col-md-7 text-center">
               <img src="{{asset('image/house.png')}}" class="img-fluid house">
            </div>
         </div> -->
         <div class="login-mainbg">
                    <div class="login-con">
                        <div class="row" style="width: 100%;margin:0;">
                            <div class="col-md-4 login-leftsidesec py-5 px-4 px-xl-5">
                                <div class="login-headerlogo">
                                    <a href="/">
                                        <img src="{{asset('image/logo-field.png')}}" alt="login header logo" class="login-image" width={159} height={120} />
                                    </a>
                                </div>
                                <!-- <div class="login-afterlogotypo">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor</p>
                                </div> -->
                                <div class="login-body">
                                    <h6>Sign In</h6>
                                    <p>Enter your email address and password to access your account.</p>
                                    @include('subadmin.error')
                                    <form action="{{ url('/subadmin/login') }}" method="post"  autocomplete="off">
                                        {{ csrf_field() }}
                                        <div class="form-group">
                                            <label htmlfor="custom-input1">Email address</label>
                                            <input type="email" name="email" class="form-control login-ipfields" id="custom-input1" placeholder="Enter your email" required="required" autocomplete="off"  />                                            
                                        </div>
                                        <div class="form-group">
                                           <div class="flex-item">
                                           <label htmlfor="custom-input2" class="login-forgetpassword">Password</label>  
                                            <a href="{{URL::to('subadmin/login/forget_password')}}" class="login-forgotpass">Forgot your password?</a>
                                           </div>                                          
                                            <input type="password" name="password" class="form-control login-ipfields" id="custom-input2" required="required" placeholder="Enter your password"/>
                                            
                                        </div>
                                        <div class="form-group form-check login-form-check">
                                            <input type="checkbox" name="remember_me" value="1" class="form-check-input login-ipcheck" id="exampleCheck1" checked />
                                            <label class="form-check-label m-0" htmlfor="exampleCheck1">Remember me</label>
                                        </div>
                                        <input type="submit" name="submit" class="login-btn" value="Login"  id="login-btn" />
                                    </form>
                                    <div class="login-rightside-headersec text-right mt-4 login-for-sc">
                                        <a href="{{URL::to('signup')}}" class="login-for-sc-dha" >Don’t have an account? </a>
                                        <button >get started</button>
                                    </div>
                                    <div class="ml-auto text-center login-icondiv">
                                        <div class="d-inline-block mr-3 login-icon-as"><a href="/"><img src="{{asset('image/app.png')}}"  alt="app store icon" /></a></div>
                                        <div class="d-inline-block login-icon-ps"><a href="/"><img src="{{asset('image/android.png')}}"  alt="google play store icon" /></a></div>
                                    </div>
                                    <div class="login-rightside-footersec text-right footer-for-sc login-footer">                                 

                                        <ul class="mb-0">
                                            <li><a href="/">@2021 RaceTrack Connection</a></li>
                                            <li><a href="/">Site Map</a></li>
                                            <li><a href="/" class="mr-0">Privacy Policy</a></li>
                                        </ul>                                                            
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8 login-rightsidesec p-4">
                                <div class="login-rightside-headersec text-right login-for-lc">
                                    <a href="{{URL::to('signup')}}" class=" login-for-sc-dha">Don’t have an account? </a>
                                    <button >get started</button>
                                </div>
                                <div class="login-rightsidevhdiv"></div>                                
                            </div>    
                                                    
                        </div>
                        <div class="login-rightside-footersec text-right footer-ls login-footer">                                 
                            <ul class="mb-0">
                                <li><a href="/">@2021 RaceTrack Connection</a></li>
                                <li><a href="/">Site Map</a></li>
                                <li><a href="/" class="mr-0">Privacy Policy</a></li>
                            </ul>                                                            
                        </div>
                    </div>
                  </div>
</main>
      <!-- @include('subadmin.login.footer') -->
</html>