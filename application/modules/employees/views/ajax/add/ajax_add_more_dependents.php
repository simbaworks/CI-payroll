<div class="row shadow p-3 mt-3 mx-1 bg-white rounded dependent-row-<?php echo $enc_code;?>">
	<?php if($dependent_count !== '1'){?>
		<div class="col-12">
			<button class="btn btn-outline-danger btn-sm float-right remove-dependent last-div" id="remove-dependent-<?php echo $enc_code;?>" row-code="<?php echo $enc_code;?>" old-row-code="<?php echo $pre_enc_code;?>"><i class="fas fa-user-times mr-2"></i>Remove Dependent</button>
		</div>
	<?php }?>
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
    <div class="col-6">
        <div class="form-group mb-3">
            <?php $field_name = 'income_document'; $max_length = '100'; $validation_type_class = 'alphabets'; $type = 'text'; ?>
            <label class="font-weight-normal" for="<?php echo $field_name; ?>"><?php echo ucwords(str_replace('_', ' ', $field_name)); ?> <span id="<?php echo 'err_' . $field_name; ?>" class="invalid-feedback small"></span></label>
            <input type="file" class="form-control-file ajax-form-row" id="<?php echo $field_name; ?>" data-field-name="<?php echo ucwords(str_replace('_', ' ', $field_name)); ?>" name="<?php echo $field_name; ?>[]">
        </div>
    </div>
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
	<div class="col-6">
  		<div class="form-group mb-3">
            <?php $field_name = 'priority'; $max_length = '100'; $validation_type_class = 'alphabets'; $type = 'text'; ?>
            <label class="font-weight-normal" for="<?php echo $field_name; ?>">Priority <span id="<?php echo 'err_' . $field_name; ?>" class="invalid-feedback small"></span></label>
            <select class="form-control ajax-validation-require ajax-form-row" id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>[]" data-field-name="Priority">
				<option value="1">First</option>
				<option value="2">Second</option>
			</select>
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
<script type="text/javascript">
	$('.datepicker').datepicker({
      	autoclose: true,
      	format: 'mm/dd/yyyy'
  	});
</script>