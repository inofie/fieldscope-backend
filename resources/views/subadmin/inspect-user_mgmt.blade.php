@extends('subadmin.master')
@section('content')
 <!-- New Work  -->
<section class="user-managment">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card-title">
                    <h1 class="main-heading">User Management</h1>
                    <button type="button" class="btn add-btn btn-add addusertype-btn-modified" data-toggle="modal"
                            data-target="#myModal">
                        <ul class="d-flex align-items-center">
                            <li>
                                <img src="{{asset('assets/images/button-icon.png')}}" alt="...">
                            </li>
                            <li class="ml-4">
                                User
                            </li>
                        </ul>
                    </button>
                </div>
            </div>
        </div>

        {{--New Starts--}}
        <div class="row  new-card-row user-type-table" style="display: none;">
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
                <table class="table table-striped" id="exampleaa"
                       style="width: 1858px; margin:30px auto ;">
                    <thead >
                        <tr class="table-head">
                            <th class="left w-20">User Name</th>
                            <th class="center w-20">Email</th>
                            <th class="center w-20">Phone Number</th>
                            <th class="center w-20">User Type</th>
                            <th class="right w-20">Settings</th>
                            <!-- <th class="center w-50">Assigned Users</th>
                            <th class="right w-30">Settings</th> -->
                        </tr>
                    </thead>
                    <tbody>
                    <tr class="table-body">
                                <td  class="left first-cell">Test User 1</td>
                                <td class="center">Test@email.com</td>
                                <td class="center">123-456-789</td>
                                <td class="center"><span class="sale-color">Sales Rep</span></td>

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
                                <td  class="left first-cell">Test User 1</td>
                                <td class="center">Test@email.com</td>
                                <td class="center">123-456-789</td>
                                <td class="center"><span class="sale-color">Sales Rep</span></td>

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
                                <td  class="left first-cell">Test User 1</td>
                                <td class="center">Test@email.com</td>
                                <td class="center">123-456-789</td>
                                <td class="center"><span class="sale-color">Sales Rep</span></td>

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
        {{--New Ends--}}

        {{--Old WOrk Starts--}}
        <div class="row new-card-row user-type-table">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <table class="table table-striped dt-responsive" id="example"
                       style=" width:100% ">
                    <thead >
                    <tr class="table-head">
                        <th class="left w-20" >Name</th>
                        <th class="center w-20" >Email</th>
                        <th class="center w-20" >Phone Number</th>
                        <th class="center w-20" >User Type</th>
                        <th class="right w-20" >Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    {{--{{dd($data)}}--}}


                    </tbody>

                </table>

            </div>
        </div>
        {{--Old WOrk Ends--}}
 </div>
        <!-- New Work  End -->

    {{--To be removed hide on Dec-2022 --}}
    <div class="row nomargin hide">
     <div class="col-md-6">
            <h1 class="main-heading">User Management</h1>
             <div class="search-bar pt-3 pb-3">
                <div class="input-group">
                    <input value="{{\Request::input('keyword')}}" id="search-input" name="keyword" type="text" class="form-control" placeholder="Search Project">
                    <span class="input-group-btn">
                        <button id="search-btn" class="btn btn-default search-btn" type="button"><i class="fas fa-search"></i></button>
                    </span>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <!-- Trigger the modal with a button -->
                        <button type="button" class="btn btn-add addusertype-btn-modified" data-toggle="modal" data-target="#myModal">Add
                            User
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
                    <div class="modal-header logoimageheader">
                        <div class="header-content">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h3 class="modal-title text-left">Add User</h3>
                            
                        </div>
                    </div>
                    <form id="add_form" action="{{URL::to('subadmin/inspect_user/store')}}" method="POST">
                        {{csrf_field()}}

                        <div class="modal-body companyinfobody rm-companyinfobody-modified ">
                            <div class="row">

                                <div class="col-md-12 companyinfobody rm-companyinfobody-modified">
                                    <label>Name</label>
                                    <input type="text" name="name"
                                           placeholder="Enter Name">
                                </div>
                                <div class="col-md-12 companyinfobody rm-companyinfobody-modified">
                                    <label>Email</label>
                                    <input type="text" name="email"
                                           placeholder="Enter Email">
                                </div>
                                <div class="col-md-12 companyinfobody rm-companyinfobody-modified">
                                    <label>Password</label>
                                    <input type="password" name="password"
                                           placeholder="Enter Password">
                                </div>
                                <div class="col-md-12 companyinfobody rm-companyinfobody-modified">
                                    <label>Confirm Password</label>
                                    <input type="password" name="password_confirmation"
                                           placeholder="Confirm Password">
                                </div>
                                <div class="col-md-12 companyinfobody rm-companyinfobody-modified">
                                    <label>Mobile Number</label>
                                    <input type="text" name="mobile_no"
                                           placeholder="Enter  Mobile Number">
                                </div>
                                <div class="col-md-12 companyinfobody rm-companyinfobody-select-modified">
                                    <label>User Type</label>
                                    <select name="company_group_id" id="sel1">
                                        @foreach($data['companyGroup'] AS $item)
                                            <option value="{{$item->id}}">{{$item->title}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-12 companyinfobody rm-companyinfobody-modified iu_mgt_special">
                                    <label for="card-element">Credit Card Details</label>
                                    <div id="card-element">
                                        <!-- A Stripe Element will be inserted here. -->
                                    </div>
                                    <!-- Used to display form errors. -->
                                    <div id="card-errors" role="alert"></div>
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
        <div class="modal-dialog add-project-modal mr-0">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <div class="header-content">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h3 class="modal-title text-left">Edit Inspector User</h3>
                        </div>
                </div>
                <form id="update_form" action="{{URL::to('subadmin/inspect_user/update')}}" method="POST">
                    {{csrf_field()}}
                    <input type="hidden" name="page" value="{{\Request::input('page',1)}}">
                    <div class="modal-body">
                        <div class="form-group new-input-modal">
                            <label>Name</label>
                            <input type="text" name="name" 
                                   placeholder="Enter Name">
                        </div>
                        <div class="form-group new-input-modal">
                        <label>Email</label>
                            <input type="text" name="email" 
                                   placeholder="Enter Email">
                        </div>
                        <div class="form-group new-input-modal">
                        <label>Mobile Number</label>
                            <input type="text" name="mobile_no"
                                   placeholder="Enter  Mobile Number">
                        </div>
                        <div class="form-group new-input-modal">
                        <label>User Types</label>
                            <select name="company_group_id"  id="sel1">
                                @foreach($data['companyGroup'] AS $item)
                                    <option value="{{$item->id}}">{{$item->title}}</option>
                                @endforeach
                            </select>
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
    </section>
@endsection


@push('page_level_css')
<!-- {{--    <style>--}}
{{--        /**--}}
{{--     * The CSS shown here will not be introduced in the Quickstart guide, but shows--}}
{{--     * how you can use CSS to style your Element's container.--}}
{{--     */--}}
{{--        .StripeElement {--}}
{{--            box-sizing: border-box;--}}

{{--            height: 40px;--}}

{{--            padding: 10px 12px;--}}

{{--            border: 1px solid transparent;--}}
{{--            border-radius: 4px;--}}
{{--            background-color: white;--}}

{{--            box-shadow: 0 1px 3px 0 #e6ebf1;--}}
{{--            -webkit-transition: box-shadow 150ms ease;--}}
{{--            transition: box-shadow 150ms ease;--}}
{{--        }--}}

{{--        .StripeElement--focus {--}}
{{--            box-shadow: 0 1px 3px 0 #cfd7df;--}}
{{--        }--}}

{{--        .StripeElement--invalid {--}}
{{--            border-color: #fa755a;--}}
{{--        }--}}

{{--        .StripeElement--webkit-autofill {--}}
{{--            background-color: #fefde5 !important;--}}
{{--        }--}}
{{--    </style>--}} -->
@endpush
@push('page_level_scripts')
    <script type="text/javascript">
        $(document).ready(function () {

            var updateUrl = "{{URL::to('subadmin/inspect_user/update')}}";
            var $editModal = $('#editModal');



            $('#search-btn').on('click',function () {
                table.ajax.reload();
            });

            var post_data;
            var table = $('#example').DataTable({
                "processing": true,
                "serverSide": true,
                "ordering": true,
                "autoWidth": false,
                searching: false,
                dom: '<pl><t>ir',
                stripeClasses: [ '', 't-row-color' ],
                rowId: 'id',
                // "createdRow": function( row, data, dataIndex ) {
                //     /*console.log('Rows');
                //     console.log($(row));
                //     console.log(data);*/
                //     // $(row).data('order_by',data.order_by);
                // },
                columns: [
                    {data: "name",class:'left first-cell'},
                    {data: "email" , class:'center'},
                    {data: "mobile_no" , class:'center'},
                    {data: "user_type" , class:'center',
                        render: function (data, type, row, meta){
                            return `<span class="sale-color">${data}</span>`;
                        }
                    },
                    {
                        data: "id",
                        class:"right",
                        render: function (data, type, row, meta) {

                            let html  = `<div class="dropdown">
                                <button class="dropdown-dots dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    <img src="{{asset('assets/images/dropdown-dots.png')}}" alt="...">

                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                    <li><a href="#"  title="Edit" data-id="${data}" class="edit_form"><img src="{{asset('image/edit.png')}}" alt="..."></a></li>
                                    <li><a href="#" title="Delete" data-module="inspect_area" data-id="${data}" class="delete_row delete"><img src="{{asset('image/trash.png')}}" alt="..."></
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
                    
                    { orderable: true, targets: '_all', },
                ],
                rowReorder: {
                    // dataSrc: 3,
                    // selector: 'td:last-child'
                    // update: false,
                },
                ajax: {
                    url: '{!! URL::to("subadmin/inspect_user_datatable") !!}',
                    type: "GET",
                    beforeSend: function () {
                        // $('.overlay').show();
                        // $('.progress').removeAttr('style');
                        // $('.progress').css({width: '20%'});
                        // timer = window.setInterval(ProgressBar, 2000);
                        // $('button').attr('disabled','disabled');
                    },
                    data: function (d) {
                        // d.custom_search = $(document).find("select,textarea, input").serialize();
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
                console.log('edit_form');
                e.preventDefault();
                var id = $(this).data('id');
                $.ajax({
                    url: "{{URL::to('subadmin/inspect_user/editFormDetails')}}/" + id,
                    method: "GET",
                    data: '',
                    success: function (response) {
                        var data = response.data;
                        $('#update_form').attr('action', updateUrl + '/' + response.data.id);

                        $('#update_form input[name="name"]').val(response.data.first_name+' '+response.data.last_name);
                        $('#update_form input[name="email"]').val(response.data.email);
                        $('#update_form input[name="mobile_no"]').val(response.data.mobile_no);

                        console.log('group id',response.data.company_group_id
                        );

                        $('#update_form select[name="company_group_id"] option').each(function (key, item) {
                            if (parseInt($(item).attr('value')) == parseInt(response.data.company_group_id)) {
                                $(item).attr('selected', true);
                                console.log('selected')
                            }

                            // $(response.data.company_group).each(function (index, item2) {
                            //     console.log('.each');
                            //     // console.log("attr('value'): "+$(item).attr('value'));
                            //     console.log("item2.cg_id: "+parseInt(item2.cg_id));
                            //
                            // });
                        });
                        $('#update_form select[name="company_group_id[]"]').trigger('change');
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
                        url:'{!! url('subadmin/inspect_user/delete') !!}/'+id,
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
        });
    </script>

    <script src="https://js.stripe.com/v3/"></script>
    <script type="text/javascript">
        // Create a Stripe client.
        var stripe = Stripe('{{config('app.stripe_pub_key')}}');

        // Create an instance of Elements.
        var elements = stripe.elements();

        // Custom styling can be passed to options when creating an Element.
        // (Note that this demo uses a wider set of styles than the guide below.)
        var style = {
            base: {
                color: '#32325d',
                fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                fontSmoothing: 'antialiased',
                fontSize: '16px',
                '::placeholder': {
                    color: '#aab7c4'
                }
            },
            invalid: {
                color: '#fa755a',
                iconColor: '#fa755a'
            }
        };

        // Create an instance of the card Element.
        var card = elements.create('card', {style: style});

        // Add an instance of the card Element into the `card-element` <div>.
        card.mount('#card-element');

        // Handle real-time validation errors from the card Element.
        card.addEventListener('change', function (event) {
            var displayError = document.getElementById('card-errors');
            if (event.error) {
                displayError.textContent = event.error.message;
            } else {
                displayError.textContent = '';
            }
        });

        // Handle form submission.
        var form = document.getElementById('add_form');
        form.addEventListener('submit', function (event) {
            event.preventDefault();

            stripe.createToken(card).then(function (result) {
                if (result.error) {
                    // Inform the user if there was an error.
                    var errorElement = document.getElementById('card-errors');
                    errorElement.textContent = result.error.message;
                } else {
                    // Send the token to your server.
                    stripeTokenHandler(result.token);
                }
            });
        });

        // Submit the form with the token ID.
        function stripeTokenHandler(token) {
            // Insert the token ID into the form so it gets submitted to the server
            var form = document.getElementById('add_form');
            var hiddenInput = document.createElement('input');
            hiddenInput.setAttribute('type', 'hidden');
            hiddenInput.setAttribute('name', 'stripeToken');
            hiddenInput.setAttribute('value', token.id);
            form.appendChild(hiddenInput);

            // Submit the form
            form.submit();
        }
    </script>

@endpush



