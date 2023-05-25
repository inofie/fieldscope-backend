@extends('subadmin.master')
@push('page_level_css')
    <link rel="stylesheet" href="{{asset("assets/pagination-2.1.5/pagination.min.css")}}" />
    <link rel="stylesheet" href="{{asset('assets/validation/bootstrap-datepicker.css')}}" />

    <style>
        .pac-container{
            z-index: 9999;
        }
        .content{
            padding-bottom: 60px;
        }
        #project_page_controls{
            padding-left: 41px;
            padding-bottom: 50px !important;
        }

        .paginationjs .paginationjs-pages li>a{
            background: #fff;
            font-size: 14px;
            color: #3f3d56;
        }

        .paginationjs .paginationjs-pages li.active>a {
            background-color: #0082f1;
        }
    </style>
    @endpush
@section('content')
        <!-- New Work  -->
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card-title">
                                <h1 class="main-heading">Projects</h1>
                                <div class="buttons">
                                <button type="button" class="add-btn" data-toggle="modal" data-target="#myModal">
                                    <ul class="d-flex align-items-center">
                                        <li>
                                            <img src="{{asset('assets/images/button-icon.png')}}" alt="...">
                                        </li>
                                        <li class="ml-4">
                                            Add Project
                                        </li>
                                    </ul>

                                </button>
                               
                            </div>
                            
                        </div>
                    </div>

                    {{----}}
                    <div class="row  new-card-row" >
                        <div class="col-md-12 d-flex align-items-center justify-content-between">
                            <!-- Trigger the modal with a button -->
                            <div class="top-button">
                                <button class="filter-btn" data-toggle="modal" data-target="#myModalFilter">
                                    <ul class="d-flex align-items-center">
                                        <li>
                                                <img src="{{asset('assets/images/filter-icon.png')}}" alt="...">
                                        </li>
                                        <li class="ml-4">
                                            filter
                                        </li>
                                    </ul>
                            </button>
                                <a href="http://127.0.0.1:8000/subadmin/crm/sync" class="btn-green-new">JobScope Sync </a>
                            </div>
                            <div class="data-tables-select">
                                <!-- <label style="left: 2px;padding: 0 0 6px 0;">
                                    Show
                                        <select name="example_length" aria-controls="example" class="form-control input-sm">
                                            <option value="10">10</option><option value="20">20</option>
                                            <option value="50">50</option><option value="100">100</option>
                                            <option value="200">200</option>
                                        </select>
                                    entries
                                </label> -->
                            </div>
                            <div class="search-input">
                                <input value="" id="search-input" name="keyword" type="text" class="form-control" placeholder="Search Projects">
                                
                            </div>
                         
                        </div>
                        

                    
                    <div class="row new-card-row" id="project_grid">


                    </div>
            </div>
                </div>
        <!-- New Work  End -->


{{--    V2 Work Starts here    --}}

<div class="row nomargin hide " id="top">
    <div class="col-md-6 pl-0">
      <h1 class="main-heading">Project Management</h1>
      <!-- <div class="search-bar pt-3">
         <div class="input-group">
            <input value="" id="search-input" name="keyword" type="text" class="form-control" placeholder="Search Project">
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
                    <div>
                        <!-- Trigger the modal with a button -->
                        <button class="btn btn-add pf-btn-cf-modified" data-toggle="modal" data-target="#myModalFilter"><i class="fa fa-filter pl-1"></i> filter</button>
                        <a href="{{URL::to('subadmin/crm/sync')}}" class="btn btn-green sync btn-pmsync-modified" >Sync to JobS </a>
                        <button type="button" class="btn btn-add btn-pmadd-modified" data-toggle="modal" data-target="#myModal">Add Project</button>
                    </div>
                </div>
                <div class="col-md-6"></div>
                <!-- <div class="col-md-6">
                    <div class="search-bar pt-3">
                        <div class="input-group pmsearch-modified">
                            <input value="" id="search-input" name="keyword" type="text" class="form-control searchip-modified" placeholder="Search here">
                            <span class="input-group-btn">
                            <button id="search-btn" class="btn btn-default search-btn search-btn-modified" type="button"><i class="fas fa-search search-icon-modified"></i></button>
                            </span>
                        </div>
                    </div>
                </div> -->
            </div>

        </div>
    </div>
</div>


{{--    Grid     --}}

    <div class="row nomargin pm-maincon-modified" id="__project_grid">

    </div>
    <div class="row nomargin pm-maincon-modified" >
        <div class="col-md-12 col-sm-12 col-xs-12" id="project_page_controls"></div>
    </div>

        <div class="col-md-3 pm-col-modified hide">
            <div class="thumbnail pm-thumbnail-modified">
                <img src="{{asset('assets/images/pm-cardimg.png')}}" alt="...">
                <div class="caption pm-caption-modified">
                    <div class="pm-captionheader-modified">
                        <h3>PROJECT NAME</h3>
                        <a >Open</a>
                        <a class="num-modified">20</a>
                    </div>
                    <p>16433 Agnes St Gardner, KS 66030</p>
                    <div class="pm-caption-bottom">
                        <div>
                            <p >Inspector:<span>Paul Lewis</span></p>
                        </div>
                        <div>
                            <p >Submitted Date:<span>10/06/2021</span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 pm-col-modified hide">
            <div class="thumbnail pm-thumbnail-modified">
                <img src="{{asset('assets/images/pm-mapimg.jpg')}}" alt="...">
                <div class="caption pm-caption-modified">
                    <div class="pm-captionheader-modified">
                        <h3>PROJECT NAME</h3>
                        <a >Open</a>
                        <a class="num-modified">20</a>
                    </div>
                    <p>16433 Agnes St Gardner, KS 66030</p>
                    <div class="pm-caption-bottom">
                        <div>
                            <p >Inspector:<span>Paul Lewis</span></p>
                        </div>
                        <div>
                            <p >Submitted Date:<span>10/06/2021</span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 pm-col-modified hide">
            <div class="thumbnail pm-thumbnail-modified">
                <img src="{{asset('assets/images/pm-cardimg.png')}}" alt="...">
                <div class="caption pm-caption-modified">
                    <div class="pm-captionheader-modified">
                        <h3>PROJECT NAME</h3>
                        <a >Open</a>
                        <a class="num-modified">20</a>
                    </div>
                    <p>16433 Agnes St Gardner, KS 66030</p>
                    <div class="pm-caption-bottom">
                        <div>
                            <p >Inspector:<span>Paul Lewis</span></p>
                        </div>
                        <div>
                            <p >Submitted Date:<span>10/06/2021</span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<div class="row nomargin hide">
  <div class="col-md-12 col-sm-12 col-xs-12">
     <table class="table table-striped" id="example">
        <thead>
           <tr>
              <th>Project</th>
              <th></th>
              <th>Photos</th>
              <th>Inspector Assigned</th>
              <th>Submission Date</th>
              {{--
              <th>J.S Synced Date</th>
              --}}
              <th>Action</th>
           </tr>
        </thead>
        <tbody>
        </tbody>
     </table>
  </div>
</div>

<!-- Add Project Modal -->
<div class="modal fade " id="myModal"  tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog add-project-modal">
        <!-- Modal content-->
        <form id="add_form" action="{{URL::to('subadmin/project/store')}}" method="POST">
            {{csrf_field()}}
            <div class="modal-content ">
                <div class="modal-header logoimageheader">
                    <div class="header-content">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h3 class="modal-title text-left">New Project</h3>
                    </div>
                </div>
                <div class="modal-body companyinfobody rm-companyinfobody-modified">
                    <div class="row">
                        <div class="col-md-12 companyinfobody rm-companyinfobody-modified">
                            <!-- <label>Project Name</label> -->
                            <input name="name" type="text"  placeholder="Project Name" >
                        </div>
                        <div class="col-md-12 companyinfobody rm-companyinfobody-modified address-group">
                            <!-- <label>Address Lane 1</label> -->
                            <input name="address1" id="add_address1" type="text"  placeholder="Address 1" autocomplete="off">
                            <input name="lat" type="hidden" >
                            <input name="long" type="hidden" >
                        </div>

                        <div class="col-md-12 companyinfobody rm-companyinfobody-modified address-group">
                            <!-- <label>Address Lane 1</label> -->
                            <input name="address2" id="add_address2" type="text"  placeholder="Address 2" autocomplete="off">

                        </div>

                        <div class="col-md-12 companyinfobody rm-companyinfobody-modified">
                            <!-- <label>Claim No</label> -->
                            <input name="claim_num" type="text" class="input" placeholder="Claim #">
                        </div>

                        <!-- <div class="col-md-12 companyinfobody rm-companyinfobody-modified">
                                 <label>Inspection Date</label>
                                <input name="inspection_date" class="input" type="date"  placeholder="Date">
                        </div> -->
                        <div class="col-md-12 companyinfobody rm-companyinfobody-modified">
                            <!-- <label>Sales Tax</label> -->
                            <input name="sales_tax" type="text" class="input" placeholder="Sales Tax">
                        </div>

                        <div class="col-md-12 companyinfobody rm-companyinfobody-modified">
                            <!-- <label>Sales Tax aaaa</label> -->
                            <input name="inspection_date"  class="input disableFuturedate"  placeholder="Date" type ="date">
                        </div>

                        <div class="col-md-12 companyinfobody rm-companyinfobody-modified">
                            <!-- <label>Claim No</label> -->
                            <input name="customer_email" type="text" class="input" placeholder="Customer Email">
                        </div>

                        <div class="col-md-12 companyinfobody rm-companyinfobody-select-modified">
                            {{--<label>User</label>--}}
                            <select name="assigned_user_id">
                                <option disabled selected>-Assign User-</option>
                                @foreach($data['inspectors'] AS $key => $item)
                                    <option value="{{$item->id}}">{{$item->userNames}}</option>
                                @endforeach
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

{{-- Filter Modal Start --}}
<div class="modal fade " id="myModalFilter" tabindex="-1" role="dialog">
    <div class="modal-dialog " role="document">
        <div class="modal-content add-project-modal">
            <div class="modal-header logoimageheader">
                    <div class="header-content">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h3 class="modal-title text-left">Add Filter</h3>
                    </div>
            </div>

            <form class="filters">
                <div class="modal-body companyinfobody rm-companyinfobody-modified">

                    <div class="row">
                        <div class="col-md-4 companyinfobody rm-companyinfobody-modified">
                            <!-- <label>Date</label> -->
                            <input type="date" name="filter_created_date" placeholder="Date"
                            />
                        </div>


                        <div class="col-md-4 companyinfobody rm-companyinfobody-select-modified">
                            <select name="filter_project_status">
                                <option value="-1" disabled selected>Select Status</option>
                                <option value="2">Closed</option>
                                <option value="1">Open</option>
                            </select>
                        </div>
                        <div class="col-md-4 companyinfobody rm-companyinfobody-select-modified">
                            <!-- <label>Users</label> -->
                            <select name="filter_inspectors">
                                <option value="-1" disabled selected>Select User</option>
                                @foreach($data['inspectors'] AS $key => $item)
                                    <option value="{{$item->id}}">{{$item->userNames}}</option>
                                @endforeach
                            </select>
                        </div>
                        {{--                                        <div class="col-md-6 companyinfobody rm-companyinfobody-select-modified hide">--}}

                        {{--                                            <!-- <label>Tags</label> -->--}}
                        {{--                                            <select name="tag_ids">--}}

                        {{--                                                <option value="0" disabled selected>Select Tags</option>--}}
                        {{--                                                <option>Tags 1</option>--}}
                        {{--                                                <option>Tags 2</option>--}}
                        {{--                                                <option>Tags 3</option>--}}
                        {{--                                            </select>--}}
                        {{--                                        </div>--}}
                    </div>

                </div>
                <div class="modal-footer logoimagefooter">
                    <button type="button" class="btn btn-close cancelButton" data-dismiss="modal">
                        Cancel
                    </button>
                    <button type="submit" class="btn btn-save bg-modified filter_submit">Confirm
                    </button>
                    <!-- <button type="button" class="btn btn-close cancelButton" data-dismiss="modal">
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
                    </button> -->
                </div>
            </form>

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<!-- Update / Edit Modal -->
<div class="modal fade " id="editModal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <form id="update_form" action="{{URL::to('subadmin/project/update')}}" method="POST">
            {{csrf_field()}}
            <div class="modal-content">
                <div class="modal-header logoimageheader">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h3 class="modal-title text-left">Edit Project</h3>
                    <hr />
                </div>
                <div class="modal-body companyinfobody rm-companyinfobody-modified">
                    <div class="row">
                    <div class="col-md-12 companyinfobody rm-companyinfobody-modified">
                        <input name="name" type="text"  placeholder="Project Name">
                    </div>
                    <div class="col-md-12 companyinfobody rm-companyinfobody-modified form-group">
                        <input name="address1" id="update_address1" type="text" placeholder="Address 1" autocomplete="off">
                        <input name="lat" type="hidden" >
                        <input name="long" type="hidden" >
                    </div>
                    <div class="col-md-12 companyinfobody rm-companyinfobody-modified form-group">
                        <input name="address2" id="update_address2" type="text" placeholder="Address 2" autocomplete="off">

                    </div>
                    <div class="col-md-6 companyinfobody rm-companyinfobody-modified">
                        <input name="customer_email" readonly type="text" class="input" placeholder="Customer Email">
                    </div>

                    <div class="col-md-6 companyinfobody rm-companyinfobody-modified">
                        <input name="claim_num" type="text" class="input" placeholder="Claim #">
                    </div>

                    <div class="col-md-6 companyinfobody rm-companyinfobody-modified">
                        <input name="inspection_date"  class="input" type="date" placeholder="Date">
                    </div>
                    <div class="col-md-6 companyinfobody rm-companyinfobody-modified ">
                        <input name="sales_tax" type="text" class=" input" placeholder="Sales Tax">
                    </div>
                    <div class="col-md-12 companyinfobody rm-companyinfobody-select-modified ">
                        <select name="assigned_user_id" >
                            <option disabled selected>-Assign User-</option>
                            @foreach($data['inspectors'] AS $key => $item)
                                <option value="{{$item->id}}">{{$item->userNames}}</option>
                            @endforeach
                        </select>
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

{{-- thumbnail modal --}}
<div class="modal" id="thumbnail-view">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <img id="img01" src="" style="width:500px;">
            </div>
        </div>
    </div>
</div>
@endsection
@push('page_level_scripts')
    <script src="{{asset('assets/pagination-2.1.5/pagination.min.js')}}" ></script>
    <script src="{{asset('assets/js/moment.min.js')}}" ></script>
    <script src="{{asset('assets/validation/bootstrap-datepicker.js')}}" ></script>

    <script type="text/javascript">



        function initAutocomplete(){
            let addressInput = $('input[name="address1"]');
            let options = {
                types: ["geocode"],
                /** street_address: indicates a precise street address,
                 * address: from table 3 */
               
                fields: ["name","address_components", "geometry"],
            };


            addressInput.each((i,el)=>{
                var autocomplete = new google.maps.places.Autocomplete(el, options);
                autocomplete.inputId = el.id;
                autocomplete.addListener('place_changed', fillIn);
            })



            function fillIn() {
                console.log("fillIn",this.inputId);

                var place = this.getPlace();
                var myInput = $('#' + this.inputId);

                // console.log('lat, long',place.geometry.location.lat()+', '+place.geometry.location.lng());
                // console.log('place.name',place.name);

                let addr = [];
                place.address_components.filter((el,i)=>{
                    // locality -> CIty
                    // administrative_area_level_1 -> State
                    // postal_code -> Postal Code
                    el.types.map((typeEl,i)=>{

                        if(typeEl == 'locality')
                            addr.city = el.long_name

                        if(typeEl == 'administrative_area_level_1')
                            addr.state = el.short_name

                        if(typeEl == 'postal_code')
                            addr.postal_code = el.long_name
                    })
                });

                console.log('place.name',place.name);
                console.log(place.address_components);

                addr.postal_code = (typeof addr.postal_code) == 'undefined' ? '': addr.postal_code;
                console.log('final address',`${place.name}, ${addr.city}, ${addr.state}, ${addr.postal_code}`);

                let formattedAddress = `${place.name}, ${addr.city}, ${addr.state} ${addr.postal_code}`

                myInput.closest("div.address-group").find("input[name='lat']").val(place.geometry.location.lat());
                myInput.closest("div.address-group").find("input[name='long']").val(place.geometry.location.lng());

                myInput[0].value = formattedAddress;

                console.log('lat',place.geometry.location.lat());
                console.log('lng',place.geometry.location.lng());
                // console.log('lat',myInput.closest("div.form-group").find("input[name='lat']").val());
                // console.log('long',myInput.closest("div.form-group").find("input[name='long']").val());

                // myInput.attr('data-city', place.address_components[3].long_name);
                //
                // myInput.on('datachange', function(){
                //     console.log('datachange')
                //
                //     // var localityData = myInput.data("city");
                //     // myInput.closest('.accommodationDivs').find('.cityRu').val(localityData);
                // });
                //
                // myInput.data('city', place.address_components[3].long_name).trigger('datachange');

            }
        }

        $(document).ready(function () {
            $('.select2').select2({
                placeholder: "Select Your Option"
            });

            var baseUrl = "{{url("")}}";
            var updateUrl = "{{URL::to('subadmin/project/update')}}";
            var $editModal = $('#editModal');
            var searchKeyword =

                $("td a.delete").on('click', function (e) {
                    return confirm("Are you sure ?");
                });

            $("#search-input").on("keyup", function (e) {
                if (e.keyCode == 13) {
                    // Do something
                    searchKeyword = $(this).val();
                    renderGrid();
                }
            });

            $('#search-btn').on('click', function (e) {
                searchKeyword = $("#search-input").val();
                renderGrid();
            });


            var selectedCItyId = '';

            /** State Input removed 21-Jun */
            {{--$('.stateInput').on('change', function (e) {--}}
            {{--    console.log('change');--}}
            {{--    var id = $(this).val();--}}
            {{--    console.log('id', id);--}}
            {{--    var $input = $(this);--}}
            {{--    $.getJSON('{{URL::to('subadmin/cities')}}/' + id, function (response) {--}}
            {{--        var items = [];--}}
            {{--        $.each(response.data, function (key, val) {--}}
            {{--            items.push("<option value='" + val.id + "'>" + val.name + "</option>");--}}
            {{--        });--}}

            {{--        $input.closest('.row').find('.cityInput')--}}
            {{--            .find('option')--}}
            {{--            .remove()--}}
            {{--            .end()--}}
            {{--            .append(items.join(""));--}}

            {{--        console.log('selectedCItyId', selectedCItyId);--}}
            {{--        $('#update_form select[name="city_id"] option').each(function (key, item) {--}}

            {{--            if ($(item).val() == selectedCItyId) {--}}
            {{--                // console.log("$(item).val()");--}}
            {{--                // console.log($(item).val());--}}
            {{--                // console.log("response.data.city_id");--}}
            {{--                // console.log(response.data.city_id);--}}
            {{--                $(item).prop('selected', true);--}}
            {{--            }--}}
            {{--        });--}}
            {{--    });--}}
            {{--});--}}

            var post_data;
            var table = $('#example_retired').DataTable({
                "processing": true,
                "serverSide": true,
                "autoWidth": false,
                searching: false,
                rowId: 'id',
                columns: [
                    {   data: "image",
                        orderable: false},
                    {data: "name"},
                    {data: "media_count"},
                    {data: "assigned_user"},
                    {data: "created_at"},
                    /*{data: "last_crm_sync_at",
                        defaultContent: '<span class="badge badge-primary">Not Synced</span>'
                    },*/
                    {
                        data: "id",
                        render: function (data, type, row, meta) {
                            // console.log(data);
                            // console.log((row.report_url !== ''),"(row.report_url !== '')");
                            // console.log('AAAAAAAAAAA');

                            var html = '<a title="Edit" class="edit_form" href="/"  data-id="' +
                                data + '"><img class="wd-25" src="{{asset("image/edit.png")}}"/></a>';

                            html += '<a title="Delete" style="margin-left:5px;" class="delete_row" data-module="project" data-id="' +
                                data + '" href="javascript:void(0)"><img class="wd-25" src="{{asset("image/trash.png")}}"/> </a>';

                            var projectDetailUrl = '{{URL::to("subadmin/project/detail/")}}/'+data;
                            // console.log(projectDetailUrl,'projectDetailUrl');
                            html += '<a title="Info" style="margin-left:5px;" class="" data-module="project" data-id="' +
                                data + '" href="' + projectDetailUrl + '"><img class="wd-25" src="{{asset("image/eye.png")}}"/> </a>';

                            html += '<a title="PDF Report" style="margin-left:5px;" class="" data-module="project" data-id="' +
                                data + '" href="{{url('subadmin/project/reportView/')}}/' + data + '"><img class="wd-25" src="{{asset("image/pdf2.png")}}"/> </a>';
                            // if(row.report_url !== ''){
                            //
                            // }


                            return html;
                        },
                        // orderable: false
                    },

                ],
                columnDefs: [
                    {
                        orderable: false,
                        targets: -1,
                    },
                    {
                        orderable: true,
                        targets: '_all',
                    },

                ],
                // rowReorder: {
                //     // dataSrc: 3,
                //     // selector: 'td:last-child'
                //     // update: false,
                // },
                ajax: {
                    url: '{!! URL::to("subadmin/project_datatable") !!}',
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

            $("#project_grid").on('click', '.thumbnail a.edit_form', function (e) {
                e.preventDefault();
                var id = $(this).data('id');
                $.ajax({
                    url: "{{URL::to('subadmin/project/editProjectDetails')}}/" + id,
                    method: "GET",
                    data: '',
                    success: function (response) {
                        var data = response.data;
                        $('#update_form').attr('action', updateUrl + '/' + response.data.id);
                        console.log(response.data);
                        console.log($('#update_form input[name="name"]'));

                        $('#update_form input[name="name"]').val(response.data.name);
                        $('#update_form input[name="address1"]').val(response.data.address1);
                        $('#update_form input[name="address2"]').val(response.data.address2);
                        // $('#update_form input[name="postal_code"]').val(response.data.postal_code);
                        $('#update_form input[name="claim_num"]').val(response.data.claim_num);
                        $('#update_form input[name="customer_email"]').val(response.data.customer_email);
                        $('#update_form input[name="sales_tax"]').val(response.data.sales_tax);
                        $('#update_form input[name="inspection_date"]').val(response.data.inspection_date);

                        $('#update_form input[name="lat"]').val(response.data.latitude);
                        $('#update_form input[name="long"]').val(response.data.longitude);

                        // selectedCItyId = response.data.city_id;
                        // $('#update_form select[name="state_id"] option').each(function (key, item) {
                        //     if ($(item).val() == response.data.state_id) {
                        //         $(item).prop('selected', true);
                        //         $('#update_form select[name="state_id"]').trigger('change');
                        //     }
                        // });

                        // $('#update_form select[name="city_id"] option[value="' + response.data.city_id + '"]').prop('selected', 'selected');

                        $('#update_form select[name="assigned_user_id"] option').each(function (key, item) {
                            if ($(item).val() == response.data.assigned_user_id) {
                                $(item).prop('selected', true);
                            }
                        });

                        $editModal.modal('show');
                    },
                    error: function () {
                        alert("No Network");
                    }
                });
            });

            table.on('click','.delete_row', function(e){
                // console.log($(this).closest('tr').attr('id'));

                var confirmRes = confirm('Are You Sure');

                if (confirmRes) {
                    var id = $(this).closest('tr').attr('id');
                    $.ajax({
                        url:'{!! url('subadmin/project/delete') !!}/'+id,
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
                $('#myModal').addClass('in');
            });

            $('#example').on('click','.myImg',function(){
                var image_src = $(this).attr('src');
                $('#img01').attr('src',image_src);
                $('#thumbnail-view').modal('show');
            })

           function renderGrid (){
                // console.log($(document).find("select,textarea, input").serialize());
                $('#project_page_controls').pagination({
                    dataSource: '{!! URL::to("subadmin/project_datatable") !!}',
                    pageSize: 9,
                    locator: "records",
                    autoHidePrevious: true,
                    autoHideNext: true,
                    ajax: {
                        data: {
                            custom_search: $(document).find("select,textarea, input").serialize(),
                            // d.reOrder = post_data;
                        },
                        beforeSend: function () {
                            // $("#project_grid").html('Loading data ...');
                        }
                    },
                    totalNumberLocator: function(response) {
                        // you can return totalNumber by analyzing response content
                        // console.log(response.total_record);
                        return response.total_record;
                    },
                    callback: function (data, pagination) {
                        // template method of yourself

                        // console.log('data',data.length,pagination);

                        var html = `
                        <div class="col-md-12 text-center">
                            <h3> Zero Project Results</h3>
                        </div>`;


                        if(data.length > 0){
                            var html = template(data);
                        }

                        $("#project_grid").html(html);
                        $('[data-toggle="tooltip"]').tooltip();
                    }
                })

            };

            function template(params) {
                let grid = "";
                params.forEach((element,index) => {
                    let substr =element.address1.length > 35 ? element.address1.substring(0, 35)+' ...' : element.address1;
                   let subassigned_user = element.assigned_user.length > 30 ? element.assigned_user.substr(0, 30) + '...' : element.assigned_user;
                   // let subemail = element.customer_email.length > 30 ? element.customer_email.substr(0, 30) + '...' : element.customer_email;
                    // "http://127.0.0.1:8000/uploads/media/1631144783457-1631145186-106830256.jpg"

                    // assets/images/pm-cardimg.png
                    // image/placeholder.png
                    let defaultImage = `{{asset("assets/images/pm-cardimg.png")}}`;
                    let thumb = defaultImage;

                    if (element.get_single_media !== null) {
                        thumb = element.get_single_media.image_url;
                    } else if (element.project_map_image !== null) {
                        thumb = element.project_map_image;
                    }

                    let isValid = isValidUrl(thumb)
                    // console.log(`index ${index}`, thumb);

                    if (!isValid) {
                        element.thumb = defaultImage;
                        // console.log('is Not Valid ', isValid);
                    } else {
                        element.thumb = thumb;
                        // console.log('is Valid ',isValid);
                    }
                    // <h3>${element.name} </h3>


                    // console.log('fromNow()',moment(element.created_at).fromNow());
                    // console.log('fromNow()',moment(element.created_at).format('hh:mm A'));



                //     grid += `<div class="col-modified col-md-4 pm-col-modified">
                //     <div class="thumbnail pm-thumbnail-modified">
                //         <img src="${thumb}" alt="${element.name} Thumbnail">
                //         <div class="caption pm-caption-modified pro-management-cards-modified">
                //             <div class="pm-captionheader-modified">
                //                 <a class="title" href="${baseUrl+"/subadmin/project/detail/"+element.id}"><h3 class="text-truncate">${element.name}</h3></a>
                //
                //                 <a class="badge">${element.project_status == 1 ?"Open":"Completed"}</a>
                //                 <a class="num-modified badge edit_form" data-id="${element.id}"><i class="fa fa-pen pl-1" title="Edit Project"></i></a>
                //             </div>
                //             <p data-toggle="tooltip" title="${element.address1}" >${substr}</p>
                //             <div class="pm-caption-bottom ">
                //                 <div>
                //                     <p >Inspector:<span>${element.assigned_user}</span></p>
                //                 </div>
                //                 <div>
                //                     <p >Submitted Date:<span>${moment(element.created_at).format("MM/DD/YYYY")}</span></p>
                //                 </div>
                //             </div>
                //         </div>
                //     </div>
                // </div>`;

                    grid += `<div class="col-md-4">
                                <div class="card-body">
                                    <div class="card-header">
                                        <ul class="new-card address-icon">
                                            <li>
                                                <!-- <a href="${baseUrl+"/subadmin/project/detail/"+element.id}"></a> -->
                                                <h1>${element.name}</h1>
                                            </li>
                                            <li>
                                                <a href="${baseUrl+"/subadmin/project/edit-project/"+element.id}"><i
                                                            class="fa fa-pen pl-1"></i></a>
                                            </li>
                                        </ul>
                                        <ul>
                                            <li>
                                                <ul class="address-icon">
                                                <li><p data-toggle="tooltip"
                                                    title="${element.address1}">${substr}</p></li>
                                                </ul>
                                                <ul class="address-icon">
                                                <li class="address-icon"><img
                                                                src="{{asset('assets/images/calender-icon.png')}}"
                                                                alt="...">
                                                <p>${moment(element.created_at).fromNow()}, <span>${moment(element.created_at).format('hh:mm A')}</span></p></li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="card-img">
                                        <img src="${element.thumb}" alt="${element.name} Thumbnail">
                                    </div>
                                    <div class="card-footer" style="right: 2px;padding: 0 0 6px 0;">
                                        <ul>
                                            <li class="address-icon"><span>Assigned To</span></li>
                                            <li><p>${subassigned_user}</p></li>
                                        </ul>
                                        <ul style="text-align: right;">
                                            <li><span>Claim #</span></li>
                                            <li><p>${element.claim_num}</p></li>
                                        </ul>
                                       
                                    </div>
                                    <div class="card-footer" style="left: 2px;padding: 0;">
                                    <ul>
                                            <li class="address-icon"><span>Email</span></li>
                                            <li><p>${element.customer_email}</p></li>
                                        </ul>
                                
                                        <ul style="text-align: right;">
                                            <li><span>Inspection Date</span></li>
                                            <li><p>${moment(element.inspection_date).format("MM/DD/YYYY")}</p></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>`;
                });
                return grid;
            }

            renderGrid();

            $('.filter_submit').on('click',function(e){
                // console.log('filter sub');
                e.preventDefault();
                renderGrid();

                $('#myModalFilter').modal('hide');
            });

            function checkUrl(url){
                var arr = [ "jpeg", "jpg", "gif", "png" ];
                var ext = url.substring(url.lastIndexOf(".")+1);
                if($.inArray(ext,arr)){
                    alert("valid url");
                    return true;
                }
            }

        });

        $(document).ready(function () {
            var currentDate = new Date();
            $('.disableFuturedate').datepicker({
            format: 'yyyy-mm-dd',
            autoclose:true,
            startDate: "currentDate",
            minDate: currentDate
            }).on('changeDate', function (ev) {
            $(this).datepicker('hide');
            });
            $('.disableFuturedate').keyup(function () {
            if (this.value.match(/[^0-9]/g)) {
                this.value = this.value.replace(/[^0-9^-]/g, '');
            }
            });
        });
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAlUlyus8U80FZOXPzVHEeVEYHcJHsOrjU&libraries=places&callback=initAutocomplete&v=3.50" async defer></script>
@endpush

