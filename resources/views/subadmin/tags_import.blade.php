@extends('subadmin.master')
@section('content')
<div class="row nomargin" id="top">
   <div class="col-md-6">
      <h1 class="main-heading">Import Photos Tags</h1>
   </div>
   <div class="col-md-6">
      <div class="container">
         <!-- Trigger the modal with a button -->
         <a href="{{URL::to('subadmin/tag/export/template')}}" class="btn btn-add btn-pmadd-modified" >Download Sample</a>
      </div>
   </div>
</div>
<div class="container">
   <div class="col-md-12 form-group">
      <form id="import_form" action="{{URL::to('subadmin/tag/import')}}" method="POST" enctype="multipart/form-data">
         {{csrf_field()}}
         <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <input type="file" name="import_file" class="form-control radius" required="">
                </div>
            </div>
         </div>
         <div class="row">
            <div class="col-md-12">
                <button type="submit" class="btn btn-add ft-left btn-pmadd-modified">Add</button>
            </div>
         </div>
      </form>
   </div>
</div>
<!-- Modal -->

@endsection
@push('page_level_scripts')
<script type="text/javascript">
   $(document).ready(function () {
       /** ############## TO BE Deleted Soon ########################*/
       {{--$('.select2').select2({--}}
       {{--    placeholder: "Select Your Option"--}}
       {{--});--}}

       {{--var updateUrl = "{{URL::to('subadmin/tag/update')}}";--}}
       {{--var $editModal = $('#editModal');--}}

       {{--$("td a.delete").on('click', function (e) {--}}
       {{--    return confirm("Are you sure ?");--}}
       {{--});--}}

       {{--$('#search-btn').on('click', function (e) {--}}
       {{--    table.ajax.reload();--}}
       {{--});--}}

       {{--var table = $('#example').DataTable({--}}
       {{--    "processing": true,--}}
       {{--    "serverSide": true,--}}
       {{--    searching: false,--}}
       {{--    rowId: 'id',--}}
       {{--    columns: [--}}
       {{--        {data: "name"},--}}
       {{--        {data: "c1_name"},--}}
       {{--        {data: "has_qty"},--}}
       {{--        {data: "is_required"},--}}
       {{--        {data: "price"},--}}
       {{--        {--}}
       {{--            data: "id",--}}
       {{--            render: function (data, type, row, meta) {--}}
       {{--                /*console.log(data);--}}
       {{--                console.log('AAAAAAAAAAA');*/--}}

       {{--                var html = '<a title="Edit" class="btn btn-sm btn-primary edit_form" href="/"  data-id="' +--}}
       {{--                    data + '"><i class="fa fa-edit"></i> </a>';--}}
       {{--                html += '<a title="Delete" style="margin-left:5px;" class="delete_row btn btn-sm btn-danger" data-module="inspect_area" data-id="' +--}}
       {{--                    data + '" href="javascript:void(0)"><i class="fa fa-trash"></i> </a>';--}}
       {{--                return html;--}}
       {{--            },--}}
       {{--            // orderable: false--}}
       {{--        },--}}

       {{--    ],--}}
       {{--    columnDefs: [--}}
       {{--        {--}}
       {{--            orderable: false,--}}
       {{--            targets: -1,--}}
       {{--        },--}}
       {{--        {--}}
       {{--            orderable: true,--}}
       {{--            targets: '_all',--}}
       {{--        },--}}

       {{--    ],--}}
       {{--    // rowReorder: {--}}
       {{--    //     // dataSrc: 3,--}}
       {{--    //     // selector: 'td:last-child'--}}
       {{--    //     // update: false,--}}
       {{--    // },--}}
       {{--    ajax: {--}}
       {{--        url: '{!! URL::to("subadmin/tag_datatable") !!}',--}}
       {{--        type: "GET",--}}
       {{--        beforeSend: function () {--}}
       {{--            // $('.overlay').show();--}}
       {{--            // $('.progress').removeAttr('style');--}}
       {{--            // $('.progress').css({width: '20%'});--}}
       {{--            // timer = window.setInterval(ProgressBar, 2000);--}}
       {{--            // $('button').attr('disabled','disabled');--}}
       {{--        },--}}
       {{--        data: function (d) {--}}
       {{--            d.custom_search = $(document).find("select,textarea, input").serialize();--}}
       {{--            // d.reOrder = post_data;--}}
       {{--        },--}}
       {{--        error: function () { // error handling--}}

       {{--        }--}}
       {{--    },--}}
       {{--    drawCallback: function (settings) {--}}
       {{--        // other functionality--}}
       {{--    },--}}
       {{--    lengthMenu: [--}}
       {{--        [10, 20, 50, 100, 200],--}}
       {{--        [10, 20, 50, 100, 200] // change per page values here--}}
       {{--    ],--}}
       {{--    pageLength: "{!! config('constants.PAGINATION_PAGE_SIZE') !!}"// default record count per page--}}
       {{--});--}}

       {{--table.on('click', 'td a.edit_form', function (e) {--}}
       {{--    e.preventDefault();--}}
       {{--    console.log('edit');--}}
       {{--    var id = $(this).data('id');--}}
       {{--    $.ajax({--}}
       {{--        url: "{{URL::to('subadmin/tag/editTagDetails/')}}/" + id,--}}
       {{--        method: "GET",--}}
       {{--        data: '',--}}
       {{--        success: function (response) {--}}
       {{--            var data = response.data;--}}
       {{--            $('#update_form').attr('action', updateUrl + '/' + response.data.id);--}}
       {{--            console.log(response.data );--}}
       {{--            $('#update_form input[name="name"]').val(response.data.name);--}}
       {{--            $('#update_form input[name="price"]').val(response.data.price);--}}

       {{--            $('#update_form select[name="has_qty"] option').each(function (key,item) {--}}

       {{--                if($(item).val() == response.data.has_qty){--}}
       {{--                    console.log('has_qty');--}}
       {{--                    console.log(response.data.has_qty);--}}
       {{--                    $(item).prop('selected', true);--}}
       {{--                }--}}
       {{--            });--}}


       {{--            $('#update_form select[name="is_required"] option').each(function (key,item) {--}}

       {{--                if($(item).val() == response.data.is_required){--}}
       {{--                    console.log('is_required');--}}
       {{--                    console.log(response.data.is_required);--}}
       {{--                    $(item).prop('selected', true);--}}
       {{--                }--}}
       {{--            });--}}

       {{--            $('#update_form select[name="ref_id"] option').each(function (key,item) {--}}

       {{--                if($(item).val() == response.data.ref_id){--}}
       {{--                    console.log('ref_id');--}}
       {{--                    console.log(response.data.ref_id);--}}
       {{--                    $(item).prop('selected', true);--}}
       {{--                }--}}
       {{--            });--}}
       {{--            $('#update_form select[name="company_group_id[]"]').trigger('change');--}}
       {{--            $editModal.modal('show');--}}
       {{--        },--}}
       {{--        error: function () {--}}
       {{--            alert("No Network");--}}
       {{--        }--}}
       {{--    });--}}
       {{--});--}}

       {{--table.on('click','.delete_row', function(e){--}}
       {{--    console.log($(this).closest('tr').attr('id'));--}}

       {{--    var confirmRes = confirm('Are You Sure');--}}

       {{--    if (confirmRes) {--}}
       {{--        var id = $(this).closest('tr').attr('id');--}}
       {{--        $.ajax({--}}
       {{--            url:'{!! url('subadmin/tag/delete') !!}/'+id,--}}
       {{--            method:'POST',--}}
       {{--            dataType: 'JSON',--}}
       {{--            success: function(response){--}}
       {{--                table.ajax.reload();--}}
       {{--                alert(response.message);--}}
       {{--            },--}}
       {{--            error: function(){--}}
       {{--            }--}}
       {{--        });--}}
       {{--    }--}}
       {{--});--}}
   });
</script>
@endpush