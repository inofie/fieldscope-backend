<style>


</style>
<div class="top_nav top-nav-margin header_static">
	<div class="nav_menu nav-menu-bg navmenu-modified align-items-center" id="nav-header-modified">
		<nav class="nav-flex">
			<div class="nav toggle">
				<!-- <a id="menu_toggle"  class="site_title menutoggle-modified"> -->
					<div class="site_title menutoggle-modified">
					<!-- <i class="fa fa-bars"></i> -->
					   <img src="{{asset('image/logo-modified-1.png')}}" class="img-responsive"/>
					</div>
				<!-- </a> -->
			</div>
			<div class="search-input">
			<input value="" id="search-input" name="keyword" type="text" class="form-control" placeholder="Search Projects">
			
				<img src="{{asset('image/search-icon.png')}}" class="img-responsive"/>
			</div>
			<ul class="nav navbar-nav navbar-modified ms-auto navigation " >
				<li>
					<a class="@if(request()->is('subadmin/project')) active-nav @endif" href="{{ URL::to('subadmin/project') }}" >Projects</a>
				</li>
				<li>
					<a class="@if(request()->is('subadmin/photo_feed')) active-nav @endif" href="{{ URL::to('subadmin/photo_feed') }}">Photo Feed</a>
				</li>
				<li class="dropdown">
					<a class="@if(request()->is('subadmin','subadmin/inspect_user','subadmin/user-type','subadmin/inspect_area','subadmin/photo_view','subadmin/require_photo','subadmin/cat_tag','subadmin/tag','subadmin/report','subadmin/questionnaire','subadmin/subscription','subadmin/settings')) active-nav @endif" href="#">Admin</a>
					<ul class="dropdown-content">
						<li>
							<a href="{{ URL::to('subadmin') }}">User Types</a>
						</li>
						<li>
							<a href="{{ URL::to('subadmin/inspect_user') }}">User Managment</a>
						</li>
						<li>
							<a href="{{ URL::to('subadmin/inspect_area') }}">Inspection Areas</a>
						</li>
						<li>
							<a href="{{ URL::to('subadmin/photo_view') }}">Photo View</a>
						</li>
						<li>
							<a href="{{ URL::to('subadmin/require_photo') }}">Required Photos</a>
						</li>
						<li>
							<a href="{{ URL::to('subadmin/cat_tag') }}">Required Photos Tags</a>
						</li>
						<li>
							<a href="{{ URL::to('subadmin/tag') }}">Photo Tags</a>
						</li>
						<li>
							<a href="{{ URL::to('subadmin/report') }}"> Report Management</a>
						</li>
						<li>
							<a href="{{ URL::to('subadmin/questionnaire') }}" >Questionnaire Management</a>
						</li>
						<li>
							<a href="{{ URL::to('subadmin/subscription') }}">Subscription Management</a>
						</li>
						<li>
							<a href="{{URL::to('subadmin/settings')}}">User Setting</a>
						</li>
					</ul>
				</li>
				<li class="d-none"><a href="{{URL::to('subadmin/settings')}}">
				<img src="{{asset('assets/images/subscription-icon-modified.png')}}" class="img-responsive"  alt="Setting image"/>
					</a></li>
				<li class="user-profile-li">
					<a href="javascript:;" class="user-profile dropdown-toggle user-profile-modified" data-toggle="dropdown" aria-expanded="false">
						@php
							$userImage = '';
								$userImageBasePath = env('BASE_URL') .config('constants.USER_IMAGE_PATH');
								if(!empty($user['image_url'])){
									$userImage = $userImageBasePath.$user['image_url'];
								}else{
									$userImage = env('BASE_URL').'image/default_user.png';
								}
						@endphp
						<!-- <img src="{{$userImage}}" alt="User Image"> -->
						<img src="{{asset('assets/images/avatar-img.png')}}" alt="User Image"><span class="user-title">{{$user['first_name']}} {{$user['last_name']}}</span>
						<!-- <span class=" fa fa-angle-down"></span> -->
					</a>

					<ul class="dropdown-menu dropdown-usermenu pull-right">

						{{--<li><a href="{{ URL::to('subadmin/change_password') }}">Change Password</a></li>--}}
						<!-- <li><a href="{{URL::to('subadmin/settings')}}"><i class="fa fa-sign-out pull-right"></i> Settings</a></li> -->
						<!-- <li><div class="divider"></div>					</li> -->
						<li><a href="{{URL::to('subadmin/logout')}}"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
					</ul>
				</li>
			</ul>

		</nav>
	</div>
</div>


@section('js')
	
	<script type="text/javascript">
        $(document).ready(function(){

            var columns = ['nav_user_name','user_image'];
            getEditRecord('POST',base_url + "/tenant/user/profile",{},{},columns); // UPDATE FUNCTION

        })
		$(".navigation li").hover(function() {
		var isHovered = $(this).is(":active");
		if (isHovered) {
			$(this).children("ul").stop().slideDown(300);
		} else {
			$(this).children("ul").stop().slideUp(300);
		}
		});
	</script>
	
	@endsection	