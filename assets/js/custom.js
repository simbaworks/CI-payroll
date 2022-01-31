$(document).on('keypress', '.alphabets', function (e) {
    var id = $.trim($(this).attr('id'));
    var val = $.trim($(this).val());
    var field_name = $.trim($(this).attr('data-field-name'));
    var key = e.keyCode || e.charCode;
    var regex = /^[a-zA-Z\s]+$/;
    var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
    // 8 = backspace 46 = Del 13 = Enter 39 = Left 37 = right Tab = 9
    if (regex.test(str) || key == 8 || key == 46 || key == 13 || key == 37 || key == 39 || key == 9) {
        $('#err_' + id).text('').hide();
        return true;
    } else {
        $('#err_' + id).text(field_name + ' is alphabets only!').show();
        e.preventDefault();
        return false;
    }
});

$(document).on('keypress', 'input[type=number][maxlength]', function (event) {
    var id = $.trim($(this).attr('id'));
    var val = $.trim($(this).val());
    var field_name = $.trim($(this).attr('data-field-name'));

    var key = event.keyCode || event.charCode;
    var charcodestring = String.fromCharCode(event.which);
    var txtVal = $(this).val();
    var maxlength = $(this).attr('maxlength');
    var regex = new RegExp('^[0-9]+$');
    // 8 = backspace 46 = Del 13 = Enter 39 = Left 37 = right Tab = 9
    if (key == 8 || key == 46 || key == 13 || key == 37 || key == 39 || key == 9) {
        return true;
    }
    // maxlength allready reached
    if (txtVal.length == maxlength) {
        event.preventDefault();
        return false;
    }
    
    // pressed key have to be a number
    if (!regex.test(charcodestring)) {
        $('#err_' + id).text(field_name + ' is numeric only!').show();
        event.preventDefault();
        return false;
    }
    $('#err_' + id).text('').hide();
    return true;
});

$(document).on('paste', 'input[type=number][maxlength]', function (event) {
    //catch copy and paste
    var ref = $(this);
    var regex = new RegExp('^[0-9]+$');
    var maxlength = ref.attr('maxlength');
    var clipboardData = event.originalEvent.clipboardData.getData('text');
    var txtVal = ref.val();//current value
    var filteredString = '';
    var combined_input = txtVal + clipboardData;//dont forget old data

    for (var i = 0; i < combined_input.length; i++) {
        if (filteredString.length < maxlength) {
            if (regex.test(combined_input[i])) {
                filteredString += combined_input[i];
            }
        }
    }
});


/*
|-------------------------------------------
|Auto update content in list page
|-------------------------------------------
*/
$(document).on('change', '.auto-update-content-enc', function (evt) {
    var data_row_field = $(this).attr('data-row-field');
    var data_row_id = $(this).attr('data-row-id');
    var prev_value = $(this).data('val');
    var current_value = $(this).val();
    var ftoken = $('#_ftoken').val();
    var edit_type = '1';

    if(data_row_field !== '' && data_row_id !== '' && ftoken !== ''){
        var dataStr = {'current_value': current_value, 'data_row_field': data_row_field, "data_row_id": data_row_id, 'ftoken': ftoken, 'edit_type': edit_type};
        var dataUrl = SITEURL + CONTROLLER + '/ajax_insta_edit_content';
        $.ajax({
            type: "POST",
            url: dataUrl,
            data: dataStr,
            cache: false,
            dataType: 'JSON',
            beforeSend: function() {
                $('.preloader').removeClass('d-none');
            },
            success: function (data) {
                if(data.code == '0'){
                    alert(data.message);
                    $(this).val(prev_value);
                }else{
                    Toast.fire({
                        icon: 'success',
                        title: data.message
                    });
                    $('._ftoken').val(data.ftoken);
                }
                $('.preloader').addClass('d-none');
            }
        });
    }
});


$(document).on('change', '.auto-update-content-no-enc', function (evt) {
    var data_row_field = $(this).attr('data-row-field');
    var data_row_id = $(this).attr('data-row-id');
    var prev_value = $(this).data('val');
    var current_value = $(this).val();
    var ftoken = $('#_ftoken').val();
    var edit_type = '2';

    if(data_row_field !== '' && data_row_id !== '' && ftoken !== ''){
        var dataStr = {'current_value': current_value, 'data_row_field': data_row_field, "data_row_id": data_row_id, 'ftoken': ftoken, 'edit_type': edit_type};
        var dataUrl = SITEURL + CONTROLLER + '/ajax_insta_edit_content';
        $.ajax({
            type: "POST",
            url: dataUrl,
            data: dataStr,
            cache: false,
            dataType: 'JSON',
            beforeSend: function() {
                $('.preloader').removeClass('d-none');
            },
            success: function (data) {
                if(data.code == '0'){
                    alert(data.message);
                    $(this).val(prev_value);
                }else{
                    Toast.fire({
                        icon: 'success',
                        title: data.message
                    });
                    $('._ftoken').val(data.ftoken);
                }
                $('.preloader').addClass('d-none');
            }
        });
    }
});

/*
|-------------------------------------------
|Change status of a record
|-------------------------------------------
*/
$(document).on('click', '.toggle', function (evt) {
    var input = $(this).find('.status-action')[0];
    var data_row_id = $(input).attr('data-row-id');
    var current_value = $(input).is(":checked") === true ? '1' : '0';
    var ftoken = $('#_ftoken').val();
    var id = $(input).attr('id');

    if(current_value !== '' && data_row_id !== ''){
        var dataStr = {'current_value': current_value, "data_row_id": data_row_id, 'ftoken': ftoken};
        var dataUrl = SITEURL + CONTROLLER + '/ajax_insta_status_update';
        $.ajax({
            type: "POST",
            url: dataUrl,
            data: dataStr,
            cache: false,
            dataType: 'JSON',
            success: function (data) {
                if(data.code == '0'){
                    alert(data.message);
                    if(current_value == '0'){
                        $('#' + id).bootstrapToggle('on');
                    }else{
                        $('#' + id).bootstrapToggle('off');
                    }
                }else{
                    Toast.fire({
                        icon: 'success',
                        title: data.message
                    });

                    if(current_value == '0'){
                        $('#' + id).bootstrapToggle('off');
                    }else{
                        $('#' + id).bootstrapToggle('on');
                    }
                    $('._ftoken').val(data.ftoken);
                }
            }
        });
    }
});

/*
|-------------------------------------------
|Ajax add new record view load
|-------------------------------------------
*/
$(document).on('click', '.add-new-ecord', function (evt) {
    var dataStr = {};
    var dataUrl = SITEURL + CONTROLLER + '/ajax_load_add_form';
    $.ajax({
        type: "POST",
        url: dataUrl,
        data: dataStr,
        cache: false,
        dataType: 'JSON',
        beforeSend: function() {
            $('.preloader').removeClass('d-none');
        },
        success: function (data) {
            $('.preloader').addClass('d-none');

            var modalTitle = data.title;
            $('.modal-title').html(modalTitle);
            $('.modal-body').html(data.html);
            $('#hrmsModal').modal('show');
        }
    });
});

/*
|-------------------------------------------
|Save ajax add new record data
|-------------------------------------------
*/
$(document).on('click', '.save-ajax-form-data', function (evt) {
    evt.preventDefault();
    var valid = 1;
    $(this).html('<i class="fas fa-cog fa-spin"></i> Saving..');
    $(this).prop('disabled', true);

    $('.validation-require').each(function (e) {
        var id          = $.trim($(this).attr('id'));
        var val         = $.trim($(this).val());
        var field_name  = $.trim($(this).attr('data-field-name'));
        if (val == '') {
            $('#err_' + id).text('*Please enter ' + field_name).show();
            valid = 0;
        }
    });
    console.log(valid);
    if (valid == 1) {
        var formData = new FormData($('#ajax-add-form')[0]);
        var dataUrl = SITEURL + CONTROLLER + '/ajax_save_add_form_data';
        $.ajax({
            type: "POST",
            url: dataUrl,
            data: formData,
            cache: false,
            processData: false,
            contentType: false,
            dataType: 'JSON',
            success: function (data) {
                if(data.code == '1'){
                    Toast.fire({
                        icon: 'success',
                        title: data.message
                    });

                    $('.ajax-form-row').each(function (e) {
                        $(this).val('');
                    });

                    $('._ftoken').val(data.ftoken);
                    $('#hrmsModal').modal('hide');
                    $('#data_table').html(data.html);
                }else{
                    alert(data.message);

                }
                $('.save-ajax-form-data').html('<i class="fa fa-save mr-1"></i>Save');
                $('.save-ajax-form-data').prop('disabled', false);
            }
        });
    } else {
        $(this).html('<i class="fa fa-save mr-1"></i>Save');
        $(this).prop('disabled', false);
    }
});

$(document).on('input propertychange change', '.validation-require', function (evt) {
    $('.validation-require').each(function (e) {
        var id          = $.trim($(this).attr('id'));
        var val         = $.trim($(this).val());
        var field_name  = $.trim($(this).attr('data-field-name'));
        if (val !== '') {
            $('#err_' + id).text('').show();
        }
    });
});

/*
|-------------------------------------------
|Ajax search function
|-------------------------------------------
*/
$(document).on('input propertychange change', '.search-input', function (evt) {
    var input_text = $(this).val();

    var dataStr = {'input_text': input_text};
    var dataUrl = SITEURL + CONTROLLER + '/ajax_search';
    $.ajax({
        type: "POST",
        url: dataUrl,
        data: dataStr,
        cache: false,
        success: function (data) {
            $('#data_table').html(data);
        }
    });
});

/*
|-------------------------------------------
|Ajax search function on centers module
|-------------------------------------------
*/
$(document).on('input propertychange change', '.centre-search-input', function (evt) {
    var input_text = $(this).val();
    var centre_type_input = $('#centre-type-input').val();
    var centre_region_input = $('#centre-region-input').val();

    search_center(input_text, centre_type_input, centre_region_input);
});

$(document).on('change', '#centre-type-input', function (evt) {
    var input_text = $('.centre-search-input').val();
    var centre_type_input = $('#centre-type-input').val();
    var centre_region_input = $('#centre-region-input').val();

    search_center(input_text, centre_type_input, centre_region_input);
});

$(document).on('change', '#centre-region-input', function (evt) {
    var input_text = $('.centre-search-input').val();
    var centre_type_input = $('#centre-type-input').val();
    var centre_region_input = $('#centre-region-input').val();

    search_center(input_text, centre_type_input, centre_region_input);
});

function search_center(input_text = '', centre_type_input = '', centre_region_input = ''){
    var dataStr = {'input_text': input_text, 'centre_type_input': centre_type_input, 'centre_region_input': centre_region_input};
    var dataUrl = SITEURL + CONTROLLER + '/ajax_search';
    $.ajax({
        type: "POST",
        url: dataUrl,
        data: dataStr,
        cache: false,
        success: function (data) {
            $('#data_table').html(data);
        }
    });
}

/*
|-------------------------------------------
|Employee Addition Page
|-------------------------------------------
*/

//Disablity percentage visibility control
$(document).on('change', '#is_disabled', function (evt) {
    var is_checked = ($(this).prop('checked') == true)? '1': '0';

    $('#disability_percentage').val('');
    $('#disability_certificate').val('');
    $('#pwd_type').val('');

    if(is_checked == '1'){
        $('.disability-percentage').removeClass('d-none');
        $('#disability_percentage').removeClass('d-none');
        $('.disability-certificate-div').removeClass('d-none');
        $('#disability_certificate').removeClass('d-none');
        $('.disability-certificate-file-div').removeClass('d-none');
        $('.disability-type').removeClass('d-none');
        $('#pwd_type').removeClass('d-none');
    }else{
        $('.disability-percentage').addClass('d-none');
        $('#disability_percentage').addClass('d-none');
        $('.disability-certificate-div').addClass('d-none');
        $('#disability_certificate').addClass('d-none');
        $('.disability-certificate-file-div').addClass('d-none');
        $('.disability-type').addClass('d-none');
        $('#pwd_type').addClass('d-none');
    }
});

//PAN validation
$(document).on('input propertychange change', '#contact_phone', function (evt) {
    var value = $(this).val();
    var id = $.trim($(this).attr('id'));
    var maxlength = $(this).attr('maxlength');

    value = value.replace(/\D/g, "");
    $(this).val(value);
    
    var regex = /[1-9]{1}[0-9]{9}$/ ;
    if(!regex.test(value)){
        $('#err_' + id).text('Please enter a valid Phone Number!').show();
    }
});

//PAN validation
$(document).on('input propertychange change', '#pan_number', function (evt) {
    var value = $(this).val();
    var id = $.trim($(this).attr('id'));
    var maxlength = $(this).attr('maxlength');

    var regex = /[A-Z]{5}[0-9]{4}[A-Z]{1}$/; 
    if(!regex.test(value)) {
        $('#err_' + id).text('Please enter a valid PAN Number!').show();
    }
});

//Addhaar card validation
$(document).on('input propertychange change', '#aadhaar_number', function (evt) {
    var value = $(this).val();
    var id = $.trim($(this).attr('id'));
    var maxlength = $(this).attr('maxlength');

    value = value.replace(/\D/g, "").split(/(?:([\d]{4}))/g).filter(s => s.length > 0).join("-");
    $(this).val(value);

    if (value.length == maxlength) {
        return false;
    }
});

//Add new employee form validation
function employee_form_validation() {
    var valid = 1;
    var validExtensions = ["jpg","jpeg","png","pdf"];
    $('.save-form-data').html('<i class="fas fa-cog fa-spin"></i> Validating..');
    $('.save-form-data').prop('disabled', true);
    $('.invalid-feedback').text('').hide();
    $('.validation-require').each(function (e) {
        var id          = $.trim($(this).attr('id'));
        var val         = $.trim($(this).val());
        var type        = $.trim($(this).prop('type'));
        var field_name  = $.trim($(this).attr('data-field-name'));
        var max_length  = $.trim($(this).prop('maxlength'));

        if(!$('#' + id).hasClass('d-none')){
            if (val == '') {
                $('#err_' + id).text(field_name + ' can\'t be empty!').show();
                valid = 0;
                console.log(field_name);
            }else{
                if(id == 'pan_number'){
                    var regex = /[A-Z]{5}[0-9]{4}[A-Z]{1}$/; 
                    if(!regex.test(val)) {
                        $('#err_' + id).text('Please enter a valid PAN Number!').show();
                        valid = 0;
                    }
                }
                if(id == 'contact_email'){
                    var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                    if(!regex.test(val)) {
                        $('#err_' + id).text('Please enter a valid Email id!').show();
                        valid = 0;
                    }
                }
                if(id == 'contact_phone'){
                    var regex = /[1-9]{1}[0-9]{9}$/;
                    if(!regex.test(val) || val.length !== 10) {
                        $('#err_' + id).text('Please enter a valid Phone Number!').show();
                        valid = 0;
                    }
                }
                if($(this).hasClass('supporting-document')){
                    var file_count = $(this)[0].files.length;
                    if(parseInt(file_count) == 0){
                        $('#err_' + id).text('*Please select a ' + field_name).show();
                        valid = 0;
                    }else{
                        var item = $(this)[0].files;
                        var fileSize = item[0].size; 
                        var fileName = item[0].name;
                        var fileExtension =  fileName.substring(fileName.lastIndexOf('.')+1);

                        if ($.inArray(fileExtension, validExtensions) == -1){
                            $('#err_' + id).text('*Only ".jpg",".jpeg",".png",".pdf" files are allowed!').show();
                            $(this).val('');
                            valid = 0;
                        }else{
                            if(parseInt(fileSize) > 2097152) {
                                $('#err_' + id).text('File size must not be more than 2 MB!').show();
                                $(this).val('');
                                valid = 0;
                            }
                        }
                    }
                }
            }
        }
    });

    console.log(valid);
    if (valid == 1) {
        $('.save-form-data').html('<i class="fas fa-cog fa-spin"></i> Saving..');
        return true;
    } else {
        $('.save-form-data').html('<i class="fa fa-save mr-1"></i> Save');
        $('.save-form-data').prop('disabled', false);
        return false;
    }
}

//Employee personal details edit
$(document).on('click', '.save-employee-personal-details-ajax-form-data', function(evt){
    var valid = 1;
    $('.save-form-data').html('<i class="fas fa-cog fa-spin"></i> Validating..');
    $('.save-form-data').prop('disabled', true);
    $('.invalid-feedback').text('').hide();
    $('.validation-require').each(function (e) {
        var id          = $.trim($(this).attr('id'));
        var val         = $.trim($(this).val());
        var type        = $.trim($(this).prop('type'));
        var field_name  = $.trim($(this).attr('data-field-name'));
        var max_length  = $.trim($(this).prop('maxlength'));

        if(!$('#' + id).hasClass('d-none')){
            if (val == '') {
                $('#err_' + id).text(field_name + ' can\'t be empty!').show();
                valid = 0;
            }else{
                if(id == 'pan_number'){
                    var regex = /[A-Z]{5}[0-9]{4}[A-Z]{1}$/; 
                    if(!regex.test(val)) {
                        $('#err_' + id).text('Please enter a valid PAN Number!').show();
                        valid = 0;
                    }
                }
                if(id == 'contact_email'){
                    var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                    if(!regex.test(val)) {
                        $('#err_' + id).text('Please enter a valid Email id!').show();
                        valid = 0;
                    }
                }
                if(id == 'contact_phone'){
                    var regex = /[1-9]{1}[0-9]{9}$/;
                    if(!regex.test(val) || val.length !== 10) {
                        $('#err_' + id).text('Please enter a valid Phone Number!').show();
                        valid = 0;
                    }
                }
                if($(this).hasClass('supporting-document')){
                    var file_count = $(this)[0].files.length;
                    if(parseInt(file_count) == 0){
                        $('#err_' + id).text('*Please select a ' + field_name).show();
                        valid = 0;
                    }else{
                        var item = $(this)[0].files;
                        var fileSize = item[0].size; 
                        var fileName = item[0].name;
                        var fileExtension =  fileName.substring(fileName.lastIndexOf('.')+1);

                        if ($.inArray(fileExtension, validExtensions) == -1){
                            $('#err_' + id).text('*Only ".jpg",".jpeg",".png",".pdf" files are allowed!').show();
                            $(this).val('');
                            valid = 0;
                        }else{
                            if(parseInt(fileSize) > 2097152) {
                                $('#err_' + id).text('File size must not be more than 2 MB!').show();
                                $(this).val('');
                                valid = 0;
                            }
                        }
                    }
                }
            }
        }
    });

    
    if (valid == 1) {
        return true;
    } else {
        $('.save-form-data').html('<i class="fa fa-save mr-1"></i> Save');
        $('.save-form-data').prop('disabled', false);
        return false;
    }
});

//Employee spouse details visibility control
$(document).on('change', '#marital_status_id', function(){
    var value = $(this).val();

    if(value == '2'){
        $('.spouse-name-div').removeClass('d-none');
        $('#spouse_name').removeClass('d-none');
        $('.marriage-certificate-div').removeClass('d-none');
        $('#marriage_certificate').removeClass('d-none');
        $('.marriage-certificate-file-div').removeClass('d-none');
    }else{
        $('.spouse-name-div').addClass('d-none');
        $('#spouse_name').addClass('d-none');
        $('.marriage-certificate-div').addClass('d-none');
        $('#marriage_certificate').addClass('d-none');
        $('.marriage-certificate-file-div').addClass('d-none');
    }
});

//Employee caste certificate visibility control
$(document).on('change', '#caste_id', function(){
    var value = $(this).val();

    if(value !== '' && value !== '1'){
        $('.caste-certificate-div').removeClass('d-none');
        $('#caste_certificate').removeClass('d-none');
        $('.caste-certificate-file-div').removeClass('d-none');
    }else{
        $('.caste-certificate-div').addClass('d-none');
        $('#caste_certificate').addClass('d-none');
        $('.caste-certificate-file-div').addClass('d-none');
    }
});

//Employee extra details add
$(document).on('click', '.add-new-employee-details', function (evt) {
    var data_row = $(this).attr('data-row');
    var data_code = $(this).attr('data-code');

    var dataStr = {'data_row': data_row, 'data_code': data_code};
    var dataUrl = SITEURL + CONTROLLER + '/ajax_load_add_form';
    $.ajax({
        type: "POST",
        url: dataUrl,
        data: dataStr,
        cache: false,
        dataType: 'JSON',
        beforeSend: function() {
            $('.preloader').removeClass('d-none');
        },
        success: function (data) {
            $('.preloader').addClass('d-none');

            var modalTitle = data.title;
            $('.modal-title').html(modalTitle);
            $('.modal-body').html(data.html);
            $('#hrmsModal').modal('show');
        }
    });
});

$(document).on('click', '.save-employee-ajax-form-data', function (evt) {
    evt.preventDefault();
    var form_type = $(this).attr('form-type');
    var valid = 1;
    var validExtensions = ["jpg","jpeg","png","pdf"];

    $(this).html('<i class="fas fa-cog fa-spin"></i> Saving..');
    $(this).prop('disabled', true);

    $('.ajax-validation-require').each(function (e) {
        var id          = $.trim($(this).attr('id'));
        var val         = $.trim($(this).val());
        var field_name  = $.trim($(this).attr('data-field-name'));
        if($(this).hasClass('d-none')){
            return true;
        }
        if (val == '') {
            $('#err_' + id).text('*Please enter ' + field_name).show();
            valid = 0;
        }else{
            $('#err_' + id).text('').show();
        }

        if(id == 'supporting_document'){
            var file_count = $(this)[0].files.length;
            if(parseInt(file_count) == 0){
                $('#err_' + id).text('*Please select a ' + field_name).show();
                valid = 0;
            }else{
                var item = $(this)[0].files;
                var fileSize = item[0].size; 
                var fileName = item[0].name;
                var fileExtension =  fileName.substring(fileName.lastIndexOf('.')+1);

                if ($.inArray(fileExtension, validExtensions) == -1){
                    $('#err_' + id).text('*Only ".jpg",".jpeg",".png",".pdf" files are allowed!').show();
                    $(this).val('');
                    valid = 0;
                }else{
                    if(parseInt(fileSize) > 2097152) {
                        $('#err_' + id).text('File size must not be more than 2 MB!').show();
                        $(this).val('');
                        valid = 0;
                    }
                }
            }
        }
        if(id == 'bank_ifsc'){
            var regex = /^[A-Z]{4}[0][A-Z0-9]{6}$/; 
            if(!regex.test(val) || val.length !== 11) {
                $('#err_' + id).text('Please enter a valid IFSC code!').show();
                valid = 0;
            }
        }
        if(id == 'contact_no'){
            var regex = /[1-9]{1}[0-9]{9}$/;
            if(!regex.test(val) || val.length !== 10) {
                $('#err_' + id).text('Please enter a valid Phone Number!').show();
                valid = 0;
            }
        }
    });
        console.log(valid);
    if (valid == 1) {
        var formData = new FormData($('#ajax-employee-details-add-form')[0]);
        if(form_type == 'education'){
            var dataUrl = SITEURL + CONTROLLER + '/ajax_save_education_form_data';
        }
        if(form_type == 'address'){
            var dataUrl = SITEURL + CONTROLLER + '/ajax_save_address_form_data';
        }
        if(form_type == 'bank'){
            var dataUrl = SITEURL + CONTROLLER + '/ajax_save_bank_form_data';
        }
        // if(form_type == 'dependent'){
        //     var dataUrl = SITEURL + CONTROLLER + '/ajax_save_dependent_form_data';
        // }
        if(form_type == 'official'){
            var dataUrl = SITEURL + CONTROLLER + '/ajax_save_official_form_data';
        }
        if(form_type == 'salary'){
            var dataUrl = SITEURL + CONTROLLER + '/ajax_save_salary_form_data';
        }
        if(form_type == 'lic'){
            var dataUrl = SITEURL + CONTROLLER + '/ajax_save_lic_form_data';
        }
        if(form_type == 'diability'){
            var dataUrl = SITEURL + CONTROLLER + '/ajax_save_diability_form_data';
        }
        $.ajax({
            type: "POST",
            url: dataUrl,
            data: formData,
            cache: false,
            processData: false,
            contentType: false,
            dataType: 'JSON',
            success: function (data) {
                if(data.code == '1'){
                    Toast.fire({
                        icon: 'success',
                        title: data.message
                    });

                    $('.ajax-form-row').each(function (e) {
                        $(this).val('');
                    });

                    $('#hrmsModal').modal('hide');

                    $('._ftoken').val(data.ftoken);
                    if(form_type == 'education'){
                        $('#custom-education').html(data.html);
                    }
                    if(form_type == 'address'){
                        $('#custom-address').html(data.html);
                    }
                    if(form_type == 'bank'){
                        $('#custom-bank').html(data.html);
                    }
                    // if(form_type == 'dependent'){
                    //     $('#custom-dependents').html(data.html);
                    // }
                    if(form_type == 'official'){
                        $('#custom-official-details').html(data.html);
                    }
                    if(form_type == 'salary'){
                        $('#custom-salary').html(data.html);
                    }
                    if(form_type == 'lic'){
                        $('#custom-lic').html(data.html);
                    }
                    if(form_type == 'diability'){
                        $('#custom-pwd').html(data.html);
                    }
                }else{
                    alert(data.message);

                }
                $('.save-employee-ajax-form-data').html('<i class="fa fa-save mr-1"></i>Save');
                $('.save-employee-ajax-form-data').prop('disabled', false);
            }
        });
    } else {
        $('.save-employee-ajax-form-data').html('<i class="fa fa-save mr-1"></i>Save');
        $('.save-employee-ajax-form-data').prop('disabled', false);
    }
});


$(document).on('change', '#employee_type_id', function(evt){
    var value = $(this).val();
    $('#esic_number').val('');

    if(value !== '3'){
        $('#esic_number').addClass('d-none');
        $('.esic-div').addClass('d-none');
    }else{
        $('#esic_number').removeClass('d-none');
        $('.esic-div').removeClass('d-none');
    }
});

//Get post office, district, state by zip code
$(document).on('change', '#pin', function (evt) {
    var pin = $(this).val();

    if (pin.length == 6) {
        var dataStr = {'pin': pin};
        var dataUrl = SITEURL + 'common/ajax_get_zip_code_details';
        $.ajax({
            type: "POST",
            url: dataUrl,
            data: dataStr,
            cache: false,
            dataType: 'JSON',
            beforeSend: function() {
                $('.preloader').removeClass('d-none');
            },
            success: function (data) {
                $('.preloader').addClass('d-none');
                if(data.code == '1'){
                    $('#district').val(data.district);
                    $('#state').val(data.state);
                }
            }
        });
    }
});

//Get bank details by IFSC code
$(document).on('change', '#bank_ifsc', function (evt) {
    var ifsc = $(this).val();

    if (ifsc.length == 11) {
        var dataStr = {'ifsc': ifsc};
        var dataUrl = SITEURL + 'common/ajax_get_ifsc_details';
        $.ajax({
            type: "POST",
            url: dataUrl,
            data: dataStr,
            cache: false,
            dataType: 'JSON',
            beforeSend: function() {
                $('.preloader').removeClass('d-none');
            },
            success: function (data) {
                $('.preloader').addClass('d-none');
                if(data.code == '1'){
                    $('#bank_name').val(data.bank_name);
                    $('#bank_branch').val(data.bank_branch);
                }
            }
        });
    }
});

$(document).on('change', '.salary-designation', function(){
    var row_id = $(this).val();
    $('#scale_id').val('');

    if(row_id !== ''){
        $('.scale-options').each(function (e) {
            $(this).addClass('d-none');
        });

        $('.designation-' + row_id).removeClass('d-none');
    } 
});

//Add more dependent
$(document).on('click', '.add-dependent', function(evt){
    evt.preventDefault();
    var row_count = $(this).attr('row-count');
    var row_code = $(this).attr('row-code');

    if(row_count !== ''){
        var dataStr = {'row_count': row_count, 'row_code': row_code};
        var dataUrl = SITEURL + CONTROLLER + '/ajax_add_more_dependent';
        $.ajax({
            type: "POST",
            url: dataUrl,
            data: dataStr,
            cache: false,
            dataType: 'JSON',
            success: function (data) {
                $('.dependent-row-' + row_code).after(data.html);
                $('.add-dependent').attr('row-code', data.enc_code);
                $('.add-dependent').attr('row-count', data.dependent_count);
            }
        });
    }
});

//Remove dependent
$(document).on('click', '.remove-dependent', function(evt){
    evt.preventDefault();
    var row_code = $(this).attr('row-code');
    var dependent_count = $('[class*="dependent-row"]').length;
    var enc_code = $(this).attr('old-row-code');

    if(row_code !== ''){
        $('.dependent-row-' + row_code).remove();
        $('.add-dependent').attr('row-code', enc_code);
        $('.add-dependent').attr('row-count', dependent_count);
    }
});

//Add dependent details
$(document).on('click', '.save-employee-dependent-form-data', function(evt){
    evt.preventDefault();
    var form_type = $(this).attr('form-type');
    var valid = 1;
    var validExtensions = ["jpg","jpeg","png","pdf"];

    $(this).html('<i class="fas fa-cog fa-spin"></i> Saving..');
    $(this).prop('disabled', true);

    /*$('.ajax-validation-require').each(function (e) {
        var id          = $.trim($(this).attr('id'));
        var val         = $.trim($(this).val());
        var field_name  = $.trim($(this).attr('data-field-name'));
        if($(this).hasClass('d-none')){
            return true;
        }
        if (val == '') {
            $('#err_' + id).text('*Please enter ' + field_name).show();
            valid = 0;
        }else{
            $('#err_' + id).text('').show();
        }

        if(id == 'supporting_document'){
            var file_count = $(this)[0].files.length;
            if(parseInt(file_count) == 0){
                $('#err_' + id).text('*Please select a ' + field_name).show();
                valid = 0;
            }else{
                var item = $(this)[0].files;
                var fileSize = item[0].size; 
                var fileName = item[0].name;
                var fileExtension =  fileName.substring(fileName.lastIndexOf('.')+1);

                if ($.inArray(fileExtension, validExtensions) == -1){
                    $('#err_' + id).text('*Only ".jpg",".jpeg",".png",".pdf" files are allowed!').show();
                    $(this).val('');
                    valid = 0;
                }else{
                    if(parseInt(fileSize) > 2097152) {
                        $('#err_' + id).text('File size must not be more than 2 MB!').show();
                        $(this).val('');
                        valid = 0;
                    }
                }
            }
        }
        if(id == 'contact_no'){
            var regex = /[1-9]{1}[0-9]{9}$/;
            if(!regex.test(val) || val.length !== 10) {
                $('#err_' + id).text('Please enter a valid Phone Number!').show();
                valid = 0;
            }
        }
    });*/

    if(valid == 1){
        var total_cpf = 0;
        $('.nominee_cpf').each(function (e) {
            var val         = $.trim($(this).val());

            total_cpf += parseInt(val); 
        });

        if (parseInt(total_cpf) !== 100) {
            valid = 0;
            Toast.fire({
                icon: 'error',
                title: 'Total off all nominee CPF must be 100%'
            });
        }
    }


    if(valid == 1){
        var total_gratuity = 0;
        $('.nominee_gratuity').each(function (e) {
            var val         = $.trim($(this).val());

            total_gratuity += parseInt(val); 
        });

        if (parseInt(total_gratuity) !== 100) {
            valid = 0;
            Toast.fire({
                icon: 'error',
                title: 'Total off all nominee gratuity must be 100%'
            });
        }
    }
    
    if (valid == 1) {
        var formData = new FormData($('#ajax-employee-details-add-form')[0]);
        var dataUrl = SITEURL + CONTROLLER + '/ajax_save_dependent_form_data';
        $.ajax({
            type: "POST",
            url: dataUrl,
            data: formData,
            cache: false,
            processData: false,
            contentType: false,
            dataType: 'JSON',
            success: function (data) {
                if(data.code == '1'){
                    Toast.fire({
                        icon: 'success',
                        title: data.message
                    });

                    $('.ajax-form-row').each(function (e) {
                        $(this).val('');
                    });

                    $('#hrmsModal').modal('hide');
                    $('#custom-dependents').html(data.html);
                }else{
                    alert(data.message);

                }
                $('.save-employee-dependent-form-data').html('<i class="fa fa-save mr-1"></i>Save');
                $('.save-employee-dependent-form-data').prop('disabled', false);
            }
        });
    } else {
        $('.save-employee-dependent-form-data').html('<i class="fa fa-save mr-1"></i>Save');
        $('.save-employee-dependent-form-data').prop('disabled', false);
    }
});

/*
|------------------------------------------
|Fetch reporting officer by employee id
|------------------------------------------
*/
$(document).on('change', '.selected-employee-for-appraisal', function(){
    var selected_emp = $(this).val();

    if(selected_emp !== ''){
        var dataStr = {'selected_emp': selected_emp};
        var dataUrl = SITEURL + CONTROLLER + '/ajax_get_reporting_off';
        $.ajax({
            type: "POST",
            url: dataUrl,
            data: dataStr,
            cache: false,
            dataType: 'JSON',
            success: function (data) {
                if(data.code == '1'){
                    $('#reporting_off_id').html(data.html);
                    $('#reviewing_off_id').append(data.reviewing_off);
                }else{
                    alert(data.html);

                }
            }
        });
    }
});

/*
|-------------------------------------------------------
|Load employee aditional 
|-------------------------------------------------------
*/
//Employee extra details edit
$(document).on('click', '.edit-employee-details', function (evt) {
    var row_code = $(this).attr('row-code');
    var row_type = $(this).attr('row-type');
    var data_code = $(this).attr('data-code');

    var dataStr = {'row_code': row_code, 'row_type': row_type, 'data_code': data_code};
    var dataUrl = SITEURL + CONTROLLER + '/ajax_load_edit_form';
    $.ajax({
        type: "POST",
        url: dataUrl,
        data: dataStr,
        cache: false,
        dataType: 'JSON',
        beforeSend: function() {
            $('.preloader').removeClass('d-none');
        },
        success: function (data) {
            $('.preloader').addClass('d-none');

            var modalTitle = data.title;
            $('.modal-title').html(modalTitle);
            $('.modal-body').html(data.html);
            $('#hrmsModal').modal('show');
        }
    });
});

/*
|-------------------------------------------------------
|Update employee aditional details
|-------------------------------------------------------
*/
$(document).on('click', '.update-employee-ajax-form-data', function (evt) {
    evt.preventDefault();
    var form_type = $(this).attr('form-type');
    var valid = 1;
    var validExtensions = ["jpg","jpeg","png","pdf"];

    $(this).html('<i class="fas fa-cog fa-spin"></i> Saving..');
    $(this).prop('disabled', true);

    $('.ajax-validation-require').each(function (e) {
        var id          = $.trim($(this).attr('id'));
        var val         = $.trim($(this).val());
        var field_name  = $.trim($(this).attr('data-field-name'));
        if($(this).hasClass('d-none')){
            return true;
        }
        if (val == '') {
            $('#err_' + id).text('*Please enter ' + field_name).show();
            valid = 0;
        }else{
            $('#err_' + id).text('').show();
        }

        if(id == 'supporting_document'){
            var file_count = $(this)[0].files.length;
            if(parseInt(file_count) == 0){
                $('#err_' + id).text('*Please select a ' + field_name).show();
                valid = 0;
            }else{
                var item = $(this)[0].files;
                var fileSize = item[0].size; 
                var fileName = item[0].name;
                var fileExtension =  fileName.substring(fileName.lastIndexOf('.')+1);

                if ($.inArray(fileExtension, validExtensions) == -1){
                    $('#err_' + id).text('*Only ".jpg",".jpeg",".png",".pdf" files are allowed!').show();
                    $(this).val('');
                    valid = 0;
                }else{
                    if(parseInt(fileSize) > 2097152) {
                        $('#err_' + id).text('File size must not be more than 2 MB!').show();
                        $(this).val('');
                        valid = 0;
                    }
                }
            }
        }
        if(id == 'bank_ifsc'){
            var regex = /^[A-Z]{4}[0][A-Z0-9]{6}$/; 
            if(!regex.test(val) || val.length !== 11) {
                $('#err_' + id).text('Please enter a valid IFSC code!').show();
                valid = 0;
            }
        }
        if(id == 'contact_no'){
            var regex = /[1-9]{1}[0-9]{9}$/;
            if(!regex.test(val) || val.length !== 10) {
                $('#err_' + id).text('Please enter a valid Phone Number!').show();
                valid = 0;
            }
        }
    });
    
    if (valid == 1) {
        var formData = new FormData($('#ajax-employee-details-add-form')[0]);
        if(form_type == 'education'){
            var dataUrl = SITEURL + CONTROLLER + '/ajax_update_education_form_data';
        }
        if(form_type == 'address'){
            var dataUrl = SITEURL + CONTROLLER + '/ajax_update_address_form_data';
        }
        if(form_type == 'bank'){
            var dataUrl = SITEURL + CONTROLLER + '/ajax_update_bank_form_data';
        }
        // if(form_type == 'dependent'){
        //     var dataUrl = SITEURL + CONTROLLER + '/ajax_save_dependent_form_data';
        // }
        if(form_type == 'official'){
            var dataUrl = SITEURL + CONTROLLER + '/ajax_update_official_form_data';
        }
        if(form_type == 'salary'){
            var dataUrl = SITEURL + CONTROLLER + '/ajax_update_salary_form_data';
        }
        if(form_type == 'lic'){
            var dataUrl = SITEURL + CONTROLLER + '/ajax_update_lic_form_data';
        }
        if(form_type == 'diability'){
            var dataUrl = SITEURL + CONTROLLER + '/ajax_update_disability_form_data';
        }
        $.ajax({
            type: "POST",
            url: dataUrl,
            data: formData,
            cache: false,
            processData: false,
            contentType: false,
            dataType: 'JSON',
            success: function (data) {
                if(data.code == '1'){
                    Toast.fire({
                        icon: 'success',
                        title: data.message
                    });

                    $('.ajax-form-row').each(function (e) {
                        $(this).val('');
                    });

                    $('#hrmsModal').modal('hide');

                    $('._ftoken').val(data.ftoken);
                    if(form_type == 'education'){
                        $('#custom-education').html(data.html);
                    }
                    if(form_type == 'address'){
                        $('#custom-address').html(data.html);
                    }
                    if(form_type == 'bank'){
                        $('#custom-bank').html(data.html);
                    }
                    // if(form_type == 'dependent'){
                    //     $('#custom-dependents').html(data.html);
                    // }
                    if(form_type == 'official'){
                        $('#custom-official-details').html(data.html);
                    }
                    if(form_type == 'salary'){
                        $('#custom-salary').html(data.html);
                    }
                    if(form_type == 'lic'){
                        $('#custom-lic').html(data.html);
                    }
                    if(form_type == 'diability'){
                        $('#custom-pwd').html(data.html);
                    }
                }else{
                    alert(data.message);

                }
                $('.update-employee-ajax-form-data').html('<i class="fa fa-save mr-1"></i> Update');
                $('.update-employee-ajax-form-data').prop('disabled', false);
            }
        });
    } else {
        $('.update-employee-ajax-form-data').html('<i class="fa fa-save mr-1"></i> Update');
        $('.update-employee-ajax-form-data').prop('disabled', false);
    }
});

/*
|-------------------------------------------------------
|Update employee dependent data
|-------------------------------------------------------
*/
$(document).on('click', '.update-employee-dependent-form-data', function(evt){
    evt.preventDefault();
    var form_type = $(this).attr('form-type');
    var valid = 1;
    var validExtensions = ["jpg","jpeg","png","pdf"];

    $(this).html('<i class="fas fa-cog fa-spin"></i> Saving..');
    $(this).prop('disabled', true);

    /*$('.ajax-validation-require').each(function (e) {
        var id          = $.trim($(this).attr('id'));
        var val         = $.trim($(this).val());
        var field_name  = $.trim($(this).attr('data-field-name'));
        if($(this).hasClass('d-none')){
            return true;
        }
        if (val == '') {
            $('#err_' + id).text('*Please enter ' + field_name).show();
            valid = 0;
        }else{
            $('#err_' + id).text('').show();
        }

        if(id == 'supporting_document'){
            var file_count = $(this)[0].files.length;
            if(parseInt(file_count) == 0){
                $('#err_' + id).text('*Please select a ' + field_name).show();
                valid = 0;
            }else{
                var item = $(this)[0].files;
                var fileSize = item[0].size; 
                var fileName = item[0].name;
                var fileExtension =  fileName.substring(fileName.lastIndexOf('.')+1);

                if ($.inArray(fileExtension, validExtensions) == -1){
                    $('#err_' + id).text('*Only ".jpg",".jpeg",".png",".pdf" files are allowed!').show();
                    $(this).val('');
                    valid = 0;
                }else{
                    if(parseInt(fileSize) > 2097152) {
                        $('#err_' + id).text('File size must not be more than 2 MB!').show();
                        $(this).val('');
                        valid = 0;
                    }
                }
            }
        }
        if(id == 'contact_no'){
            var regex = /[1-9]{1}[0-9]{9}$/;
            if(!regex.test(val) || val.length !== 10) {
                $('#err_' + id).text('Please enter a valid Phone Number!').show();
                valid = 0;
            }
        }
    });*/

    if(valid == 1){
        var total_cpf = 0;
        $('.nominee_cpf').each(function (e) {
            var val         = $.trim($(this).val());

            total_cpf += parseInt(val); 
        });

        if (parseInt(total_cpf) !== 100) {
            valid = 0;
            Toast.fire({
                icon: 'error',
                title: 'Total off all nominee CPF must be 100%'
            });
        }
    }


    if(valid == 1){
        var total_gratuity = 0;
        $('.nominee_gratuity').each(function (e) {
            var val         = $.trim($(this).val());

            total_gratuity += parseInt(val); 
        });

        if (parseInt(total_gratuity) !== 100) {
            valid = 0;
            Toast.fire({
                icon: 'error',
                title: 'Total off all nominee gratuity must be 100%'
            });
        }
    }
    
    if (valid == 1) {
        var formData = new FormData($('#ajax-employee-details-add-form')[0]);
        var dataUrl = SITEURL + CONTROLLER + '/ajax_update_dependent_form_data';
        $.ajax({
            type: "POST",
            url: dataUrl,
            data: formData,
            cache: false,
            processData: false,
            contentType: false,
            dataType: 'JSON',
            success: function (data) {
                if(data.code == '1'){
                    Toast.fire({
                        icon: 'success',
                        title: data.message
                    });

                    $('.ajax-form-row').each(function (e) {
                        $(this).val('');
                    });

                    $('#hrmsModal').modal('hide');
                    $('#custom-dependents').html(data.html);
                }else{
                    alert(data.message);

                }
                $('.update-employee-dependent-form-data').html('<i class="fa fa-save mr-1"></i> Update');
                $('.update-employee-dependent-form-data').prop('disabled', false);
            }
        });
    } else {
        $('.update-employee-dependent-form-data').html('<i class="fa fa-save mr-1"></i> Update');
        $('.update-employee-dependent-form-data').prop('disabled', false);
    }
});

/*
|-------------------------------------------------------
|View employee details
|-------------------------------------------------------
*/
$(document).on('click', '.view-employee-record', function(evt){
    var row_code = $(this).attr('data-code');
    var token = $('#_ftoken').val();

    if(row_code !== ''){
        var dataStr = {'row_code': row_code, 'token': token};
        var dataUrl = SITEURL + CONTROLLER + '/ajax_view_employee_details';
        $.ajax({
            type: "POST",
            url: dataUrl,
            data: dataStr,
            cache: false,
            dataType: 'JSON',
            beforeSend: function() {
                $('.preloader').removeClass('d-none');
            },
            success: function (data) {
                $('.preloader').addClass('d-none');

                if(data.code !== '0'){
                    $('.modal-title').html(data.message);
                    $('.modal-body').html(data.html);
                    $('#hrmsModal').modal('show');
                    $('#_ftoken').val(data.ftoken);
                }else{
                    Toast.fire({
                        icon: 'error',
                        title: data.message
                    });
                }
            }
        });
    }
});

/*
|-------------------------------------------------------
|Employee search view control
|-------------------------------------------------------
*/
$(document).on('change', '#employee-search-filter', function(){
    var selected_value = $(this).val();

    if(selected_value !== ''){
        $('#employee-search-input-div').removeClass('d-none');
        $('#employee-search-input').removeClass('d-none');
        $('#employee-search-input').val('');

        if(selected_value == 'emp_id'){
            $('#employee-search-input').attr('placeholder', 'Search by Employee Id');
        }
        if(selected_value == 'emp_email'){
            $('#employee-search-input').attr('placeholder', 'Search by Email Id');
        }
        if(selected_value == 'emp_mobile'){
            $('#employee-search-input').attr('placeholder', 'Search by Phone Number');
        }
        if(selected_value == 'emp_name'){
            $('#employee-search-input').attr('placeholder', 'Search by Name');
        }
    }else{
        location.href = SITEURL + CONTROLLER;
    }
});

/*
|-------------------------------------------------------
|Reset filter
|-------------------------------------------------------
*/
$(document).on('keyup', '#employee-search-input', function(){
    var input_value = $(this).val();
    var filter_value = $('#employee-search-filter').val();

    if(input_value !== '' && filter_value !== ''){
        var dataStr = {'input_value': input_value, 'filter_value': filter_value};
        var dataUrl = SITEURL + CONTROLLER + '/ajax_search';
        $.ajax({
            type: "POST",
            url: dataUrl,
            data: dataStr,
            cache: false,
            success: function (data) {
                $('#data_table').html(data);
            }
        });
    }
});

/*
|-------------------------------------------------------
|Reset filter
|-------------------------------------------------------
*/
$(document).on('click', '#reset-filter', function(){
    location.href = SITEURL + CONTROLLER;
});

/*
|-------------------------------------------------------
|View property return details
|-------------------------------------------------------
*/
$(document).on('click', '.view-pr-record', function(evt){
    var row_code = $(this).attr('data-code');

    if(row_code !== ''){
        var dataStr = {'row_code': row_code};
        var dataUrl = SITEURL + CONTROLLER + '/ajax_view_pr_details';
        $.ajax({
            type: "POST",
            url: dataUrl,
            data: dataStr,
            cache: false,
            dataType: 'JSON',
            beforeSend: function() {
                $('.preloader').removeClass('d-none');
            },
            error: function() {
                alert('Some error occured. Please try again!');
                $('.preloader').addClass('d-none');
            },
            success: function (data) {
                $('.preloader').addClass('d-none');

                if(data.code !== '0'){
                    $('.modal-title').html(data.message);
                    $('.modal-body').html(data.html);
                    $('#hrmsModal').modal('show');
                    $('#_ftoken').val(data.ftoken);
                }else{
                    Toast.fire({
                        icon: 'error',
                        title: data.message
                    });
                }
            }
        });
    }
});