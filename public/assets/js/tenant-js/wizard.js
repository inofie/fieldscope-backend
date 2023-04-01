var file_header = [];
$(document).ready(function () {



    var navListItems = $('div.setup-panel div a'),
        allWells = $('.setup-content'),
        allNextBtn = $('.nextBtn');

    allWells.hide();


    navListItems.click(function (e) {
        e.preventDefault();
        var $target = $($(this).attr('href')),
            $item = $(this);

        if (!$item.hasClass('disabled')) {
            navListItems.removeClass('btn-success').addClass('btn-default');
            $item.addClass('btn-success');
            allWells.hide();
            $target.show();
            $target.find('input:eq(0)').focus();
        }
    });

    allNextBtn.click(function () {
        var curStep = $(this).closest(".setup-content"),
            curStepBtn = curStep.attr("id"),
            nextStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().next().children("a"),
            curInputs = curStep.find("input[type='text'],input[type='url'],input[type='file']"),
            isValid = true;

        $(".form-group").removeClass("has-error");
        for (var i = 0; i < curInputs.length; i++) {
            if (!curInputs[i].validity.valid) {
                isValid = false;
                $(curInputs[i]).closest(".form-group").addClass("has-error");
            }
        }

        if (isValid){

            if(curStepBtn == 'step-1'){
                var formData = new FormData();
                $.each($('input[name="file"]')[0].files, function(i, file) {
                    formData.append('file', file);
                });

                $.ajax({
                    type:"POST",
                    url: $('#frm_'+curStepBtn).attr('action'),
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    beforeSend:function(){
                        /*$(this).attr('disabled','disabled');
                        $('.error').hide();*/
                        

                    },
                    success:function(res){
                        
                        nextStepWizard.removeAttr('disabled').trigger('click');
                        nextStepWizard.removeClass('disabled').trigger('click');

                    }
                });

            }else{
                var formData = $('#frm_'+curStepBtn).serialize();
                $.ajax({
                    type:"POST",
                    url: $('#frm_'+curStepBtn).attr('action'),
                    data: formData,
                    beforeSend:function(){
                        /*$(this).attr('disabled','disabled');
                        $('.error').hide();*/
                        

                    },
                    success:function(res){
                        
                        if(curStepBtn == 'step-2'){
                             file_header = res.data.file_header;
                            if(file_header.length > 0)
                            {
                                var options_html = '<option value="">Select</option>';
                                for(var i=0; i<file_header.length;i++)
                                {
                                     options_html += '<option value="'+[i]+'">'+ file_header[i] +'</option>';  
                                }        
                                $('.field_head').html(options_html);
                             
                            } 

                            var template_id = res.data.template_id;
                            $('.template_id').val(template_id);

                        }
                        nextStepWizard.removeAttr('disabled').trigger('click');
                        nextStepWizard.removeClass('disabled').trigger('click');


                    }
                });
            }
        }

    });

    $('div.setup-panel div a.btn-success').trigger('click');


});

