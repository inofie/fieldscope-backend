
<div class="col-md-3 left_col menu_fixed sidemenu-bg sidemenu-mt d-none">
    <div class="left_col scroll-view sidemenu-bg">
        <!-- <div class="navbar nav_title sidemenu-bg nav-title-width" style="border: 0;">
            <a href="{{ URL::to('subadmin/analytics') }}" class="site_title">
                <img src="{{asset('image/logo-modified-1.png')}}" class="img-responsive">
            </a>
        </div> -->

        <div class="clearfix"></div>

        <!-- sidebar menu -->
        <div id="sidebar-menu sidemenu-bg" class="main_menu_side hidden-print main_menu sidebar-nav-modified">
            <div class="menu_section">
                <ul class="nav side-menu sidemenu-color" style="font-size: 12px;" id="sidebar-special">
                    <li><a href="{{ URL::to('subadmin/project') }}"> 
                        <!-- <i class="fas fa-home icon"></i> -->
                        <img src="{{asset('assets/images/home-icon-modified.png')}}" />
                        <span class="menu">Project Management</span></a></li>
                    <li><a href="{{ URL::to('subadmin/photo_feed') }}"> 
                        <!-- <i class="fas fa-images icon"></i> -->
                        <img src="{{asset('assets/images/requiredphoto-icon-modified.png')}}" />
                        <span class="menu">Photo Feed </span></a></li>
                    <!-- <li><a href="{{ URL::to('subadmin/analytics') }}"> <span class="menu">Dashboard</span></a></li> -->
                    <li><a href="{{ URL::to('subadmin') }}"> 
                        <!-- <i class="far fa-user icon" rel="tooltip" title="" ></i> -->
                        <img class="ut-imgclass-modified" src="{{asset('assets/images/usertype-icon-modified.png')}}" />
                        <span class="menu">User Types </span></a></li>
                    <li><a href="{{ URL::to('subadmin/inspect_user') }}">
                        <!-- <i class="fas fa-user-plus icon" ></i></i> -->
                        <img class="ut-imgclass-modified" src="{{asset('assets/images/usermanagement-icon-modified.png')}}" />
                        <span class="menu">User Management</span></a></li>
                    <li><a href="{{ URL::to('subadmin/inspect_area') }}">
                        <img src="{{asset('assets/images/inspectionarea-icon-modified.png')}}" />
                        <!-- <i class="fas fa-map-marker-alt icon" rel="tooltip" title="" ></i> -->
                        <span class="menu">Inspection Areas</span></a></li>
                    <li><a href="{{ URL::to('subadmin/photo_view') }}">
                        <!-- <i class="fas fa-camera-retro icon"></i>-->
                        <img src="{{asset('assets/images/photoviews-icon-modified.png')}}" />                        
                        <span class="menu">Photo Views</span></a></li>
                    <li><a href="{{ URL::to('subadmin/require_photo') }}"> 
                        <!-- <i class="far fa-image icon" rel="tooltip" title="" ></i> -->
                        <img src="{{asset('assets/images/requiredphoto-icon-modified.png')}}" />                        
                        <span class="menu">Required Photos</span></a></li>
                    <li><a href="{{ URL::to('subadmin/cat_tag') }}"> 
                        <!-- <i class="fas fa-tag icon"></i> -->
                        <img src="{{asset('assets/images/requiredphoto-tags-modified.png')}}" /> 
                        <span class="menu">Required Photos Tags</span></a></li>
                    <li><a href="{{ URL::to('subadmin/tag') }}"> 
                        <!-- <i class="fas fa-tags icon"></i> -->
                        <img src="{{asset('assets/images/phototags-modified.png')}}" /> 
                        <span class="menu">Photo Tags</span>
                    </a></li>                    
                    <li><a href="{{ URL::to('subadmin/report') }}"> 
                        <!-- <i class="fas fa-question-circle icon" rel="tooltip" title="" ></i> -->
                        <img src="{{asset('assets/images/reportmanagement-icon-modified.png')}}" /> 
                        <span class="menu">Report Management</span></a></li>
                    <li><a href="{{ URL::to('subadmin/questionnaire') }}"> 
                        <!-- <i class="fas fa-question-circle icon" rel="tooltip" title="" ></i> -->
                        <img src="{{asset('assets/images/questionairemanagement-icon-modified.png')}}" /> 
                        <span class="menu qm-modified">Questionnaire Management</span></a></li>
                    <li><a href="{{ URL::to('subadmin/subscription') }}"> 
                        <!-- <i class="fas fa-bell icon"></i> -->
                        <img src="{{asset('assets/images/subscription-icon-modified.png')}}" />
                        <span class="menu">Subscription Management</span></a></li>
                    <!-- <li><a href="{{ URL::to('subadmin/analytics') }}"> <i class="fas fa-home icon"></i><span class="menu">Dashboard</span></a></li>
                    <li><a href="{{ URL::to('subadmin') }}"> <i class="far fa-user icon" rel="tooltip" title="" ></i><span class="menu">User Type Management</span></a></li>
                    <li><a href="{{ URL::to('subadmin/inspect_user') }}"><i class="fas fa-user-plus icon" ></i></i><span class="menu">Inspector User Management</span></a></li>
                    <li><a href="{{ URL::to('subadmin/inspect_area') }}"><i class="fas fa-map-marker-alt icon" rel="tooltip" title="" ></i><span class="menu">Inspection Area Management</span></a></li>
                    <li><a href="{{ URL::to('subadmin/photo_view') }}"><i class="fas fa-camera-retro icon"></i><span class="menu">Photo Views Management</span></a></li>
                    <li><a href="{{ URL::to('subadmin/require_photo') }}"> <i class="far fa-image icon" rel="tooltip" title="" ></i><span class="menu">Required Photos Management</span></a></li>
                    <li><a href="{{ URL::to('subadmin/cat_tag') }}"> <i class="fas fa-tag icon"></i><span class="menu">Req. Photos Tags Management</span></a></li>
                    <li><a href="{{ URL::to('subadmin/tag') }}"> <i class="fas fa-tags icon"></i><span class="menu">Photo Tags Management</span></a></li>
                    <li><a href="{{ URL::to('subadmin/photo_feed') }}"> <i class="fas fa-images icon"></i><span class="menu">Photo Feed Management</span></a></li>
                    <li><a href="{{ URL::to('subadmin/project') }}"> <i class="fas fa-project-diagram icon"></i><span class="menu">Project Management</span></a></li>
                    <li><a href="{{ URL::to('subadmin/questionnaire') }}"> <i class="fas fa-question-circle icon" rel="tooltip" title="" ></i><span class="menu">Questionnaire Management</span></a></li>
                    <li><a href="{{ URL::to('subadmin/report') }}"> <i class="fas fa-question-circle icon" rel="tooltip" title="" ></i><span class="menu">Report Management</span></a></li>
                    <li><a href="{{ URL::to('subadmin/subscription') }}"> <i class="fas fa-bell icon"></i><span class="menu">Subscription Management</span></a></li> -->

                </ul>
            </div>
        </div>
        <!-- /sidebar menu -->

    </div>
</div>
