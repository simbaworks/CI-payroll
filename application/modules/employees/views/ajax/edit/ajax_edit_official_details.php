<form method="post" action="#" id="ajax-employee-details-add-form">	
	<div class="row">
		<div class="col-6">
	  		<div class="form-group mb-3">
	            <?php $field_name = 'center_id'; $max_length = '100'; $validation_type_class = 'alphabets'; $type = 'text'; ?>
	            <label class="font-weight-normal" for="<?php echo $field_name; ?>">Posting <span id="<?php echo 'err_' . $field_name; ?>" class="invalid-feedback small"></span></label>
	            <select class="form-control ajax-form-row" id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>" data-field-name="Posting">
					<option value="">-Location-</option>
					<?php if(isset($centre_details)){?>
						<?php foreach($centre_details as $cd){?>
							<option value="<?php echo $cd['id'];?>" <?php echo $official_details['loc_code'] == $cd['id']? 'selected' : '';?>><?php echo base64_decode($cd['centre_name']) . ' - ' . base64_decode($cd['centre_type_name']) . '(' . base64_decode($cd['ro_name']) . ')';?></option>
						<?php }?>
					<?php }?>
				</select>
	  		</div>
	    </div>
		<div class="col-6">
	  		<div class="form-group mb-3">
	            <?php $field_name = 'employee_type_id'; $max_length = '100'; $validation_type_class = 'alphabets'; $type = 'text'; ?>
	            <label class="font-weight-normal" for="<?php echo $field_name; ?>">Employee Type <span id="<?php echo 'err_' . $field_name; ?>" class="invalid-feedback small"></span></label>
	            <select class="form-control ajax-validation-require ajax-form-row" id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>" data-field-name="Employee Type">
					<option value="">-Employee Type-</option>
					<?php if(isset($employee_types)){?>
						<?php foreach($employee_types as $et){?>
							<option value="<?php echo $et['id'];?>" <?php echo $official_details['employee_type_id'] == $et['id']? 'selected' : '';?>><?php echo base64_decode($et['type_name']);?></option>
						<?php }?>
					<?php }?>
				</select>
	  		</div>
	    </div>
		<div class="col-12">
	  		<div class="form-group mb-3 esic-div <?php echo isset($official_details['employee_type_id']) && $official_details['employee_type_id'] == '3'? '' : 'd-none';?>">
	            <?php $field_name = 'esic_number'; $max_length = '11'; $validation_type_class = 'alphabets'; $type = 'text'; ?>
	            <label class="font-weight-normal" for="<?php echo $field_name; ?>">ESIC Number <span id="<?php echo 'err_' . $field_name; ?>" class="invalid-feedback small"></span></label>
	            <input type="<?php echo $type; ?>" maxlength="<?php echo $max_length; ?>" data-field-name="ESIC Number" id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>" class="form-control ajax-validation-require ajax-form-row  <?php echo isset($official_details['employee_type_id']) && $official_details['employee_type_id'] == '3'? '' : 'd-none';?>" value="<?php echo isset($official_details['esic_number'])? $official_details['esic_number'] : '';?>">
	  		</div>
	    </div>
	</div>
	<div class="row">
		<div class="col-6">
	  		<div class="form-group mb-3">
	            <?php $field_name = 'department_id'; $max_length = '100'; $validation_type_class = 'alphabets'; $type = 'text'; ?>
	            <label class="font-weight-normal" for="<?php echo $field_name; ?>">Department <span id="<?php echo 'err_' . $field_name; ?>" class="invalid-feedback small"></span></label>
	            <select class="form-control ajax-validation-require ajax-form-row" id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>" data-field-name="Department">
					<option value="">-Department-</option>
					<?php if(isset($department_master)){?>
						<?php foreach($department_master as $dm){?>
							<option value="<?php echo $dm['id'];?>" <?php echo $official_details['deptt_code'] == $dm['id']? 'selected' : '';?>><?php echo $dm['name'];?></option>
						<?php }?>
					<?php }?>
				</select>
	  		</div>
	    </div>
		<div class="col-6">
	  		<div class="form-group mb-3">
	            <?php $field_name = 'designation_id'; $max_length = '100'; $validation_type_class = 'alphabets'; $type = 'text'; ?>
	            <label class="font-weight-normal" for="<?php echo $field_name; ?>">Designation <span id="<?php echo 'err_' . $field_name; ?>" class="invalid-feedback small"></span></label>
	            <select class="form-control ajax-validation-require ajax-form-row" id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>" data-field-name="Designation">
					<option value="">-Designation-</option>
					<?php if(isset($designation_master)){?>
						<?php foreach($designation_master as $designation){?>
							<option value="<?php echo $designation['id'];?>" <?php echo $official_details['desgn_code'] == $designation['id']? 'selected' : '';?>><?php echo $designation['description'] . '(' . $designation['type'] . ') - ' . $designation['shortname'];?></option>
						<?php }?>
					<?php }?>
				</select>
	  		</div>
	    </div>
		<div class="col-6">
	  		<div class="form-group mb-3">
	            <?php $field_name = 'reporting_officer_id'; $max_length = '100'; $validation_type_class = 'alphabets'; $type = 'text'; ?>
	            <label class="font-weight-normal" for="<?php echo $field_name; ?>">Reporting Officer <span id="<?php echo 'err_' . $field_name; ?>" class="invalid-feedback small"></span></label>
	            <select class="form-control ajax-form-row" id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>" data-field-name="Reporting Officer">
					<option value="">-Reporting Officer-</option>
					<?php if(isset($employees)){?>
						<?php foreach($employees as $ro){?>
							<option value="<?php echo $ro['id'];?>" <?php echo $official_details['rep_emp_id'] == $ro['id']? 'selected' : '';?>><?php echo base64_decode($ro['emp_name']);?></option>
						<?php }?>
					<?php }?>
				</select>
	  		</div>
	    </div>
		<div class="col-6">
	  		<div class="form-group mb-3">
	            <?php $field_name = 'alternate_reporting_officer_id'; $max_length = '100'; $validation_type_class = 'alphabets'; $type = 'text'; ?>
	            <label class="font-weight-normal" for="<?php echo $field_name; ?>">Alternate-reporting Officer <span id="<?php echo 'err_' . $field_name; ?>" class="invalid-feedback small"></span></label>
	            <select class="form-control ajax-form-row" id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>" data-field-name="Alternate-reporting Officer">
					<option value="">-Alternate-reporting Officer-</option>
					<?php if(isset($employees)){?>
						<?php foreach($employees as $ro){?>
							<option value="<?php echo $ro['id'];?>" <?php echo $official_details['alternate_reporting_officer_id'] == $ro['id']? 'selected' : '';?>><?php echo base64_decode($ro['emp_name']);?></option>
						<?php }?>
					<?php }?>
				</select>
	  		</div>
	    </div>
		<div class="col-6">
	  		<div class="form-group mb-3">
	            <?php $field_name = 'reviewing_officer_id'; $max_length = '100'; $validation_type_class = 'alphabets'; $type = 'text'; ?>
	            <label class="font-weight-normal" for="<?php echo $field_name; ?>">Reviewing Officer <span id="<?php echo 'err_' . $field_name; ?>" class="invalid-feedback small"></span></label>
	            <select class="form-control ajax-form-row" id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>" data-field-name="Reviewing Officer">
					<option value="">-Reviewing Officer-</option>
					<?php if(isset($employees)){?>
						<?php foreach($employees as $ro){?>
							<option value="<?php echo $ro['id'];?>" <?php echo $official_details['reviewing_officer_id'] == $ro['id']? 'selected' : '';?>><?php echo base64_decode($ro['emp_name']);?></option>
						<?php }?>
					<?php }?>
				</select>
	  		</div>
	    </div>
		<div class="col-6">
	  		<div class="form-group mb-3">
	            <?php $field_name = 'acceptance_officer_id'; $max_length = '100'; $validation_type_class = 'alphabets'; $type = 'text'; ?>
	            <label class="font-weight-normal" for="<?php echo $field_name; ?>">Acceptance Officer <span id="<?php echo 'err_' . $field_name; ?>" class="invalid-feedback small"></span></label>
	            <select class="form-control ajax-form-row" id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>" data-field-name="Acceptance Officer">
					<option value="">-Acceptance Officer-</option>
					<?php if(isset($employees)){?>
						<?php foreach($employees as $ro){?>
							<option value="<?php echo $ro['id'];?>" <?php echo $official_details['acceptance_officer_id'] == $ro['id']? 'selected' : '';?>><?php echo base64_decode($ro['emp_name']);?></option>
						<?php }?>
					<?php }?>
				</select>
	  		</div>
	    </div>
		<div class="col-6">
	  		<div class="form-group mb-3">
	            <?php $field_name = 'service_book_no'; $max_length = '11'; $validation_type_class = 'alphabets'; $type = 'text'; ?>
	            <label class="font-weight-normal" for="<?php echo $field_name; ?>">Service Book Number <span id="<?php echo 'err_' . $field_name; ?>" class="invalid-feedback small"></span></label>
	            <input type="<?php echo $type; ?>" maxlength="<?php echo $max_length; ?>" data-field-name="Service Book Number" id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>" class="form-control ajax-form-row" value="<?php echo isset($official_details['service_book_no'])? $official_details['service_book_no'] : '';?>">
	  		</div>
	    </div>
		<!-- <div class="col-6">
	  		<div class="form-group mb-3">
	            <?php $field_name = 'pension_acc_no'; $max_length = '18'; $validation_type_class = 'alphabets'; $type = 'number'; ?>
	            <label class="font-weight-normal" for="<?php echo $field_name; ?>">Pension Account Number <span id="<?php echo 'err_' . $field_name; ?>" class="invalid-feedback small"></span></label>
	            <input type="<?php echo $type; ?>" maxlength="<?php echo $max_length; ?>" data-field-name="Pension Account Number" id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>" class="form-control ajax-validation-require ajax-form-row" value="<?php echo isset($official_details['pension_acc_no'])? base64_decode($official_details['pension_acc_no']) : '';?>">
	  		</div>
	    </div> -->
		<div class="col-6">
	  		<div class="form-group mb-3">
	            <?php $field_name = 'co_opp_acc_no'; $max_length = '18'; $validation_type_class = 'alphabets'; $type = 'number'; ?>
	            <label class="font-weight-normal" for="<?php echo $field_name; ?>">Co-Opp Account Number <span id="<?php echo 'err_' . $field_name; ?>" class="invalid-feedback small"></span></label>
	            <input type="<?php echo $type; ?>" maxlength="<?php echo $max_length; ?>" data-field-name="Co-Opp Account Number" id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>" class="form-control ajax-validation-require ajax-form-row" value="<?php echo isset($official_details['co_opp_acc_no'])? base64_decode($official_details['co_opp_acc_no']) : '';?>">
	  		</div>
	    </div>
		<!-- <div class="col-6">
	  		<div class="form-group mb-3">
	            <?php $field_name = 'union_id'; $max_length = '100'; $validation_type_class = 'alphabets'; $type = 'text'; ?>
	            <label class="font-weight-normal" for="<?php echo $field_name; ?>">Union <span id="<?php echo 'err_' . $field_name; ?>" class="invalid-feedback small"></span></label>
	            <select class="form-control ajax-validation-require ajax-form-row" id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>" data-field-name="Union">
					<option value="">-Union-</option>
					<?php if(isset($unions)){?>
						<?php foreach($unions as $value){?>
							<option value="<?php echo $value['id'];?>" <?php echo $official_details['union_id'] == $value['id']? 'selected' : '';?>><?php echo base64_decode($value['union_name']);?></option>
						<?php }?>
					<?php }?>
				</select>
	  		</div>
	    </div> -->
		<div class="col-6">
	  		<div class="form-group mb-3">
	            <?php $field_name = 'date_of_effect'; $max_length = '200'; $validation_type_class = 'alphabets'; $type = 'text'; ?>
	            <label class="font-weight-normal" for="<?php echo $field_name; ?>"><?php echo ucwords(str_replace('_', ' ', $field_name)); ?> <span id="<?php echo 'err_' . $field_name; ?>" class="invalid-feedback small"></span></label>
	            <input type="<?php echo $type; ?>" maxlength="<?php echo $max_length; ?>" data-field-name="<?php echo ucwords(str_replace('_', ' ', $field_name)); ?>" id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>" class="form-control ajax-validation-require datepicker" readonly value="<?php echo isset($official_details['date_of_effect'])? date('d/m/Y', strtotime($official_details['date_of_effect'])) : '';?>">
	  		</div>
	    </div>
	</div>
	<hr>
	<div class="row">
	    <div class="col-12">
	    	<div class=" text-right">
	            <input type="hidden" name="_ftoken" class="_ftoken" id="_ftoken" value="<?php echo $_ftoken; ?>" />
	            <input type="hidden" name="row-code" class="row-code" id="row-code" value="<?php echo $row_code; ?>" />
	            <input type="hidden" name="data-code" class="data-code" id="data-code" value="<?php echo $employee_id; ?>" />
	            <button class="btn btn-outline-primary my-2 btn-sm update-employee-ajax-form-data btn-flat" type="submit" form-type="official"><i class="fa fa-save mr-1"></i> Update</button>
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