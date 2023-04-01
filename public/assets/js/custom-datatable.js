//ajax datatable
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

var ajaxDatatable = (element,source_url = '', param = []) => {
    console.log('ajaxDatatable');
    var ids;
    var action;
    if(source_url == ''){
        source_url = window.location.href + '/ajax-listing'
    }
    var table = $(element).DataTable({
        "processing": true,
        "serverSide": true,
        "ordering": true,
        aoColumnDefs: [
            {
                bSortable: false,
                aTargets: [ -1 ]
            }
        ],
        searching: false,
        // rowReorder: ("rowReorder" in param) ? param.rowReorder : false,
        rowReorder: {
            dataSrc: 1
        },
        "ajax":{
            url :source_url,
            type: "GET",
            beforeSend : function(){
                // $('.overlay').show();
                // $('.progress').removeAttr('style');
                // $('.progress').css({width: '20%'});
                // timer = window.setInterval(ProgressBar, 2000);
                // $('button').attr('disabled','disabled');
            },
            data : function(d) {
                d.custom_search = $(document).find("select,textarea, input").serialize();
            },
            error: function(){ // error handling

            }
        },
        drawCallback: function (settings) {
            // other functionality

        },
        lengthMenu: [
            [10, 20, 50, 100, 200],
            [10, 20, 50, 100, 200] // change per page values here
        ],
        pageLength: 10// default record count per page

    });

    $('.search_filter').on('click',function(){
        table.ajax.reload();
    });

    $('#search-btn').on('click', function (e) {
        // var keyword = $('#search-input').val();
        // search(keyword);
        table.ajax.reload();
    });

    $('.dt_select_all').on('click',function(){
        var attr_name = $(this).attr('name');
        if($(this).is(':checked')){
            $('.' + attr_name).prop('checked',true);
            $('select[name="action"]').show();
        }else{
            $('.' + attr_name).prop('checked',false);
            $('select[name="action"]').hide();
        }
    });

    $(document).on('click','.ids',function(){
        if($('.ids:checked').length > 0){
            $('select[name="action"]').show()
        }else{
            $('select[name="action"]').hide()
        }
    });

    $('select[name="action"]').on('change',function(e){

        e.preventDefault();
        ids = [];
        $('.ids:checked').each(function(){
            ids.push($(this).val());
        });
        action = $(this).val();
        var selector = this;
        if(action != ''){
            alertify.confirm("Are you sure you want to continue?",function(evt){
                if(evt == true){
                    $('#alertify-cancel').click();
                    let url = window.location.href + "/action";
                    $.ajax({
                        type : "POST",
                        url : url.replace('#',''),
                        data : {ids:ids , action:action, _csrf:_token},
                        success : function(data){
                            if(data == 'denied'){
                                alertify.error("<p>You don't have a permission to delete this record.</p>");
                                return false;

                            }else if(data == 'error'){
                                alertify.error("<p>You can't delete this record because it is used in some modules.</p>");
                                return false;
                            }else{
                                alertify.set('notifier','position', 'top-right');
                                if(action == 'delete'){
                                    alertify.success("<p>Record has been deleted successfully.</p>");
                                }else{
                                    alertify.success("<p>Record has been updated successfully.</p>");
                                }
                                $('.dt_select_all').prop('checked',false);
                                $(selector).hide();
                                table.ajax.reload();
                            }
                        }
                    });
                }else{
                    $('#alertify-cancel').click();
                    return false;
                }
            });
            $('.alertify-button-ok').show();
        }
    })

//delete select row
    $(document).on('click','.delete_row',function(){
        $(this).parent().parent().find('input.ids').prop('checked',true);
        $('select[name="action"]').val('delete').change();
    });


    $(element).on('click','td a.delete_row', function (e) {
        var confirmVar = confirm('Are you sure ?');
        e.preventDefault();
        var id = $(this).data('id');
        var module = $(this).data('module');
        var url = base_url + "/subadmin/delete/" + module + "/" + id;
        console.log(url);
        console.log('module',module);
        if(confirmVar){
            $.ajax({
                url: url,
                method: "POST",
                data: '',
                success: function (response) {
                    var data = response.data;

                    if(response.code == 200){
                        alert("Record Deleted");
                        // $(this).closest('tr').hide();
                        table.ajax.reload();
                    }
                },
                error: function () {
                    alert("No Network");
                }
            });
        }
        return false;
    });


//reset fields
    $('.reset_fields').click(function(e){
        e.preventDefault()
        $('table').find('input, textarea, select').val('');
        table.ajax.reload();
    });
}