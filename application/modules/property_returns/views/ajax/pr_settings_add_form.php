<?php 
$assigned_employees = array();
if(isset($pr_settings)){
	foreach($pr_settings as $prs){
		$assigned_employees[] = $prs['employee_id'];
	}
}
?>
<form method="post" action="#" id="ajax-add-form">
	<div class="row">
		<div class="col-12">
	  		<div class="form-group mb-3">
	            <?php $field_name = 'employee_id'; $max_length = '200'; $validation_type_class = 'alphabets'; $type = 'text'; ?>
	            <label class="font-weight-normal" for="<?php echo $field_name; ?>">Employee <span id="<?php echo 'err_' . $field_name; ?>" class="invalid-feedback small"></span></label>
				<select class="form-control ajax-form-row multiple-select" placeholder="Search here.." multiple="" id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>[]" data-field-name="Employee">
					<?php if(isset($employee_details)){?>
						<?php foreach($employee_details as $ed){?>
							<?php if(in_array($ed['id'], $assigned_employees)){continue;}?>
							<option value="<?php echo $ed['id'];?>"><?php echo  '[' . base64_decode($ed['emp_id']) . '] ' . base64_decode($ed['emp_name']);?></option>
						<?php }?>
					<?php }?>
				</select>
			</div>
		</div>
		<div class="col-6">
	  		<div class="form-group mb-3">
	            <?php $field_name = 'start_date'; $max_length = '200'; $validation_type_class = 'alphabets'; $type = 'text'; ?>
	            <label class="font-weight-normal" for="<?php echo $field_name; ?>"><?php echo ucwords(str_replace('_', ' ', $field_name)); ?> <span id="<?php echo 'err_' . $field_name; ?>" class="invalid-feedback small"></span></label>
	            <input type="<?php echo $type; ?>" maxlength="<?php echo $max_length; ?>" data-field-name="<?php echo ucwords(str_replace('_', ' ', $field_name)); ?>" id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>" class="form-control  validation-require date_picker datepicker" value="<?php echo isset($employee_details['date_of_birth'])? date('d/m/Y', strtotime($employee_details['date_of_birth'])) : '';?>" readonly>
			</div>
		</div>
	    <div class="col-6">
	    	<div class="form-group mb-3">
	            <?php $field_name = 'end_date'; $max_length = '100'; $validation_type_class = 'alphabets'; $type = 'text'; ?>
	            <label class="font-weight-normal" for="<?php echo $field_name; ?>"><?php echo ucwords(str_replace('_', ' ', $field_name)); ?> <span id="<?php echo 'err_' . $field_name; ?>" class="invalid-feedback small"></span></label>
	            <input type="<?php echo $type; ?>" maxlength="<?php echo $max_length; ?>" data-field-name="<?php echo ucwords(str_replace('_', ' ', $field_name)); ?>" id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>" class="form-control  validation-require date_picker datepicker" value="<?php echo isset($employee_details['date_of_birth'])? date('d/m/Y', strtotime($employee_details['date_of_birth'])) : '';?>" readonly>
	      	</div>
	    </div>
	    <div class="col-12">
	    	<div class=" text-right mt-4">
	            <input type="hidden" name="_ftoken" class="_ftoken" id="_ftoken" value="<?php echo $_ftoken; ?>" />
	            <button class="btn btn-outline-primary my-2 btn-sm save-ajax-pr-settings-form-data btn-flat" type="submit"><i class="fa fa-save mr-1"></i> Save</button>
	        </div>
	    </div>
	</div>
</form>


<script type="text/javascript">
    $('.multiple-select').multipleSelect('destroy');
    $('.multiple-select').multipleSelect({
        filter: true,
        multiple: false,
        hideOptgroupCheckboxes: true,
        dropWidth: 580
    });


	$('.datepicker').datepicker({
        max: true,
      	autoclose: true,
        inline: true,
      	format: 'dd/mm/yyyy',
      	startDate: '0d'
    });

    $("#start_date").datepicker().on('changeDate', (selected) => {
        var minDate = new Date(selected.date.valueOf());
        $('#end_date').datepicker('setStartDate', minDate);
    });

    $("#end_date").datepicker().on('changeDate', (selected) => {
        var minDate = new Date(selected.date.valueOf());
        $('#start_date').datepicker('setEndDate', minDate);
    });

    /*
	|-------------------------------------------
	|Save ajax add new record data
	|-------------------------------------------
	*/
	$(document).on('click', '.save-ajax-pr-settings-form-data', function (evt) {
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

	    if (valid == 1) {
	        var formData = new FormData($('#ajax-add-form')[0]);
	        var dataUrl = SITEURL + CONTROLLER + '/ajax_save_pr_settings_add_form_data';
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
	                    window.location.href = SITEURL + CONTROLLER + '/property_return_settings';
	                }else{
	                    alert(data.message);
	                }
	                $('.save-ajax-pr-settings-form-data').html('<i class="fa fa-save mr-1"></i>Save');
	                $('.save-ajax-pr-settings-form-data').prop('disabled', false);
	            }
	        });
	    } else {
	        $(this).html('<i class="fa fa-save mr-1"></i>Save');
	        $(this).prop('disabled', false);
	    }
	});
</script>