@extends('subadmin.master')
@section('content')
{{--{{dd(request()->input('project_ids'))}}--}}

    <style>
        .select2-container {
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

        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
            color: white;
        }
        .card-image img{
            height:150px;
            border-radius:5px;
        }

    </style>

    <!-- New Work  -->
    <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                                <div class="card-title-photo-feed">
                                    <h1 >Photo Feed</h1>
                                    
                                </div>
                            </div>
                    </div>
                    <div class="row  new-card-row" >
                        <div class="col-md-12 d-flex align-items-center justify-content-between">
                                <!-- Trigger the modal with a button -->
                                    <div class="top-button">
                                        <button class="btn btn-add pf-btn-cf-modified" data-toggle="modal" data-target="#myModal">
                                            <ul class="d-flex align-items-center">
                                                <li>
                                                        <img src="{{asset('assets/images/filter-icon.png')}}" alt="...">
                                                </li>
                                                <li class="ml-4">
                                                    filter        
                                                </li>
                                            </ul>
                                         </button>
                                         
                                    <a href="{{URL::to('subadmin/photo_feed')}}" class="btn btn-add pf-btn-cf-modified"> Clear Filter</a>
                                    </div>
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
                </div>
        <!-- New Work  End -->
    <div class="row">
        <div class="col-md-6">
            <!-- <h1 class="main-heading">Photo Feed </h1> -->
        </div>

        <div class="col-md-6">
            <!-- <div class="container">
                <div class="row" >
                    <div class="col-md-12" >
                        <button class="btn btn-add pf-btn-cf-modified" data-toggle="modal" data-target="#myModal"><i class="fa fa-filter pl-1"></i> filter</button>
                        <a href="{{URL::to('subadmin/photo_feed')}}" class="btn btn-add pf-btn-cf-modified"> Clear Filter</a>
                    </div>                    
                    <div class="col-md-6"></div>
                    <div class="col-md-6">
                        <div class="search-bar pt-3">
                            <div class="input-group pmsearch-modified">
                                <input value="" id="search-input " name="keyword" type="text" class="form-control searchip-modified" placeholder="Search here">
                                <span class="input-group-btn">
                                <button id="search-btn" class="btn btn-default search-btn search-btn-modified" type="button"><i class="fas fa-search search-icon-modified"></i></button>
                                </span>
                            </div>
                        </div>
                    </div>
                    
                </div> -->
                    
                <!-- Trigger the modal with a button -->
                {{--<button type="button" class="btn btn-add" >Add Project </button>--}}

                <div class="modal fade " id="myModal" tabindex="-1" role="dialog">
                    <div class="modal-dialog " role="document">
                        <div class="modal-content ">
                            <div class="modal-header logoimageheader">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                            aria-hidden="true">&times;</span></button>
                                <h3 class="modal-title text-left">Add Filter</h3>
                                <hr />
                            </div>
                            <form class="filters">
                            <div class="modal-body companyinfobody rm-companyinfobody-modified">

                                    <div class="row" >
                                        <div class="col-md-6 companyinfobody rm-companyinfobody-modified">
                                            <!-- <label>Date</label> -->
                                            <input type="date" name="date"  placeholder="Date"
                                                   @if(!empty(request()->input('date')) )
                                                   value="{{request()->input('date')}}"
                                                    @endif
                                            />
                                        </div>
                                        <div class="col-md-6 companyinfobody rm-companyinfobody-select-modified">
                                            <!-- <label>Projects</label> -->
                                            <select name="project_ids" class="select2" >
                                                @if(empty(request()->input('project_ids')))
                                                    <option value="0" disabled selected>Select Projects</option>
                                                @endif

                                                @foreach($data['projects'] AS $key => $item)
                                                    <option
                                                            @if(!empty(request()->input('project_ids')) AND request()->input('project_ids') == $item['id'])
                                                            {{'selected'}}
                                                            @endif

                                                            value="{{$item['id']}}">{{$item['name']}}</option>

                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6 companyinfobody rm-companyinfobody-select-modified">
                                            <!-- <label>Users</label> -->
                                            <select name="user_ids" >
                                                @if(empty(request()->input('user_ids')))
                                                    <option value="0" disabled selected>Select Users</option>
                                                @endif
                                                @foreach($data['user'] AS $key => $item)
                                                    <option
                                                            @if(!empty(request()->input('user_ids')) AND  request()->input('user_ids') == $item['id'])
                                                            {{'selected'}}
                                                            @endif

                                                            value="{{$item['id']}}">{{$item['first_name']}} {{$item['last_name']}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6 companyinfobody rm-companyinfobody-select-modified">

                                            <!-- <label>Tags</label> -->
                                            <select name="tag_ids" class="form-control select2">
                                                @if(empty(request()->input('tag_ids')))
                                                    <option value="0" disabled selected>Select Tags</option>
                                                @endif
                                                @foreach($data['tag'] AS $key => $item)
                                                    <option
                                                            @if(!empty(request()->input('tag_ids')) AND  request()->input('tag_ids') == $item['id'])
                                                            {{'selected'}}
                                                            @endif
                                                            value="{{$item['id']}}">{{$item['name']}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                            </div>
                                <div class="modal-footer logoimagefooter">
                                    <button type="button" class="btn btn-close cancelButton" data-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-save bg-modified">Confirm</button>
                                </div>
                            </form>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
                <!-- /.modal -->
            </div>
        </div>
    </div>
<div class="row pt-4 listing">

        @if(!empty($data['latest_photos']->total()))
            @foreach($data['latest_photos'] AS $key => $item)
                             <div class="col-md-4">
                                <div class="card-body">
                                    <div class="card-header">
                                        <ul class="new-card address-icon">
                                            <li>
                                                <!-- <a href="${baseUrl+"/subadmin/project/detail/"+element.id}"></a> -->
                                                <h4>{{$item->p_name}}</h4>
                                            </li>
                                            <li>
                                            <a href="{{url('subadmin/photo_feed/edit/'.$item->id)}}"><i
                                                            class="fa fa-pen pl-1"></i></a>
                                                <!-- <a href="{{url('subadmin/photo_feed/details/'.$item->id)}}"><i
                                                            class="fa fa-eye pl-1"></i></a> -->
                                            </li>
                                        </ul>
                                       
                                    </div>
                                    <div class="card-img">
                                    <img src="{{url('uploads/media/'.$item->path)}}"  class="img-responsive"/>
                                    </div>
                                  
                                    <div class="card-footer" style="left: 2px;padding: 0;">
                                    <h5 class="light-gray"
                                    title="{{\Carbon\Carbon::parse($item->created_at)->format('Y-m-d g:i A') }}">{{\Carbon\Carbon::parse($item->created_at)->diffForHumans() }}
                                    . {{$item->u_first_name}} {{$item->u_last_name}}</h5>
                                    </div>

                                </div>
                            </div>
                
            @endforeach
        @else
        <div class="col-md-12 mb-3 text-center">
            <h4>No Data Found</h4>
        </div>
        @endif

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        {{$data['latest_photos']->appends(request()->input())->links()}}
    </div>
</div>
</div>

<div class="modal fade" id="editModal" role="dialog">
    <div class="modal-dialog modal-sm">
        <form id="update_form" action="{{URL::to('subadmin/photo_view/update')}}" method="POST">
            {{csrf_field()}}
            <input type="hidden" name="page" value="{{\Request::input('page',1)}}">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Edit Photo View</h4>
                </div>


                <div class="modal-body">
                    <div class="form-group">
                        <input name="name" type="text" class="form-control input" placeholder="Photo View Name">
                    </div>
                    <div class="form-group">
                        <select name="parent_id" class="form-control select2" id="sel1">
                            {{--                                @foreach($data['area'] AS $item)--}}
                            {{--                                    <option value="{{$item['id']}}">{{$item['name']}}</option>--}}
                            {{--                                @endforeach--}}

                        </select>
                    </div>

                    {{--<div class="form-group">--}}
                    {{--<select name="thumbnail" class="select2 form-control " data-placeholder="Default Thumbnail">--}}
                    {{--<option value=""></option>--}}
                    {{--<option value="1">Yes</option>--}}
                    {{--<option value="0">No</option>--}}
                    {{--</select>--}}
                    {{--</div>--}}

                    <div class="form-group">
                        <input name="min_quantity" type="text" class="form-control input" placeholder="Quantity">
                    </div>
                </div>
                <div class="modal-footer text-center">
                    <button type="submit" class="btn btn-info bt-save">Update</button>
                </div>

            </div>
        </form>
    </div>
</div>
@endsection

@push('page_level_scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            var filters = '@php echo json_encode(request()->input()); @endphp';
            var requestP = JSON.parse(filters);
            console.log(filters, 'filters');

// $('.select2').select2({
//     placeholder: "Select Your Option"
// });

            var updateUrl = "{{URL::to('subadmin/photo_view/update')}}";
            var $editModal = $('#editModal');

            $("td a.delete").on('click', function (e) {
                return confirm("Are you sure ?");
            });

            $('#search-btn').on('click', function (e) {
                var keyword = $('#search-input').val();
                search(keyword);
            });

            function search(keyword) {
                var url = new URL(window.location.href);
                url.searchParams.set('keyword', keyword);
                url.searchParams.set('page', 1);
                console.log(url.href);
                window.location.href = url.href;
            }

            console.log(requestP, 'requestP');

            $("form.filters").on('submit', function (e) {
// alert('FORM');
                e.preventDefault();
                var inputP = queryStringToJson($(this).find("select,textarea, input").serialize());

                requestP.date = inputP.date;
                requestP.project_ids = inputP.project_ids;
                requestP.tag_ids = inputP.tag_ids;
                requestP.user_ids = inputP.user_ids;

                console.log(inputP, 'inputP');
                console.log(requestP, 'requestP');


                window.location = location.protocol + '//' + location.host + location.pathname + '?' + $.param(inputP);
            });

            function queryStringToJson(url) {
                return JSON.parse('{"' + decodeURI(url).replace(/"/g, '\\"').replace(/&/g, '","').replace(/=/g, '":"') + '"}');
            }


// alert('test');

            $("#example").on('click', 'td a.edit_form', function (e) {
                e.preventDefault();
                var id = $(this).data('id');
                $.ajax({
                    url: "{{URL::to('subadmin/photo_view/editPhotoDetails')}}/" + id,
                    method: "GET",
                    data: '',
                    success: function (response) {
                        var data = response.data;
                        $('#update_form').attr('action', updateUrl + '/' + response.data.id);
                        console.log(response.data);
                        $('#update_form input[name="name"]').val(response.data.name);
                        $('#update_form input[name="min_quantity"]').val(response.data.min_quantity);
                        console.log('group id');

                        $('#update_form select[name="parent_id"] option').each(function (key, item) {
                            if ($(item).val() == response.data.parent_id) {
                                console.log('parent_id');
                                console.log(response.data.parent_id);
                                $(item).prop('selected', true);
                            }
                        });

// $('#update_form select[name="thumbnail"] option').each(function (key,item) {
//     if($(item).val() == response.data.thumbnail){
//         console.log('thumbnail');
//         console.log(response.data.thumbnail);
//         $(item).prop('selected', true);
//     }
// });

                        $('#update_form select[name="parent_id"]').trigger('change');
// $('#update_form select[name="thumbnail"]').trigger('change');

                        $editModal.modal('show');
                    },
                    error: function () {
                        alert("No Network");
                    }
                });
            });

            $('#search-btn').on('click', function () {
                table.ajax.reload();
            });

            var post_data;
            var table = $('#example').DataTable({
                "processing": true,
                "serverSide": true,
                "ordering": false,
                "autoWidth": true,
                searching: false,
                rowId: 'id',
                "createdRow": function (row, data, dataIndex) {
                    /*console.log('Rows');
                    console.log($(row));
                    console.log(data);*/
                    $(row).data('order_by', data.order_by);
                },
                columns: [
                    {data: "name"},
                    {data: "parent"},
                    {data: "min_quantity"},
// {data: "thumbnail"},
                    {
                        data: "id",
                        render: function (data, type, row, meta) {
                            /*console.log(data);
                            console.log('AAAAAAAAAAA');*/

                            var html = '<a title="Edit" class="btn btn-sm btn-primary edit_form" href="/"  data-id="' +
                                data + '"><i class="fa fa-edit"></i> </a>';
                            html += '<a title="Delete" style="margin-left:5px;" class="delete_row btn btn-sm btn-danger" data-module="inspect_area" data-id="' +
                                data + '" href="javascript:void(0)"><i class="fa fa-trash"></i> </a>';
                            return html;
                        }
                    },
                    {
                        render: function (data, type, row, meta) {
                            var html = '<a title="Drag N Drop" class="" href="/"  data-id="' +
                                data + '"><i class="fas fa-arrows-alt-v"></i> </a>';
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
                    url: '{!! URL::to("subadmin/photo_view_datatable") !!}',
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
                    $.each(data, function (index, item) {
                        /*console.log( index + ": " + $(item.node).attr('id'));
                        console.log( index + ": " + $(item.node).attr('id'));*/
                        object[index] = {
                            'old_position': data[index].oldPosition,
                            'new_position': data[index].newPosition,
                            'id': $(item.node).attr('id'),
                            'order_by': $(item.node).data('order_by')
                        }

                    });
                    console.log(object);
                    post_data = object;
                }
            });


            table.on('click', '.delete_row', function (e) {
                console.log($(this).closest('tr').attr('id'));

                var confirmRes = confirm('Are You Sure');

                if (confirmRes) {
                    var id = $(this).closest('tr').attr('id');
                    $.ajax({
                        url: '{!! url('subadmin/delete/photo_view') !!}/' + id,
                        method: 'POST',
                        dataType: 'JSON',
                        success: function (response) {
                            table.ajax.reload();
                            alert(response.message);
                        },
                        error: function () {
                        }
                    });
                }
            });
// console.clear();
        });
    </script>
@endpush




