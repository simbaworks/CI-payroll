<form method="post" action="#" id="ajax-add-form">
	<div class="row">
		<div class="col-6">
	  		<div class="form-group mb-3">
	            <?php $field_name = 'centre_type_id'; $max_length = '200'; $validation_type_class = 'alphabets'; $type = 'text'; ?>
	            <label for="<?php echo $field_name; ?>">Center Type <span id="<?php echo 'err_' . $field_name; ?>" class="invalid-feedback small"></span></label>
				<select class="form-control validation-require ajax-form-row" id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>" data-field-name="Center Type">
					<option value="">-Centre Types-</option>
					<?php if(isset($centre_types)){?>
						<?php foreach($centre_types as $ct){?>
							<option value="<?php echo $ct['id'];?>"><?php echo base64_decode($ct['centre_type_name']);?></option>
						<?php }?>
					<?php }?>
				</select>
			</div>
		</div>
		<div class="col-6">
	  		<div class="form-group mb-3">
	            <?php $field_name = 'ro_id'; $max_length = '200'; $validation_type_class = 'alphabets'; $type = 'text'; ?>
	            <label for="<?php echo $field_name; ?>">Region <span id="<?php echo 'err_' . $field_name; ?>" class="invalid-feedback small"></span></label>
				<select class="form-control validation-require ajax-form-row" id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>" data-field-name="Region">
					<option value="">-Center Regions-</option>
					<?php if(isset($regions)){?>
						<?php foreach($regions as $rgn){?>
							<option value="<?php echo $rgn['id'];?>"><?php echo base64_decode($rgn['ro_name']);?></option>
						<?php }?>
					<?php }?>
				</select>
			</div>
		</div>
		<div class="col-12">
	  		<div class="form-group mb-3">
	            <?php $field_name = 'centre_name'; $max_length = '200'; $validation_type_class = 'alphabets'; $type = 'text'; ?>
	            <label for="<?php echo $field_name; ?>"><?php echo ucwords(str_replace('_', ' ', $field_name)); ?> <span id="<?php echo 'err_' . $field_name; ?>" class="invalid-feedback small"></span></label>
	            <input type="<?php echo $type; ?>" maxlength="<?php echo $max_length; ?>" data-field-name="<?php echo ucwords(str_replace('_', ' ', $field_name)); ?>" id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>" class="form-control ajax-form-row validation-require">
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