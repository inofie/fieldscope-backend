<?php
//echo "<pre>";
$session = \Session::all();
$user = $session['user'];
//print_r($user); die;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <title>subadmin </title>
    <!-- Bootstrap -->
    <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/css/subadmin/style.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
    <link rel="icon" href="{{ asset('image/logo.png') }}" type="image/gif" sizes="16x16">

    <!-- NProgress -->
    <link href="{{asset('assets/css/nprogress.css')}}" rel="stylesheet">
    <!-- jQuery custom content scroller -->
    <link href="{{asset('assets/css/jquery.mCustomScrollbar.min.css')}}" rel="stylesheet"/>

    <!-- Custom Theme Style -->
    <link href="{{asset('assets/css/custom.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/css/mytheme.css')}}" rel="stylesheet">
    <link href="{{asset('assets/select2/css/select2.css')}}" rel="stylesheet">
    

    <link href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/rowreorder/1.2.5/css/rowReorder.dataTables.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.5.3/css/bootstrap-colorpicker.css"
    rel="stylesheet">
    <!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.5.3/css/bootstrap-colorpicker.min.css" rel="stylesheet"> -->
    <!-- <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/@simonwep/pickr/dist/themes/classic.min.css"
    />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/@simonwep/pickr/dist/themes/monolith.min.css"
    />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/@simonwep/pickr/dist/themes/nano.min.css"
    /> -->
     

    <script>
        var base_url = "{{URL::to('/')}}";
    </script>

    <!--Start: Page Level CSS-->
    @stack('page_level_css')
    <!--End: Page Level CSS-->

</head>
<body class="nav-md">
<div class="container body">
    <div class="main_container">
        @include('subadmin.include.nav')
        @include('subadmin.include.sidebar')
        <div class="right_col right-col-modified" role="main">
            <?php //print_r($data); /*die;*/?>
            @include('subadmin.error')
            @yield('content')

        </div>
    </div>
</div>

<!-- jQuery -->
<script src="{{asset('assets/js/jquery.min.js')}}"></script>
<!-- Bootstrap -->
<script src="{{asset('assets/js/bootstrap.min.js')}}"></script>

<!-- FastClick -->
<script src="{{asset('assets/js/fastclick.js')}}"></script>
<!-- NProgress -->
<script src="{{asset('assets/js/nprogress.js')}}"></script>
<!-- jQuery custom content scroller -->
<script src="{{asset('assets/js/jquery.mCustomScrollbar.concat.min.js')}}"></script>
<!-- Custom Theme Scripts -->
<script src="{{asset('assets/js/custom.js')}}"></script>

<script src="{{asset('assets/select2/js/select2.min.js')}}"></script>
{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.bundle.js"></script>--}}
{{--<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script> To be removed commented on Dec-2022 --}}

<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/rowreorder/1.2.5/js/dataTables.rowReorder.min.js"></script>


<script src="{{asset('assets/js/custom-datatable.js')}}"></script>


@stack('page_level_scripts')
<script type="text/javascript">
		// When the user scrolls the page, execute myFunction
		window.onscroll = function() {myFunction()};

		// Get the header
		var header = document.getElementById("nav-header-modified");
		var sidebarMargin = document.getElementById("sidebar-special");
		// Get the offset position of the navbar
		// var sticky = header.offsetTop;

		// Add the sticky class to the header when you reach its scroll position. Remove "sticky" when you leave the scroll position
		function myFunction() {
		if (window.scrollY > 77) {
			sidebarMargin.classList.add("special-margin");
		}
		   else {
        sidebarMargin.classList.remove("special-margin");
		    // header.classList.add("normal-margin");
       }
		}
	</script>
</body>
</html>