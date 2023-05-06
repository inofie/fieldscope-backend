@extends('subadmin.master')
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
        label {
    display: inline-block;
    max-width: 100%;
    margin-bottom: 0px;
    font-weight: 700;
}
    </style>
    <!-- New Work  -->
    <section class="user-managment">
            <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card-title">
                                <h1 class="main-heading">Required Photos</h1>
                                  <button type="button" class="btn add-btn btn-add addusertype-btn-modified" data-toggle="modal" data-target="#myModal">
                                        <ul class="d-flex align-items-center">
                                            <li>
                                            <img src="{{asset('assets/images/button-icon.png')}}" alt="...">
                                            </li>
                                            <li class="ml-4">
                                                Required Photos       
                                            </li>
                                        </ul>
                                  </button>
                                </div>
                            </div>
                   </div>
                    {{-- To be removed hide on Dec-2022 --}}
                    <div class="row  new-card-row user-type-table hide" >
                        <div class="col-12 col-md-12">
                              <div class="pagination-data-table">
                                <nav aria-label="Page navigation">
                                        <ul class="pagination">
                                            <li>
                                            <a href="#" aria-label="Previous">
                                                <span aria-hidden="true">Pages</span>
                                            </a>
                                            </li>
                                            <li class="active"><a href="#" >1</a></li>
                                            <li><a href="#">2</a></li>
                                            <li><a href="#">3</a></li>
                                            <li><a href="#">4</a></li>
                                            <li><a href="#">5</a></li>
                                            <li>
                                            </li>
                                        </ul>
                                </nav>
                                <div class="data-tables-select" >
                                        <label>
                                            Show 
                                                <select name="example_length" aria-controls="example" class="form-control input-sm">
                                                    <option value="10">10</option><option value="20">20</option>
                                                    <option value="50">50</option><option value="100">100</option>
                                                    <option value="200">200</option>
                                                </select> 
                                            entries
                                        </label>
                                    </div>
                              </div>
                        </div>
                        <div class="col-12 col-md-12">
                            <table class="table table-striped" style="width: 1858px; margin:30px auto ;">
                                <thead >
                                    <tr class="table-head">
                                        <th class="left w-20">Inspection Area</th>
                                        <th class="center w-20">Type</th>
                                        <th class="center w-20">User Type</th>
                                        <th class="center w-20">Min. Quantity</th>
                                        <th class="center w-20">Thumbnail </th>
                                        <th class="right w-20">Settings</th>
                                        <!-- <th class="center w-50">Assigned Users</th>
                                        <th class="right w-30">Settings</th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="table-body">
                                            <td  class="left first-cell">Front Elevation</td>
                                            <td class="center">Required</td>
                                            <td class="center ">Sales Representative</td>
                                            <td class="center "><span class="sale-color">1</span></td>
                                            <td class="center first-cell">Yes</td>
                                           
                                            <td class="right">
                                                <div class="dropdown">
                                                    <button class="dropdown-dots dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                    <img src="{{asset('assets/images/dropdown-dots.png')}}" alt="...">
                                                    
                                                    </button>
                                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                                            <li><a href="#"  class="edit_form"><img src="{{asset('image/edit.png')}}" alt="..."></a></li>
                                                            <li><a href="# " class="delete"><img src="{{asset('image/trash.png')}}" alt="..."></
                                                        </ul>
                                                    </div>
                                            </td>
                                    </tr>
                                    <tr class="table-body t-row-color">
                                            <td  class="left first-cell">Right Elevation</td>
                                            <td class="center">Required</td>
                                            <td class="center ">Sales Representative</td>
                                            <td class="center "><span class="sale-color">1</span></td>
                                            <td class="center first-cell">Yes</td>
                                           
                                            <td class="right">
                                                <div class="dropdown">
                                                    <button class="dropdown-dots dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                    <img src="{{asset('assets/images/dropdown-dots.png')}}" alt="...">
                                                    
                                                    </button>
                                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                                            <li><a href="#"  class="edit_form"><img src="{{asset('image/edit.png')}}" alt="..."></a></li>
                                                            <li><a href="# " class="delete"><img src="{{asset('image/trash.png')}}" alt="..."></
                                                        </ul>
                                                    </div>
                                            </td>
                                    </tr>
                                    <tr class="table-body">
                                            <td  class="left first-cell">Left Elevation</td>
                                            <td class="center">Required</td>
                                            <td class="center ">Sales Representative</td>
                                            <td class="center "><span class="sale-color">1</span></td>
                                            <td class="center first-cell">Yes</td>
                                           
                                            <td class="right">
                                                <div class="dropdown">
                                                    <button class="dropdown-dots dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                    <img src="{{asset('assets/images/dropdown-dots.png')}}" alt="...">
                                                    
                                                    </button>
                                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                                            <li><a href="#"  class="edit_form"><img src="{{asset('image/edit.png')}}" alt="..."></a></li>
                                                            <li><a href="# " class="delete"><img src="{{asset('image/trash.png')}}" alt="..."></
                                                        </ul>
                                                    </div>
                                            </td>
                                    </tr>
                                    <tr class="table-body t-row-color">
                                            <td  class="left first-cell">Rear Elevation</td>
                                            <td class="center">Required</td>
                                            <td class="center ">Sales Representative</td>
                                            <td class="center "><span class="sale-color">1</span></td>
                                            <td class="center first-cell">Yes</td>
                                           
                                            <td class="right">
                                                <div class="dropdown">
                                                    <button class="dropdown-dots dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                    <img src="{{asset('assets/images/dropdown-dots.png')}}" alt="...">
                                                    
                                                    </button>
                                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                                            <li><a href="#"  class="edit_form"><img src="{{asset('image/edit.png')}}" alt="..."></a></li>
                                                            <li><a href="# " class="delete"><img src="{{asset('image/trash.png')}}" alt="..."></
                                                        </ul>
                                                    </div>
                                            </td>
                                    </tr>
                                    <tr class="table-body">
                                            <td  class="left first-cell">Front Elevation</td>
                                            <td class="center">Required</td>
                                            <td class="center ">Sales Representative</td>
                                            <td class="center "><span class="sale-color">1</span></td>
                                            <td class="center first-cell">Yes</td>
                                           
                                            <td class="right">
                                                <div class="dropdown">
                                                    <button class="dropdown-dots dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                    <img src="{{asset('assets/images/dropdown-dots.png')}}" alt="...">
                                                    
                                                    </button>
                                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                                            <li><a href="#"  class="edit_form"><img src="{{asset('image/edit.png')}}" alt="..."></a></li>
                                                            <li><a href="# " class="delete"><img src="{{asset('image/trash.png')}}" alt="..."></
                                                        </ul>
                                                    </div>
                                            </td>
                                    </tr>
                                    <tr class="table-body t-row-color">
                                            <td  class="left first-cell">Right Elevation</td>
                                            <td class="center">Required</td>
                                            <td class="center ">Sales Representative</td>
                                            <td class="center "><span class="sale-color">1</span></td>
                                            <td class="center first-cell">Yes</td>
                                           
                                            <td class="right">
                                                <div class="dropdown">
                                                    <button class="dropdown-dots dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                    <img src="{{asset('assets/images/dropdown-dots.png')}}" alt="...">
                                                    
                                                    </button>
                                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                                            <li><a href="#"  class="edit_form"><img src="{{asset('image/edit.png')}}" alt="..."></a></li>
                                                            <li><a href="# " class="delete"><img src="{{asset('image/trash.png')}}" alt="..."></
                                                        </ul>
                                                    </div>
                                            </td>
                                    </tr>
                                    <tr class="table-body">
                                            <td  class="left first-cell">Left Elevation</td>
                                            <td class="center">Required</td>
                                            <td class="center ">Sales Representative</td>
                                            <td class="center "><span class="sale-color">1</span></td>
                                            <td class="center first-cell">Yes</td>
                                           
                                            <td class="right">
                                                <div class="dropdown">
                                                    <button class="dropdown-dots dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                    <img src="{{asset('assets/images/dropdown-dots.png')}}" alt="...">
                                                    
                                                    </button>
                                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                                            <li><a href="#"  class="edit_form"><img src="{{asset('image/edit.png')}}" alt="..."></a></li>
                                                            <li><a href="# " class="delete"><img src="{{asset('image/trash.png')}}" alt="..."></
                                                        </ul>
                                                    </div>
                                            </td>
                                    </tr>
                                    <tr class="table-body t-row-color">
                                            <td  class="left first-cell">Rear Elevation</td>
                                            <td class="center">Required</td>
                                            <td class="center ">Sales Representative</td>
                                            <td class="center "><span class="sale-color">1</span></td>
                                            <td class="center first-cell">Yes</td>
                                           
                                            <td class="right">
                                                <div class="dropdown">
                                                    <button class="dropdown-dots dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                    <img src="{{asset('assets/images/dropdown-dots.png')}}" alt="...">
                                                    
                                                    </button>
                                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                                            <li><a href="#"  class="edit_form"><img src="{{asset('image/edit.png')}}" alt="..."></a></li>
                                                            <li><a href="# " class="delete"><img src="{{asset('image/trash.png')}}" alt="..."></
                                                        </ul>
                                                    </div>
                                            </td>
                                    </tr>
                                    <tr class="table-body">
                                            <td  class="left first-cell">Front Elevation</td>
                                            <td class="center">Required</td>
                                            <td class="center ">Sales Representative</td>
                                            <td class="center "><span class="sale-color">1</span></td>
                                            <td class="center first-cell">Yes</td>
                                           
                                            <td class="right">
                                                <div class="dropdown">
                                                    <button class="dropdown-dots dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                    <img src="{{asset('assets/images/dropdown-dots.png')}}" alt="...">
                                                    
                                                    </button>
                                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                                            <li><a href="#"  class="edit_form"><img src="{{asset('image/edit.png')}}" alt="..."></a></li>
                                                            <li><a href="# " class="delete"><img src="{{asset('image/trash.png')}}" alt="..."></
                                                        </ul>
                                                    </div>
                                            </td>
                                    </tr>
                                    <tr class="table-body t-row-color">
                                            <td  class="left first-cell">Right Elevation</td>
                                            <td class="center">Required</td>
                                            <td class="center ">Sales Representative</td>
                                            <td class="center "><span class="sale-color">1</span></td>
                                            <td class="center first-cell">Yes</td>
                                           
                                            <td class="right">
                                                <div class="dropdown">
                                                    <button class="dropdown-dots dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                    <img src="{{asset('assets/images/dropdown-dots.png')}}" alt="...">
                                                    
                                                    </button>
                                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                                            <li><a href="#"  class="edit_form"><img src="{{asset('image/edit.png')}}" alt="..."></a></li>
                                                            <li><a href="# " class="delete"><img src="{{asset('image/trash.png')}}" alt="..."></
                                                        </ul>
                                                    </div>
                                            </td>
                                    </tr>
                                    <tr class="table-body">
                                            <td  class="left first-cell">Left Elevation</td>
                                            <td class="center">Required</td>
                                            <td class="center ">Sales Representative</td>
                                            <td class="center "><span class="sale-color">1</span></td>
                                            <td class="center first-cell">Yes</td>
                                           
                                            <td class="right">
                                                <div class="dropdown">
                                                    <button class="dropdown-dots dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                    <img src="{{asset('assets/images/dropdown-dots.png')}}" alt="...">
                                                    
                                                    </button>
                                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                                            <li><a href="#"  class="edit_form"><img src="{{asset('image/edit.png')}}" alt="..."></a></li>
                                                            <li><a href="# " class="delete"><img src="{{asset('image/trash.png')}}" alt="..."></
                                                        </ul>
                                                    </div>
                                            </td>
                                    </tr>
                                    <tr class="table-body t-row-color">
                                            <td  class="left first-cell">Rear Elevation</td>
                                            <td class="center">Required</td>
                                            <td class="center ">Sales Representative</td>
                                            <td class="center "><span class="sale-color">1</span></td>
                                            <td class="center first-cell">Yes</td>
                                           
                                            <td class="right">
                                                <div class="dropdown">
                                                    <button class="dropdown-dots dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                    <img src="{{asset('assets/images/dropdown-dots.png')}}" alt="...">
                                                    
                                                    </button>
                                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                                            <li><a href="#"  class="edit_form"><img src="{{asset('image/edit.png')}}" alt="..."></a></li>
                                                            <li><a href="# " class="delete"><img src="{{asset('image/trash.png')}}" alt="..."></
                                                        </ul>
                                                    </div>
                                            </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                <div class="row new-card-row user-type-table">
                    <div class="col-12 col-md-12">
                        <table class="table table-striped re-table" id="example" style="width:100%;">
                            <thead >
                            <tr class="table-head">
                                <th class="left w-20">Photo View</th>
                                <th class="center w-20">Type</th>
                                <th class="center w-20">User Type</th>
                                <th class="center w-20">Min. Quantity</th>
                                <th class="center w-20">Thumbnail </th>
                                <th class="right w-20">Settings</th>
                                <th></th>
                                <!-- <th class="center w-50">Assigned Users</th>
                                <th class="right w-30">Settings</th> -->
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
    </section>
    <!-- New Work  End -->
    {{--To be removed commented on Dec-2022--}}

    {{--
<div class="row nomargin">
    <div class="col-md-6">
        <h1 class="main-heading">Required Photos </h1>
        <!-- <div class="search-bar pt-3 pb-3">
            <div class="input-group">
                <input value="{{\Request::input('keyword')}}" id="search-input" name="keyword" type="text" class="form-control " placeholder="Search for...">
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
                    <button type="button" class="btn btn-add addusertype-btn-modified" data-toggle="modal" data-target="#myModal">Add Required Photo
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


        </div>
    </div>
</div>


<div class="container">

    <div class="row nomargin">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <table id="example" class="table table-striped">
                <thead>
                <tr>
                    <th>Inspections Areas</th>
                    <th>Type</th>
                    <th>User Type</th>
                    <th>Min Quantity</th>
                    <th>Thumbnail</th>
                    <th>Actions</th>
                    <th></th>
                </tr>
                </thead>
                --}}{{--<tbody>--}}{{--
                --}}{{--@foreach($data['categories'] AS $key => $item)--}}{{--
                    --}}{{--<tr>--}}{{--
                        --}}{{--<td>{{$item['name']}}</td>--}}{{--
                        --}}{{--<td>{{($item['type'] == 1) ? 'Required': 'Damaged'}}</td>--}}{{--
                        --}}{{--<td>{{$item['company_group_titles']}}</td>--}}{{--
                        --}}{{--<td colspan="2" class="text-right">--}}{{--
                            --}}{{--<a href="/" class="edit_form" data-id="{{$item->id}}"> <i class="fas fa-pen"></i></a>--}}{{--
                            --}}{{--<a class="delete" href="{{URL::to('subadmin/require_photo/delete/'.$item->id.'?page='.\Request::input('page',1))}}"><i--}}{{--
                                        --}}{{--class="fas fa-trash-alt"></i></a>--}}{{--
                        --}}{{--</td>--}}{{--
                --}}{{--</tr>--}}{{--
                --}}{{--@endforeach--}}{{--
                --}}{{--</tbody>--}}{{--
            </table>

        </div>

    </div>
</div>--}}

    <!-- Add Modal -->
    <div class="modal fade " id="myModal" role="dialog">
        <div class="modal-dialog add-project-modal">
            <form id="add_form" action="{{URL::to('subadmin/require_photo/store')}}" method="POST">
            {{csrf_field()}}
            <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header logoimageheader">
                        <div class="header-content">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h3 class="modal-title text-left">Add Required Photo</h3>
                        </div>
                    </div>
                    <div class="modal-body companyinfobody rm-companyinfobody-modified">
                        <div class="row ">
                            <div class="col-md-12 companyinfobody rm-companyinfobody-modified">
                                <label>Photo View</label>
                                <input name="name" type="text"  placeholder="Photo View">
                            </div>
                            @if(!empty($data['companyGroups']))
                                <div class="col-md-12 companyinfobody rm-companyinfobody-select-modified">
                                    <label>User Type</label>

                                    <select name="company_group_id[]" data-placeholder="User Type" class="select2" style="font-size: 20px;" multiple>
                                        @foreach($data['companyGroups'] AS $key => $item)
                                            <option value="{{$item->id}}">{{$item->title}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif
                            <div class="col-md-6 companyinfobody rm-companyinfobody-modified">
                                <label>Min Quantity</label>
                                <input name="min_quantity" type="text"  placeholder="| Qty" class="quantity-input">
                            </div>

                            <div class="col-md-6 companyinfobody rm-companyinfobody-select-modified">
                            <label>Thumbnail @if($data['thumbnailCount'] > 0) (Already Set) @endif</label>
                                <select name="thumbnail"  class="select" data-placeholder="Thumbnail @if($data['thumbnailCount'] > 0) (Already Set) @endif"  @if($data['thumbnailCount'] > 0) disabled @endif>
                                    <option value="" disabled selected>Thumbnail @if($data['thumbnailCount'] > 0) (Already Set) @endif</option>
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>


                            
                        </div>
                    </div>
                    <div class="modal-footer logoimagefooter">
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
    <!-- Edit Modal -->
    <div class="modal fade new-modal" id="editModal" role="dialog">
        <div class="modal-dialog add-project-modal mr-0">

            <form id="update_form" action="{{URL::to('subadmin/require_photo/update/')}}" method="POST">
                {{csrf_field()}}
                <input type="hidden" name="page" value="{{\Request::input('page',1)}}">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="header-content">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h3 class="modal-title text-left">Edit Required Photo</h3>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="form-group  new-input-modal">
                        <label>Photo View</label>
                            <input name="name" type="text" class="form-control"
                                   placeholder="Inspection Area Name">
                        </div>

                        <div class="form-group  ">
                        <label>User Type</label>
                            <select name="company_group_id[]" class="select2 form-control " multiple>

                                @foreach($data['companyGroups'] AS $key => $item)
                                    <option value="{{$item->id}}">{{$item->title}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group new-input-modal">
                        <label>Thumbnail @if($data['thumbnailCount'] > 0) (Already Set) @endif</label>
                            <select name="thumbnail" class="select form-control " data-placeholder="Default Thumbnail">
                                <option value=""></option>
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                        </div>

                        <div class="form-group  new-input-modal">
                        <label>Min Quantity</label>
                            <input name="min_quantity" type="text" class="form-control" placeholder="Quantity">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-close" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-save">Update</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
@endsection


@push('page_level_scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            let thumbnailCount = {{$data['thumbnailCount']}};
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
                
                dom: '<pl><t>ir',
                stripeClasses: [ '', 't-row-color' ],
                rowId: 'id',

                columns: [
                    {data: "name", class:'left first-cell'},
                    {data: "type", class:'center'},
                    {data: "company_group_titles", class:'center'},
                                        {data: "min_quantity", class:'center',
                        render: function (data, type, row, meta){
                            return `<span class="sale-color">${data}</span>`;
                        }
                    },
                    {data: "thumbnail", class:'center'},
                    {
                       data: "id", class: 'right',
                        render: function (data, type, row, meta) {
                                                        return html = `<div class="dropdown">
                            <button class="dropdown-dots dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                            <img src="{{asset('assets/images/dropdown-dots.png')}}" alt="...">

                            </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                    <li><a href="#"  data-id="${data}" class="edit_form"><img src="{{asset('image/edit.png')}}" alt="..."></a></li>
                                    <li><a href="# " data-module="inspect_area" data-id="${data}" class="delete_row"><img src="{{asset('image/trash.png')}}" alt="..."></
                                </ul>
                            </div>`;
                        }
                    },
                    {
                        data: 'order_by',
                        render: function (data, type, row, meta)  {
                            var html = '<a title="Drag N Drop" class="" href="/"  data-id="' +
                                data + '"><img class="wd-13" src="{{asset("image/action.png")}}"/> </a>';
                            return html;
                        }
                    }
                ],
                createdRow: function (row, data, dataIndex) {
                    $(row).addClass('table-body');
                    $(row).data('order_by',data.order_by);
                },
                columnDefs: [
                    {orderable: false, targets: '_all',}
                ],
                rowReorder: {
                    dataSrc: 'order_by',
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
                            'old_position': data[index].oldData,
                            'new_position': data[index].newData,
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
    </script>
@endpush



