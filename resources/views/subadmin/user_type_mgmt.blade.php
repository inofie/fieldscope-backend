
@extends('subadmin.master')
@section('content')
    <!-- New Work  -->
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card-title">
                    <h1 class="main-heading">User Types</h1>
                      <button type="button" class="btn add-btn btn-add addusertype-btn-modified" data-toggle="modal" data-target="#myModal">
                            <ul class="d-flex align-items-center">
                                <li>
                                <img src="{{asset('assets/images/button-icon.png')}}" alt="...">
                                </li>
                                <li class="ml-4">
                                    User Type
                                </li>
                            </ul>
                      </button>
                    </div>
                </div>
       </div>
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
                            <th class="left w-20">User Type</th>
                            <th class="center w-50">Assigned Users</th>
                            <th class="right w-30">Settings</th>
                        </tr>
                    </thead>
                    <tbody>
                            <tr class="table-body">
                                <td  class="left first-cell">Sales Rep</td>
                                <td class="center second-cell">Test User 1, Test User 2, Test User 3, Test User 4</td>
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
                                <td  class="left first-cell">Production Manager</td>
                                <td class="center second-cell">Test User 1, Test User 2, Test User 3, Test User 4</td>
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
                                <td  class="left first-cell">Sales Rep</td>
                                <td class="center second-cell">Test User 1, Test User 2, Test User 3, Test User 4</td>
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
                                <td  class="left first-cell">Production Manager</td>
                                <td class="center second-cell">Test User 1, Test User 2, Test User 3, Test User 4</td>
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
                                <td  class="left first-cell">Sales Rep</td>
                                <td class="center second-cell">Test User 1, Test User 2, Test User 3, Test User 4</td>
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
                                <td  class="left first-cell">Production Manager</td>
                                <td class="center second-cell">Test User 1, Test User 2, Test User 3, Test User 4</td>
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
                                <td  class="left first-cell">Sales Rep</td>
                                <td class="center second-cell">Test User 1, Test User 2, Test User 3, Test User 4</td>
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
                                <td  class="left first-cell">Production Manager</td>
                                <td class="center second-cell">Test User 1, Test User 2, Test User 3, Test User 4</td>
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
                                <td  class="left first-cell">Sales Rep</td>
                                <td class="center second-cell">Test User 1, Test User 2, Test User 3, Test User 4</td>
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
                                <td  class="left first-cell">Production Manager</td>
                                <td class="center second-cell">Test User 1, Test User 2, Test User 3, Test User 4</td>
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
                                <td  class="left first-cell">Sales Rep</td>
                                <td class="center second-cell">Test User 1, Test User 2, Test User 3, Test User 4</td>
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
                                <td  class="left first-cell">Production Manager</td>
                                <td class="center second-cell">Test User 1, Test User 2, Test User 3, Test User 4</td>
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

        <div class="row  new-card-row user-type-table">
            <div class="col-12 col-md-12">
                <table class="table table-striped" id="example" style="width: 100%">
                    <thead>
                    <tr class="table-head">
                        <th class="left w-20" >User Type</th>
                        <th class="center w-50" >Assigned Users</th>
                        <th class="right w-30" >Settings</th>
                    </tr>
                    </thead>
                    <tbody>

{{--                    @if(count($data ))--}}
{{--                        @foreach ($data AS $item)--}}
{{--                            <tr class="table-body">--}}
{{--                                <td class="left first-cell">--}}
{{--                                    {{$item->title}}--}}
{{--                                </td>--}}
{{--                                <td class="center second-cell">Test User 1, Test User 2, Test User 3, Test User 4</td>--}}
{{--                                <td class="right">--}}
{{--                                    <div class="dropdown">--}}
{{--                                        <button class="dropdown-dots dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">--}}
{{--                                            <img src="{{asset('assets/images/dropdown-dots.png')}}" alt="...">--}}
{{--                                        </button>--}}
{{--                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">--}}
{{--                                            <li><a href="/" class="edit_form" data-id="{{$item->id}}"><img src="{{asset('image/edit.png')}}" alt="..."></a></li>--}}
{{--                                            <li><a class="delete" href="{{URL::to('subadmin/user-type/delete/'.$item->id.'?page='.\Request::input('page',1) )}}"><img src="{{asset('image/trash.png')}}" alt="..."></--}}
{{--                                        </ul>--}}
{{--                                    </div>--}}
{{--                                </td>--}}
{{--                            </tr>--}}
{{--                        @endforeach--}}
{{--                    @endif--}}
                    </tbody>
                </table>
{{--                {{ $data->appends($_GET)->links() }}--}}
            </div>
        </div>
    </div>
    <!-- New Work  End -->

    {{--To be removed hidden on Dec-2022 --}}
    <div class="row nomargin hide">
        <div class="col-md-6">
            <h1 class="main-heading">User Types</h1>
        </div>
        <div class="col-md-6">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <!-- Trigger the modal with a button -->
                        <button type="button" class="btn btn-add addusertype-btn-modified" data-toggle="modal" data-target="#myModal">Add User
                            Type
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

    <!-- Add Modal -->
    <div class="modal fade " id="myModal" role="dialog">
        <div class="modal-dialog add-project-modal">
            <!-- Modal content-->
            <div class="modal-content">
                <form id="add_form" action="{{URL::to('subadmin/user-type/store')}}" method="POST">
                    {{csrf_field()}}
                    <div class="modal-header logoimageheader">
                        <div class="header-content">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h3 class="modal-title text-left">Add User Type</h3>
                        </div>
                    </div>
                    <div class="modal-body companyinfobody rm-companyinfobody-modified">
                        <div class="row">
                            <div class="col-md-12 companyinfobody rm-companyinfobody-modified">
                                <label>User Type Name</label>
                                <input type="text" name="user_type"  placeholder="User Type Name" required/>
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
                </form>
            </div>
        </div>
    </div>
    <!-- Edit Modal -->
    <div class="modal fade new-modal" id="editModal" role="dialog">
        <div class="modal-dialog add-project-modal">
            <!-- Modal content-->
            <div class="modal-content">
                <form id="update_form" action="{{URL::to('subadmin/user-type/update')}}" method="POST">
                    {{csrf_field()}}
                    <input type="hidden" name="page" value="{{\Request::input('page',1)}}">
                    <div class="modal-header">
                        <div class="header-content">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h3 class="modal-title text-left">Edit User Type</h3>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group new-input-modal">
                            <label>User Type Name</label>
                        <input type="text" name="user_type" placeholder="User Type Name" required/>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="add-cancel-bnt">
                            <button type="button" class="btn btn-close cancelButton" data-dismiss="modal">
                                    <ul class="add-cancel-btn">
                                        <li>-</li>
                                        <li> Cancel</li>
                                    </ul>
                            </button>
                            <button type="submit" class="btn btn-save bg-modified">
                                    <ul class="add-cancel-btn">
                                        <li></li>
                                        <li>Update</li>
                                    </ul>
                            </button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
@endsection

@push('page_level_scripts')
    <script type="text/javascript">
        $(document).ready(function(){
            var updateUrl = "{{URL::to('subadmin/user-type/update')}}";
            var $editModal = $('#editModal');

            $("td a.delete").on('click',function (e) {
                return confirm("Are you sure ?");
            });

            $('#search-btn').on('click',function (e) {
                table.ajax.reload();
            });

            console.log('Table');
            var table = $('#example').DataTable({
                "processing": true,
                "serverSide": true,
                "autoWidth": false,
                searching: false,
                dom: '<pl><t>ir',
                stripeClasses: [ '', 't-row-color' ],
                rowId: 'id',
                columns: [
                    {data: "title", class:'left first-cell' },
                    {data: "users", class:'center second-cell' },
                    {
                        data: "id",
                        class:'right',
                        render: function (data, type, row, meta) {
                            let html = `<div class="dropdown">
                                        <button class="dropdown-dots dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                        <img src="{{asset('assets/images/dropdown-dots.png')}}" alt="...">

                                        </button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                                <li><a href="#"  data-id="${data}" class="edit_form"><img src="{{asset('image/edit.png')}}" alt="..."></a></li>
                                                <li><a href="# " data-id="${data}" class="delete_row"><img src="{{asset('image/trash.png')}}" alt="..."></
                                            </ul>
                                        </div>`;
                            return html;
                        },
                        // orderable: false
                    },

                ],
                createdRow: function (row, data, dataIndex) {
                    $(row).addClass('table-body');
                },
                columnDefs: [
                    { orderable: false, targets: -1, },
                    { orderable: true, targets: '_all', },
                ],
                // rowReorder: {
                //     // dataSrc: 3,
                //     // selector: 'td:last-child'
                //     // update: false,
                // },
                ajax: {
                    url: '{!! URL::to("subadmin/user-type_datatable") !!}',
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
                        // d.reOrder = post_data;
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

            table.on('click', 'td a.edit_form', function (e) {
                e.preventDefault();
                var id = $(this).data('id');
                $.ajax({
                    url: "{{URL::to('subadmin/user-type/editFormDetails')}}/" + id,
                    method: "GET",
                    data: '',
                    success: function (response) {
                        var data = response.data ;

                        $('#update_form').attr('action',updateUrl+'/'+response.data.id);
                        $('#update_form input[name="user_type"]').val(response.data.title);
                        $editModal.modal('show');
                    },
                    error: function () {
                        alert("No Network");
                    }
                });
            });

            table.on('click','.delete_row', function(e){
                console.log($(this).closest('tr').attr('id'));

                var confirmRes = confirm('Are You Sure');

                if (confirmRes) {
                    var id = $(this).closest('tr').attr('id');
                    $.ajax({
                        url:'{!! url('subadmin/user-type/delete') !!}/'+id,
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
        });
    </script>
@endpush