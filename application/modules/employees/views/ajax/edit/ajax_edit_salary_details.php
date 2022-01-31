<?php 
$designation = array();
?>
<form method="post" action="#" id="ajax-employee-details-add-form">	
	<div class="row">	
		<div class="col-6">
	  		<div class="form-group mb-3">
	            <?php $field_name = 'designation'; $max_length = '100'; $validation_type_class = 'alphabets'; $type = 'text'; ?>
	            <label class="font-weight-normal" for="<?php echo $field_name; ?>">Designation <span id="<?php echo 'err_' . $field_name; ?>" class="invalid-feedback small"></span></label>
	            <select class="form-control ajax-validation-require ajax-form-row salary-designation" id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>" data-field-name="Designation">
					<option value="">-Designation-</option>
					<?php if(isset($designation_pay_scale)){?>
						<?php foreach($designation_pay_scale as $dps){?>
							<?php if(in_array($dps['designation_id'], $designation)){continue;}else{$designation[] = $dps['designation_id'];}?>
							<option value="<?php echo $dps['designation_id'];?>" <?php echo $salary_details['designation_id'] == $dps['designation_id']? 'selected' : '';?>><?php echo $dps['description'];?></option>
						<?php }?>
					<?php }?>
				</select>
	  		</div>
	    </div>
		<div class="col-6">
	  		<div class="form-group mb-3">
	            <?php $field_name = 'scale_id'; $max_length = '100'; $validation_type_class = 'alphabets'; $type = 'text'; ?>
	            <label class="font-weight-normal" for="<?php echo $field_name; ?>">Scale <span id="<?php echo 'err_' . $field_name; ?>" class="invalid-feedback small"></span></label>
	            <select class="form-control ajax-validation-require ajax-form-row" id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>" data-field-name="Scale">
					<option value="">-Scale-</option>
					<?php if(isset($designation_pay_scale)){?>
						<?php foreach($designation_pay_scale as $dps){?>
							<option value="<?php echo $dps['id'];?>" <?php echo $salary_details['scale_id'] == $dps['id']? 'selected' : '';?> class="scale-options <?php echo 'designation-' . $dps['designation_id'];?> <?php echo $salary_details['designation_id'] == $dps['designation_id']? '' : 'd-none';?>"><?php echo $dps['pay_pattern'] . '(' . $dps['scale_min'] . ' - ' . $dps['scale_max'] . ')';?></option>
						<?php }?>
					<?php }?>
				</select>
	  		</div>
	    </div>
		<div class="col-6">
	  		<div class="form-group mb-3">
	            <?php $field_name = 'basics'; $max_length = '11'; $validation_type_class = 'alphabets'; $type = 'text'; ?>
	            <label class="font-weight-normal" for="<?php echo $field_name; ?>">Basic salary <span id="<?php echo 'err_' . $field_name; ?>" class="invalid-feedback small"></span></label>
	            <input type="<?php echo $type; ?>" maxlength="<?php echo $max_length; ?>" data-field-name="Basic salary" id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>" class="form-control ajax-form-row ajax-validation-require" value="<?php echo isset($salary_details['basics'])? $salary_details['basics'] : '';?>">
	  		</div>
	    </div>	
		<div class="col-6">
	  		<div class="form-group mb-3">
	            <?php $field_name = 'special_pay'; $max_length = '5'; $validation_type_class = 'alphabets'; $type = 'text'; ?>
	            <label class="font-weight-normal" for="<?php echo $field_name; ?>">Special Pay <span id="<?php echo 'err_' . $field_name; ?>" class="invalid-feedback small"></span></label>
	            <input type="<?php echo $type; ?>" maxlength="<?php echo $max_length; ?>" data-field-name="Special Pay" id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>" class="form-control ajax-form-row" value="<?php echo isset($salary_details['special_pay'])? $salary_details['special_pay'] : '';?>">
	  		</div>
	    </div>
		<div class="col-6">
	  		<div class="form-group mb-3">
	            <?php $field_name = 'pay_protection'; $max_length = '100'; $validation_type_class = 'alphabets'; $type = 'text'; ?>
	            <label class="font-weight-normal" for="<?php echo $field_name; ?>"><?php echo ucwords(str_replace('_', ' ', $field_name)); ?> <span id="<?php echo 'err_' . $field_name; ?>" class="invalid-feedback small"></span></label>
	            <input type="<?php echo $type; ?>" maxlength="<?php echo $max_length; ?>" data-field-name="<?php echo ucwords(str_replace('_', ' ', $field_name)); ?>" id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>" class="form-control ajax-form-row" value="<?php echo isset($salary_details['pay_protection'])? $salary_details['pay_protection'] : '';?>">
	  		</div>
	    </div>
		<div class="col-6">
	  		<div class="form-group mb-3">
	            <?php $field_name = 'da_type'; $max_length = '100'; $validation_type_class = 'alphabets'; $type = 'text'; ?>
	            <label class="font-weight-normal" for="<?php echo $field_name; ?>">DA Type <span id="<?php echo 'err_' . $field_name; ?>" class="invalid-feedback small"></span></label>
	            <select class="form-control ajax-validation-require ajax-form-row" id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>" data-field-name="DA Type">
					<option value="">-DA Type-</option>
					<option value="CDA" <?php echo $salary_details['da_type'] == 'CDA'? 'selected' : '';?>>CDA</option>
					<option value="IDA" <?php echo $salary_details['da_type'] == 'IDA'? 'selected' : '';?>>IDA</option>
				</select>
	  		</div>
	    </div>
	</div>
	<hr>
	<div class="row">
	    <div class="col-12">
	    	<div class="text-right">
	            <input type="hidden" name="_ftoken" class="_ftoken" id="_ftoken" value="<?php echo $_ftoken; ?>" />
	            <input type="hidden" name="row-code" class="row-code" id="row-code" value="<?php echo $row_code; ?>" />
	            <input type="hidden" name="data-code" class="data-code" id="data-code" value="<?php echo $employee_id; ?>" />
	            <button class="btn btn-outline-primary my-2 btn-sm update-employee-ajax-form-data btn-flat" type="submit" form-type="salary"><i class="fa fa-save mr-1"></i> Update</button>
	        </div>
	    </div>
	</div>
</form>