@extends('subadmin.master')
@section('content')
<!-- New Work  -->
<section class="report-management-sec">
    <div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card-title">
                <h1 class="main-heading">Questionnaire Management</h1>
                <div class="buttons">
                        <!-- <button type="button" class="btn add-btn btn-add addusertype-btn-modified import-btn" data-toggle="modal" data-target="#myModal">
                                <ul class="d-flex align-items-center">
                                    <li>
                                    <img src="{{asset('assets/images/filter-icon.png')}}" alt="...">
                                    </li>
                                    <li class="ml-4">
                                           Filter
                                    </li>
                                </ul>
                        </button> -->
                        <a href="{{ URL::to('subadmin/questionnaire/add') }}" class="btn add-btn btn-add">
                                <ul class="d-flex align-items-center">
                                    <li>
                                    <img src="{{asset('assets/images/button-icon.png')}}" alt="...">
                                    </li>
                                    <li class="ml-4">
                                      Question
                                    </li>
                                </ul>
                        </a>

                  </div>
                </div>
            </div>
    </div>
    {{--  To be removed hidden on Dec-2022  --}}
    <div class="row  new-card-row user-type-table hide" >
        <div class="col-12 col-md-12" >
              <div class="pagination-data-table">
                <h1 class="questionnaire-title">
                  Select Area
                </h1>
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
                        <th class="right w-30">Settings</th>
                    </tr>
                </thead>
                <tbody>
                        <tr class="table-body">
                            <td  class="left first-cell">Pre-Inspection Photos</td>
                           <td class="right">
                                <div class="dropdown">
                                    <button class="dropdown-dots dropdown-toggle" >
                                      <a href="questionnaire/edit_select">
                                       <img src="{{asset('assets/images/dropdown-dots.png')}}" alt="...">
                                      </a>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr class="table-body t-row-color">
                            <td  class="left first-cell">Additional Photos</td>
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
                            <td  class="left first-cell">Roofing Photos</td>

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
                            <td  class="left first-cell">Gutters Photos</td>
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
                            <td  class="left first-cell">Siding Photos</td>

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
                            <td  class="left first-cell">Roofing</td>
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
                            <td  class="left first-cell">Gutters by Elevation  <span class="light-cell-color"> - Rear &amp; Left</span> </td>

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
                            <td  class="left first-cell"> Siding by Elevation <span class="light-cell-color"> - Front Elevation</span></td>
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
                            <td  class="left first-cell">Siding by Elevation <span class="light-cell-color"> - Right Elevation</span> </td>
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
                            <td  class="left first-cell">Siding by Elevation  <span class="light-cell-color"> - Left Elevation</span></td>
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
                            <td  class="left first-cell">Siding by Elevation  <span class="light-cell-color">- Rear Elevation</span></td>
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
            <table class="table table-striped" id="example" style="width: 100%; margin:30px auto ;">
                <thead >
                <tr class="table-head">
                    <th class="left w-30">Title</th>
                    <th class="w-20">Area</th>
                    <th class="right w-10">Settings</th>
                    <th class="right w-10"></th>
                </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
    </div>
</section>
<!-- New Work  End -->
<div class="row nomargin hide">
        <div class="col-md-6">
        <h1 class="main-heading">Questionnaire Management</h1>
        <!-- <div class="search-bar pt-3 pb-3">
                <div class="input-group">
                    <input value="{{\Request::input('keyword')}}" id="search-input" name="keyword" type="text" class="form-control " placeholder="Search for...">
                        <span class="input-group-btn">
                            <button id="search-btn" class="btn btn-default search-btn" type="button"><i class="fas fa-search"></i></button>
                        </span>
                </div>
            </div>-->
        </div> 
        <div class="col-md-6">
                <div class="row">
                    <div class="col-md-12">
                        <a href="{{ URL::to('subadmin/questionnaire/add') }}" class="btn btn-add addusertype-btn-modified">Add New</a>
                        <!-- Trigger the modal with a button
                        <button type="button" class="btn btn-add addusertype-btn-modified" data-toggle="modal" data-target="#myModal">Add
                            User
                        </button> -->
                        
                    </div>
                    <div class="col-md-6"></div>
                    <div class="col-md-6">
                        <div class="search-bar pt-3 pb-3">
                            <div class="input-group">
                                <input value="{{\Request::input('keyword')}}" id="search-input" name="keyword" type="text" class="form-control utminputsearch-modified" placeholder="Search Project"
                                style="border-radius: 5px; border: 1px solid transparent;color: #3f3d56;opacity:0.5;">
                                <span class="input-group-btn">
                                    <button id="search-btn" class="btn btn-default search-btn utmsearchbtn-modified" type="button" style="border-radius: 5px; border: 1px solid transparent;"><i class="fas fa-search" ></i></button>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            <!-- <a href="{{ URL::to('subadmin/questionnaire/add') }}" class="btn btn-add">Add New</a> -->

        </div>

    </div>
<div class="container hide">
        <div class="row nomargin">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Questions</th>
                        <th>Inspection Area</th>
                        <th>Actions</th>
                        <th></th>
                    </tr>
                    </thead>
                    {{--<tbody>--}}
                    {{--@foreach($data['queries'] AS $key => $item)--}}
                        {{--<tr>--}}
                            {{--<td>--}}
                                {{--{{$item->query}}--}}
                            {{--</td>--}}
                            {{--<td colspan="2" class="text-right">--}}
                                {{--<a href="{{URL::to('subadmin/questionnaire/editQuestionnaireDetails/'.$item->id)}}" class="edit_form" data-id="{{$item->id}}"> <i class="fas fa-pen"></i>--}}
                                {{--</a>--}}
                                {{--<a class="delete"--}}
                                   {{--href="{{URL::to('subadmin/questionnaire/delete/'.$item->id.'?page='.\Request::input('page',1))}}">--}}
                                    {{--<i class="fas fa-trash-alt"></i>--}}
                                {{--</a>--}}
                            {{--</td>--}}
                        {{--</tr>--}}
                    {{--@endforeach--}}
                    {{--</tbody>--}}
                </table>
                {{--{{$data['queries']->appends($_GET)->links()}}--}}
            </div>
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
                var keyword = $('#search-input').val();
                table.ajax.reload();
            });

            var post_data;
            console.log($('#example'));
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
                    {data: "query" , class:'left first-cell'},
                    {data: "category_name" , class:'center'},
                    {
                        data: "id", class: 'right',
                        render: function (data, type, row, meta) {
                            /*console.log(data);
                            console.log('AAAAAAAAAAA');*/

                            var href ='{!! URL::to('subadmin/questionnaire/editQuestionnaireDetails')  !!}';

                            /*var html = '<a title="Edit" class="edit_form" href="'+href+'/'+data+'" data-id=" '+data+' "><img class="wd-25" src="{{asset("image/edit.png")}}"/></a>';
                            html += '<a title="Delete" style="margin-left:5px;" class="delete_row" data-module="inspect_area" data-id="' +
                                data + '" href="javascript:void(0)"><img class="wd-25" src="{{asset("image/trash.png")}}"/> </a>';
                            return html;*/

                            return `
                            <div class="dropdown">
                                <button class="dropdown-dots dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                <img src="{{asset('assets/images/dropdown-dots.png')}}" alt="...">
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                    <li><a href="${href}/${data}"  data-id="${data}" class="edit_form"><img src="{{asset('image/edit.png')}}" alt="..."></a></li>
                                    <li><a href="# " data-module="inspect_area" data-id="${data}" class="delete_row"><img src="{{asset('image/trash.png')}}" alt="..."></
                                </ul>
                            </div>`;
                        }
                    },
                    {
                        data: 'order_by',
                        render: function (data, type, row, meta) {
                            var html = '<a title="Drag N Drop" class="" href="/"  data-id="' +
                                data + '"><img class="wd-13" src="{{asset("image/action.png")}}"/>  </a>';
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
                    },
                ],
                rowReorder: {
                    dataSrc: 'order_by',
                    selector: 'td:last-child'
                    // update: false,
                },
                ajax: {
                    url: '{!! URL::to("subadmin/questionnaire_datatable") !!}',
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

            table.on('click','.delete_row', function(e){
                console.log($(this).closest('tr').attr('id'));
                var confirmRes = confirm('Are You Sure');

                if (confirmRes) {
                    var id = $(this).closest('tr').attr('id');
                    $.ajax({
                        url:'{!! url('subadmin/questionnaire/delete') !!}/'+id,
                        method:'POST',
                        dataType: 'JSON',
                        success: function(response){
                            table.ajax.reload();
                            alert(response.message);
                        },
                        error: function(err){

                            console.log(err);

                        }
                    });
                }
            });

            console.clear();
            {{--ajaxDatatable('#example','{!! URL::to("subadmin/questionnaire_datatable") !!}');--}}

        });
    </script>
@endpush


