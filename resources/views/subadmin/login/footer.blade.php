<section class="footer">
         <div class="container">
            <div class="row py-4">
               <div class="col-md-2">
                  <p class="ft-14">@2020 Fieldscope</p>
               </div>
               <div class="col-md-2">
                  <p class="ft-14"><a class="theme" href="/">Site Map</a></p>
               </div>
               <div class="col-md-2">
                  <p class="ft-14"><a class="theme" href="/">Privacy Policy</a></p>
               </div>
               <div class="col-md-6 text-right">
                  <a href="/"><img src="{{asset('image/app.png')}}" class="img-fluid wd-100"/></a>
                  <a href="/"><img src="{{asset('image/android.png')}}" class="img-fluid wd-100"/></a>
               </div>
            </div>
         </div>
      </section>
   </body>
   <script src="{{ asset('assets/js/jquery.min.js')}}"></script>
   <script src="{{ asset('assets/js/bootstrap.js') }}"></script>
   <script src="{{asset('assets/js/tenant-js/login.js')}}"></script>
   <script>
      $(function () {
          $('input, select').on('focus', function () {
              $(this).parent().find('.input-group-text').css({'border-color':'#80bdff','color':'#00ADE7','background': '#F7FDFF'});
          });
          $('input, select').on('blur', function () {
              $(this).parent().find('.input-group-text').css({'border-color':'#ced4da','color':'gray','background':'#F5F5F5'});
          });
      
      });
      
            
   </script>