<form method="post" action="#" id="ajax-employee-details-add-form">	
	<div class="row shadow p-3 m-1 bg-white rounded dependent-row-<?php echo $enc_code;?>">
		<div class="col-6">
	  		<div class="form-group mb-3">
	            <?php $field_name = 'dependent_name'; $max_length = '100'; $validation_type_class = 'alphabets'; $type = 'text'; ?>
	            <label class="font-weight-normal" for="<?php echo $field_name; ?>"><?php echo ucwords(str_replace('_', ' ', $field_name)); ?> <span id="<?php echo 'err_' . $field_name; ?>" class="invalid-feedback small"></span></label>
	            <input type="<?php echo $type; ?>" maxlength="<?php echo $max_length; ?>" data-field-name="<?php echo ucwords(str_replace('_', ' ', $field_name)); ?>" id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>[]" class="form-control ajax-form-row ajax-validation-require">
	  		</div>
	    </div>
		<div class="col-6">
	  		<div class="form-group mb-3">
	            <?php $field_name = 'relation_id'; $max_length = '100'; $validation_type_class = 'alphabets'; $type = 'text'; ?>
	            <label class="font-weight-normal" for="<?php echo $field_name; ?>">Relation <span id="<?php echo 'err_' . $field_name; ?>" class="invalid-feedback small"></span></label>
	            <select class="form-control ajax-validation-require ajax-form-row" id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>[]" data-field-name="Relation">
					<option value="">-Relation-</option>
					<?php if(isset($relations)){?>
						<?php foreach($relations as $rl){?>
							<option value="<?php echo $rl['id'];?>"><?php echo base64_decode($rl['relation']);?></option>
						<?php }?>
					<?php }?>
				</select>
	  		</div>
	    </div>
		<div class="col-6">
	  		<div class="form-group mb-3">
	            <?php $field_name = 'dependent_dob'; $max_length = '100'; $validation_type_class = 'alphabets'; $type = 'text'; ?>
	            <label class="font-weight-normal" for="<?php echo $field_name; ?>"><?php echo ucwords(str_replace('_', ' ', $field_name)); ?> <span id="<?php echo 'err_' . $field_name; ?>" class="invalid-feedback small"></span></label>
	            <input type="<?php echo $type; ?>" maxlength="<?php echo $max_length; ?>" data-field-name="<?php echo ucwords(str_replace('_', ' ', $field_name)); ?>" id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>[]" class="form-control  ajax-validation-require datepicker ajax-form-row" readonly>
	  		</div>
	    </div>
		<div class="col-6">
	  		<div class="form-group mb-3">	            
	            <?php $field_name = 'contact_no'; $max_length = '10'; $validation_type_class = 'alphabets'; $type = 'number'; ?>
	            <label class="font-weight-normal" for="<?php echo $field_name; ?>">Contact Number <span id="<?php echo 'err_' . $field_name; ?>" class="invalid-feedback small"></span></label>
	            <input type="<?php echo $type; ?>" maxlength="<?php echo $max_length; ?>" data-field-name="Contact Number" id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>[]" class="form-control ajax-form-row ajax-validation-require">
	  		</div>
	    </div>
		<div class="col-12">
	  		<div class="form-group mb-3">
	            <?php $field_name = 'address'; $max_length = '200'; $validation_type_class = 'alphabets'; $type = 'text'; ?>
	            <label class="font-weight-normal" for="<?php echo $field_name; ?>"><?php echo ucwords(str_replace('_', ' ', $field_name)); ?> <span id="<?php echo 'err_' . $field_name; ?>" class="invalid-feedback small"></span></label>
	            <input type="<?php echo $type; ?>" maxlength="<?php echo $max_length; ?>" data-field-name="<?php echo ucwords(str_replace('_', ' ', $field_name)); ?>" id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>[]" class="form-control ajax-form-row ajax-validation-require" min="1">
	  		</div>
	    </div>
		<div class="col-6">
	  		<div class="form-group mb-3">            
	            <?php $field_name = 'income'; $max_length = '5'; $validation_type_class = 'alphabets'; $type = 'number'; ?>
	            <label class="font-weight-normal" for="<?php echo $field_name; ?>"><?php echo ucwords(str_replace('_', ' ', $field_name)); ?> <span id="<?php echo 'err_' . $field_name; ?>" class="invalid-feedback small"></span></label>
	            <input type="<?php echo $type; ?>" maxlength="<?php echo $max_length; ?>" data-field-name="<?php echo ucwords(str_replace('_', ' ', $field_name)); ?>" id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>[]" class="form-control ajax-form-row">
	  		</div>
	    </div>
	    <!-- <div class="col-6">
	    	<div class="form-group mb-3">
	            <?php $field_name = 'income_document'; $max_length = '100'; $validation_type_class = 'alphabets'; $type = 'text'; ?>
	            <label class="font-weight-normal" for="<?php echo $field_name; ?>"><?php echo ucwords(str_replace('_', ' ', $field_name)); ?> <span id="<?php echo 'err_' . $field_name; ?>" class="invalid-feedback small"></span></label>
              	<input type="file" class="form-control-file ajax-form-row" id="<?php echo $field_name; ?>" data-field-name="<?php echo ucwords(str_replace('_', ' ', $field_name)); ?>" name="<?php echo $field_name; ?>[]">
          	</div>
	    </div> -->
		<div class="col-6">
	  		<div class="form-group mb-3">            
	            <?php $field_name = 'nominee_cpf'; $max_length = '3'; $validation_type_class = 'alphabets'; $type = 'number'; ?>
	            <label class="font-weight-normal" for="<?php echo $field_name; ?>">Nominee CPF <span id="<?php echo 'err_' . $field_name; ?>" class="invalid-feedback small"></span></label>
	            <input type="<?php echo $type; ?>" maxlength="<?php echo $max_length; ?>" data-field-name="Nominee CPF" id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>[]" class="form-control ajax-form-row ajax-validation-require nominee_cpf">
	  		</div>
	    </div>
		<div class="col-6">
	  		<div class="form-group mb-3">            
	            <?php $field_name = 'nominee_gratuity'; $max_length = '3'; $validation_type_class = 'alphabets'; $type = 'number'; ?>
	            <label class="font-weight-normal" for="<?php echo $field_name; ?>"><?php echo ucwords(str_replace('_', ' ', $field_name)); ?> <span id="<?php echo 'err_' . $field_name; ?>" class="invalid-feedback small"></span></label>
	            <input type="<?php echo $type; ?>" maxlength="<?php echo $max_length; ?>" data-field-name="<?php echo ucwords(str_replace('_', ' ', $field_name)); ?>" id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>[]" class="form-control ajax-form-row ajax-validation-require nominee_gratuity">
	  		</div>
	    </div>
		<div class="col-6">
	  		<div class="form-group mb-3">
	            <?php $field_name = 'nominee_medical'; $max_length = '100'; $validation_type_class = 'alphabets'; $type = 'text'; ?>
	            <label class="font-weight-normal" for="<?php echo $field_name; ?>">Medical <span id="<?php echo 'err_' . $field_name; ?>" class="invalid-feedback small"></span></label>
	            <select class="form-control ajax-validation-require ajax-form-row" id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>[]" data-field-name="Medical">
					<option value="0">No</option>
					<option value="1">Yes</option>
				</select>
	  		</div>
	    </div>
		<div class="col-6">
	  		<div class="form-group mb-3">
	            <?php $field_name = 'nominee_ltc'; $max_length = '100'; $validation_type_class = 'alphabets'; $type = 'text'; ?>
	            <label class="font-weight-normal" for="<?php echo $field_name; ?>">LTC <span id="<?php echo 'err_' . $field_name; ?>" class="invalid-feedback small"></span></label>
	            <select class="form-control ajax-validation-require ajax-form-row" id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>[]" data-field-name="LTC">
					<option value="0">No</option>
					<option value="1">Yes</option>
				</select>
	  		</div>
	    </div>
		<!-- <div class="col-6">
	  		<div class="form-group mb-3">
	            <?php $field_name = 'priority'; $max_length = '100'; $validation_type_class = 'alphabets'; $type = 'text'; ?>
	            <label class="font-weight-normal" for="<?php echo $field_name; ?>">Priority <span id="<?php echo 'err_' . $field_name; ?>" class="invalid-feedback small"></span></label>
	            <select class="form-control ajax-validation-require ajax-form-row" id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>[]" data-field-name="Priority">
					<option value="1">First</option>
					<option value="2">Second</option>
				</select>
	  		</div>
	    </div> -->
	    <div class="col-6">
	        <div class="form-group mb-3">
	            <?php $field_name = 'document_type'; $max_length = '100'; $validation_type_class = 'alphabets'; $type = 'text'; ?>
	            <label class="font-weight-normal" for="<?php echo $field_name; ?>">Medical <span id="<?php echo 'err_' . $field_name; ?>" class="invalid-feedback small"></span></label>
	            <select class="form-control ajax-validation-require ajax-form-row" id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>[]" data-field-name="Medical">
	                <option value="voter_id">Voter ID</option>
	                <option value="aadhaar_id">Aadhaar ID</option>
	                <option value="pan_id">PAN ID</option>
	            </select>
	        </div>
	    </div>
	    <div class="col-6">
	        <div class="form-group mb-3">
	            <?php $field_name = 'document_number'; $max_length = '100'; $validation_type_class = 'alphabets'; $type = 'text'; ?>
	            <label class="font-weight-normal" for="<?php echo $field_name; ?>"><?php echo ucwords(str_replace('_', ' ', $field_name)); ?> <span id="<?php echo 'err_' . $field_name; ?>" class="invalid-feedback small"></span></label>
	            <input type="<?php echo $type; ?>" maxlength="<?php echo $max_length; ?>" data-field-name="<?php echo ucwords(str_replace('_', ' ', $field_name)); ?>" id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>[]" class="form-control ajax-form-row ajax-validation-require">
	        </div>
	    </div>
	    <div class="col-6">
	    	<div class="form-group mb-3">
	            <?php $field_name = 'supporting_document'; $max_length = '100'; $validation_type_class = 'alphabets'; $type = 'text'; ?>
	            <label class="font-weight-normal" for="<?php echo $field_name; ?>"><?php echo ucwords(str_replace('_', ' ', $field_name)); ?> <span id="<?php echo 'err_' . $field_name; ?>" class="invalid-feedback small"></span></label>
              	<input type="file" class="form-control-file ajax-form-row ajax-validation-require" id="<?php echo $field_name; ?>" data-field-name="<?php echo ucwords(str_replace('_', ' ', $field_name)); ?>" name="<?php echo $field_name; ?>[]">
          	</div>
	    </div>
	</div>
	<div class="row shadow p-3 mt-3 mx-1 bg-white rounded">
		<div class="col-12">
			<button class="btn btn-outline-success btn-sm float-right add-dependent" id="add-dependent-<?php echo $enc_code;?>" row-count="<?php echo $dependent_count;?>" row-code="<?php echo $enc_code;?>"><i class="fas fa-user-plus mr-2"></i>Add More Dependent</button>
		</div>
	</div>
	<hr>
	<div class="row">
	    <div class="col-12">
	    	<div class=" text-center">
	            <input type="hidden" name="_ftoken" class="_ftoken" id="_ftoken" value="<?php echo $_ftoken; ?>" />
	            <input type="hidden" name="row-id" class="row-id" id="row-id" value="<?php echo $employee_id; ?>" />
	            <button class="btn btn-outline-primary my-2 btn-sm save-employee-dependent-form-data btn-flat" type="submit" form-type="dependent"><i class="fa fa-save mr-1"></i> Save</button>
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