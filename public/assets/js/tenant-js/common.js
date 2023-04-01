$.ajaxSetup({
    headers: {

        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).ready(function() {

    $('form').submit(function(e) {

        var redirect_url = $('.redirect_url').val();
        redirect_url = typeof redirect_url == 'undefined' ? window.location.href : redirect_url;

        e.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            type: "POST",
            url: $('.submit_url').val(),
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function() {
                $(this).attr('disabled', 'disabled');
                $('.error').hide();
                if ($("#loader").show()) {
                    // $("input, select, textarea").prop("disabled", true);
                }
            },
            success: function(res) {

                $("#loader").hide();
                // $("input, select, textarea, button").prop("disabled", false);

                $(this).removeAttr('disabled');
                if (res.code == 200) {
                    success_html = '<li>' + res.message + '</li>';
                    $('.success').html(success_html);
                    $('.success').show();
                    $(".ajax-button").prop('disabled', true);
                    setTimeout(function() {
                        window.location.href = redirect_url;
                    }, 1000)

                } else {
                    let error_html = '';
                    var messages = res.data[0];
                    for (message in messages) {
                        error_html += '<li>' + messages[message] + '</li>';
                    }
                    $('.error').html(error_html);
                    $('.error').show();
                }
            }
        });

    })


    $(document).on('click', '#redirect2', function(e) {
              
               if(window.event.target.name=='lead_ids'){
                
               }else{

                var id = $(this).closest('tr').find('input[type="checkbox"]').val();

                 var getUrl = window.location + '/edit/'+id;

                // var redirect_url = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1]+'/lead/edit/'+id;
                let redirect_url = getUrl;
                window.location.href = redirect_url;
               }
               
    })

    //redirect edit page
    $(document).on('click', '.redirect', function(e) {
        e.preventDefault();
        let redirect_url = $(this).data('href');

       
        window.location.href = redirect_url;
    });

    //delete media script
    $(document).on('click', '._delete_media', function() {

        var msg = confirm("Are you sure you want to continue?");
        if (msg) {
            var mediaID = $(this).data('mediaid');
            var get_all_media_id = $('.delete_media').val();
            if (get_all_media_id == '') {
                $('.delete_media').val(mediaID);
            } else {
                $('.delete_media').val(get_all_media_id + ',' + mediaID);
            }
            $(this).parent().hide('slow');
        } else {
            return false
        }
    })

});

function getEditRecord(method, url, data = {}, headers = {}, columns = [], element = "tbody") {
    ajaxCall(method, url, data = {}, headers = {}).then(function(res) {
        if (res.code == 200) {
            let record = res.data;



            for (var c = 0; c < columns.length; c++) {

                if (columns[c] == 'media') {



                    var ulHtml = '<ul class="navbar-nav">';
                    if (record[columns[c]].length > 0) {
                        for (var i = 0; i < record[columns[c]].length; i++) {
                            ulHtml += '<li>';
                            if (record[columns[c]][i].media_type != "image") {

                                ulHtml += '<a href="' + record[columns[c]][i].path + '" target="_blank"><img src="' + base_url + '/image/pdf.png" style="width: 100px;height: 100px;" class="image-url"></a>';
                                ulHtml += '<a data-mediaId="' + record[columns[c]][i].id + '" class="btn cross _delete_media" style="color:black !important;font-size: 20px;">x</a>';
                                ulHtml += '</li>';
                            } else {
                                ulHtml += '<img src="' + record[columns[c]][i].path + '" style="width: 100px;height: 100px;" class="image-url">';
                                ulHtml += '<a data-mediaId="' + record[columns[c]][i].id + '" class="btn cross _delete_media" style="color:black !important;font-size: 20px;">x</a>';
                                ulHtml += '</li>';
                            }
                        }
                        $('.view_image').html(ulHtml);
                    }
                    ulHtml += '</ul>';
                } else if (columns[c] == 'image_url') {
                    var ulHtml = '<ul class="navbar-nav" style="float:none;">';
                    ulHtml += '<img src="' + record[columns[c]] + '" style="border-radius:50%;width:200px;height:200px;margin: 0 auto;" class="img-responsive">';
                    ulHtml += '<a data-mediaId="' + record[columns[c]].id + '" class="btn cross _delete_media" style="color:black !important;font-size: 20px;">x</a>';
                    ulHtml += '</li>';
                    $('.view_image').html(ulHtml);
                    ulHtml += '</ul>';

                } else if (columns[c] == 'nav_user_name') {

                    var new_user_image = record.image_url;
                    var new_name = record.name;
                    var aHtml = '';
                    aHtml += '<a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false"> <img src="' + new_user_image + '" alt="">' + new_name + '<span class=" fa fa-angle-down" style="display:inline-block;padding-left:10px;"></span> </a>';
                    $('.view_user').prepend(aHtml);


                } else if (columns[c] == 'comm_target_id') {
                    $('.target_id').val(record.user_id);

                } else if (columns[c] == 'old_status') {
                    var old_status_id = record.status.id;
                    $('select[name="status_id"] option[value="' + old_status_id + '"]').attr('selected', 'selected')

                    $('.selectpicker').selectpicker('refresh')
                } else if (columns[c] == 'old_type') {
                    var old_type_id = record.type.id;

                    $('select[name="type_id"] option[value="' + old_type_id + '"]').attr('selected', 'selected')

                    $('.selectpicker').selectpicker('refresh')
                } else if (columns[c] == 'assignee') {
                    var old_assignee_id = record.assignee.id;
                    $('select[name="target_id"] option[value="' + old_assignee_id + '"]').attr('selected', 'selected')

                    $('.selectpicker').selectpicker('refresh')
                } else {

                    $('[name="' + columns[c] + '"]').val(record[columns[c]]);
                }

            }
        } else {
            alert(res.message);
        }
    });
}


function ajaxCall(method, url, data = {}, headers = {}) {
    return new Promise(function(resolve, reject) {
        $.ajax({
            type: method,
            url: url,
            data: data,
            headers: headers,
            success: function(res) {
                resolve(res);


            }
        });
    })
}

// ajax call
function loadGridWitoutAjax(method, url, params = {}, headers = {}, columns = [], element = 'tbody', readData = '', redirect = true, pagination = false,check = true,filtered,theID) {
    ajaxCall(method, url, params, headers).then(function(res) {
        if (res.code == 200) {
          
            var tbodyHtml = '';
            if (readData == '') {
                var record = res.data;
            } else {
                var record = res.data[readData];
            }
            if (record.length > 0) {

                if (pagination == false) {
                    var index = 1;
                } else
                 {
                    var pagination_meta = res.meta;


                    var index = ((10 * (pagination_meta.current_page - 1)) + 1);

                    $('#checkAll').click(function() {
                        if ($(this).is(':checked')) {
                            $(".chkboxes").prop("checked", true);
                            $("#txtAge").dialog({
                                close: function() {
                                    $('.chkboxes').prop('checked', false);
                                    $('#checkAll').prop('checked', false);
                                }
                            });


                        } else {

                            $("#txtAge").dialog('close');

                            $(".chkboxes").prop("checked", false);
                        }

                    }); 


                }

                for (var i = 0; i < record.length; i++) {

                   
                    if (redirect == true) 
                    {

                        tbodyHtml += '<tr class="redirect" data-href="' + window.location.href + '/edit/' + record[i].id + '">';
                    }                
                    else 
                    {

                        tbodyHtml += '<tr>';

                    }

                    if (pagination == true) {

                        var lead_id = res.data[i].id;
                        var checkbox = '<input type="checkbox" class="chkboxes abc"  id="checkbox'+ lead_id+'" name="lead_ids" value="' + lead_id + '">';
                       
                        tbodyHtml += '<tr id="redirect2">';
                        tbodyHtml += '<td>' + checkbox + '</td>';

                       $(document).on('click', '.abc', function(e) 
                    {   
                           
                        if ($(this).is(':checked')) 
                        { 
                            

                                $('.bulk-action').show();
                            

                                                 
                        }

                        if( $('.abc:checked').length == 0) 
                       {
                            $('.bulk-action').hide();
                       }

                    })     

                    }


                    tbodyHtml += '<td>' + index + '</td>';




                    for (var c = 0; c < columns.length; c++) {


                       
                        if (columns[c] == 'color_code') {
                            // < iclass="fas fa-circle" style="color:;"></i>
                            tbodyHtml += '<td id="' + columns[c] + '" class="' + columns[c] + ' text-center"><i class="fas fa-circle" style="color:' + record[i][columns[c]] + ';"></i>' + record[i][columns[c]] + '</td>';
                        } else if (columns[c] == 'latitude') {
                            tbodyHtml += '<td id="' + columns[c] + '" class="' + columns[c] + ' text-center">' + record[i].coordinate.latitude + '</td>';
                        } else if (columns[c] == 'longitude') {

                            tbodyHtml += '<td id="' + columns[c] + '" class="' + columns[c] + ' text-center">' + record[i].coordinate.longitude + '</td>';

                        } else if (columns[c] == 'lead_count') {

                            var new_count = record[i].lead_count;
                            var new_color = record[i].color_code;
                           
                            tbodyHtml += '<td id="' + columns[c] + '" class="' + columns[c] + ' text-center lead_count_' + new_id + '">' + new_count + '  <i class="fas fa-map-marker-alt" style="color:' + new_color + ';"></i></td>';

                        } else if (columns[c] == 'lead_percentage') {
                            var new_id = record[i].id;

                            var lead_per = record[i].lead_percentage;
                            tbodyHtml += '<td id="' + lead_per + '" class="' + lead_per + ' text-center lead_percentage_' + new_id + '   ">' + lead_per + '%</td>';

                        } else if (columns[c] == 'test_title') 

                        {   
                           
                            var status_title = record[i].title;
                            var status_ids = record[i].id;


                            var legchecked = record.length;
                            if(check == true)

                            {

                                var default_checked = 'checked';    
                            }
                            
                            else
                            {   console.log('record', record[i].id);
                                console.log('filter', filtered[i]);
                                  // var array = $.inArray(theID,filtered);
                                  //  console.log(array);

                                if(filtered[i] == record[i].id)
                                    
                                {  
                                    var default_checked = ''; 
                                }

                                else
                                { 
                                    var default_checked = 'checked';
                                } 
                            }

                            //var default_checked = '';
                            
                            //tbodyHtml += '<td id="'+ status_title +'" class="'+ status_title +' text-center"><input type="checkbox" name="status_ids" value="'+ status_title +'" class="form-check-input" id="exampleCheck1" checked="checked"> '+ status_title +'</td>';
                            tbodyHtml += '<td class="' + status_title + ' text-center"><input type="checkbox" name="status_id" value="' + record[i].id + '" id="' + status_ids + '"   '+default_checked+'/>' + status_title + '</td>';

                        } 
                        else
                        {
                            if (columns[c].includes('.')) {
                                var innerKey = columns[c].split('.');
                                var td_value = '';
                                for (var k = 0; k < innerKey.length; k++) {
                                    if (k == 0) {
                                        td_value = record[i][innerKey[k]];

                                    } else {
                                        td_value = td_value[innerKey[k]];

                                    }
                                }
                            } else {
                                var td_value = record[i][columns[c]];
                            }
                            if (typeof td_value === 'undefined') {
                                td_value = '---';
                            }
                            tbodyHtml += '<td id="' + columns[c] + '" class="' + columns[c].split(' ').join('_') + ' text-center">' + td_value + '</td>';
                        }
                    }





                    tbodyHtml += '</tr>';
                    index++;

                }

                
                $(element).html(tbodyHtml);



                //pagination
                if (pagination) {

                    var pagination_obj = res.meta;
                    var last_page_number = pagination_obj.last_page;

                    if (last_page_number > 1) {
                        var pagination_html = '<nav aria-label="Page navigation example">';
                        pagination_html += '<ul class="pagination">';
                        if (pagination_obj.current_page > 1) {
                            pagination_html += '<li data-page_number="1" class="page-item"><a class="page-link" > << </a></li>';
                        }
                        pagination_html += '<li data-page_number="' + (parseInt(pagination_obj.current_page) - 1) + '" class="page-item"><a class="page-link"> < </a></li>';
                        var index = 1;

                        for (var p = pagination_obj.current_page; p <= last_page_number; p++) {
                            if (index <= 10) {
                                if (index == 1) {
                                    var active_class = 'active_page';
                                } else {
                                    var active_class = '';
                                }
                                pagination_html += '<li data-page_number="' + p + '" class="page-item"><a class="' + active_class + '  page-link">' + p + '</a></li>';
                            }

                            index++;

                        }

                        if (pagination_obj.current_page != last_page_number) {
                            pagination_html += '<li data-page_number="' + (parseInt(pagination_obj.current_page) + 1) + '" class="page-item"><a class="page-link"> > </a></li>';

                        }


                        if (pagination_obj.current_page < last_page_number) {
                            pagination_html += '<li data-page_number="' + last_page_number + '" class="page-item"><a class="page-link"> >> </a></li>';
                        }
                        pagination_html += '</ul>';
                        pagination_html += '</nav>';
                        $('.pagination_cont').html(pagination_html)
                    }

                    if (last_page_number == 1) {
                        $('.pagination_cont').html('')
                    }
                }


            } else {

                tbodyHtml += '<tr>';
                tbodyHtml += '<td colspan ="100" class="text-center"> No record found </td>';
                tbodyHtml += '</tr>';
                $(element).html(tbodyHtml);

            }
        } else {
            tbodyHtml += '<tr>';
            tbodyHtml += '<td colspan ="100" class="text-center"> No record found </td>';
            tbodyHtml += '</tr>';
            $(element).html(tbodyHtml);
        }
    })
}


//ajax datatable
var ajaxDatatable = (element, source_url, pageLength = 10, columns = [], field = '') => {

    var columnJson = [];
    var tbodyHtml = '';

    for (var c = 0; c < columns.length; c++) {
        columnJson.push({
            "data": columns[c]
        });

    }
    var ids;
    var action;
    var table = $(element).DataTable({
        "processing": true,
        "serverSide": true,
        "ordering": false,
        searching: false,
        "lengthChange": false,
        createdRow: function(row, data, dataIndex) {

            if (field == 'type') {
                $(row).attr('data-href', window.location.href + '/edit/' + data.id + '?type=' + data.type);
                $(row).attr('class', 'redirect');
            } else {
                $(row).attr('data-href', window.location.href + '/edit/' + data.id);
                $(row).attr('class', 'redirect');
            }


        },

        "ajax": {
            url: source_url,
            type: "GET",
            beforeSend: function() {
                //$('button').attr('disbaled','disabled');
            },
            data: function(d) {
                delete d.columns;
            },
            error: function() { // error handling

            }
        },
        drawCallback: function(settings) {
            // other functionality
            //$('button').removeAttr('disbaled');
        },
        lengthMenu: [
            [10, 20, 50, 100, 200],
            [10, 20, 50, 100, 200] // change per page values here
        ],
        pageLength: pageLength, // default record count per page

        "columns": columnJson
    });

}