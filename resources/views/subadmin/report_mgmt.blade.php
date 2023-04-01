@extends('subadmin.master')
@php
        // dd($templates);
        @endphp
@section('content')
    <style>
        .select2-container{
            width: 100% !important;
        }
        .select2-container--default .select2-search--inline .select2-search__field {
            width: 100% !important;
        }
        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            border-radius: 13px;
            color: white;
            background-color: #00aee7;
        }
        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove{
            color: white;
        }
      
      #main_primary,#main_secondary {
        height: 170px;
        width: 300px;
        display: inline-block;
        border: 1px solid #ccc;
        margin-left: 2rem;
        margin-bottom: 5rem;
      }
      #main_secondary {
          margin-left: 6rem;
      }

      .primary-color {
        display: inline-block;
        position: absolute;
        left: 42%;
        top: 42%;
      }

      .secondary-color {
        display: inline-block;
        position: absolute;
        top: 42%;
        left: 55%;
      }

        .companyinfobody > .form-group > input {
            height: 40px;
            border-radius: 3px;
            background: #F0F1F2;
            font-size: 13px;
            color: #505a6c;
            width: 100%;
            display: block;
            padding: 6px 12px;
            line-height: 1.42857143;
            border: 1px solid transparent;
            margin-bottom: 10px;
            margin-top: 10px;
        }


    </style>
        <!-- New Work  -->
            <section class="report-management-sec">
                 <div class="container">
                     <div class="row">
                         <div class="col-md-12">
                             <div class="card-title">
                                 <h1 class="main-heading">Report Management</h1>

                             </div>
                         </div>
                     </div>
                    <div class="row  new-card-row user-type-table" >
                        <div class="col-12 col-md-12">
                            <table class="table table-striped" >
                                <thead >
                                    <tr class="table-head">
                                        <th class="left w-20">Report Feature</th>
                                        <th class="right w-30">Settings</th>
                                    </tr>
                                </thead>
                                <tbody>
                                        <tr class="table-body">
                                            <td  class="left first-cell">Company Logo</td>
                                           
                                            <td class="right">
                                                <div class="dropdown">
                                                    <button class="dropdown-dots dropdown-toggle"  data-toggle="modal" data-target="#companyLogoModal">
                                                    <img src="{{asset('assets/images/dropdown-dots.png')}}" alt="...">
                                                    </button>
                                                        
                                                    </div>
                                            </td>
                                        </tr>
                                        <tr class="table-body t-row-color">
                                            <td  class="left first-cell">Company Colors</td>
                                            <td class="right">
                                                <div class="dropdown">
                                                    <button class="dropdown-dots dropdown-toggle" data-toggle="modal" data-target="#companyColorsModal">
                                                    <img src="{{asset('assets/images/dropdown-dots.png')}}" alt="...">
                                                    
                                                    </button>
                                                        
                                                    </div>
                                            </td>
                                        </tr>
                                        <tr class="table-body">
                                            <td  class="left first-cell">Company Information</td>
                                           
                                            <td class="right">
                                                <div class="dropdown">
                                                    <button class="dropdown-dots dropdown-toggle" data-toggle="modal" data-target="#companyInformationModal">
                                                    <img src="{{asset('assets/images/dropdown-dots.png')}}" alt="...">
                                                    
                                                    </button>
                                                        
                                                    </div>
                                            </td>
                                        </tr>
                                        <tr class="table-body t-row-color">
                                            <td  class="left first-cell">Cover Page</td>
                                            <td class="right">
                                                <div class="dropdown">
                                                    <button class="dropdown-dots dropdown-toggle" data-toggle="modal" data-target="#coverPageModal" >
                                                    <img src="{{asset('assets/images/dropdown-dots.png')}}" alt="...">
                                                    
                                                    </button>
                                                       
                                                    </div>
                                            </td>
                                        </tr>
                                        <tr class="table-body">
                                            <td  class="left first-cell">Company Introduction</td>
                                           
                                            <td class="right">
                                                <div class="dropdown">
                                                    <button class="dropdown-dots dropdown-toggle" type="button" data-toggle="modal" data-target="#companyIntroductionModal">
                                                    <img src="{{asset('assets/images/dropdown-dots.png')}}" alt="...">
                                                    
                                                    </button>
                                                       
                                                    </div>
                                            </td>
                                        </tr>
                                        <tr class="table-body t-row-color">
                                            <td  class="left first-cell">Credit Disclaimer</td>
                                            <td class="right">
                                                <div class="dropdown">
                                                    <button class="dropdown-dots dropdown-toggle" data-toggle="modal" data-target="#productDisclaimerModal">
                                                    <img src="{{asset('assets/images/dropdown-dots.png')}}" alt="...">
                                                    
                                                    </button>
                                                       
                                                    </div>
                                            </td>
                                        </tr>
                                        <tr class="table-body">
                                            <td  class="left first-cell">Owner Authorization</td>
                                           
                                            <td class="right">
                                                <div class="dropdown">
                                                    <button class="dropdown-dots dropdown-toggle" data-toggle="modal" data-target="#ownerAuthorizationModal">
                                                    <img src="{{asset('assets/images/dropdown-dots.png')}}" alt="...">
                                                    
                                                    </button>
                                                       
                                                    </div>
                                            </td>
                                        </tr>
                                        <tr class="table-body t-row-color">
                                            <td  class="left first-cell">Company Terms and Conditions</td>
                                            <td class="right">
                                                <div class="dropdown">
                                                    <button class="dropdown-dots dropdown-toggle"  data-toggle="modal" data-target="#companyTermsConditionsModal">
                                                    <img src="{{asset('assets/images/dropdown-dots.png')}}" alt="...">
                                                    
                                                    </button>
                                                        
                                                    </div>
                                            </td>
                                        </tr>
                                        <tr class="table-body">
                                            <td  class="left first-cell">Additional  Documents Options</td>
                                           
                                            <td class="right">
                                                <div class="dropdown">
                                                    <button class="dropdown-dots dropdown-toggle"  data-toggle="modal" data-target="#documentOptionsModal">
                                                    <img src="{{asset('assets/images/dropdown-dots.png')}}" alt="...">
                                                    
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="table-body t-row-color">
                                            <td  class="left first-cell">Roof Inspection</td>
                                            <td class="right">
                                                <div class="dropdown">
                                                    <button class="dropdown-dots dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                    <img src="{{asset('assets/images/dropdown-dots.png')}}" alt="...">
                                                    
                                                    </button>
                                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                                            <li><a href="#"  class="edit_form">
                                                            <i class="icon-edit-sign"></i>   
                                                            <img src="{{asset('image/edit.png')}}" alt="..."></a></li>
                                                            <li><a href="# " class="delete"><img src="{{asset('image/trash.png')}}" alt="..."></a></li>
                                                        </ul>
                                                    </div>
                                            </td>
                                        </tr>
                                       
                                </tbody>
                            </table>
                        </div>
                    </div>
             </div>
            </section>
        <!-- New Work  End -->
    {{--To be removed hidden on Dec-2022--}}
    <div class="row nomargin hide">
        <div class="col-md-6">
            <h1 class="main-heading">Report Management </h1>
            <!-- <div class="search-bar pt-3 pb-3">
                <div class="input-group">
                    <input value="{{\Request::input('keyword')}}" id="search-input" name="keyword" type="text" class="form-control " placeholder="Search for..."/>
                        <span class="input-group-btn">
                            <button id="search-btn" class="btn btn-default search-btn" type="button"><i class="fas fa-search"></i></button>
                        </span>
                </div>
            </div> -->
        </div> 
        <div class="col-md-6">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <!-- Trigger the modal with a button -->
                        <button type="button" class="btn btn-add addusertype-btn-modified " data-toggle="modal" data-target="#myModal">import
                        </button>
                        <button type="button" class="btn btn-add addusertype-btn-modified rm-import-btn-modified" data-toggle="modal" data-target="#myModalNew">Add tag
                        </button>
                    </div>
                    <div class="col-md-6"></div>
                    <div class="col-md-6">
                        <div class="search-bar pt-3 pb-3">
                            <div class="input-group">
                                <input value="{{\Request::input('keyword')}}" id="search-input" name="keyword" type="text" class="form-control utminputsearch-modified" placeholder="Search here"
                                style="border-radius: 5px; border: 1px solid transparent;color: #3f3d56;opacity:0.5;">
                                <span class="input-group-btn">
                                    <button id="search-btn" class="btn btn-default search-btn utmsearchbtn-modified" type="button" style="border-radius: 5px; border: 1px solid transparent;"><i class="fas fa-search" ></i></button>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
{{--                <!-- Trigger the modal with a button -->--}}
{{--                <button type="button" class="btn btn-add" data-toggle="modal" data-target="#myModal">Add Required Photo--}}
{{--                </button>--}}

                <!-- ADD TAG Modal New-->
                <div class="modal fade " id="myModalNew" role="dialog">
                    <div class="modal-dialog">
                        <form method="POST" action="{{url('subadmin/report/storeInfo')}}">
                        {{csrf_field()}}
                        <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header logoimageheader">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h3 class="modal-title text-left ">Add Tag</h3>
                                    <hr>
                                </div>
                                <div class="modal-body companyinfobody rm-companyinfobody-modified">
                                    <div class="row d-none">
                                        <div class="col-md-12 companyinfobody rm-companyinfobody-select-modified">
                                            <select name="Tage name" >
                                                <option>tag 1</option>
                                                <option>tag 2</option>
                                                <option>tag 3</option>
                                                <option>tag 4</option>
                                            </select>
                                        </div>
                                        <div class="col-md-12 companyinfobody rm-companyinfobody-modified">
                                            <input type="text" placeholder="Default Annotation Note"  name="name"      value="@if(!empty($report->name)){{$report->name}}@endif" />
                                        </div>
                                        <div class="col-md-6 companyinfobody rm-companyinfobody-modified">
                                            <input type="text" placeholder="Is Required?"  name="name"      value="@if(!empty($report->name)){{$report->name}}@endif" />
                                        </div>
                                        <div class="col-md-6 companyinfobody rm-companyinfobody-modified">
                                            <input type="text" placeholder="Select Photo View"  name="name"      value="@if(!empty($report->name)){{$report->name}}@endif" />
                                        </div>
                                        <div class="col-md-6 companyinfobody rm-companyinfobody-modified">
                                            <input type="text" placeholder="Select Spec Type"  name="name"      value="@if(!empty($report->name)){{$report->name}}@endif" />
                                        </div>
                                        <div class="col-md-6 companyinfobody rm-companyinfobody-modified">
                                            <input type="text" placeholder="Hover Field Type"  name="name"      value="@if(!empty($report->name)){{$report->name}}@endif" />
                                        </div>
                                        <div class="col-md-6 companyinfobody rm-companyinfobody-modified" ></div>
                                        <div class="col-md-6 companyinfobody rm-companyinfobody-modified">
                                            <input type="text" placeholder="Hover Field"  name="name"      value="@if(!empty($report->name)){{$report->name}}@endif" />
                                        </div>
                                        <div class="col-md-6 companyinfobody rm-companyinfobody-modified" style="margin-top:6rem;">
                                            <input type="text" placeholder="Qty"  name="name"      value="@if(!empty($report->name)){{$report->name}}@endif" />
                                        </div>

                                        <div class="col-md-6 companyinfobody rm-companyinfobody-modified" style="margin-top:6rem;">
                                            <input type="text" placeholder="UOM"  name="name"      value="@if(!empty($report->name)){{$report->name}}@endif" />
                                        </div>
                                        <div class="col-md-6 companyinfobody rm-companyinfobody-modified">
                                            <input type="text" placeholder="Material"  name="name"      value="@if(!empty($report->name)){{$report->name}}@endif" />
                                        </div>
                                        <div class="col-md-6 companyinfobody rm-companyinfobody-modified">
                                            <input type="text" placeholder="Labor"  name="name"      value="@if(!empty($report->name)){{$report->name}}@endif" />
                                        </div>
                                        <div class="col-md-6 companyinfobody rm-companyinfobody-modified">
                                            <input type="text" placeholder="Equipment"  name="name"      value="@if(!empty($report->name)){{$report->name}}@endif" />
                                        </div>
                                        <div class="col-md-6 companyinfobody rm-companyinfobody-modified">
                                            <input type="text" placeholder="Supervision"  name="name"      value="@if(!empty($report->name)){{$report->name}}@endif" />
                                        </div>
                                        <div class="col-md-6 companyinfobody rm-companyinfobody-modified">
                                            <input type="text" placeholder="Margin %"  name="name"      value="@if(!empty($report->name)){{$report->name}}@endif" />
                                        </div>
                                        
                                    </div>                                   
                                </div>
                                <div class="modal-footer logoimagefooter">
                                    <button type="button" class="btn btn-close cancelButton" data-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-save bg-modified">Confirm</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- Modal -->
                <div class="modal fade" id="myModal" role="dialog">
                <!-- <div class="modal fade new-modal" id="myModal" role="dialog"> -->
                    <div class="modal-dialog">
                        <form id="add_form" action="{{URL::to('subadmin/require_photo/store')}}" method="POST">
                        {{csrf_field()}}
                        <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header logoimageheader">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h3 class="modal-title text-left ">Add Required Photo</h3>
                                    <hr />
                                </div>
                                <div class="modal-body companyinfobody rm-companyinfobody-modified">
                                    <div class="row">
                                        <div class="col-md-12 companyinfobody rm-companyinfobody-modified form-group">
                                            <!-- <label>Required Photo</label> -->
                                            <input name="name" type="text"  placeholder="Required Photo">
                                        </div>
                                        @if(!empty($data['companyGroups']))
                                            <div class="col-md-12 companyinfobody rm-companyinfobody-select-modified form-group" >
                                            <!-- <label>User Type</label> -->
                                                <select name="company_group_id[]" class="" multiple>
                                                <!-- <select name="company_group_id[]" class="select2 form-control" multiple> -->
                                                    
                                                        <option value="{{$item->id}}">{{$item->title}}</option>
                                                    
                                                </select>
                                            </div>
                                        @endif

                                        <div class="col-md-12 companyinfobody rm-companyinfobody-select-modified form-group">
                                            <!-- <label>Thumbnail @if($data['thumbnailCount'] > 0) (Already Set) @endif</label> -->
                                            <select name="thumbnail" class="select2" data-placeholder="Default Thumbnail"  @if($data['thumbnailCount'] > 0) disabled @endif>
                                                <option value="" disabled selected>Thumbnail @if($data['thumbnailCount'] > 0) (Already Set) @endif</option>
                                                <option value="1">Yes</option>
                                                <option value="0">No</option>
                                            </select>
                                        </div>


                                        <div class="col-md-12 companyinfobody rm-companyinfobody-modified form-group">
                                            <!-- <label>Min Quantity</label> -->
                                            <input name="min_quantity" type="text"  placeholder="Quantity">
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer logoimagefooter">
                                    <button type="button" class="btn btn-close cancelButton" data-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-save bg-modified">Confirm</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

  <!--New Company Logo Modal  -->
    <div class="modal fade" id="companyLogoModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog add-project-modal upload-csv-modal" role="document">
            <form id="js-upload-form" method="POST" action="{{url('subadmin/report/storeLogo')}}" enctype="multipart/form-data">
                {{csrf_field()}}
                <div class="modal-content">
                <div class="modal-header">
                    <div class="header-content">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h3 class="modal-title text-left">Company Logo</h3>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="upload-drop-zone @if(!empty($report->logo_path)) hide @endif" id="drop-zone">
                                <div class="drop-cvs" >
                                    <div class="cvs-border" >
                                        <div class="img-cvs">
                                            <img src="{{asset('assets/images/csvs-img.png')}}" alt="...">
                                        </div>
                                        <div class="cvs-import-tile text-center">
                                            <p>Drag and drop to upload your CSV file </p>
                                            <p><span>Acceptable Formats:</span>jpeg, gif, png, pdf</p>

                                            <div class="fileUpload btn-broswe blue-btn btn width100">
                                                <span><ul class="add-cancel-btn">
                                                    <li class="browse-plus">+</li>
                                                    <li>Browse</li>
                                                </ul></span>
                                                <input name="logo" type="file" id="js-upload-files" class="uploadlogo @if(!empty($report->logo_path)) {{"hide"}} @endif"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                           {{-- <div class="row logo_preview">
                                <div class="col-md-12 text-center">
                                    <img  src="" class="img-thumbnail hide" style="max-height: 300px;"/>
                                </div>
                            </div>--}}


                            <div class="row image_preview @if(empty($report->logo_path)) hide @endif" >
                                @if(!empty($report->logo_path)) <input type="hidden" name="image_set" value="true" /> @endif
                                <div class="col-md-12 text-center">
                                    <img  src="{{url("uploads/report_templates/".$report->logo_path)}}" class="img-thumbnail" style="max-height: 300px;"/>
                                </div>
                                <div class="col-md-12 text-center pt-3">
                                    <button type="button" class="btn btn-danger image_remove">Remove</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer footer-switch-btn">
                        <div class="switch-btn">
                        </div>
                        <div class="add-cancel-bnt">
                                <button type="button" class="btn btn-close cancelButton" data-dismiss="modal">
                                    <ul class="add-cancel-btn">
                                        <li>-</li>
                                        <li> Cancel</li>
                                    </ul>
                                </button>
                                <button type="submit" class="btn btn-save bg-modified">
                                    <ul class="add-cancel-btn">
                                        <li>+</li>
                                        <li>Save</li>
                                    </ul>
                                </button>
                        </div>
                </div>
            </div>
            </form>
        </div>
    </div>
    <!---New Company Logo Modal End -->

    {{--Old Logo Modal --}}
    <div class="modal fade " id="logoImageModal" role="dialog">
        <div class="modal-dialog">
            <form method="POST" action="{{url('subadmin/report/storeLogo')}}" enctype="multipart/form-data">
                {{csrf_field()}}

                <!-- Modal content-->
                <div class="modal-content ">
                    <div class="modal-header logoimageheader">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h3 class="modal-title text-left ">Company Logo</h3>
                        <hr>
                    </div>

                    <div class="modal-body logoimagebody">
                        <p>This logo will be used in the header and on the cover page of your reports.</p>
                        <div class="form-group logoimagemodalfiles @if(!empty($report->logo_path)) {{"hide"}} @endif">
                            {{-- <label>Upload Your File </label> --}}
                            {{-- <div class="inputlogoimage"></div> --}}
                            <input type="file" class="form-control" name="logo">
                        </div>

                           <div class="row image_preview @if(empty($report->logo_path)) hide @endif" >
                               @if(!empty($report->logo_path)) <input type="hidden" name="image_set" value="true" /> @endif
                               <div class="col-md-12 text-center">
                                   <img  src="{{url("uploads/report_templates/".$report->logo_path)}}" class="img-thumbnail" style="max-height: 300px;"/>
                               </div>
                               <div class="col-md-12 text-center pt-3">
                                   <button type="button" class="btn btn-danger image_remove">Remove</button>
                               </div>
                           </div>
                    </div>

                    <div class="modal-footer logoimagefooter">
                        <button type="button" class="btn btn-close cancelButton" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-save bg-modified">Confirm</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Company Information Modal -->
    <div class="modal fade " id="companyInformationModal" role="dialog">
        <div class="modal-dialog add-project-modal">
            <form method="POST" action="{{url('subadmin/report/storeInfo')}}">
            {{csrf_field()}}
            <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header logoimageheader">
                        <div class="header-content">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h3 class="modal-title text-left">Company Information</h3>
                        </div>
                    </div>
                    <div class="modal-body companyinfobody rm-companyinfobody-modified">
                        <input type="text" placeholder="Company Name"  name="name"      value="@if(!empty($report->name)){{$report->name}}@endif" />
                        <input type="text" placeholder="Company Email" name="email"     value="@if(!empty($report->email)){{$report->email}}@endif" />
                        <input type="text" placeholder="Company Phone" name="phone"     value="@if(!empty($report->phone)){{$report->phone}}@endif" />
                        <input type="text" placeholder="Website"       name="website"   value="@if(!empty($report->website)){{$report->website}}@endif" />
                        <input type="text" placeholder="Our Services"  name="services"  value="@if(!empty($report->services)){{$report->services}}@endif" />
                    </div>
                    <div class="modal-footer logoimagefooter">
                    <div class="add-cancel-bnt">
                        <button type="button" class="btn btn-close cancelButton" data-dismiss="modal">
                            <ul class="add-cancel-btn">
                              <li>-</li>
                             <li> Cancel</li>
                            </ul>
                        </button>
                          <button type="submit" class="btn btn-save bg-modified">
                                <ul class="add-cancel-btn">
                                        <li>+</li>
                                        <li>Save</li>
                                    </ul>
                            </button>
                    </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Cover Page Modal -->
    <div class="modal fade " id="coverPageModals" role="dialog">
        <div class="modal-dialog">
            <form id="report-image" action="{{url('subadmin/report/storeCoverInfo')}}" method="POST" enctype="multipart/form-data">
            {{csrf_field()}}
            <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header logoimageheader">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h3 class="modal-title text-left ">Cover Page</h3>
                        <hr>
                    </div>
                    <div class="modal-body companyinfobody coverPageModal rm-companyinfobody-modified">
                        <input type="text" placeholder="Report Name" name="report_name" value="@if(!empty($report->report_name)) {{$report->report_name}} @endif" />

                        <div class="form-group cover_image @if(!empty($report->report_cover_image)) {{"hide"}} @endif">
                            <input type="file" style="line-height: 2.428571;" placeholder="Cover Page Image" name="cover_image">
                        </div>

                        <div class="row image_preview @if(empty($report->report_cover_image)) hide @endif" >
                            @if(!empty($report->report_cover_image)) <input type="hidden" name="image_set" value="true" /> @endif
                            <div class="col-md-12 text-center">
                                <img  src="{{url("uploads/report_templates/".$report->report_cover_image)}}" class="img-thumbnail" style="max-height: 300px;"/>
                            </div>
                            <div class="col-md-12 text-center pt-3">
                                <button type="button" class="btn btn-danger image_remove ">Remove</button>
                            </div>
                        </div>

                        <h3>Footer Settings</h3>
                        <p>Select which user information you want to display in the footer on the cover page. Main company information will display by default.</p>
                        <div class="coverPageModalCheckBox">
                            <label class="container firstcheckbox">User Name
                                <input type="checkbox" name="user_name" value="true" @if(!empty($report->is_footer_user_name)) checked="checked" @endif />
                                <span class="checkmark"></span>
                            </label>
                            <label class="container">User Email
                                <input type="checkbox" name="user_email" value="true" @if(!empty($report->is_footer_user_email)) checked="checked"  @endif />
                                <span class="checkmark"></span>
                            </label>
                            <label class="container">User Mobile Number
                                <input type="checkbox" name="user_number" value="true" @if(!empty($report->is_footer_user_phone)) checked="checked"  @endif />
                                <span class="checkmark"></span>
                            </label>
                           
                            {{-- <input type="radio" id="username" name="userinformation" value="username">
                            <label for="username">User Name</label>
                            <input type="radio" id="useremail" name="userinformation" value="useremail" >
                            <label for="useremail">User Email</label>
                            <input type="radio" id="usermobilenumber" name="userinformation" value="usermobilenumber" > 
                            <label for="usermobilenumber">User Mobile Number</label> --}}
                        </div>                        
                    </div>
                    <div class="modal-footer logoimagefooter">
                        <button type="button" class="btn btn-close cancelButton" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-save bg-modified">Confirm</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

     <!-- New Cover Page Modal -->
    <div class="modal fade " id="coverPageModal" role="dialog">
        <div class="modal-dialog add-project-modal">
            <form id="report-image" action="{{url('subadmin/report/storeCoverInfo')}}" method="POST" enctype="multipart/form-data">
            {{csrf_field()}}
            <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header logoimageheader">
                        <div class="header-content">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h3 class="modal-title text-left">Cover Page</h3>
                        </div>
                    </div>
                    <div class="modal-body companyinfobody  rm-companyinfobody-modified">
                        <input type="text" placeholder="Report Name" name="report_name" value="@if(!empty($report->report_name)) {{$report->report_name}} @endif" />

                        <div class="form-group cover_image pen-cover-img @if(!empty($report->report_cover_image)) {{"hide"}} @endif">
                           
                            <div class="form-group setting-from-group">
                                    <label for="file">choose a file</label>
                                        <input id="file" class="form-control input-filke" type="file" placeholder="Cover Image" name="cover_image" />
                                    </div>
{{--                            <img src="{{asset('assets/images/edit-pen-img.png')}}" alt="...">--}}
                        </div>

                        <div class="row image_preview @if(empty($report->report_cover_image)) hide @endif" >
                            @if(!empty($report->report_cover_image)) 
                            <input type="hidden" name="image_set" value="true" /> @endif
                            <div class="col-md-12 text-center">
                                <img  src="{{url("uploads/report_templates/".$report->report_cover_image)}}" class="img-thumbnail" style="max-height: 300px;"/>
                            </div>
                            <div class="col-md-12 text-center pt-3">
                                <button type="button" class="btn btn-danger image_remove cover">Remove</button>
                            </div>
                        </div>

                        <div class="footer-seeting">
                            <p class="footer-seeting-title">Footer Settings</p>
                            <p>Select which user information you want to display in the footer on the cover page. Main company information will display by default.</p>
                            <div class="radio-box">
                                <label class="radio-inline"><input type="checkbox" value="true" name="user_name" @if(!empty($report->is_footer_user_name)) checked="checked" @endif  >User Name</label>
                                <label class="radio-inline"><input type="checkbox" value="true" name="user_email" @if(!empty($report->is_footer_user_email)) checked="checked" @endif >User Email </label>
                                <label class="radio-inline"><input type="checkbox" value="true" name="user_number" @if(!empty($report->is_footer_user_phone)) checked="checked" @endif >Use Mobile Number </label>
                            </div>
                        </div>
                                        
                    </div>
                    <div class="modal-footer logoimagefooter">
                    <div class="add-cancel-bnt">
                        <button type="button" class="btn btn-close cancelButton" data-dismiss="modal">
                                <ul class="add-cancel-btn">
                                    <li>-</li>
                                    <li> Cancel</li>
                                </ul>
                            </button>
                            <button type="submit" class="btn btn-save bg-modified">
                                <ul class="add-cancel-btn">
                                    <li>+</li>
                                    <li>Save</li>
                                </ul>
                            </button>
                    </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
     <!-- New Cover Page Modal -->

    <!-- Credict Disclaimer Modal -->
    <div class="modal fade " id="productDisclaimerModal" role="dialog">
    <div class="modal-dialog add-project-modal">
        <form id="report-image" action="{{url('subadmin/report/storeInfo')}}" method="POST">
            {{csrf_field()}}

        <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header logoimageheader">
                    <div class="header-content">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h3 class="modal-title text-left">Credit Disclaimer</h3>
                    </div>
                </div>
                <div class="modal-body companyinfobody coverPageModal rm-companyinfobody-modified">
                    <input type="text" placeholder="Credit Disclaimer" name="credit_disclaimer" value="@if(!empty($report->credit_disclaimer)){{$report->credit_disclaimer}}@endif"/>
                    <div class="coverPageModalCheckBox creditPageModalCheckBox">
                        <p>Active:</p>
                        <input type="radio" id="yes" name="is_disclaimer" value="1" @if($report->is_disclaimer > 0)checked="checked"@endif />
                    <label for="yes">Yes</label>
                    <input type="radio" id="no" name="is_disclaimer" value="0" @if($report->is_disclaimer < 1)checked="checked"@endif>
                    <label for="no">No</label>
                    </div>
                </div>
                <div class="modal-footer logoimagefooter">
                    <button type="button" class="btn btn-close cancelButton" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-save bg-modified">Confirm</button>
                </div>
            </div>
        </form>
    </div>
    </div>

    <!-- Owner Authorization Modal -->
    <div class="modal fade " id="ownerAuthorizationModal" role="dialog">
        <div class="modal-dialog add-project-modal">
            <form id="report-image" action="{{ action('ReportController@storeOwnerAuthorization') }}" method="POST">
                {{ csrf_field() }}
                <div class="modal-content">
                    <div class="modal-header logoimageheader ownerAuthorizationModal">
                        <div class="header-content">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h3 class="modal-title text-left">Owner Authorization</h3>
                        </div>
                    </div>
                    <div class="modal-body companyinfobody coverPageModal ownerAuthModalBody rm-companyinfobody-modified">
                        <input type="text" required value="{{ $report->estimate_terms }}" name="estimate_terms" placeholder="Estimate Terms" name="disclaimercredit">
                        <div class="bodysecitems">
                            <h3>Section Items</h3>
                            <p>These items will show on owner authorization as additional available options for your clients to select in additions to the other items on the estimate.</p>
                            <div id="_section_items_continer" class="rm-companyinfobody-modified">
                                 @if( !empty($report->json_data) )
                                    @php
                                       $json_data = json_decode($report->json_data);
                                    @endphp
                                    @for( $i=0; $i < count($json_data->section_item->item); $i++ )
                                        <input type="text" value="{{ $json_data->section_item->item[$i] }}" name="section_item[]" placeholder="Item" class="item-input-price ">
                                        <input type="number" value="{{ $json_data->section_item->price[$i] }}" name="section_price[]" placeholder="Price" class="form-control priceinput">
                                    @endfor
                                 @else
                                    <input type="text" name="section_item[]" placeholder="Item" class="form-control iteminput">
                                    <input type="number" name="section_price[]" placeholder="Price" class="form-control priceinput">
                                 @endif 
                            </div>
                            <a id="add_more_section_item" href="javascript:void(0)"><span>Add Item</span> </a>
                        </div>
                        <div class=" bodysecitems itemoptions">
                            <h3>Item Options</h3>
                            
                            <div id="item_option_container" class="rm-companyinfobody-modified">
                                @if( !empty($report->json_data) )
                                    @php
                                       $json_data = json_decode($report->json_data);
                                    @endphp
                                    @for( $i=0; $i < count($json_data->item_option); $i++ )
                                        <p class="aboveinput">Example: Roof Color</p>
                                        <input type="text" value="{{ $json_data->item_option[$i] }}" class="form-control  iteminput-modified" name="item_option[]" placeholder="Option Title">
                                    @endfor
                                @else
                                    <p class="aboveinput">Example: Roof Color</p>
                                    <input type="text" class="form-control  iteminput-modified" name="item_option[]" placeholder="Option Title">
                                @endif
                            </div>
                            <a id="add_more_item_option" href="javascript:void(0)"> <span>Add Option</span></a>
                        </div>
                        <div class=" bodysecitems ownerauthfooterdisc rm-companyinfobody-modified">
                            <h3>Footer Disclaimer</h3>
                            
                            <input type="text" value="{{ $report->footer_disclaimer }}" required name="footer_disclaimer" placeholder="Footer Disclaimer">
                        </div>
                    </div>
                    <div class="modal-footer logoimagefooter">
                    <div class="add-cancel-bnt">
                            <button type="button" class="btn btn-close cancelButton" data-dismiss="modal">
                                    <ul class="add-cancel-btn">
                                         <li>-</li>
                                         <li> Cancel</li>
                                    </ul>
                            </button>
                            <button type="submit" class="btn btn-save bg-modified">
                                <ul class="add-cancel-btn">
                                    <li>+</li>
                                    <li>Save</li>
                                </ul>
                            </button>
                    </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Document Options Modal -->
    <div class="modal fade " id="documentOptionsModal" role="dialog">
        <div class="modal-dialog add-project-modal company-intoduction-modal">
            <form id="report-image" action="{{ action('ReportController@saveDocument') }}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="modal-content">
                    <div class="modal-header logoimageheader">
                        <div class="header-content">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h3 class="modal-title text-left">Document Options</h3>
                        </div>
                    </div>
                    <div class="modal-body logoimagebody uploadpdffilemodalbody rm-companyinfobody-modified">
                        <!-- <form method="post" action="#" id="#">
                            <h5 class="mb-3">Title</h5>
                            <input required  type="text" name="title" class="form-control ">
                            <p style="margin-top: 3rem">User can select from these PDF documents when creating a report. When a PDF is selected it will be added to their report.</p>

                            <div class="form-group logoimagemodalfiles pdffileuploadmodal rm-companyinfobody-modified" style="margin-top: 1rem;">
                                {{-- <label>Upload Your File </label> --}}
                                {{-- <div class="inputlogoimage"></div> --}}
                                <input required type="file" class="form-control" name="document" accept="application/pdf">
                            </div>
                        </form> -->
                        <div class="upload-csv-modal">
                            <p>Users can select from these PDF documents when creating a report. When a PDF is selected it will be added to their report.</p>
                        <div class="drop-cvs">
                            <div class="cvs-border">
                                <div class="img-cvs">
                                  <img src="{{asset('assets/images/csvs-img.png')}}" alt="...">
                                </div>
                                <div class="cvs-import-tile text-center">
                                <p>Drag and drop to upload your PDF file</p>
                                <div class="fileUpload btn-broswe blue-btn btn width100">
                                   <span><ul class="add-cancel-btn">
                                           <li class="browse-plus">+</li>
                                            <li>Browse</li>
                                     </ul></span>
                                    <input type="file" class="uploadlogo" />
                                    </div>
                                    </div>
                                   </div>
                        </div>
                        </div>
                        <div class="d-none">
                        <h3>PDF Documents</h3>
                        <hr>
                        @if( count($documents) )
                            @foreach( $documents as $document )
                                <div class="pdffileuploadmodalfiles">
                                    <p><a target="_blank" href="{{ URL::to($document->path) }}">PDF # {{ $document->title }}</a></p>
                                    <div class="pdfeditdeleteIcon">
                                        <a id="{{ md5($document->path) }}" class="delIcon delete_document" href="/"><i class="far fa-trash-alt"></i></a>
                                    </div>
                                    <hr>
                                </div>
                             @endforeach
                        @endif
                        </div>
                        <div class="introdution-title">
                     <h3>PDF Documents</h3>
                    
                    </div>
                        <div class="modal-table">
                            <table class="table table-striped" >
                                <tbody>
                                        <tr class="table-body">
                                            <td  class="left first-cell">PDF 1</td>
                                           
                                            <td class="right">
                                            <div class="dropdown">
                                                    <button class="dropdown-dots dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                    <img src="{{asset('assets/images/dropdown-dots.png')}}" alt="...">
                                                    
                                                    </button>
                                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                                            <li><a href="# " class="delete"><img src="{{asset('image/trash.png')}}" alt="..."></
                                                        </ul>
                                                    </div>
                                            </div>
                                            </td>
                                        </tr>
                                        <tr class="table-body t-row-color">
                                            <td  class="left first-cell">PDF 2</td>
                                            <td class="right">
                                            <div class="dropdown">
                                                    <button class="dropdown-dots dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                    <img src="{{asset('assets/images/dropdown-dots.png')}}" alt="...">
                                                    
                                                    </button>
                                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                                            <li><a href="# " class="delete"><img src="{{asset('image/trash.png')}}" alt="..."></
                                                        </ul>
                                                    </div>
                                            </div>
                                            </td>
                                        </tr>
                                        <tr class="table-body">
                                            <td  class="left first-cell">PDF 3</td>
                                           
                                            <td class="right">
                                            <div class="dropdown">
                                                    <button class="dropdown-dots dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                    <img src="{{asset('assets/images/dropdown-dots.png')}}" alt="...">
                                                    
                                                    </button>
                                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                                            <li><a href="# " class="delete"><img src="{{asset('image/trash.png')}}" alt="..."></
                                                        </ul>
                                                    </div>
                                            </div>
                                            </td>
                                        </tr>
                                        <tr class="table-body t-row-color">
                                            <td  class="left first-cell">PDF 4</td>
                                            <td class="right">
                                            <div class="dropdown">
                                                    <button class="dropdown-dots dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                    <img src="{{asset('assets/images/dropdown-dots.png')}}" alt="...">
                                                    
                                                    </button>
                                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                                            <li><a href="# " class="delete"><img src="{{asset('image/trash.png')}}" alt="..."></
                                                        </ul>
                                                    </div>
                                            </div>
                                            </td>
                                        </tr>
                                  </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer logoimagefooter">
                        <button type="button" class="btn btn-close cancelButton" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-save bg-modified ">Confirm</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Company Introduction Modal -->
    <div class="modal fade " id="companyIntroductionModal" role="dialog">
        <div class="modal-dialog add-project-modal company-intoduction-modal">
            <!-- Modal content-->
            <div class="modal-content rm-companyinfobody-modified">
                <form method="post" action="{{ action('ReportController@storeIntroduction') }}" id="#">
                    {{csrf_field()}}
                <input type="hidden" name="template_id" {{--disabled="disabled"--}}  readonly value="0" />
                <div class="modal-header logoimageheader logoimageheader">
                    <div class="header-content">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h3 class="modal-title text-left">Company Introduction</h3>
                    </div>
                </div>
                <div class="modal-body  uploadpdffilemodalbody company-intoduction-modal">

                    <div class="row">
                        <div class="col-md-12 rm-companyinfobody-modified">
                            <input value="{{ !empty($introductions->title) ? $introductions->title : null }}"  type="text" class="form-control" id="intro_title" name="title" placeholder="Title" />
                        </div>
<!--                         <div class="form-group col-md-2 text-right">
                            <button type="button" class="btn add_new " style="background-color: #00ADE7; color: white" >Add New</button>
                        </div> -->
                    </div>


                    <textarea name="editor1">{{ !empty($introductions->content) ? $introductions->content : null }}</textarea>

                    <div class="introdution-title">
                        <h3>Introduction Templates</h3>
                        <p>These introduction templates can be selected by the user when creating report.</p>
                    </div>
                    <div class="modal-table">
                        <table class="table table-striped" >
                        <tbody>
                        @foreach($templates->where('identifier','introduction') AS $key => $item)
                            {{--@php  dd($item->title) @endphp--}}
                            <tr class="table-body">
                                <td  class="left first-cell">{{$item->title}}</td>
                                <td class="right">
                                    <div class="dropdown">
                                    <button class="dropdown-dots dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    <img src="{{asset('assets/images/dropdown-dots.png')}}" alt="...">
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                        <li><a href="#"  data-id="{{$item->id}}" class="edit_intro"><img src="{{asset('image/edit.png')}}" alt="..."></a></li>
                                        <li><a href="#" data-id="{{$item->id}}" class="delete_intro"><img src="{{asset('image/trash.png')}}" alt="..."></a></li>
                                    </ul>
                                </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer logoimagefooter">
                    <div class="add-cancel-bnt">
                      <button type="button" class="btn btn-close cancelButton" data-dismiss="modal">
                            <ul class="add-cancel-btn">
                              <li>-</li>
                              <li> Cancel</li>
                            </ul>
                       </button>
                       <button type="submit" class="btn btn-save bg-modified">
                            <ul class="add-cancel-btn">
                               <li>+</li>
                               <li>Save</li>
                            </ul>
                        </button>
                    </div>
                 </div>
                
                </form> 
            </div>

        </div>
    </div>

    <!-- Company Terms & Conditions Modal -->
    <div class="modal fade " id="companyTermsConditionsModal" role="dialog">
        <div class="modal-dialog add-project-modal company-intoduction-modal">
            <form id="report-image" action="{{ action('ReportController@companyTermsConditions') }}" method="POST">
                {{ csrf_field() }}
                <div class="modal-content">
                    <div class="modal-header logoimageheader">
                        <div class="header-content">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h3 class="modal-title text-left">Company Terms & Conditions</h3>
                        </div>
                    </div>
                    <div class="modal-body logoimagebody uploadpdffilemodalbody">
                        <textarea name="editor2">{{ !empty($termsConditions->content) ? $termsConditions->content : null }}</textarea>
                        <form method="post" action="#" id="#">
                            {{-- <div class="form-group logoimagemodalfiles pdffileuploadmodal "> --}}
                            {{-- <label>Upload Your File </label> --}}
                            {{-- <div class="inputlogoimage"></div> --}}
                            {{-- <input type="file" class="form-control" multiple="" >
                            </div>  --}}

                        </form>
                        {{-- <h3>Introduction Templates</h3>
                        <p >These introduction templates can be selected by the user when creating report.</p>
                        <hr>
                        <div class="pdffileuploadmodalfiles">
                            <p>Template # 1</p>
                            <div class="pdfeditdeleteIcon">
                                <a class="editIcon" href="/"><i class="fas fa-pen"></i></a>
                                <a class="delIcon" href="/"><i class="far fa-trash-alt"></i></a>
                            </div>
                            <hr>
                        </div>
                        <div class="pdffileuploadmodalfiles">
                            <p>Template # 2</p>
                            <div class="pdfeditdeleteIcon">
                                <a class="editIcon" href="/"><i class="fas fa-pen"></i></a>
                                <a class="delIcon" href="/"><i class="far fa-trash-alt"></i></a>
                            </div>
                            <hr>
                        </div>
                        <div class="pdffileuploadmodalfiles">
                            <p>Template # 3</p>
                            <div class="pdfeditdeleteIcon">
                                <a class="editIcon" href="/"><i class="fas fa-pen"></i></a>
                                <a class="delIcon" href="/"><i class="far fa-trash-alt"></i></a>
                            </div>
                            <hr>
                        </div> --}}
                    </div>
                    <div class="modal-footer logoimagefooter">
                    <div class="add-cancel-bnt">
                        <button type="button" class="btn btn-close cancelButton" data-dismiss="modal">
                                <ul class="add-cancel-btn">
                                         <li>-</li>
                                         <li> Cancel</li>
                                </ul>
                        </button>
                        <button type="submit" class="btn btn-save bg-modified">
                                <ul class="add-cancel-btn">
                                        <li>+</li>
                                        <li>Save</li>
                                </ul>
                        </button>
                    </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Company Colors Modal -->
    <div class="modal fade " id="companyColorsModal" role="dialog">
        <div class="modal-dialog add-project-modal">
            <form id="report-image" action="{{ action('ReportController@companyColor') }}" method="POST">
                {{ csrf_field() }}
                <div class="modal-content">
                    <div class="modal-header logoimageheader">
                        <div class="header-content">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h3 class="modal-title text-left">Company Colors</h3>
                        </div>
                    </div>
                    <div class="modal-body logoimagebody uploadpdffilemodalbody">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12">
                                <p class="company-color-title">These colors will be applied to your reports to match your company branding.</p>
                                </div>
                                <div class="col-md-6">
                                    <p class="piker-title">Primary Color</p>
                                    <div  class="new-colorpicker-component">
                                    <input class="form-control color" name="primary_color" type="color" value="{{ !empty($report->primary_color) ? $report->primary_color : '#83b545' }}" data-css-var="--main-bg-color" />
                                        <div class="piker-img">
                                            <img src="{{asset('assets/images/color-piker-icon.png')}}" alt="..." class="img-piiker">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <p class="piker-title" >Secondary Color</p>
                                    <div  class="new-colorpicker-component">
                                        <input class="form-control color" name="secondary_color" type="color" value="{{ !empty($report->secondary_color) ? $report->secondary_color : '#83b545' }}"data-css-var="--main-bg-color" />
                                        <div class="piker-img" >
                                            <img src="{{asset('assets/images/color-piker-icon.png')}}" alt="..." type="color" data-css-var="--main-bg-color"> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer logoimagefooter">
                    <div class="add-cancel-bnt">
                                 <button type="button" class="btn btn-close cancelButton" data-dismiss="modal">
                                    <ul class="add-cancel-btn">
                                        <li>-</li>
                                        <li> Cancel</li>
                                    </ul>
                                </button>
                                <button type="submit" class="btn btn-save bg-modified">
                                    <ul class="add-cancel-btn">
                                        <li>+</li>
                                        <li>Save</li>
                                    </ul>
                                </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{--To be removed hidden on Dec-2022--}}
    <div class="container hide">
        <div class="row nomargin">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <table id="example" class="table table-striped old-table ">
                    <thead>
                    <tr>
                        <th>Report Name</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="editIconMainRM modified-class-m">
                                <p>
                                    Company Logo
                                </p>                                
                            </td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="editIconMainRM modified-class-m">
                                <!-- Upload Image Modal Button -->
                                <button type="button" class="btn btn-primary reportModuleBtnSpecial" data-toggle="modal" data-target="#logoImageModal">
                                    <i class="fas fa-pen"></i>
                                </button>
                                {{-- <a class="editIcon" href="/"></a> --}}
                            </td>
                        </tr>
                        <tr>
                            <td class="editIconMainRM modified-class-m">
                                <p>
                                    Company Information
                                </p>
                            </td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="editIconMainRM modified-class-m">
                                <!-- Company Information Modal Button -->
                                <button type="button" class="btn btn-primary reportModuleBtnSpecial" data-toggle="modal" data-target="#companyInformationModal">
                                    <i class="fas fa-pen"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td class="editIconMainRM modified-class-m">
                                <p>
                                    Cover Page 
                                </p>                              
                            </td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="editIconMainRM modified-class-m">
                                <!-- Cover Page Modal Button -->
                                <button type="button" class="btn btn-primary reportModuleBtnSpecial" data-toggle="modal" data-target="#coverPageModal">
                                    <i class="fas fa-pen"></i>
                                </button>                                
                            </td>
                        </tr>
                        <tr>
                            <td class="editIconMainRM modified-class-m"> 
                                <p>
                                    Credit Disclaimer 
                                </p>                                        
                            </td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="editIconMainRM modified-class-m">
                                <!-- Credit Disclaimer Button -->
                                <button type="button" class="btn btn-primary reportModuleBtnSpecial" data-toggle="modal" data-target="#productDisclaimerModal">
                                    <i class="fas fa-pen"></i>
                                </button>                                
                            </td>
                        </tr>
                        <tr>
                            <td class="editIconMainRM modified-class-m">
                                <p>
                                    Owner Authorization 
                                </p>                              
                            </td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="editIconMainRM">
                                <!-- Owner Authorization Button -->
                                <button type="button" class="btn btn-primary reportModuleBtnSpecial" data-toggle="modal" data-target="#ownerAuthorizationModal">
                                    <i class="fas fa-pen"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td class="editIconMainRM modified-class-m">
                                <p>
                                    Document Options 
                                </p>                              
                            </td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="editIconMainRM modified-class-m">
                                <!-- Document Options Button -->
                                <button type="button" class="btn btn-primary reportModuleBtnSpecial" data-toggle="modal" data-target="#documentOptionsModal">
                                    <i class="fas fa-pen"></i>
                                </button>                               
                            </td>
                        </tr>
                        <tr>
                            <td class="editIconMainRM modified-class-m">
                                <p>
                                    Company Introduction 
                                </p>                                  
                            </td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="editIconMainRM modified-class-m">
                                <!-- Company Introduction Button -->
                                <button type="button" class="btn btn-primary reportModuleBtnSpecial" data-toggle="modal" data-target="#companyIntroductionModal">
                                    <i class="fas fa-pen"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td class="editIconMainRM modified-class-m">
                                <p>
                                    Company Terms & Conditions 
                                </p>                                  
                            </td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="editIconMainRM modified-class-m">
                                <!-- Company Terms & Conditions Button -->
                                <button type="button" class="btn btn-primary reportModuleBtnSpecial" data-toggle="modal" data-target="#companyTermsConditionsModal">
                                    <i class="fas fa-pen"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td class="editIconMainRM modified-class-m">
                                <p>
                                    Company Colors 
                                </p>                                  
                            </td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="editIconMainRM modified-class-m">
                                <!-- Company Terms & Conditions Button -->
                                <button type="button" class="btn btn-primary reportModuleBtnSpecial" data-toggle="modal" data-target="#companyColorsModal">
                                    <i class="fas fa-pen"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
        
@endsection


@push('page_level_scripts')
    <script src="https://cdn.ckeditor.com/4.16.2/basic/ckeditor.js"></script>
    <!-- Ck 5 Editor  CDN -->
    <script src="https://cdn.ckeditor.com/ckeditor5/35.3.2/classic/ckeditor.js"></script>
    <!-- Ck 5 Editor CDN End -->

    <script>  
        // Company Introduction Modal Editor
        let introEditor = CKEDITOR.replace( 'editor1' );
    </script>
    <script>
        let termsEditor = CKEDITOR.replace('editor2');
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.5.3/js/bootstrap-colorpicker.js"></script>
    <script src="{{asset('assets/js/jquery-simple-upload.js')}}"></script>
    <script>
         $(function() {
            $('#cp1').colorpicker().on('changeColor',function(e){
                $('#mycolordiv1')[0].style.backgroundColor = e.color.toString('rgba');
            });
            $('#cp2').colorpicker().on('changeColor',function(e){
                $('#mycolordiv2')[0].style.backgroundColor = e.color.toString('rgba');
            });
        });

         + function($) {
             'use strict';

             // UPLOAD CLASS DEFINITION
             // ======================

             var dropZone = document.getElementById('drop-zone');
             var uploadForm = document.getElementById('js-upload-form');
             let logos ;

             var startUpload = function(files) {
                 console.log('startUpload');

             }

             uploadForm.addEventListener('submit', function(e) {
                 var uploadFiles = document.getElementById('js-upload-files').files;
                 e.preventDefault()

                 var fd = new FormData($('#js-upload-form')[0]);

                 fd.append('logo',logos[0]);

                 console.log('logo',logos[0]);
                 $.ajax({
                     type: "POST",
                     enctype: 'multipart/form-data',
                     url: '{{URL::to('subadmin/report/storeLogo')}}',
                     data: fd,
                     processData: false,
                     contentType: false,
                     cache: false,
                     success: (data) => {
                         console.log('ajax good',$(".alert-success.success"));
                         $('#companyLogoModal').modal('toggle');
                         $("div.alert-success.success").text(data.message).show();
                         setTimeout(()=>{
                             $("div.alert.alert-success.success").hide();
                         },2000);
                     }
                 });

                 startUpload(uploadFiles)
             })

             dropZone.ondrop = function(e) {
                 e.preventDefault();
                 this.className = 'upload-drop-zone';
                 logos = e.dataTransfer.files;
                 // startUpload(e.dataTransfer.files)

                 if (FileReader && logos && logos.length) {
                     var fr = new FileReader();
                     fr.onload = function () {
                         // document.getElementById(outImage).src = fr.result;
                         $('.image_preview').find('img.img-thumbnail').attr('src',fr.result);

                         if($('.image_preview').hasClass('hide')){
                             $('.image_preview').removeClass('hide');
                         }

                     }
                     console.log(URL.createObjectURL(logos[0]) );
                     fr.readAsDataURL(logos[0]);
                     $('.upload-drop-zone').addClass('hide');
                 }
             }

             dropZone.ondragover = function() {
                 this.className = 'upload-drop-zone drop';
                 return false;
             }

             dropZone.ondragleave = function() {
                 this.className = 'upload-drop-zone';
                 return false;
             }

         }(jQuery);

         $(document).ready(function () {
             /** image_remove is getting used in two inputs:
              *  1. Cover Image
              *  2. Company Logo  */
             $("button.image_remove").on('click', function (e) {
                 console.log('clicked')

                 let $imagePreview = $(this).closest('.image_preview');
                 let $modalBody = $(this).closest('.modal-body');

                 console.log('$imagePreview',$imagePreview);
                 console.log('$modalBody',$modalBody);
                 console.log('drop-zone', $modalBody.find(".upload-drop-zone").first());

                 console.log('class',$(this).attr('class'));

                 /** For cover image */
                 if($(this).hasClass('cover')){
                     console.log('cover_image',$modalBody.find(".form-group.cover_image").first());
                     $modalBody.find(".form-group.cover_image").first().removeClass("hide");
                 }

                 $modalBody.find(".upload-drop-zone").first().removeClass("hide");
                 $imagePreview.addClass("hide");
                 $imagePreview.find("input[name='image_set']").first().attr("disabled", true);
             });

             $(".edit_intro").on('click',function(e){
                 e.preventDefault();
                 console.log($(this).data('id'));
                 var edit = $(this);
                 $.ajax({
                     url: "{{url('subadmin/report/getIntroduction')}}",
                     data:{
                       "id": $(this).data('id')
                     },
                     success:function(response){
                         introEditor.setData(response.data.content);
                         $("#intro_title").val(response.data.title);
                         $("input[name='template_id']").val(response.data.id);
                         // edit.css('background-color','#00ade7').css('color','white');
                     }
                 });
             });

             $(".delete_intro").on('click',function(e){
                 e.preventDefault();
                 console.log('del');
                 var deleteAction = $(this);
                 $.ajax({
                     url: "{{url('subadmin/report/deleteIntroduction')}}",
                     method:'POST',
                     data:{
                         "id": $(this).data('id')
                     },
                     success:function(response){
                         deleteAction.closest("tr.table-body").hide();
                         introEditor.setData('');
                         $("#intro_title").val('');
                     }
                 });
             });




         }); // doc ready

    </script>
    <script type="text/javascript">
        if(false){
            $(document).ready(function () {
                let thumbnailCount = "{{$data['thumbnailCount']}}";
                $('.select2').select2({
                    placeholder: "Select Your Option"
                });

                var updateUrl = "{{URL::to('subadmin/require_photo/update')}}";
                var $editModal = $('#editModal');

                $("td a.delete").on('click', function (e) {
                    return confirm("Are you sure ?");
                });

                $('#search-btn').on('click', function (e) {
                    var keyword = $('#search-input').val();
                    search(keyword);
                });

                function search(keyword) {
                    // var url = new URL(window.location.href);
                    // url.searchParams.set('keyword', keyword);
                    // url.searchParams.set('page',1);
                    // console.log(url.href);
                    // window.location.href = url.href;
                }

                $("#example").on('click', "td a.edit_form", function (e) {
                    e.preventDefault();
                    console.log('edit');
                    var id = $(this).data('id');
                    $.ajax({
                        url: "{{URL::to('subadmin/require_photo/editRequirePhotoDetails/')}}/" + id,
                        method: "GET",
                        data: '',
                        success: function (response) {
                            var data = response.data;
                            $('#update_form').attr('action', updateUrl + '/' + response.data.id);
                            console.log(response.data);
                            $('#update_form input[name="name"]').val(response.data.name);
                            $('#update_form input[name="min_quantity"]').val(response.data.min_quantity);
                            console.log('group id');
                            $('#update_form select[name="company_group_id[]"] option').each(function (key, item) {
                                $(response.data.company_group).each(function (index, item2) {
                                    // console.log('.each');
                                    // console.log("attr('value'): "+$(item).attr('value'));
                                    // console.log("item2.cg_id: "+parseInt(item2.cg_id));
                                    if (parseInt($(item).attr('value')) == parseInt(item2.cg_id)) {
                                        $(item).attr('selected', true);
                                    } else {

                                    }
                                });
                            });



                            $('#update_form select[name="thumbnail"] option').each(function (key,item) {
                                if(parseInt($(item).attr('value')) == parseInt(response.data.thumbnail)){
                                    console.log('thumbnail');
                                    console.log(response.data.thumbnail );
                                    $(item).prop('selected', true);
                                }
                            });

                            /** IF tag which is getting update, doesn't have thumbnail 'YES' disable this fieldd
                             * Meaning: thumbnail only can be 'NO' (un-set) */
                            let $thumbnailSelect = $('#update_form select[name="thumbnail"]');
                            if (response.data.thumbnail == 0 && thumbnailCount > 0) {
                                $thumbnailSelect.prop('disabled', true);
                            }else{
                                $thumbnailSelect.prop('disabled', false);
                            }

                            $('#update_form select[name="company_group_id[]"]').trigger('change');
                            $('#update_form select[name="thumbnail"]').trigger('change');
                            $editModal.modal('show');
                        },
                        error: function () {
                            alert("No Network");
                        }
                    });
                });

                $('#search-btn').on('click',function () {
                    table.ajax.reload();
                });

                var post_data;
                var table = $('#example').DataTable({
                    "processing": true,
                    "serverSide": true,
                    "ordering": false,
                    "autoWidth": false,
                    searching: false,
                    rowId: 'id',
                    "createdRow": function( row, data, dataIndex ) {
                        /*console.log('Rows');
                        console.log($(row));
                        console.log(data);*/
                        $(row).data('order_by',data.order_by);
                    },
                    columns: [
                        {data: "name"},
                        {data: "type"},
                        {data: "company_group_titles"},
                        {data: "min_quantity"},
                        {data: "thumbnail"},
                        {
                            data: "id",
                            render: function (data, type, row, meta) {
                                /*console.log(data);
                                console.log('AAAAAAAAAAA');*/

                                var html = '<a title="Edit" class="edit_form" href="/"  data-id="' +
                                    data + '"><img class="wd-25" src="{{asset("image/edit.png")}}"/></a>';
                                html += '<a title="Delete" style="margin-left:5px;" class="delete_row" data-module="inspect_area" data-id="' +
                                    data + '" href="javascript:void(0)"><img class="wd-25" src="{{asset("image/trash.png")}}"/> </a>';
                                return html;
                            }
                        },
                        {
                            render: function (data, type, row, meta)  {
                                var html = '<a title="Drag N Drop" class="" href="/"  data-id="' +
                                    data + '"><img class="wd-13" src="{{asset("image/action.png")}}"/> </a>';
                                return html;
                            }
                        }
                    ],
                    columnDefs: [
                        {
                            orderable: false,
                            targets: '_all',
                            // render: function(data, type, row, meta){
                            //     console.log(data);
                            //     console.log('AAAAAAAAAAA');
                            //     // return true;
                            //     var html = '<a title="Edit" class="btn btn-sm btn-primary edit_form" href="/"  data-id="' +
                            //         data +'"><i class="fa fa-edit"></i> </a>';
                            //     html += '<a title="Delete" style="margin-left:5px;" class="delete_row btn btn-sm btn-danger" data-module="inspect_area" data-id="' +
                            //         data +'" href="javascript:void(0)"><i class="fa fa-trash"></i> </a>';
                            //     return html;
                            // }

                        },

                    ],
                    rowReorder: {
                        dataSrc: 3,
                        selector: 'td:last-child'
                        // update: false,
                    },
                    ajax: {
                        url: '{!! URL::to("subadmin/require_photo_datatable") !!}',
                        type: "GET",
                        beforeSend: function () {
                            // $('.overlay').show();
                            // $('.progress').removeAttr('style');
                            // $('.progress').css({width: '20%'});
                            // timer = window.setInterval(ProgressBar, 2000);
                            // $('button').attr('disabled','disabled');
                        },
                        data: function (d) {
                            d.custom_search = $(document).find("select,textarea, input").serialize();
                            d.reOrder = post_data;
                        },
                        error: function () { // error handling

                        }
                    },
                    drawCallback: function (settings) {
                        // other functionality

                    },
                    lengthMenu: [
                        [10, 20, 50, 100, 200],
                        [10, 20, 50, 100, 200] // change per page values here
                    ],
                    pageLength: "{!! config('constants.PAGINATION_PAGE_SIZE') !!}"// default record count per page

                });

                table.on('row-reorder.dt', function (dragEvent, data, nodes) {
                    // console.log(table.page.info());
                    /*Even me last chahiye
                    * Odd me first chahiye
                    * */
                    console.log(data,'data');
                    // console.log($(data[0].node).hasClass('even'));
                    if (data.length > 0) {
                        var object = [];
                        $.each(data, function( index, item ) {
                            /*console.log( index + ": " + $(item.node).attr('id'));
                            console.log( index + ": " + $(item.node).attr('id'));*/
                            object[index] = {
                                'old_position': data[index].oldPosition,
                                'new_position': data[index].newPosition,
                                'id': $(item.node).attr('id'),
                                'order_by': $(item.node).data('order_by')
                            }

                        });
                        console.log(object,'object');
                        post_data = object;
                    }
                });

                table.on('click','.delete_row', function(e){
                    console.log($(this).closest('tr').attr('id'));

                    var confirmRes = confirm('Are You Sure');

                    if (confirmRes) {
                        var id = $(this).closest('tr').attr('id');
                        $.ajax({
                            url:'{!! url('subadmin/delete/require_photo') !!}/'+id,
                            method:'POST',
                            dataType: 'JSON',
                            success: function(response){
                                table.ajax.reload();
                                alert(response.message);
                            },
                            error: function(){
                            }
                        });
                    }
                });
                console.clear();
                {{--ajaxDatatable('#example','{!! URL::to("subadmin/require_photo_datatable") !!}');--}}

                $('#add_form').submit(function(){
                    $(this).find('.btn-save').attr('disabled',true);
                    $('#myModal').modal('toggle');
                });

            });
        }

        $('.delete_document').click( function(e) {
            e.preventDefault();
            var path = $(this).attr('id');  
            var ele  = $(this); 
            var msg  = confirm('Are you sure you want to delete this document?');
            if( msg ){
                $.ajax({
                   type:'post',
                   url: '{{ action("ReportController@deleteDocument") }}',
                   data:{path:path},
                   success: function(res){
                      if( res.code == 200  ){
                          alert(res.message);
                          ele.parent().parent().remove();
                      }
                   }
                })
            } else {
               return false
            } 
        })
       
        $('#add_more_section_item').click( function(e){
            e.preventDefault();
            var add_more_item = `<span><input type="text" name="section_item[]" placeholder="Item" class="form-control iteminput">
                                 <input type="number" name="section_price[]" placeholder="Price" class="form-control priceinput">
                                 <div class="editdelicons">
                                 <div class="dropdown">
                                                    <button class="dropdown-dots dropdown-toggle delete-drop" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                    <img src="{{asset('assets/images/dropdown-dots.png')}}" alt="...">
                                                    
                                                    </button>
                                                        <ul class="dropdown-menu drop-delte" aria-labelledby="dropdownMenu1">
                                                            <li><a class="delIcon delete_section_item" href="javascript:void(0)"><i class="far fa-trash-alt"></i></a></li>
                                                        </ul>
                                                    </div>
                                   
                                 </div></span>`;
            $('#_section_items_continer').append(add_more_item)
        })  
        
        $(document).on( 'click', '.delete_section_item', function(){
            $(this).parent().parent().remove();
        })  
        
        $('#add_more_item_option').click( function(){
            var add_more_item = `<span>
                                 <input type="text" class="form-control iteminput-modified" name="item_option[]" placeholder="Option Title">
                                 <div class="editdelicons">
                                 <div class="dropdown">
                                                    <button class="dropdown-dots dropdown-toggle delete-drop" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                    <img src="{{asset('assets/images/dropdown-dots.png')}}" alt="...">
                                                    
                                                    </button>
                                                        <ul class="dropdown-menu drop-delte" aria-labelledby="dropdownMenu1">
                                                            <li> <a class="delIcon delete_section_item" href="javascript:void(0)"><i class="far fa-trash-alt"></i></a></li>
                                                        </ul>
                                                    </div>
                                   
                                 </div></span>`;
            $('#item_option_container').append(add_more_item);
        })  
          
        // drag drop input
        //selecting all required elements
        // const dropArea = document.querySelector(".drag-area"),
        // dragText = dropArea.querySelector("header"),
        // button = dropArea.querySelector("button"),
        // input = dropArea.querySelector("input");
        // let file; //this is a global variable and we'll use it inside multiple functions

        // button.onclick = ()=>{
        // input.click(); //if user click on the button then the input also clicked
        // }

        // input.addEventListener("change", function(){
        // //getting user select file and [0] this means if user select multiple files then we'll select only the first one
        // file = this.files[0];
        // dropArea.classList.add("active");
        // showFile(); //calling function
        // });


        // //If user Drag File Over DropArea
        // dropArea.addEventListener("dragover", (event)=>{
        // event.preventDefault(); //preventing from default behaviour
        // dropArea.classList.add("active");
        // dragText.textContent = "Release to Upload File";
        // });

        // //If user leave dragged File from DropArea
        // dropArea.addEventListener("dragleave", ()=>{
        // dropArea.classList.remove("active");
        // dragText.textContent = "Drag & Drop to Upload File";
        // });

        // //If user drop File on DropArea
        // dropArea.addEventListener("drop", (event)=>{
        // event.preventDefault(); //preventing from default behaviour
        // //getting user select file and [0] this means if user select multiple files then we'll select only the first one
        // file = event.dataTransfer.files[0];
        // showFile(); //calling function
        // });

        // function showFile(){
        // let fileType = file.type; //getting selected file type
        // let validExtensions = ["image/jpeg", "image/jpg", "image/png"]; //adding some valid image extensions in array
        // if(validExtensions.includes(fileType)){ //if user selected file is an image file
        //     let fileReader = new FileReader(); //creating new FileReader object
        //     fileReader.onload = ()=>{
        //     let fileURL = fileReader.result; //passing user file source in fileURL variable
        //         // UNCOMMENT THIS BELOW LINE. I GOT AN ERROR WHILE UPLOADING THIS POST SO I COMMENTED IT
        //     // let imgTag = `<img src="${fileURL}" alt="image">`; //creating an img tag and passing user selected file source inside src attribute
        //     dropArea.innerHTML = imgTag; //adding that created img tag inside dropArea container
        //     }
        //     fileReader.readAsDataURL(file);
        // }else{
        //     alert("This is not an Image File!");
        //     dropArea.classList.remove("active");
        //     dragText.textContent = "Drag & Drop to Upload File";
        // }
        // }
        
        // New Piker Script 
        $('input[type="color"]').on("change", function () {
            document.body.style.setProperty($(this).attr("data-css-var"), this.value);
        }); 
         
        
   // New Piker Script end //

    </script>
@endpush



