<form method="post" action="<?php echo site_url($controller . '/edit/' . base64_encode($employee_details['id']));?>" id="ajax-employee-personal-details-form" enctype='multipart/form-data' onsubmit="return employee_form_validation();">
	<div class="row">
		<div class="col-4">
	  		<div class="form-group mb-3">
	            <?php $field_name = 'name'; $max_length = '200'; $validation_type_class = 'alphabets'; $type = 'text'; ?>
	            <label class="font-weight-normal" for="<?php echo $field_name; ?>"><?php echo ucwords(str_replace('_', ' ', $field_name)); ?> <span id="<?php echo 'err_' . $field_name; ?>" class="invalid-feedback small"></span></label>
	            <input type="<?php echo $type; ?>" maxlength="<?php echo $max_length; ?>" data-field-name="<?php echo ucwords(str_replace('_', ' ', $field_name)); ?>" id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>" class="form-control  validation-require" value="<?php echo base64_decode($employee_details['emp_name']);?>">
	  		</div>
	    </div>
		<div class="col-4">
	  		<div class="form-group mb-3">
	            <?php $field_name = 'dob'; $max_length = '200'; $validation_type_class = 'alphabets'; $type = 'text'; ?>
	            <label class="font-weight-normal" for="<?php echo $field_name; ?>"><?php echo ucwords(str_replace('_', ' ', $field_name)); ?> <span id="<?php echo 'err_' . $field_name; ?>" class="invalid-feedback small"></span></label>
	            <input type="<?php echo $type; ?>" maxlength="<?php echo $max_length; ?>" data-field-name="<?php echo ucwords(str_replace('_', ' ', $field_name)); ?>" id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>" class="form-control  validation-require date_picker datepicker" value="<?php echo isset($employee_details['date_of_birth'])? date('d/m/Y', strtotime($employee_details['date_of_birth'])) : '';?>" readonly>
	  		</div>
	    </div>
		<div class="col-4">
	  		<div class="form-group mb-3">
	            <?php $field_name = 'gender_id'; $max_length = '200'; $validation_type_class = 'alphabets'; $type = 'text'; ?>
	            <label class="font-weight-normal" for="<?php echo $field_name; ?>">Gender <span id="<?php echo 'err_' . $field_name; ?>" class="invalid-feedback small"></span></label>
				<select class="form-control validation-require " id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>" data-field-name="Gender">
					<option value="">-Gender-</option>
					<option value="1" <?php echo $employee_details['emp_gender_id'] == '1'? 'selected' : '';?>>Male</option>
					<option value="2" <?php echo $employee_details['emp_gender_id'] == '2'? 'selected' : '';?>>Female</option>
					<option value="3" <?php echo $employee_details['emp_gender_id'] == '3'? 'selected' : '';?>>Transgender</option>
				</select>
	  		</div>
	    </div>
		<div class="col-4">
	  		<div class="form-group mb-3">
	            <?php $field_name = 'father_name'; $max_length = '200'; $validation_type_class = 'alphabets'; $type = 'text'; ?>
	            <label class="font-weight-normal" for="<?php echo $field_name; ?>"><?php echo ucwords(str_replace('_', ' ', $field_name)); ?> <span id="<?php echo 'err_' . $field_name; ?>" class="invalid-feedback small"></span></label>
	            <input type="<?php echo $type; ?>" maxlength="<?php echo $max_length; ?>" data-field-name="<?php echo ucwords(str_replace('_', ' ', $field_name)); ?>" id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>" class="form-control  validation-require" value="<?php echo base64_decode($employee_details['emp_father']);?>">
	  		</div>
	    </div>
		<div class="col-4">
	  		<div class="form-group mb-3">
	            <?php $field_name = 'mother_name'; $max_length = '200'; $validation_type_class = 'alphabets'; $type = 'text'; ?>
	            <label class="font-weight-normal" for="<?php echo $field_name; ?>"><?php echo ucwords(str_replace('_', ' ', $field_name)); ?> <span id="<?php echo 'err_' . $field_name; ?>" class="invalid-feedback small"></span></label>
	            <input type="<?php echo $type; ?>" maxlength="<?php echo $max_length; ?>" data-field-name="<?php echo ucwords(str_replace('_', ' ', $field_name)); ?>" id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>" class="form-control  validation-require" value="<?php echo base64_decode($employee_details['emp_mother']);?>">
	  		</div>
	    </div>
		<div class="col-4">
	  		<div class="form-group mb-3">
	            <?php $field_name = 'marital_status_id'; $max_length = '200'; $validation_type_class = 'alphabets'; $type = 'text'; ?>
	            <label class="font-weight-normal" for="<?php echo $field_name; ?>">Marital Status <span id="<?php echo 'err_' . $field_name; ?>" class="invalid-feedback small"></span></label>
				<select class="form-control validation-require " id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>" data-field-name="Marital Status">
					<option value="">-Marital Status-</option>
					<?php if(isset($marital_status)){?>
						<?php foreach($marital_status as $ms){?>
							<option value="<?php echo $ms['id'];?>" <?php echo $employee_details['emp_mar_status'] == $ms['id']? 'selected' : '';?>><?php echo base64_decode($ms['marital_status']);?></option>
						<?php }?>
					<?php }?>
				</select>
	  		</div>
	    </div>
		<!-- <div class="col-4 spouse-name-div <?php echo isset($employee_details['emp_mar_status']) && $employee_details['emp_mar_status'] == '2'? '' : 'd-none';?>">
	  		<div class="form-group mb-3">
	            <?php $field_name = 'spouse_name'; $max_length = '200'; $validation_type_class = 'alphabets'; $type = 'text'; ?>
	            <label class="font-weight-normal" for="<?php echo $field_name; ?>"><?php echo ucwords(str_replace('_', ' ', $field_name)); ?> <span id="<?php echo 'err_' . $field_name; ?>" class="invalid-feedback small"></span></label>
	            <input type="<?php echo $type; ?>" maxlength="<?php echo $max_length; ?>" data-field-name="<?php echo ucwords(str_replace('_', ' ', $field_name)); ?>" id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>" class="form-control validation-require <?php echo isset($employee_details['emp_mar_status']) && $employee_details['emp_mar_status'] == '2'? '' : 'd-none';?>" value="<?php echo base64_decode($employee_details['emp_spouse']);?>">
	  		</div>
	    </div>
	    <div class="col-4 marriage-certificate-div <?php echo isset($employee_details['emp_mar_status']) && $employee_details['emp_mar_status'] == '2'? '' : 'd-none';?>">
	    	<div class="form-group mb-3">
	            <?php $field_name = 'marriage_certificate'; $max_length = '100'; $validation_type_class = 'alphabets'; $type = 'text'; ?>
	            <label class="font-weight-normal" for="<?php echo $field_name; ?>"><?php echo ucwords(str_replace('_', ' ', $field_name)); ?> <span id="<?php echo 'err_' . $field_name; ?>" class="invalid-feedback small"></span></label>
              	<input type="file" class="form-control-file <?php echo isset($employee_details['emp_mar_status']) && $employee_details['emp_mar_status'] == '2'? '' : 'd-none';?>" id="<?php echo $field_name; ?>" data-field-name="<?php echo ucwords(str_replace('_', ' ', $field_name)); ?>" name="<?php echo $field_name; ?>">
            </div>
	    </div>
	    <div class="col-4 marriage-certificate-file-div <?php echo isset($employee_details['emp_mar_status']) && $employee_details['emp_mar_status'] == '2'? '' : 'd-none';?>">
            <label class="font-weight-normal">Uploaded Document </label><br>
            <?php if ($employee_details['marriage_certificate'] !== '' && $employee_details['marriage_certificate'] !== NULL && file_exists('./assets/uploads/marriage_certificates/' . $employee_details['marriage_certificate'])) { ?>
            	<a class="btn btn-outline-info btn-sm" href="<?php echo site_url('assets/uploads/marriage_certificates/' . $employee_details['marriage_certificate']);?>" target="_blank" title="View supporting document"><i class="far fa-file-image"></i></a>
            <?php }?>
        </div> -->
	</div>
	<hr>	
	<div class="row">
		<div class="col-6">
	  		<div class="form-group mb-3">
	            <?php $field_name = 'emp_id'; $max_length = '200'; $validation_type_class = 'alphabets'; $type = 'text'; ?>
	            <label class="font-weight-normal" for="<?php echo $field_name; ?>">Employee Id <span id="<?php echo 'err_' . $field_name; ?>" class="invalid-feedback small"></span></label>
	            <input type="<?php echo $type; ?>" maxlength="<?php echo $max_length; ?>" data-field-name="Employee Id" id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>" class="form-control  validation-require" value="<?php echo base64_decode($employee_details[$field_name]);?>">
	  		</div>
	    </div>
		<div class="col-6">
	  		<div class="form-group mb-3">
	            <?php $field_name = 'date_of_joining'; $max_length = '200'; $validation_type_class = 'alphabets'; $type = 'text'; ?>
	            <label class="font-weight-normal" for="<?php echo $field_name; ?>"><?php echo ucwords(str_replace('_', ' ', $field_name)); ?> <span id="<?php echo 'err_' . $field_name; ?>" class="invalid-feedback small"></span></label>
	            <input type="<?php echo $type; ?>" maxlength="<?php echo $max_length; ?>" data-field-name="<?php echo ucwords(str_replace('_', ' ', $field_name)); ?>" id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>" class="form-control  validation-require datepicker" readonly value="<?php echo isset($employee_details['emp_doj'])? date('d/m/Y', strtotime($employee_details['emp_doj'])) : '';?>">
	  		</div>
	    </div>
	</div>
	<hr>
	<div class="row">
		<div class="col-4">
	  		<div class="form-group mb-3">
	            <?php $field_name = 'religion_id'; $max_length = '200'; $validation_type_class = 'alphabets'; $type = 'text'; ?>
	            <label class="font-weight-normal" for="<?php echo $field_name; ?>">Religion <span id="<?php echo 'err_' . $field_name; ?>" class="invalid-feedback small"></span></label>
				<select class="form-control validation-require " id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>" data-field-name="Religion">
					<option value="">-Religion-</option>
					<?php if(isset($religion)){?>
						<?php foreach($religion as $rlgn){?>
							<option value="<?php echo $rlgn['id'];?>" <?php echo $employee_details['emp_religion_id'] == $rlgn['id']? 'selected' : '';?>><?php echo base64_decode($rlgn['religion_name']);?></option>
						<?php }?>
					<?php }?>
				</select>
			</div>
		</div>
		<div class="col-4">
	  		<div class="form-group mb-3">
	            <?php $field_name = 'caste_id'; $max_length = '200'; $validation_type_class = 'alphabets'; $type = 'text'; ?>
	            <label class="font-weight-normal" for="<?php echo $field_name; ?>">Caste <span id="<?php echo 'err_' . $field_name; ?>" class="invalid-feedback small"></span></label>
				<select class="form-control validation-require " id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>" data-field-name="Caste">
					<option value="">-Caste-</option>
					<?php if(isset($caste)){?>
						<?php foreach($caste as $ct){?>
							<option value="<?php echo $ct['id'];?>" <?php echo $employee_details['emp_caste_id'] == $ct['id']? 'selected' : '';?>><?php echo base64_decode($ct['caste_name']);?></option>
						<?php }?>
					<?php }?>
				</select>
			</div>
		</div>
	    <div class="col-2 caste-certificate-div <?php echo isset($employee_details['emp_caste_id']) && $employee_details['emp_caste_id'] !== '1'? '' : 'd-none';?>">
	    	<div class="form-group mb-3">
	            <?php $field_name = 'caste_certificate'; $max_length = '100'; $validation_type_class = 'alphabets'; $type = 'text'; ?>
	            <label class="font-weight-normal" for="<?php echo $field_name; ?>"><?php echo ucwords(str_replace('_', ' ', $field_name)); ?> <span id="<?php echo 'err_' . $field_name; ?>" class="invalid-feedback small"></span></label>
              	<input type="file" class="form-control-file <?php echo isset($employee_details['emp_caste_id']) && $employee_details['emp_caste_id'] !== '1'? '' : 'validation-require d-none';?> " id="<?php echo $field_name; ?>" data-field-name="<?php echo ucwords(str_replace('_', ' ', $field_name)); ?>" name="<?php echo $field_name; ?>">
            </div>
	    </div>
	    <div class="col-2 caste-certificate-file-div <?php echo isset($employee_details['emp_caste_id']) && $employee_details['emp_caste_id'] !== '1'? '' : 'd-none';?>">
            <label class="font-weight-normal">Uploaded Document </label><br>
            <?php if ($employee_details['caste_certificate'] !== '' && $employee_details['caste_certificate'] !== NULL && file_exists('./assets/uploads/caste_certificates/' . $employee_details['caste_certificate'])) { ?>
            	<a class="btn btn-outline-info btn-sm" href="<?php echo site_url('assets/uploads/caste_certificates/' . $employee_details['caste_certificate']);?>" target="_blank" title="View supporting document"><i class="far fa-file-image"></i></a>
            <?php }?>
        </div>
		<!-- <div class="col-4">
	  		<div class="form-group mb-3">
	            <?php $field_name = 'nationality'; $max_length = '200'; $validation_type_class = 'alphabets'; $type = 'text'; ?>
	            <label class="font-weight-normal" for="<?php echo $field_name; ?>"><?php echo ucwords(str_replace('_', ' ', $field_name)); ?> <span id="<?php echo 'err_' . $field_name; ?>" class="invalid-feedback small"></span></label>
	            <input type="<?php echo $type; ?>" maxlength="<?php echo $max_length; ?>" data-field-name="<?php echo ucwords(str_replace('_', ' ', $field_name)); ?>" id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>" class="form-control  validation-require" value="<?php echo base64_decode($employee_details[$field_name]);?>">
	  		</div>
	    </div> -->
	</div>
	<hr>
	<div class="row">
		<div class="col-4">
	  		<div class="form-group mb-3">
	            <?php $field_name = 'blood_group_id'; $max_length = '200'; $validation_type_class = 'alphabets'; $type = 'text'; ?>
	            <label class="font-weight-normal" for="<?php echo $field_name; ?>">Blood Group <span id="<?php echo 'err_' . $field_name; ?>" class="invalid-feedback small"></span></label>
				<select class="form-control validation-require " id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>" data-field-name="Blood Group">
					<option value="">-Blood Group-</option>
					<?php if(isset($blood_groups)){?>
						<?php foreach($blood_groups as $bg){?>
							<option value="<?php echo $bg['id'];?>" <?php echo $employee_details['emp_blood_group'] == $bg['id']? 'selected' : '';?>><?php echo base64_decode($bg['group_name']);?></option>
						<?php }?>
					<?php }?>
				</select>
			</div>
		</div>
	    <div class="col-2">
	    	<div class="form-group mb-3">
	            <?php $field_name = 'blood_certificate'; $max_length = '100'; $validation_type_class = 'alphabets'; $type = 'text'; ?>
	            <label class="font-weight-normal" for="<?php echo $field_name; ?>"><?php echo ucwords(str_replace('_', ' ', $field_name)); ?> <span id="<?php echo 'err_' . $field_name; ?>" class="invalid-feedback small"></span></label>
              	<input type="file" class="form-control-file " id="<?php echo $field_name; ?>" data-field-name="<?php echo ucwords(str_replace('_', ' ', $field_name)); ?>" name="<?php echo $field_name; ?>">
            </div>
	    </div>
	    <div class="col-2">
            <label class="font-weight-normal">Uploaded Document </label><br>
            <?php if ($employee_details['blood_certificate'] !== '' && $employee_details['blood_certificate'] !== NULL && file_exists('./assets/uploads/blood_certificates/' . $employee_details['blood_certificate'])) { ?>
            	<a class="btn btn-outline-info btn-sm" href="<?php echo site_url('assets/uploads/blood_certificates/' . $employee_details['blood_certificate']);?>" target="_blank" title="View supporting document"><i class="far fa-file-image"></i></a>
            <?php }?>
        </div>
		<div class="col-4">
	  		<div class="form-group mb-3">
	            <?php $field_name = 'identification_mark'; $max_length = '200'; $validation_type_class = 'alphabets'; $type = 'text'; ?>
	            <label class="font-weight-normal" for="<?php echo $field_name; ?>"><?php echo ucwords(str_replace('_', ' ', $field_name)); ?> <span id="<?php echo 'err_' . $field_name; ?>" class="invalid-feedback small"></span></label>
	            <input type="<?php echo $type; ?>" maxlength="<?php echo $max_length; ?>" data-field-name="<?php echo ucwords(str_replace('_', ' ', $field_name)); ?>" id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>" class="form-control" value="<?php echo base64_decode($employee_details['emp_identification_mark']);?>">
	  		</div>
	    </div>
	    <div class="col-12">
	    	<div class="form-check mt-4 pt-2 mb-3">
	            <?php $field_name = 'is_disabled'; $max_length = '200'; $validation_type_class = 'alphabets'; $type = 'text'; ?>
			    <input type="checkbox" class="form-check-input" value="1" data-field-name="<?php echo ucwords(str_replace('_', ' ', $field_name)); ?>" id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>" <?php echo $employee_details['emp_pwd_status'] == '1'? 'checked' : '';?>>
			    <label class="form-check-label mr-3" for="exampleCheck1">Is Disabled</label>
			</div>
	    </div>
	</div>
	<hr>
	<div class="row">
		<div class="col-4">
	  		<div class="form-group mb-3">
	            <?php $field_name = 'contact_email'; $max_length = '200'; $validation_type_class = 'alphabets'; $type = 'text'; ?>
	            <label class="font-weight-normal" for="<?php echo $field_name; ?>"><?php echo ucwords(str_replace('_', ' ', $field_name)); ?> <span id="<?php echo 'err_' . $field_name; ?>" class="invalid-feedback small"></span></label>
	            <input type="<?php echo $type; ?>" maxlength="<?php echo $max_length; ?>" data-field-name="<?php echo ucwords(str_replace('_', ' ', $field_name)); ?>" id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>" class="form-control  validation-require" value="<?php echo base64_decode($employee_details['emp_email']);?>">
	  		</div>
	    </div>
		<div class="col-4">
	  		<div class="form-group mb-3">
	            <?php $field_name = 'contact_phone'; $max_length = '200'; $validation_type_class = 'alphabets'; $type = 'text'; ?>
	            <label class="font-weight-normal" for="<?php echo $field_name; ?>">Contact No <span id="<?php echo 'err_' . $field_name; ?>" class="invalid-feedback small"></span></label>
	            <input type="<?php echo $type; ?>" maxlength="<?php echo $max_length; ?>" data-field-name="Contact No" id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>" class="form-control  validation-require" value="<?php echo base64_decode($employee_details['emp_mobile']);?>">
	  		</div>
	    </div>
		<div class="col-4">
	  		<div class="form-group mb-3">
	            <?php $field_name = 'alternate_contact'; $max_length = '200'; $validation_type_class = 'alphabets'; $type = 'text'; ?>
	            <label class="font-weight-normal" for="<?php echo $field_name; ?>">Emergency contact number <span id="<?php echo 'err_' . $field_name; ?>" class="invalid-feedback small"></span></label>
	            <input type="<?php echo $type; ?>" maxlength="<?php echo $max_length; ?>" data-field-name="Emergency contact number" id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>" class="form-control  validation-require" value="<?php echo base64_decode($employee_details['emp_alternate_contact']);?>">
	  		</div>
	    </div>
	    <div class="col-2">
	    	<div class="form-group mb-3">
	            <?php $field_name = 'profile_picture'; $max_length = '100'; $validation_type_class = 'alphabets'; $type = 'text'; ?>
	            <label class="font-weight-normal" for="<?php echo $field_name; ?>"><?php echo ucwords(str_replace('_', ' ', $field_name)); ?> <span id="<?php echo 'err_' . $field_name; ?>" class="invalid-feedback small"></span></label>
              	<input type="file" class="form-control-file " id="<?php echo $field_name; ?>" data-field-name="<?php echo ucwords(str_replace('_', ' ', $field_name)); ?>" name="<?php echo $field_name; ?>">
            </div>
	    </div>
	    <div class="col-2">
            <label class="font-weight-normal">Uploaded Document </label><br>
            <?php if ($employee_details['profile_picture'] !== '' && $employee_details['profile_picture'] !== NULL && file_exists('./assets/uploads/profile_pictures/' . $employee_details['profile_picture'])) { ?>
            	<a class="btn btn-outline-info btn-sm" href="<?php echo site_url('assets/uploads/profile_pictures/' . $employee_details['profile_picture']);?>" target="_blank" title="View supporting document"><i class="far fa-file-image"></i></a>
            <?php }?>
        </div>
		<div class="col-4">
	  		<div class="form-group mb-3">
	            <?php $field_name = 'pan_number'; $max_length = '200'; $validation_type_class = 'alphabets'; $type = 'text'; ?>
	            <label class="font-weight-normal" for="<?php echo $field_name; ?>"><?php echo ucwords(str_replace('_', ' ', $field_name)); ?> <span id="<?php echo 'err_' . $field_name; ?>" class="invalid-feedback small"></span></label>
	            <input type="<?php echo $type; ?>" maxlength="<?php echo $max_length; ?>" data-field-name="<?php echo ucwords(str_replace('_', ' ', $field_name)); ?>" id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>" class="form-control  validation-require" value="<?php echo base64_decode($employee_details['emp_pan']);?>">
	  		</div>
	    </div>
	    <div class="col-2">
	    	<div class="form-group mb-3">
	            <?php $field_name = 'pan_card'; $max_length = '100'; $validation_type_class = 'alphabets'; $type = 'text'; ?>
	            <label class="font-weight-normal" for="<?php echo $field_name; ?>"><?php echo ucwords(str_replace('_', ' ', $field_name)); ?>  Document <small class="text-info">(Upload both side)</small> <span id="<?php echo 'err_' . $field_name; ?>" class="invalid-feedback small"></span></label>
              	<input type="file" class="form-control-file ajax-form-row" id="<?php echo $field_name; ?>" data-field-name="<?php echo ucwords(str_replace('_', ' ', $field_name)); ?>" name="<?php echo $field_name; ?>">
            </div>
	    </div>
	    <div class="col-2">
            <label class="font-weight-normal">Uploaded Document </label><br>
            <?php if ($employee_details['pan_card'] !== '' && $employee_details['pan_card'] !== NULL && file_exists('./assets/uploads/pan_cards/' . $employee_details['pan_card'])) { ?>
            	<a class="btn btn-outline-info btn-sm" href="<?php echo site_url('assets/uploads/pan_cards/' . $employee_details['pan_card']);?>" target="_blank" title="View supporting document"><i class="far fa-file-image"></i></a>
            <?php }?>
        </div>
		<div class="col-4">
	  		<div class="form-group mb-3">
	            <?php $field_name = 'aadhaar_number'; $max_length = '14'; $validation_type_class = 'alphabets'; $type = 'text'; ?>
	            <label class="font-weight-normal" for="<?php echo $field_name; ?>"><?php echo ucwords(str_replace('_', ' ', $field_name)); ?> <span id="<?php echo 'err_' . $field_name; ?>" class="invalid-feedback small"></span></label>
	            <input type="<?php echo $type; ?>" maxlength="<?php echo $max_length; ?>" data-field-name="<?php echo ucwords(str_replace('_', ' ', $field_name)); ?>" id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>" class="form-control  validation-require" value="<?php echo base64_decode($employee_details['emp_aadhar']);?>">
	  		</div>
	    </div>
	    <div class="col-2">
	    	<div class="form-group mb-3">
	            <?php $field_name = 'aadhaar_card'; $max_length = '14'; $validation_type_class = 'alphabets'; $type = 'text'; ?>
	            <label class="font-weight-normal" for="<?php echo $field_name; ?>"><?php echo ucwords(str_replace('_', ' ', $field_name)); ?> Document <span id="<?php echo 'err_' . $field_name; ?>" class="invalid-feedback small"></span></label>
              	<input type="file" class="form-control-file ajax-form-row" id="<?php echo $field_name; ?>" data-field-name="<?php echo ucwords(str_replace('_', ' ', $field_name)); ?>" name="<?php echo $field_name; ?>">
            </div>
	    </div>
	    <div class="col-2">
            <label class="font-weight-normal">Uploaded Document </label><br>
            <?php if ($employee_details['aadhaar_card'] !== '' && $employee_details['aadhaar_card'] !== NULL && file_exists('./assets/uploads/aadhaar_cards/' . $employee_details['aadhaar_card'])) { ?>
            	<a class="btn btn-outline-info btn-sm" href="<?php echo site_url('assets/uploads/aadhaar_cards/' . $employee_details['aadhaar_card']);?>" target="_blank" title="View supporting document"><i class="far fa-file-image"></i></a>
            <?php }?>
        </div>
		<div class="col-4">
	  		<div class="form-group mb-3">
	            <?php $field_name = 'uan'; $max_length = '200'; $validation_type_class = 'alphabets'; $type = 'text'; ?>
	            <label class="font-weight-normal" for="<?php echo $field_name; ?>">UAN <span id="<?php echo 'err_' . $field_name; ?>" class="invalid-feedback small"></span></label>
	            <input type="<?php echo $type; ?>" maxlength="<?php echo $max_length; ?>" data-field-name="UAN" id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>" class="form-control" value="<?php echo base64_decode($employee_details['emp_uan']);?>">
	  		</div>
	    </div>
	    <div class="col-12">
	    	<div class=" text-right mt-4">
	            <input type="hidden" name="_ftoken" class="_ftoken" id="_ftoken" value="<?php echo $_ftoken; ?>" />
	            <button class="btn btn-outline-primary my-2 btn-sm update-employee-personal-details btn-flat" type="submit"><i class="fa fa-save mr-1"></i> Save</button>
	        </div>
	    </div>
	</div>
</form>

<script type="text/javascript">
	$('.datepicker').datepicker({
        max: true,
      	autoclose: true,
        inline: true,
      	format: 'dd/mm/yyyy',
      	endDate: '0d'
    });

    $("#dob").datepicker().on('changeDate', (selected) => {
        var minDate = new Date(selected.date.valueOf() + (86400000*6570));
        $('#date_of_joining').datepicker('setStartDate', minDate);
    });

    $("#date_of_joining").datepicker().on('changeDate', (selected) => {
        var minDate = new Date(selected.date.valueOf() - (86400000*6570));
        $('#dob').datepicker('setEndDate', minDate);
    });
</script>