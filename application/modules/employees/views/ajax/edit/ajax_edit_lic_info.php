<form method="post" action="#" id="ajax-employee-details-add-form">	
	<div class="row">
		<div class="col-6">
	  		<div class="form-group mb-3">
	            <?php $field_name = 'policy_no'; $max_length = '50'; $validation_type_class = 'alphabets'; $type = 'text'; ?>
	            <label class="font-weight-normal" for="<?php echo $field_name; ?>">Policy Number <span id="<?php echo 'err_' . $field_name; ?>" class="invalid-feedback small"></span></label>
	            <input type="<?php echo $type; ?>" maxlength="<?php echo $max_length; ?>" data-field-name="Policy Number" id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>" class="form-control ajax-form-row ajax-validation-require" min="1" value="<?php echo isset($lic_details['policy_no'])? $lic_details['policy_no'] : '';?>">
	  		</div>
	    </div>
		<div class="col-6">
	  		<div class="form-group mb-3">
	            <?php $field_name = 'premium_amount'; $max_length = '11'; $validation_type_class = 'alphabets'; $type = 'number'; ?>
	            <label class="font-weight-normal" for="<?php echo $field_name; ?>"><?php echo ucwords(str_replace('_', ' ', $field_name)); ?> <span id="<?php echo 'err_' . $field_name; ?>" class="invalid-feedback small"></span></label>
	            <input type="<?php echo $type; ?>" maxlength="<?php echo $max_length; ?>" data-field-name="<?php echo ucwords(str_replace('_', ' ', $field_name)); ?>" id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>" class="form-control ajax-validation-require ajax-form-row" value="<?php echo isset($lic_details['premium_amount'])? $lic_details['premium_amount'] : '';?>">
	  		</div>
	    </div>
		<div class="col-6">
	  		<div class="form-group mb-3">
	            <?php $field_name = 'issue_date'; $max_length = '100'; $validation_type_class = 'alphabets'; $type = 'text'; ?>
	            <label class="font-weight-normal" for="<?php echo $field_name; ?>"><?php echo ucwords(str_replace('_', ' ', $field_name)); ?> <span id="<?php echo 'err_' . $field_name; ?>" class="invalid-feedback small"></span></label>
	            <input type="<?php echo $type; ?>" maxlength="<?php echo $max_length; ?>" data-field-name="<?php echo ucwords(str_replace('_', ' ', $field_name)); ?>" id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>" class="form-control  ajax-validation-require datepicker ajax-form-row" readonly value="<?php echo isset($lic_details['issue_date'])? date('d/m/Y', strtotime($lic_details['issue_date'])) : '';?>">
	  		</div>
	    </div>
		<div class="col-6">
	  		<div class="form-group mb-3">
	            <?php $field_name = 'maturity_date'; $max_length = '100'; $validation_type_class = 'alphabets'; $type = 'text'; ?>
	            <label class="font-weight-normal" for="<?php echo $field_name; ?>"><?php echo ucwords(str_replace('_', ' ', $field_name)); ?> <span id="<?php echo 'err_' . $field_name; ?>" class="invalid-feedback small"></span></label>
	            <input type="<?php echo $type; ?>" maxlength="<?php echo $max_length; ?>" data-field-name="<?php echo ucwords(str_replace('_', ' ', $field_name)); ?>" id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>" class="form-control  ajax-validation-require datepicker ajax-form-row" readonly value="<?php echo isset($lic_details['maturity_date'])? date('d/m/Y', strtotime($lic_details['maturity_date'])) : '';?>">
	  		</div>
	    </div>
	    <div class="col-3">
	    	<div class="form-group mb-3">
	            <?php $field_name = 'supporting_document'; $max_length = '100'; $validation_type_class = 'alphabets'; $type = 'text'; ?>
	            <label class="font-weight-normal" for="<?php echo $field_name; ?>"><?php echo ucwords(str_replace('_', ' ', $field_name)); ?> <span id="<?php echo 'err_' . $field_name; ?>" class="invalid-feedback small"></span></label>
              	<input type="file" class="form-control-file ajax-form-row" id="<?php echo $field_name; ?>" data-field-name="<?php echo ucwords(str_replace('_', ' ', $field_name)); ?>" name="<?php echo $field_name; ?>">
            </div>
	    </div>
	    <div class="col-3">
            <label class="font-weight-normal">Uploaded Document </label><br>
            <?php if ($lic_details['supporting_document'] !== '' && $lic_details['supporting_document'] !== NULL && file_exists('./assets/uploads/employee_lic/' . $lic_details['supporting_document'])) { ?>
            	<a class="btn btn-outline-info btn-sm" href="<?php echo site_url('assets/uploads/employee_lic/' . $lic_details['supporting_document']);?>" target="_blank" title="View supporting document"><i class="far fa-file-image"></i></a>
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
	            <button class="btn btn-outline-primary my-2 btn-sm update-employee-ajax-form-data btn-flat" type="submit" form-type="lic"><i class="fa fa-save mr-1"></i> Update</button>
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