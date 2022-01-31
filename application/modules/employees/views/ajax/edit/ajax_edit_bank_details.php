<form method="post" action="#" id="ajax-employee-details-add-form">	
	<div class="row">	
		<div class="col-6">
	  		<div class="form-group mb-3">
	            <?php $field_name = 'bank_ifsc'; $max_length = '11'; $validation_type_class = 'alphabets'; $type = 'text'; ?>
	            <label class="font-weight-normal" for="<?php echo $field_name; ?>">IFSC Code <span id="<?php echo 'err_' . $field_name; ?>" class="invalid-feedback small"></span></label>
	            <input type="<?php echo $type; ?>" maxlength="<?php echo $max_length; ?>" data-field-name="IFSC Code" id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>" class="form-control ajax-form-row ajax-validation-require" value="<?php echo isset($bank_details['bank_ifsc'])? base64_decode($bank_details['bank_ifsc']) : '';?>">
	  		</div>
	    </div>	
		<div class="col-6">
	  		<div class="form-group mb-3">
	            <?php $field_name = 'bank_name'; $max_length = '5'; $validation_type_class = 'alphabets'; $type = 'text'; ?>
	            <label class="font-weight-normal" for="<?php echo $field_name; ?>">Bank <span id="<?php echo 'err_' . $field_name; ?>" class="invalid-feedback small"></span></label>
	            <input type="<?php echo $type; ?>" maxlength="<?php echo $max_length; ?>" data-field-name="Bank Name" id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>" class="form-control ajax-form-row ajax-validation-require" value="<?php echo isset($bank_details['bank_name'])? base64_decode($bank_details['bank_name']) : '';?>">
	  		</div>
	    </div>
		<div class="col-6">
	  		<div class="form-group mb-3">
	            <?php $field_name = 'bank_branch'; $max_length = '100'; $validation_type_class = 'alphabets'; $type = 'text'; ?>
	            <label class="font-weight-normal" for="<?php echo $field_name; ?>">Branch Name <span id="<?php echo 'err_' . $field_name; ?>" class="invalid-feedback small"></span></label>
	            <input type="<?php echo $type; ?>" maxlength="<?php echo $max_length; ?>" data-field-name="Branch Name" id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>" class="form-control ajax-form-row ajax-validation-require" value="<?php echo isset($bank_details['bank_branch'])? base64_decode($bank_details['bank_branch']) : '';?>">
	  		</div>
	    </div>
		<div class="col-6">
	  		<div class="form-group mb-3">
	            <?php $field_name = 'bank_acc_no'; $max_length = '100'; $validation_type_class = 'alphabets'; $type = 'text'; ?>
	            <label class="font-weight-normal" for="<?php echo $field_name; ?>">Account Number <span id="<?php echo 'err_' . $field_name; ?>" class="invalid-feedback small"></span></label>
	            <input type="<?php echo $type; ?>" maxlength="<?php echo $max_length; ?>" data-field-name="Account Number" id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>" class="form-control ajax-form-row ajax-validation-require" value="<?php echo isset($bank_details['bank_acc_no'])? base64_decode($bank_details['bank_acc_no']) : '';?>">
	  		</div>
	    </div>
		<div class="col-6">
	  		<div class="form-group mb-3">
	            <?php $field_name = 'bank_acc_type'; $max_length = '100'; $validation_type_class = 'alphabets'; $type = 'text'; ?>
	            <label class="font-weight-normal" for="<?php echo $field_name; ?>">Account Type <span id="<?php echo 'err_' . $field_name; ?>" class="invalid-feedback small"></span></label>
	            <select class="form-control ajax-validation-require ajax-form-row" id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>" data-field-name="<?php echo ucwords(str_replace('_', ' ', $field_name)); ?>">
					<option value="savings_account" <?php echo base64_decode($bank_details['bank_acc_type']) == 'savings_account'? 'selected' : '';?>>Savings Account</option>
					<option value="current_account" <?php echo base64_decode($bank_details['bank_acc_type']) == 'current_account'? 'selected' : '';?>>Current Account</option>
				</select>
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
            <?php if ($bank_details['supporting_document'] !== '' && $bank_details['supporting_document'] !== NULL && file_exists('./assets/uploads/employee_bank_details/' . $bank_details['supporting_document'])) { ?>
            	<a class="btn btn-outline-info btn-sm" href="<?php echo site_url('assets/uploads/employee_bank_details/' . $bank_details['supporting_document']);?>" target="_blank" title="View supporting document"><i class="far fa-file-image"></i></a>
            <?php }?>
        </div>
	</div>
	<div class="col-6">
  		<div class="form-group mb-3">
            <?php $field_name = 'account_purposes'; $max_length = '100'; $validation_type_class = 'alphabets'; $type = 'text'; ?>
            <label class="font-weight-normal" for="<?php echo $field_name; ?>"><?php echo ucwords(str_replace('_', ' ', $field_name)); ?> <span id="<?php echo 'err_' . $field_name; ?>" class="invalid-feedback small"></span></label>
            <select class="form-control ajax-validation-require ajax-form-row" id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>" data-field-name="<?php echo ucwords(str_replace('_', ' ', $field_name)); ?>">
				<option value="salary" <?php echo base64_decode($bank_details['account_purposes']) == 'salary'? 'selected' : '';?>>Salary</option>
				<option value="other" <?php echo base64_decode($bank_details['account_purposes']) == 'other'? 'selected' : '';?>>Other</option>
			</select>
  		</div>
    </div>
	<hr>
	<div class="row">
	    <div class="col-12">
	    	<div class=" text-right">
	            <input type="hidden" name="_ftoken" class="_ftoken" id="_ftoken" value="<?php echo $_ftoken; ?>" />
	            <input type="hidden" name="row-code" class="row-code" id="row-code" value="<?php echo $row_code; ?>" />
	            <input type="hidden" name="data-code" class="data-code" id="data-code" value="<?php echo $employee_id; ?>" />
	            <button class="btn btn-outline-primary my-2 btn-sm update-employee-ajax-form-data btn-flat" type="submit" form-type="bank"><i class="fa fa-save mr-1"></i> Update</button>
	        </div>
	    </div>
	</div>
</form>