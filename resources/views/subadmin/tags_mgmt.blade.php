{{--{{dd($data['hover_field_types']->toArray())}}--}}
@extends('subadmin.master')
@section('content')
<!-- New Work  -->
<section class="user-managment">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card-title">
                    <h1 class="main-heading">Photo Tags</h1>
                    <div class="buttons">
                        <button type="button" class="btn add-btn btn-add addusertype-btn-modified import-btn"
                                data-toggle="modal" data-target="#importModal">
                            <ul class="d-flex align-items-center">
                                <li>
                                    <span class="button-plus">+</span>
                                </li>
                                <li class="ml-4">
                                    Import
                                </li>
                            </ul>
                        </button>
                        <button type="button" class="btn add-btn btn-add addusertype-btn-modified"
                                data-toggle="modal" data-target="#myModal">
                            <ul class="d-flex align-items-center">
                                <li>
                                    <img src="{{asset('assets/images/button-icon.png')}}" alt="...">
                                </li>
                                <li class="ml-4">
                                    Photo Tag
                                </li>
                            </ul>
                        </button>

                    </div>
                </div>
            </div>
        </div>
        {{--To be removed hide on Dec-2022 --}}
        <div class="row  new-card-row user-type-table hide">
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
                    <div class="row overflow-auto">
                    <table class="table table-striped">
                        <thead >
                            <tr class="table-head">
                                <th class="left w-16">Tag Name</th>
                                <th class="center w-16">Photo Views	</th>
                                <th class="center w-16">Quantity</th>
                                <th class="center w-16">Required</th>
                                <th class="center w-16">Price </th>
                                <th class="right w-16">Settings</th>
                                <!-- <th class="center w-50">Assigned Users</th>
                                <th class="right w-30">Settings</th> -->
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="table-body">
                                  <td class="left first-cell">Cornice return</td>
                                    <td  class="center">Cornice Returns & Strips	</td>
                                    <td class="center ">1</td>
                                    <td class="center first-cell">Yes</td>
                                    <td class="center "><span class="sale-color">$142.86</span></td>


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
                                  <td class="left first-cell">Cornice strip	</td>
                                    <td  class="center">Cornice Returns & Strips	</td>
                                    <td class="center ">3</td>
                                    <td class="center first-cell">No</td>
                                    <td class="center "><span class="sale-color">$30.00</span></td>


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
                                  <td class="left first-cell">Cornice return 2 + stories </td>
                                    <td  class="center">Cornice Returns & Strips	</td>
                                    <td class="center ">1</td>
                                    <td class="center first-cell">Yes</td>
                                    <td class="center "><span class="sale-color">$125.00</span></td>


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
                                  <td class="left first-cell">Cornice strip 2 + stories	</td>
                                    <td  class="center">Cornice Returns & Strips	</td>
                                    <td class="center ">3</td>
                                    <td class="center first-cell">No</td>
                                    <td class="center "><span class="sale-color">$28.57	</span></td>


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
                                  <td class="left first-cell">Cornice return</td>
                                    <td  class="center">Cornice Returns & Strips	</td>
                                    <td class="center ">1</td>
                                    <td class="center first-cell">Yes</td>
                                    <td class="center "><span class="sale-color">$142.86</span></td>


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
                                  <td class="left first-cell">Cornice strip	</td>
                                    <td  class="center">Cornice Returns & Strips	</td>
                                    <td class="center ">3</td>
                                    <td class="center first-cell">No</td>
                                    <td class="center "><span class="sale-color">$30.00</span></td>


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
                                  <td class="left first-cell">Cornice return 2 + stories </td>
                                    <td  class="center">Cornice Returns & Strips	</td>
                                    <td class="center ">1</td>
                                    <td class="center first-cell">Yes</td>
                                    <td class="center "><span class="sale-color">$125.00</span></td>


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
                                  <td class="left first-cell">Cornice strip 2 + stories	</td>
                                    <td  class="center">Cornice Returns & Strips	</td>
                                    <td class="center ">3</td>
                                    <td class="center first-cell">No</td>
                                    <td class="center "><span class="sale-color">$28.57	</span></td>


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
                                  <td class="left first-cell">Cornice return</td>
                                    <td  class="center">Cornice Returns & Strips	</td>
                                    <td class="center ">1</td>
                                    <td class="center first-cell">Yes</td>
                                    <td class="center "><span class="sale-color">$142.86</span></td>


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
                                  <td class="left first-cell">Cornice strip	</td>
                                    <td  class="center">Cornice Returns & Strips	</td>
                                    <td class="center ">3</td>
                                    <td class="center first-cell">No</td>
                                    <td class="center "><span class="sale-color">$30.00</span></td>


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
                                  <td class="left first-cell">Cornice return 2 + stories </td>
                                    <td  class="center">Cornice Returns & Strips	</td>
                                    <td class="center ">1</td>
                                    <td class="center first-cell">Yes</td>
                                    <td class="center "><span class="sale-color">$125.00</span></td>


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
                                  <td class="left first-cell">Cornice strip 2 + stories	</td>
                                    <td  class="center">Cornice Returns & Strips	</td>
                                    <td class="center ">3</td>
                                    <td class="center first-cell">No</td>
                                    <td class="center "><span class="sale-color">$28.57	</span></td>


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
                                  <td class="left first-cell">Cornice return</td>
                                    <td  class="center">Cornice Returns & Strips	</td>
                                    <td class="center ">1</td>
                                    <td class="center first-cell">Yes</td>
                                    <td class="center "><span class="sale-color">$142.86</span></td>


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
                                  <td class="left first-cell">Cornice strip	</td>
                                    <td  class="center">Cornice Returns & Strips	</td>
                                    <td class="center ">3</td>
                                    <td class="center first-cell">No</td>
                                    <td class="center "><span class="sale-color">$30.00</span></td>


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
                                  <td class="left first-cell">Cornice return 2 + stories </td>
                                    <td  class="center">Cornice Returns & Strips	</td>
                                    <td class="center ">1</td>
                                    <td class="center first-cell">Yes</td>
                                    <td class="center "><span class="sale-color">$125.00</span></td>


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
                                  <td class="left first-cell">Cornice strip 2 + stories	</td>
                                    <td  class="center">Cornice Returns & Strips	</td>
                                    <td class="center ">3</td>
                                    <td class="center first-cell">No</td>
                                    <td class="center "><span class="sale-color">$28.57	</span></td>


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
                                  <td class="left first-cell">Cornice return</td>
                                    <td  class="center">Cornice Returns & Strips	</td>
                                    <td class="center ">1</td>
                                    <td class="center first-cell">Yes</td>
                                    <td class="center "><span class="sale-color">$142.86</span></td>


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
                                  <td class="left first-cell">Cornice strip	</td>
                                    <td  class="center">Cornice Returns & Strips	</td>
                                    <td class="center ">3</td>
                                    <td class="center first-cell">No</td>
                                    <td class="center "><span class="sale-color">$30.00</span></td>


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
                                  <td class="left first-cell">Cornice return 2 + stories </td>
                                    <td  class="center">Cornice Returns & Strips	</td>
                                    <td class="center ">1</td>
                                    <td class="center first-cell">Yes</td>
                                    <td class="center "><span class="sale-color">$125.00</span></td>


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
                                  <td class="left first-cell">Cornice strip 2 + stories	</td>
                                    <td  class="center">Cornice Returns & Strips	</td>
                                    <td class="center ">3</td>
                                    <td class="center first-cell">No</td>
                                    <td class="center "><span class="sale-color">$28.57	</span></td>


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
        </div>
        <div class="row  new-card-row user-type-table">
            <div class="col-12 col-md-12">
                <div class="row overflow-auto">
                    <table class="table table-striped" style="width: 100%;" id="example">
                        <thead>
                        <tr class="table-head">
                            <th class="left w-16">Tag Name</th>
                            <th class="center w-16">Photo Views</th>
                            <th class="center w-16">Quantity</th>
                            <th class="center w-16">Required</th>
                            <th class="center w-16">Price</th>
                            <th class="right w-16">Settings</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
        <!-- New Work  End -->

{{--To be removed hide on Dec-2022 --}}
<div class="row nomargin hide" id="top">
   <div class="col-md-6">
      <h1 class="main-heading">Photo Tags</h1>
      <!-- <div class="col-md-12 form-group pull-right top_search" id="search-bar">
         <div class="input-group">
            <input value="{{\Request::input('keyword')}}" id="search-input" name="keyword" type="text" class="form-control " placeholder="Search for...">
            <span class="input-group-btn">
            <button id="search-btn" class="btn btn-default search-btn" type="button">
            <i class="fas fa-search"></i>
            </button>
            </span>
         </div>
      </div> -->
   </div>
   <div class="col-md-6">
      <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <!-- Trigger the modal with a button -->
                    <a href="{{URL::to('subadmin/tag/import')}}" class="btn btn-add addusertype-btn-modified" >Import</a>
                    <button type="button" class="btn btn-add addusertype-btn-modified addtag-modified-btn" data-toggle="modal" data-target="#myModal">Add Tag</button>
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
<div class="container hide">
   <div class="row nomargin">
      <div class="col-md-12 col-sm-12 col-xs-12">
         <table class="table table-striped" >
            <thead>
               <tr>
                  <th>Tags Name</th>
                  <th>Photo Views</th>
                  <th>Quantity</th>
                  <th>Is Required</th>
                  <th>Price</th>
                  <th>Action</th>
                  <th></th>
               </tr>
            </thead>
            <tbody>
            </tbody>
         </table>
      </div>
   </div>
</div>

<!-- Import Modal -->
<div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog add-project-modal upload-csv-modal" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="header-content">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h3 class="modal-title text-left">Upload CSV</h3>
                </div>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="drop-cvs">
                            <div class="cvs-border">
                                <div class="img-cvs">
                                    <img src="{{asset('assets/images/csvs-img.png')}}" alt="...">
                                </div>
                                <div class="cvs-import-tile text-center">
                                    <p>Drag and drop to upload your CSV file </p>
                                    <div class="fileUpload btn-broswe blue-btn btn width100">
                                                                                            <span><ul class="add-cancel-btn">
                                                                                                <li class="browse-plus">+</li>
                                                                                                <li>Browse</li>
                                                                                            </ul></span>
                                        <input type="file" class="uploadlogo"/>
                                    </div>
                                </div>
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
    </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog add-project-modal" role="document">
        <form id="add_form" action="{{URL::to('subadmin/tag/store')}}" method="POST">
            {{csrf_field()}}>
            <div class="modal-content">
                <div class="modal-header">
                    <div class="header-content">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h3 class="modal-title text-left">Add Photo Tag</h3>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 companyinfobody rm-companyinfobody-modified">
                            <input name="name" type="text" placeholder="Tag Name">
                        </div>
                        <div class="col-md-12 companyinfobody rm-companyinfobody-modified">
                            <input name="annotation" type="text" placeholder="Default Annotation Note">
                        </div>
                        <div class="col-md-6 companyinfobody rm-companyinfobody-modified">
                            <select  name="ref_id" class="form-control select-form">
                                <option disabled selected>Photo View</option>
                                @foreach($data['photoViews'] AS $key => $item)
                                    <option value="{{$item['category2_id']}}">{{$item['category2_name']}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 companyinfobody rm-companyinfobody-modified">
                            <select name="spec_type" class="form-control select-form spec_type" id="">
                                <option disabled selected>Spec Type</option>
                                @forelse($data['specTypes'] AS $key => $item)
                                    <option value="{{$item}}">{{$item}}</option>
                                @empty
                                    <option disabled>No Options found</option>
                                @endforelse
                            </select>
                        </div>
                        <div class="col-md-6 companyinfobody rm-companyinfobody-modified build_spec_group" style="display: none; ">
                            <!-- <label>Build Spec</label> -->
                            <select name="build_spec" class=" form-control select-form build_spec" id="">
                                <option disabled selected>Build Spec</option>
                            </select>
                        </div>
                        <div class="col-md-6 companyinfobody rm-companyinfobody-modified hover_field_type_group">
                            <select name="hover_field_type_id" class="form-control select-form hover_field_type" id="">
                                <option disabled selected>Hover Field Type</option>

                                @forelse($data['hover_field_types'] AS $key => $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                @empty
                                    <option disabled>No Options found</option>
                                @endforelse
                            </select>
                        </div>
                        <div class="col-md-6 companyinfobody rm-companyinfobody-select-modified hover_field_group"
                             style="display: none; ">
                            <!-- <label>Hover Field</label> -->
                            <select name="hover_field_id" class="form-control select-form hover_field" id="">
                                <option disabled selected>Select Hover Field</option>
                            </select>
                        </div>

                        <div class="col-md-6 companyinfobody rm-companyinfobody-modified">
                            <select name="has_qty" class="form-control select-form" id="sel1">
                                <option disabled selected>Quantity</option>
                                <option value="1">YES</option>
                                <option value="0">NO</option>
                            </select>
                        </div>

                        <div class="col-md-6 companyinfobody rm-companyinfobody-modified">
                            <!-- <label>Price</label> -->
                            <input name="price" type="text"  placeholder="Price" readonly>
                        </div>

                        <div class="col-md-6 companyinfobody rm-companyinfobody-modified">
                            <input name="material_cost" type="text" placeholder="Material">
                        </div>
                        <div class="col-md-6 companyinfobody rm-companyinfobody-modified">
                            <input name="equipment_cost" type="text" placeholder="Equipment">
                        </div>
                        <div class="col-md-6 companyinfobody rm-companyinfobody-modified">
                            <input name="margin" type="text" placeholder="Margin %">
                        </div>
                        <div class="col-md-6 companyinfobody rm-companyinfobody-modified">
                            <select name="uom_id" class="form-control select-form" id="uom_id">
                                <option disabled selected>Select UOM</option>

                                @forelse($data['uoms'] AS $key => $item)
                                    <option value="{{$item->id}}">{{$item->title}}</option>
                                @empty
                                    <option disabled>No Options found</option>
                                @endforelse
                            </select>
                        </div>
                        <div class="col-md-6 companyinfobody rm-companyinfobody-modified">
                            <input name="labor_cost" type="text" placeholder="Labor">
                        </div>
                        <div class="col-md-12 companyinfobody rm-companyinfobody-modified">
                            <input name="supervision_cost" type="text" placeholder="Supervision">
                        </div>

                    </div>
                </div>
                <div class="modal-footer footer-switch-btn">
                    <div class="switch-btn">
                        <button type="button" class="btn btn-sm btn-toggle" data-toggle="button"
                                aria-pressed="false" autocomplete="off">
                            <div class="handle"></div>
                        </button>
                        <span>Required</span>
                    </div>
                    <input type="hidden" name="is_required" value="false" class="test_class"/>
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

<!-- Edit New Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog add-project-modal" role="document">
              <form id="update_form" action="{{URL::to('subadmin/tag/update')}}" method="POST">
         {{csrf_field()}}
            <div class="modal-content">
                <div class="modal-header">
                    <div class="header-content">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h3 class="modal-title text-left">Edit Photo Tag</h3>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 companyinfobody rm-companyinfobody-modified">
                            <input name="name" type="text" placeholder="Tag Name">
                        </div>
                        <div class="col-md-12 companyinfobody rm-companyinfobody-modified">
                            <input name="annotation" type="text" placeholder="Default Annotation Note">
                        </div>
                        <div class="col-md-6 companyinfobody rm-companyinfobody-modified">
                            <select  name="ref_id" class="form-control select-form">
                                <option disabled selected>Photo View</option>
                                @foreach($data['photoViews'] AS $key => $item)
                                    <option value="{{$item['category2_id']}}">{{$item['category2_name']}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 companyinfobody rm-companyinfobody-modified">
                            <select name="spec_type" class="form-control select-form spec_type" id="">
                                <option disabled selected>Spec Type</option>
                                @forelse($data['specTypes'] AS $key => $item)
                                    <option value="{{$item}}">{{$item}}</option>
                                @empty
                                    <option disabled>No Options found</option>
                                @endforelse
                            </select>
                        </div>
                        <div class="col-md-6 companyinfobody rm-companyinfobody-modified build_spec_group" style="display: none; ">
                            <!-- <label>Build Spec</label> -->
                            <select name="build_spec" class=" form-control select-form build_spec" id="">
                                <option disabled selected>Build Spec</option>
                            </select>
                        </div>
                        <div class="col-md-6 companyinfobody rm-companyinfobody-modified hover_field_type_group">
                            <select name="hover_field_type_id" class="form-control select-form hover_field_type" id="">
                                <option disabled selected>Hover Field Type</option>

                                @forelse($data['hover_field_types'] AS $key => $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                @empty
                                    <option disabled>No Options found</option>
                                @endforelse
                            </select>
                        </div>
                        <div class="col-md-6 companyinfobody rm-companyinfobody-select-modified hover_field_group"
                             style="display: none; ">
                            <!-- <label>Hover Field</label> -->
                            <select name="hover_field_id" class="form-control select-form hover_field" id="">
                                <option disabled selected>Select Hover Field</option>
                            </select>
                        </div>

                        <div class="col-md-6 companyinfobody rm-companyinfobody-modified">
                            <select name="has_qty" class="form-control select-form" id="sel1">
                                <option disabled selected>Quantity</option>
                                <option value="1">YES</option>
                                <option value="0">NO</option>
                            </select>
                        </div>

                        <div class="col-md-6 companyinfobody rm-companyinfobody-modified">
                            <!-- <label>Price</label> -->
                            <input name="price" type="text"  placeholder="Price" readonly>
                        </div>

                        <div class="col-md-6 companyinfobody rm-companyinfobody-modified">
                            <input name="material_cost" type="text" placeholder="Material">
                        </div>
                        <div class="col-md-6 companyinfobody rm-companyinfobody-modified">
                            <input name="equipment_cost" type="text" placeholder="Equipment">
                        </div>
                        <div class="col-md-6 companyinfobody rm-companyinfobody-modified">
                            <input name="margin" type="text" placeholder="Margin %">
                        </div>
                        <div class="col-md-6 companyinfobody rm-companyinfobody-modified">
                            <select name="uom_id" class="form-control select-form" id="uom_id">
                                <option disabled selected>Select UOM</option>

                                @forelse($data['uoms'] AS $key => $item)
                                    <option value="{{$item->id}}">{{$item->title}}</option>
                                @empty
                                    <option disabled>No Options found</option>
                                @endforelse
                            </select>
                        </div>
                        <div class="col-md-6 companyinfobody rm-companyinfobody-modified">
                            <input name="labor_cost" type="text" placeholder="Labor">
                        </div>
                        <div class="col-md-12 companyinfobody rm-companyinfobody-modified">
                            <input name="supervision_cost" type="text" placeholder="Supervision">
                        </div>

                    </div>
                </div>
                <div class="modal-footer footer-switch-btn">
                    <div class="switch-btn">
                        <button type="button" class="btn btn-sm btn-toggle" data-toggle="button"
                                aria-pressed="false" autocomplete="off">
                            <div class="handle"></div>
                        </button>
                        <span>Required</span>
                    </div>
                    <input type="hidden" name="is_required" value="false" class="test_class"/>
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


<!-- Edit Old Modal -->
<div class="modal fade new-modal " id="editModal" role="dialog">
   <div class="modal-dialog modal-lg">
      <form id="update_form" action="{{URL::to('subadmin/tag/update')}}" method="POST">
         {{csrf_field()}}
         <!-- Modal content-->
         <div class="modal-content">
            <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal">&times;</button>
               <h4 class="modal-title">Edit Tag</h4>
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="form-group col-md-12">
                        <label>Tag Name</label>
                        <input name="name" type="text" class="form-control" placeholder="Tag Name" >
                    </div>
                    <div class="form-group col-md-12">
                        <label>Default Annotation</label>
                        <input name="annotation" type="text" class="form-control" placeholder="Default Annotation" >
                    </div>
                    <div class="form-group col-md-6">
                        <label>Quantity</label>
                        <select name="has_qty" class="form-control" id="sel1">
                            <option disabled selected>Quantity</option>
                            <option value="1">YES</option>
                            <option value="0">NO</option>
                        </select>
                    </div>
                    <div class="form-group col-md-6 cat_id photo_view" >
                        <label>Photo View</label>
                        <select name="ref_id" class="form-control">
                            <option disabled selected>Select Photo View</option>
                            @foreach($data['photoViews'] AS $key => $item)
                                <option value="{{$item['category2_id']}}">{{$item['category2_name']}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Is Required?</label>
                        <select name="is_required" class="form-control" id="is_required">
                            <option disabled selected>Is Required?</option>
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Spec Type</label>
                        <select name="spec_type" class="form-control spec_type" id="">
                            <option disabled selected>Select Spec Type</option>
                            @forelse($data['specTypes'] AS $key => $item)
                                <option value="{{$item}}">{{$item}}</option>
                            @empty
                                <option disabled>No Options found</option>
                            @endforelse
                        </select>
                    </div>
                    <div class="form-group col-md-6 build_spec_group" style="display: none; ">
                        <label>Build Spec</label>
                        <select name="build_spec" class="form-control input build_spec" id="">
                            <option disabled selected>Select Build Spec</option>
                        </select>
                    </div>

                    <div class="form-group col-md-6 hover_field_type_group" style="/*display: none;*/ ">
                        <label>Hover Field Type</label>
                        <select name="hover_field_type_id" class="form-control hover_field_type" id="">
                            <option disabled selected>Select Hover Field Type</option>

                            @forelse($data['hover_field_types'] AS $key => $item)
                                <option value="{{$item->id}}">{{$item->name}}</option>
                            @empty
                                <option disabled>No Options found</option>
                            @endforelse
                        </select>
                    </div>
                    <div class="form-group col-md-6 hover_field_group" style="display: none; ">
                        <label>Hover Field</label>
                        <select name="hover_field_id" class="form-control hover_field" id="">
                            <option disabled selected>Select Hover Field</option>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Price</label>
                        <input name="price" type="text" class="form-control" placeholder="Price" readonly>
                    </div>

                    <div class=" col-md-12">
                        <div class="divider" style="margin: 12px -15px;"></div>
                    </div>

                    <div class="form-group col-md-6">
                        <label>UOM</label>
                        <select name="uom_id" class="form-control" id="uom_id">
                            <option disabled selected>Select UOM</option>

                            @forelse($data['uoms'] AS $key => $item)
                                <option value="{{$item->id}}">{{$item->title}}</option>
                            @empty
                                <option disabled>No Options found</option>
                            @endforelse
                        </select>
                    </div>

                    <div class="form-group col-md-6">
                        <label>Material</label>
                        <input name="material_cost" type="text" class="form-control" placeholder="Material">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Labor</label>
                        <input name="labor_cost" type="text" class="form-control" placeholder="Labor">
                    </div>

                    <div class="form-group col-md-6">
                        <label>Equipment</label>
                        <input name="equipment_cost" type="text" class="form-control" placeholder="Equipment">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Supervision</label>
                        <input name="supervision_cost" type="text" class="form-control" placeholder="Supervision">
                    </div>

                    <div class="form-group col-md-6">
                        <label>Margin %</label>
                        <input name="margin" type="text" class="form-control" placeholder="Margin %">
                    </div>
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
       $('.select2').select2({
           placeholder: "Select Your Option"
       });
   
       var updateUrl = "{{URL::to('subadmin/tag/update')}}";
       var $editModal = $('#editModal');
   
       $("td a.delete").on('click', function (e) {
           return confirm("Are you sure ?");
       });
   
       $('#search-btn').on('click', function (e) {
           table.ajax.reload();
       });

       $('.btn-toggle').on('click',function(e){
           let state = $(this).closest('.modal-footer').find('input[name="is_required"]').val();
           if(state === 'true'){
               $(this).closest('.modal-footer').find('input[name="is_required"]').val(false); // Toggling
           }else{
               $(this).closest('.modal-footer').find('input[name="is_required"]').val(true); // Toggling
           }
       });

       function isRequiredToggle(el,state = null){

           let isRequiredEl , isRequiredVal ;
           isRequiredEl = el.closest('.modal-footer').find('input[name="is_required"]');

           if(state){
               isRequiredVal = state;
           }else{
               isRequiredVal = !(isRequiredEl.val() === 'false' ? false : true) ; // Toggling

           }

           if(isRequiredVal){
               el.addClass('active');
           }

           el.attr('aria-pressed',isRequiredVal);
           isRequiredEl.val(isRequiredVal);
       }
   
   
       var selectedBuildSpec = '';

       $('.spec_type').on('change', function (e) {
           /*console.log('spec_type change');
           console.log(e.target);*/

           var id = $(this).val();
           var $input = $(this);
           $.getJSON('{{URL::to('subadmin/crm/spec_list')}}/' + id, function (response) {
               var items = [];

               items.push("<option disabled selected>Select Build Spec</option>");

               /*Adding to build spec*/
               $.each(response.data, function (key, val) {
                   items.push("<option value='" + val + "'>" + val + "</option>");
               });


               $input.closest('.modal-body').find('.build_spec').empty().append(items.join(""));
               $input.closest('.modal-body').find('.build_spec_group').show();

               /*Selecting on Update dropdown*/
               $('#update_form select[name="build_spec"] option').each(function (key, item) {
                   if (selectedBuildSpec == $(item).val()) {
                       $(item).prop('selected', true);
                   }
               });

           });
       });

       var selectedHoverField = '';
       $('.hover_field_type').on('change', function (e) {
           // console.log('hover_field_type change');
           // console.log(e.target);

           var id = $(this).val();
           var $input = $(this);
           $.getJSON('{{URL::to('subadmin/hover/field_list')}}/' + id, function (response) {
               var items = [];
               items.push("<option disabled selected>Select Hover Field</option>");

               /*Adding to build spec*/
               $.each(response.data, function (key, val) {
                   items.push("<option value='" + val.id + "'>" + val.name + "</option>");
               });

               $input.closest('.modal-body').find('.hover_field').empty().append(items.join(""));
               $input.closest('.modal-body').find('.hover_field_group').show();

               /*Selecting on Update dropdown*/
               $('#update_form select[name="hover_field_id"] option').each(function (key, item) {
                   if (selectedHoverField == $(item).val()) {
                       $(item).prop('selected', true);
                   }
               });

           });
       });

        var post_data;
       var table = $('#example').DataTable({
           "processing": true,
           "serverSide": true,
           "ordering": false,
           "autoWidth": false,
           searching: false,
           dom: '<pl><t>ir',
           stripeClasses: ['', 't-row-color'],
           rowId: 'id',
           columns: [
               {data: "name", class: 'left first-cell'},
               {data: "c1_name", class: 'center'},
               {data: "has_qty", class: 'center'},
               {data: "is_required", class: 'center'},
               {
                   data: "price", class: 'center', render: function (data, type, row, meta) {
                       return `<span class="sale-color">${data}</span>`;
                   }
               },
               {
                   data: "id",
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
                   },
                   // orderable: false
               },
               {
                        data: 'order_by',
                   render: function (data, type, row, meta) {
                       var html = '<a title="Drag N Drop" class="" href="/"  data-id="' +
                           data + '"><img class="wd-13" src="{{asset("image/action.png")}}"/> </a>';
                       return html;
                   }
               }
           ],
                createdRow: function( row, data, dataIndex ) {
                    $(row).addClass('table-body');
                    $(row).data('order_by',data.order_by);
                },
           columnDefs: [
               {
                   orderable: false,
                   targets: '_all',
               }
           ],
           rowReorder: {
               dataSrc: 'order_by',
               selector: 'td:last-child',
               // update: false,
           },
           ajax: {
               url: '{!! URL::to("subadmin/tag_datatable") !!}',
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
           console.log(data);
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
               console.log(object);
               post_data = object;
           }
       });


       table.on('click', 'td a.edit_form', function (e)     {
           e.preventDefault();
           var id = $(this).data('id');
           $.ajax({
               url: "{{URL::to('subadmin/tag/editTagDetails/')}}/" + id,
               method: "GET",
               data: '',
               success: function (response) {
                   $('#update_form').attr('action', updateUrl + '/' + response.data.id);
   
                   $('#update_form input[name="name"]').val(response.data.name);
                   $('#update_form input[name="annotation"]').val(response.data.annotation);
                   $('#update_form input[name="price"]').val(response.data.price);

                   $('#update_form select[name="uom_id"] option').each(function (key,item) {
                       if($(item).val() == response.data.uom_id){
                           $(item).prop('selected', true);
                       }
                   });

                   $('#update_form input[name="material_cost"]').val(response.data.material_cost);
                   $('#update_form input[name="labor_cost"]').val(response.data.labor_cost);
                   $('#update_form input[name="equipment_cost"]').val(response.data.equipment_cost);
                   $('#update_form input[name="supervision_cost"]').val(response.data.supervision_cost);
                   $('#update_form input[name="margin"]').val(response.data.margin);

                   $('#update_form select[name="has_qty"] option').each(function (key, item) {
                       if ($(item).val() == response.data.has_qty) {
                           $(item).prop('selected', true);
                       }
                   });

                   if (response.data.is_required) {
                       isRequiredToggle($('#update_form .btn-toggle'), response.data.is_required > 0 ? 'true' : 'false');
                   }

                   $('#update_form select[name="ref_id"] option').each(function (key, item) {
                       if ($(item).val() == response.data.ref_id) {
                           $(item).prop('selected', true);
                       }
                   });

                   // console.log('response.data.build_spec',response.data.hover_field_type_id ,response.data.hover_field_id);

                   selectedBuildSpec = response.data.build_spec;
                   selectedHoverField = response.data.hover_field_id;

                   if(response.data.spec_type && response.data.build_spec > 0){
                       /*Selecting Spec Type and triggering change*/
                       $('#update_form select[name="spec_type"] option').each(function (key, item) {
                           if ($(item).val() == response.data.spec_type) {
                               $(item).prop('selected', true);
                               $('#update_form select[name="spec_type"]').trigger('change');
                           }
                       });
                   }

                   if(response.data.hover_field_type_id && response.data.hover_field_id > 0 ){
                       $('#update_form select[name="hover_field_type_id"] option').each(function (key, item) {
                           if ($(item).val() == response.data.hover_field_type_id) {

                               $(item).prop('selected', true);
                               $('#update_form select[name="hover_field_type_id"]').trigger('change');
                           }
                       });
                   }

                   $editModal.modal('show');
               },
               error: function () {
                   alert("No Network");
               }
           });
       });
   
       table.on('click', '.delete_row', function(e){

           console.log($(this).closest('tr').attr('id'));
   
           var confirmRes = confirm('Are You Sure');
   
           if (confirmRes) {
               var id = $(this).closest('tr').attr('id');
               $.ajax({
                   url:'{!! url('subadmin/tag/delete') !!}/'+id,
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

       $('#add_form').submit(function(){
           $(this).find('.btn-save').attr('disabled',true);
           $('#myModal').modal('toggle');
       });


       $('input[name="material_cost"], input[name="labor_cost"], input[name="equipment_cost"], input[name="supervision_cost"], input[name="margin"]').on('input', function (e){

           let $form = $(this).closest('form');

           let material_cost    = +$form.find('input[name="material_cost"]').val();
           let labor_cost       = +$form.find('input[name="labor_cost"]').val();
           let equipment_cost   = +$form.find('input[name="equipment_cost"]').val();
           let supervision_cost = +$form.find('input[name="supervision_cost"]').val();
           let margin           = +$form.find('input[name="margin"]').val();

           $form.find('input[name="price"]').val(((material_cost + labor_cost + equipment_cost + supervision_cost)/ (1- (margin/100)) ).toFixed(2));
       });
   });
</script>
@endpush