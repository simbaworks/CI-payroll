<form method="post" action="#" id="ajax-add-form">
	<div class="row">
		<div class="col-6">
	  		<div class="form-group mb-3">
	            <?php $field_name = 'employee_id'; $max_length = '200'; $validation_type_class = 'alphabets'; $type = 'text'; ?>
	            <label for="<?php echo $field_name; ?>">Employee <span id="<?php echo 'err_' . $field_name; ?>" class="invalid-feedback small"></span></label>
				<select class="form-control validation-require ajax-form-row selected-employee-for-appraisal" id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>" data-field-name="Office">
					<option value="">-Select Employee-</option>
					<?php if(isset($employee_details)){?>
						<?php foreach($employee_details as $ed){?>
							<option value="<?php echo $ed['id'];?>"><?php echo  '[' . base64_decode($ed['emp_id']) . '] ' . base64_decode($ed['name']);?></option>
						<?php }?>
					<?php }?>
				</select>
			</div>
		</div>
		<div class="col-6">
	  		<div class="form-group mb-3">
	            <?php $field_name = 'reporting_off_id'; $max_length = '200'; $validation_type_class = 'alphabets'; $type = 'text'; ?>
	            <label for="<?php echo $field_name; ?>">Reporting Officer <span id="<?php echo 'err_' . $field_name; ?>" class="invalid-feedback small"></span></label>
				<select class="form-control validation-require ajax-form-row" id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>" data-field-name="Reporting Officer">
					<option value="">-Select Reporting Officer-</option>
				</select>
			</div>
		</div>
		<div class="col-6">
	  		<div class="form-group mb-3">
	            <?php $field_name = 'reviewing_off_id'; $max_length = '200'; $validation_type_class = 'alphabets'; $type = 'text'; ?>
	            <label for="<?php echo $field_name; ?>">Reviewing Officer <span id="<?php echo 'err_' . $field_name; ?>" class="invalid-feedback small"></span></label>
				<select class="form-control validation-require ajax-form-row" id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>" data-field-name="Reviewing Officer">
					<option value="">-Select Reviewing Officer-</option>
				</select>
			</div>
		</div>
		<div class="col-6">
	  		<div class="form-group mb-3">
	            <?php $field_name = 'marks_obtained'; $max_length = '200'; $validation_type_class = 'number'; $type = 'number'; ?>
	            <label for="<?php echo $field_name; ?>"><?php echo ucwords(str_replace('_', ' ', $field_name)); ?> <span id="<?php echo 'err_' . $field_name; ?>" class="invalid-feedback small"></span></label>
	            <input type="<?php echo $type; ?>" maxlength="<?php echo $max_length; ?>" data-field-name="<?php echo ucwords(str_replace('_', ' ', $field_name)); ?>" id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>" class="form-control ajax-form-row validation-require <?php echo $validation_type_class; ?>">
	  		</div>
	    </div>
		<div class="col-6">
	  		<div class="form-group mb-3">
	            <?php $field_name = 'year'; $max_length = '200'; $validation_type_class = 'alphabets'; $type = 'text'; ?>
	            <label for="<?php echo $field_name; ?>">Year <span id="<?php echo 'err_' . $field_name; ?>" class="invalid-feedback small"></span></label>
				<select class="form-control validation-require ajax-form-row" id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>" data-field-name="Year">
					<option value="">-Select Year-</option>
					<?php for($i = 1; $i <= 30; $i++){?>
						<option value="<?php echo date('Y', strtotime('-' . $i . ' year'));?>"><?php echo date('Y', strtotime('-' . $i . ' year'));?></option>
					<?php }?>
				</select>
			</div>
		</div>
	    <div class="col-6">
	    	<div class="form-group mb-3">
	            <?php $field_name = 'supporting_document'; $max_length = '100'; $validation_type_class = 'alphabets'; $type = 'text'; ?>
	            <label class="font-weight-normal" for="<?php echo $field_name; ?>"><?php echo ucwords(str_replace('_', ' ', $field_name)); ?> <span id="<?php echo 'err_' . $field_name; ?>" class="invalid-feedback small"></span></label>
	          	<input type="file" class="form-control-file ajax-form-row validation-require" id="<?php echo $field_name; ?>" data-field-name="<?php echo ucwords(str_replace('_', ' ', $field_name)); ?>" name="<?php echo $field_name; ?>">
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