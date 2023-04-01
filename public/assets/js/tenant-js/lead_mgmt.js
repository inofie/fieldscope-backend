$(document).ready(function(){

    $('.add-link').click(function(){
        var url = $(this).data('href')
        window.location.href = url;
    })

    $("#e2").daterangepicker({
        datepickerOptions : {
            numberOfMonths : 2
        }
    });

    $(document).on('click','.hide_show_table',function(){

        var id = $(this).data('id'); 
        if( $(this).is(':checked') ){
             $(document).find('.' + id).show();   
        }else{
           $(document).find('.' + id).hide(); 
        }

    })

});

