<form method="post" action="#" id="ajax-employee-details-add-form">	
	<div class="row">
		<div class="col-6">
	  		<div class="form-group mb-3">
	            <?php $field_name = 'policy_no'; $max_length = '50'; $validation_type_class = 'alphabets'; $type = 'text'; ?>
	            <label class="font-weight-normal" for="<?php echo $field_name; ?>">Policy Number <span id="<?php echo 'err_' . $field_name; ?>" class="invalid-feedback small"></span></label>
	            <input type="<?php echo $type; ?>" maxlength="<?php echo $max_length; ?>" data-field-name="Policy Number" id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>" class="form-control ajax-form-row ajax-validation-require" min="1">
	  		</div>
	    </div>
		<div class="col-6">
	  		<div class="form-group mb-3">
	            <?php $field_name = 'premium_amount'; $max_length = '11'; $validation_type_class = 'alphabets'; $type = 'number'; ?>
	            <label class="font-weight-normal" for="<?php echo $field_name; ?>"><?php echo ucwords(str_replace('_', ' ', $field_name)); ?> <span id="<?php echo 'err_' . $field_name; ?>" class="invalid-feedback small"></span></label>
	            <input type="<?php echo $type; ?>" maxlength="<?php echo $max_length; ?>" data-field-name="<?php echo ucwords(str_replace('_', ' ', $field_name)); ?>" id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>" class="form-control ajax-validation-require ajax-form-row">
	  		</div>
	    </div>
		<div class="col-6">
	  		<div class="form-group mb-3">
	            <?php $field_name = 'issue_date'; $max_length = '100'; $validation_type_class = 'alphabets'; $type = 'text'; ?>
	            <label class="font-weight-normal" for="<?php echo $field_name; ?>"><?php echo ucwords(str_replace('_', ' ', $field_name)); ?> <span id="<?php echo 'err_' . $field_name; ?>" class="invalid-feedback small"></span></label>
	            <input type="<?php echo $type; ?>" maxlength="<?php echo $max_length; ?>" data-field-name="<?php echo ucwords(str_replace('_', ' ', $field_name)); ?>" id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>" class="form-control  ajax-validation-require datepicker ajax-form-row" readonly>
	  		</div>
	    </div>
		<div class="col-6">
	  		<div class="form-group mb-3">
	            <?php $field_name = 'maturity_date'; $max_length = '100'; $validation_type_class = 'alphabets'; $type = 'text'; ?>
	            <label class="font-weight-normal" for="<?php echo $field_name; ?>"><?php echo ucwords(str_replace('_', ' ', $field_name)); ?> <span id="<?php echo 'err_' . $field_name; ?>" class="invalid-feedback small"></span></label>
	            <input type="<?php echo $type; ?>" maxlength="<?php echo $max_length; ?>" data-field-name="<?php echo ucwords(str_replace('_', ' ', $field_name)); ?>" id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>" class="form-control  ajax-validation-require datepicker ajax-form-row" readonly>
	  		</div>
	    </div>
	    <div class="col-6">
	    	<div class="form-group mb-3">
	            <?php $field_name = 'supporting_document'; $max_length = '100'; $validation_type_class = 'alphabets'; $type = 'text'; ?>
	            <label class="font-weight-normal" for="<?php echo $field_name; ?>"><?php echo ucwords(str_replace('_', ' ', $field_name)); ?> <span id="<?php echo 'err_' . $field_name; ?>" class="invalid-feedback small"></span></label>
                  	<input type="file" class="form-control-file ajax-form-row ajax-validation-require" id="<?php echo $field_name; ?>" data-field-name="<?php echo ucwords(str_replace('_', ' ', $field_name)); ?>" name="<?php echo $field_name; ?>">
                </div>
          	</div>
	    </div>
	</div>
	<hr>
	<div class="row">
	    <div class="col-12">
	    	<div class=" text-right">
	            <input type="hidden" name="_ftoken" class="_ftoken" id="_ftoken" value="<?php echo $_ftoken; ?>" />
	            <input type="hidden" name="row-id" class="row-id" id="row-id" value="<?php echo $employee_id; ?>" />
	            <button class="btn btn-outline-primary my-2 btn-sm save-employee-ajax-form-data btn-flat" type="submit" form-type="lic"><i class="fa fa-save mr-1"></i> Save</button>
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