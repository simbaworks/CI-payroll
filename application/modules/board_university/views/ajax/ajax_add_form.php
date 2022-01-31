<form method="post" action="#" id="ajax-add-form">
	<div class="row">
		<div class="col-12">
	  		<div class="form-group mb-3">
	            <?php $field_name = 'bu_name'; $max_length = '200'; $validation_type_class = 'alphabets'; $type = 'text'; ?>
	            <label for="<?php echo $field_name; ?>">Board/University Name <span id="<?php echo 'err_' . $field_name; ?>" class="invalid-feedback small"></span></label>
	            <input type="<?php echo $type; ?>" maxlength="<?php echo $max_length; ?>" data-field-name="Board/University Name" id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>" class="form-control ajax-form-row validation-require <?php echo $validation_type_class; ?>">
	  		</div>
	    </div>
	    <div class="col-12">
	    	<div class=" text-right mt-4">
	            <input type="hidden" name="_ftoken" class="_ftoken" id="_ftoken" value="<?php echo $_ftoken; ?>" />
	            <button class="btn btn-outline-primary my-2 btn-sm save-ajax-form-data btn-flat" type="submit"><i class="fa fa-save mr-1"></i> Save</button>
	        </div>
	    </div>
	</div>
</form>