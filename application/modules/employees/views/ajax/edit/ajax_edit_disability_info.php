<form method="post" action="#" id="ajax-employee-details-add-form">	
	<div class="row">
		<div class="col-6">
	  		<div class="form-group mb-3">
	            <?php $field_name = 'pwd_type'; $max_length = '50'; $validation_type_class = 'alphabets'; $type = 'text'; ?>
	            <label class="font-weight-normal" for="<?php echo $field_name; ?>">Policy Number <span id="<?php echo 'err_' . $field_name; ?>" class="invalid-feedback small"></span></label>
	            <select class="form-control custom-select ajax-validation-require" data-field-name="Disability Type" id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>">
	            	<option value="">-Disability Types-</option>
	            	<?php if(isset($pwd_master)){?>
	            		<?php foreach ($pwd_master as $pm) {?>
	            			<option value="<?php echo $pm['id'];?>" <?php echo $pm['id'] == $pwd_details['pwd_type_id']? 'selected' : '';?>><?php echo base64_decode($pm['pwd_name']);?></option>
	            		<?php }?>
	            	<?php }?>
	            </select>
	  		</div>
	    </div>
		<div class="col-6">
	  		<div class="form-group mb-3">
	            <?php $field_name = 'disability_percentage'; $max_length = '2'; $validation_type_class = 'alphabets'; $type = 'number'; ?>
	            <label class="font-weight-normal" for="<?php echo $field_name; ?>"><?php echo ucwords(str_replace('_', ' ', $field_name)); ?> <span id="<?php echo 'err_' . $field_name; ?>" class="invalid-feedback small"></span></label>
	            <input type="<?php echo $type; ?>" maxlength="<?php echo $max_length; ?>" data-field-name="<?php echo ucwords(str_replace('_', ' ', $field_name)); ?>" id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>" class="form-control ajax-validation-require ajax-form-row" value="<?php echo isset($pwd_details['pwd_percentage'])? base64_decode($pwd_details['pwd_percentage']) : '';?>">
	  		</div>
	    </div>
	    <div class="col-3">
	    	<div class="form-group mb-3">
	            <?php $field_name = 'disability_certificate'; $max_length = '100'; $validation_type_class = 'alphabets'; $type = 'text'; ?>
	            <label class="font-weight-normal" for="<?php echo $field_name; ?>"><?php echo ucwords(str_replace('_', ' ', $field_name)); ?> <span id="<?php echo 'err_' . $field_name; ?>" class="invalid-feedback small"></span></label>
              	<input type="file" class="form-control-file ajax-form-row" id="<?php echo $field_name; ?>" data-field-name="<?php echo ucwords(str_replace('_', ' ', $field_name)); ?>" name="<?php echo $field_name; ?>">
            </div>
	    </div>
	    <div class="col-3">
            <label class="font-weight-normal">Uploaded Document </label><br>
            <?php if ($pwd_details['disability_certificate'] !== '' && $pwd_details['disability_certificate'] !== NULL && file_exists('./assets/uploads/disability_certificates/' . $pwd_details['disability_certificate'])) { ?>
            	<a class="btn btn-outline-info btn-sm" href="<?php echo site_url('assets/uploads/disability_certificates/' . $pwd_details['disability_certificate']);?>" target="_blank" title="View supporting document"><i class="far fa-file-image"></i></a>
            <?php }?>
        </div>
	</div>
	<hr>
	<div class="row">
	    <div class="col-12">
	    	<div class=" text-right">
	            <input type="hidden" name="_ftoken" class="_ftoken" id="_ftoken" value="<?php echo $_ftoken; ?>" />
	            <input type="hidden" name="row-code" class="row-code" id="row-code" value="<?php echo $row_code; ?>" />
	            <input type="hidden" name="data-code" class="data-code" id="data-code" value="<?php echo $employee_id; ?>" />
	            <button class="btn btn-outline-primary my-2 btn-sm update-employee-ajax-form-data btn-flat" type="submit" form-type="diability"><i class="fa fa-save mr-1"></i> Update</button>
	        </div>
	    </div>
	</div>
</form>
<script type="text/javascript">
	$('.datepicker').datepicker({
      	autoclose: true,
      	format: 'dd/mm/yyyy'
  	});
</script>