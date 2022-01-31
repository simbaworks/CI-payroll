<form method="post" action="#" id="ajax-add-form">
	<div class="row">
		<div class="col-6">
	  		<div class="form-group mb-3">
	            <?php $field_name = 'office_id'; $max_length = '200'; $validation_type_class = 'alphabets'; $type = 'text'; ?>
	            <label for="<?php echo $field_name; ?>">Office <span id="<?php echo 'err_' . $field_name; ?>" class="invalid-feedback small"></span></label>
				<select class="form-control validation-require ajax-form-row" id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>" data-field-name="Office">
					<option value="">-Select Office-</option>
					<?php if(isset($centre_details)){?>
						<?php foreach($centre_details as $cd){?>
							<option value="<?php echo $cd['id'];?>"><?php echo base64_decode($cd['centre_type_name']) . '-' . base64_decode($cd['centre_name']) . '-' . base64_decode($cd['ro_name']);?></option>
						<?php }?>
					<?php }?>
				</select>
			</div>
		</div>
		<div class="col-6">
	  		<div class="form-group mb-3">
	            <?php $field_name = 'designation_id'; $max_length = '200'; $validation_type_class = 'alphabets'; $type = 'text'; ?>
	            <label for="<?php echo $field_name; ?>">Designation <span id="<?php echo 'err_' . $field_name; ?>" class="invalid-feedback small"></span></label>
				<select class="form-control validation-require ajax-form-row" id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>" data-field-name="Designation">
					<option value="">-Select Designation-</option>
					<?php if(isset($designation_master)){?>
						<?php foreach($designation_master as $dm){?>
							<option value="<?php echo $dm['id'];?>"><?php echo $dm['description'] . '-' . $dm['type'] . '(' . $dm['shortname'] . ')';?></option>
						<?php }?>
					<?php }?>
				</select>
			</div>
		</div>
		<div class="col-12">
	  		<div class="form-group mb-3">
	            <?php $field_name = 'vacant_post_count'; $max_length = '200'; $validation_type_class = 'number'; $type = 'number'; ?>
	            <label for="<?php echo $field_name; ?>"><?php echo ucwords(str_replace('_', ' ', $field_name)); ?> <span id="<?php echo 'err_' . $field_name; ?>" class="invalid-feedback small"></span></label>
	            <input type="<?php echo $type; ?>" maxlength="<?php echo $max_length; ?>" data-field-name="<?php echo ucwords(str_replace('_', ' ', $field_name)); ?>" id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>" class="form-control ajax-form-row validation-require <?php echo $validation_type_class; ?>">
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