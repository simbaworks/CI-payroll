<div class="row">
	<div class="col">
		<div class="card">
          	<div class="card-header">
				<div class="row">
				    <div class="col">
                		<h3 class="card-title">Add New Employee</h3>
                	</div>
                	<!-- <div class="col">
                		<a class="btn btn-info btn-sm add-new-ecord float-right" href="<?php echo site_url($controller . '/lists');?>" title="Back to lists"><i class="fas fa-chevron-left mr-2"></i>Back</a>
                	</div> -->
                </div>
          	</div>
			<div class="card-body">
				<div class="row">
					<div class="col-12">
						<form method="post" action="<?php echo site_url($controller . '/' . $method); ?>" id="ajax-employee-add-form" onsubmit="return employee_form_validation();" enctype='multipart/form-data'>	
							<div class="row">
								<div class="col-4">
							  		<div class="form-group mb-3">
							            <?php $field_name = 'name'; $max_length = '200'; $validation_type_class = 'alphabets'; $type = 'text'; ?>
							            <label class="font-weight-normal" for="<?php echo $field_name; ?>"><?php echo ucwords(str_replace('_', ' ', $field_name)); ?> <span id="<?php echo 'err_' . $field_name; ?>" class="invalid-feedback small"></span></label>
							            <input type="<?php echo $type; ?>" maxlength="<?php echo $max_length; ?>" data-field-name="<?php echo ucwords(str_replace('_', ' ', $field_name)); ?>" id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>" class="form-control ajax-form-row validation-require">
							  		</div>
							    </div>
								<div class="col-4">
							  		<div class="form-group mb-3">
							            <?php $field_name = 'dob'; $max_length = '200'; $validation_type_class = 'alphabets'; $type = 'text'; ?>
							            <label class="font-weight-normal" for="<?php echo $field_name; ?>"><?php echo ucwords(str_replace('_', ' ', $field_name)); ?> <span id="<?php echo 'err_' . $field_name; ?>" class="invalid-feedback small"></span></label>
							            <input type="<?php echo $type; ?>" maxlength="<?php echo $max_length; ?>" data-field-name="<?php echo ucwords(str_replace('_', ' ', $field_name)); ?>" id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>" class="form-control ajax-form-row validation-require datepicker" readonly>
							  		</div>
							    </div>
								<div class="col-4">
							  		<div class="form-group mb-3">
							            <?php $field_name = 'gender_id'; $max_length = '200'; $validation_type_class = 'alphabets'; $type = 'text'; ?>
							            <label class="font-weight-normal" for="<?php echo $field_name; ?>">Gender <span id="<?php echo 'err_' . $field_name; ?>" class="invalid-feedback small"></span></label>
										<select class="form-control validation-require ajax-form-row" id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>" data-field-name="Gender">
											<option value="">-Gender-</option>
											<option value="1">Male</option>
											<option value="2">Female</option>
											<option value="3">Transgender</option>
										</select>
							  		</div>
							    </div>
								<div class="col-4">
							  		<div class="form-group mb-3">
							            <?php $field_name = 'father_name'; $max_length = '200'; $validation_type_class = 'alphabets'; $type = 'text'; ?>
							            <label class="font-weight-normal" for="<?php echo $field_name; ?>"><?php echo ucwords(str_replace('_', ' ', $field_name)); ?> <span id="<?php echo 'err_' . $field_name; ?>" class="invalid-feedback small"></span></label>
							            <input type="<?php echo $type; ?>" maxlength="<?php echo $max_length; ?>" data-field-name="<?php echo ucwords(str_replace('_', ' ', $field_name)); ?>" id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>" class="form-control ajax-form-row validation-require">
							  		</div>
							    </div>
								<div class="col-4">
							  		<div class="form-group mb-3">
							            <?php $field_name = 'mother_name'; $max_length = '200'; $validation_type_class = 'alphabets'; $type = 'text'; ?>
							            <label class="font-weight-normal" for="<?php echo $field_name; ?>"><?php echo ucwords(str_replace('_', ' ', $field_name)); ?> <span id="<?php echo 'err_' . $field_name; ?>" class="invalid-feedback small"></span></label>
							            <input type="<?php echo $type; ?>" maxlength="<?php echo $max_length; ?>" data-field-name="<?php echo ucwords(str_replace('_', ' ', $field_name)); ?>" id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>" class="form-control ajax-form-row validation-require">
							  		</div>
							    </div>
								<div class="col-4">
							  		<div class="form-group mb-3">
							            <?php $field_name = 'marital_status_id'; $max_length = '200'; $validation_type_class = 'alphabets'; $type = 'text'; ?>
							            <label class="font-weight-normal" for="<?php echo $field_name; ?>">Marital Status <span id="<?php echo 'err_' . $field_name; ?>" class="invalid-feedback small"></span></label>
										<select class="form-control validation-require ajax-form-row" id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>" data-field-name="Marital Status">
											<option value="">-Marital Status-</option>
											<?php if(isset($marital_status)){?>
												<?php foreach($marital_status as $ms){?>
													<option value="<?php echo $ms['id'];?>"><?php echo base64_decode($ms['marital_status']);?></option>
												<?php }?>
											<?php }?>
										</select>
							  		</div>
							    </div>
								<!-- <div class="col-4 spouse-name-div d-none">
							  		<div class="form-group mb-3">
							            <?php $field_name = 'spouse_name'; $max_length = '200'; $validation_type_class = 'alphabets'; $type = 'text'; ?>
							            <label class="font-weight-normal" for="<?php echo $field_name; ?>"><?php echo ucwords(str_replace('_', ' ', $field_name)); ?> <span id="<?php echo 'err_' . $field_name; ?>" class="invalid-feedback small"></span></label>
							            <input type="<?php echo $type; ?>" maxlength="<?php echo $max_length; ?>" data-field-name="<?php echo ucwords(str_replace('_', ' ', $field_name)); ?>" id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>" class="form-control ajax-form-row validation-require d-none">
							  		</div>
							    </div>
							    <div class="col-4 marriage-certificate-div d-none">
							    	<div class="form-group mb-3">
							            <?php $field_name = 'marriage_certificate'; $max_length = '100'; $validation_type_class = 'alphabets'; $type = 'text'; ?>
							            <label class="font-weight-normal" for="<?php echo $field_name; ?>"><?php echo ucwords(str_replace('_', ' ', $field_name)); ?> <span id="<?php echo 'err_' . $field_name; ?>" class="invalid-feedback small"></span></label>
					                  	<input type="file" class="form-control-file ajax-form-row validation-require supporting-document d-none" id="<?php echo $field_name; ?>" data-field-name="<?php echo ucwords(str_replace('_', ' ', $field_name)); ?>" name="<?php echo $field_name; ?>">
					                </div>
							    </div> -->
							</div>
							<hr>
							<div class="row">
								<div class="col-6">
							  		<div class="form-group mb-3">
							            <?php $field_name = 'emp_id'; $max_length = '200'; $validation_type_class = 'alphabets'; $type = 'text'; ?>
							            <label class="font-weight-normal" for="<?php echo $field_name; ?>">Employee Id <span id="<?php echo 'err_' . $field_name; ?>" class="invalid-feedback small"></span></label>
							            <input type="<?php echo $type; ?>" maxlength="<?php echo $max_length; ?>" data-field-name="Employee Id" id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>" class="form-control ajax-form-row validation-require">
							  		</div>
							    </div>
								<div class="col-6">
							  		<div class="form-group mb-3">
							            <?php $field_name = 'date_of_joining'; $max_length = '200'; $validation_type_class = 'alphabets'; $type = 'text'; ?>
							            <label class="font-weight-normal" for="<?php echo $field_name; ?>"><?php echo ucwords(str_replace('_', ' ', $field_name)); ?> <span id="<?php echo 'err_' . $field_name; ?>" class="invalid-feedback small"></span></label>
							            <input type="<?php echo $type; ?>" maxlength="<?php echo $max_length; ?>" data-field-name="<?php echo ucwords(str_replace('_', ' ', $field_name)); ?>" id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>" class="form-control ajax-form-row validation-require datepicker" readonly>
							  		</div>
							    </div>
							</div>
							<hr>
							<div class="row">
								<div class="col-4">
							  		<div class="form-group mb-3">
							            <?php $field_name = 'religion_id'; $max_length = '200'; $validation_type_class = 'alphabets'; $type = 'text'; ?>
							            <label class="font-weight-normal" for="<?php echo $field_name; ?>">Religion <span id="<?php echo 'err_' . $field_name; ?>" class="invalid-feedback small"></span></label>
										<select class="form-control validation-require ajax-form-row" id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>" data-field-name="Religion">
											<option value="">-Religion-</option>
											<?php if(isset($religion)){?>
												<?php foreach($religion as $rlgn){?>
													<option value="<?php echo $rlgn['id'];?>"><?php echo base64_decode($rlgn['religion_name']);?></option>
												<?php }?>
											<?php }?>
										</select>
									</div>
								</div>
								<div class="col-4">
							  		<div class="form-group mb-3">
							            <?php $field_name = 'caste_id'; $max_length = '200'; $validation_type_class = 'alphabets'; $type = 'text'; ?>
							            <label class="font-weight-normal" for="<?php echo $field_name; ?>">Caste <span id="<?php echo 'err_' . $field_name; ?>" class="invalid-feedback small"></span></label>
										<select class="form-control validation-require ajax-form-row" id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>" data-field-name="Caste">
											<option value="">-Caste-</option>
											<?php if(isset($caste)){?>
												<?php foreach($caste as $ct){?>
													<option value="<?php echo $ct['id'];?>"><?php echo base64_decode($ct['caste_name']);?></option>
												<?php }?>
											<?php }?>
										</select>
									</div>
								</div>
							    <div class="col-4 caste-certificate-div d-none">
							    	<div class="form-group mb-3">
							            <?php $field_name = 'caste_certificate'; $max_length = '100'; $validation_type_class = 'alphabets'; $type = 'text'; ?>
							            <label class="font-weight-normal" for="<?php echo $field_name; ?>"><?php echo ucwords(str_replace('_', ' ', $field_name)); ?> <span id="<?php echo 'err_' . $field_name; ?>" class="invalid-feedback small"></span></label>
					                  	<input type="file" class="form-control-file ajax-form-row validation-require supporting-document d-none" id="<?php echo $field_name; ?>" data-field-name="<?php echo ucwords(str_replace('_', ' ', $field_name)); ?>" name="<?php echo $field_name; ?>">
					                </div>
							    </div>
								<!-- <div class="col-4">
							  		<div class="form-group mb-3">
							            <?php $field_name = 'nationality'; $max_length = '200'; $validation_type_class = 'alphabets'; $type = 'text'; ?>
							            <label class="font-weight-normal" for="<?php echo $field_name; ?>"><?php echo ucwords(str_replace('_', ' ', $field_name)); ?> <span id="<?php echo 'err_' . $field_name; ?>" class="invalid-feedback small"></span></label>
							            <input type="<?php echo $type; ?>" maxlength="<?php echo $max_length; ?>" data-field-name="<?php echo ucwords(str_replace('_', ' ', $field_name)); ?>" id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>" class="form-control ajax-form-row validation-require">
							  		</div>
							    </div> -->
							</div>
							<hr>
							<div class="row">
								<div class="col-4">
							  		<div class="form-group mb-3">
							            <?php $field_name = 'blood_group_id'; $max_length = '200'; $validation_type_class = 'alphabets'; $type = 'text'; ?>
							            <label class="font-weight-normal" for="<?php echo $field_name; ?>">Blood Group <span id="<?php echo 'err_' . $field_name; ?>" class="invalid-feedback small"></span></label>
										<select class="form-control validation-require ajax-form-row" id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>" data-field-name="Blood Group">
											<option value="">-Blood Group-</option>
											<?php if(isset($blood_groups)){?>
												<?php foreach($blood_groups as $bg){?>
													<option value="<?php echo $bg['id'];?>"><?php echo base64_decode($bg['group_name']);?></option>
												<?php }?>
											<?php }?>
										</select>
									</div>
								</div>
							    <div class="col-4">
							    	<div class="form-group mb-3">
							            <?php $field_name = 'blood_certificate'; $max_length = '100'; $validation_type_class = 'alphabets'; $type = 'text'; ?>
							            <label class="font-weight-normal" for="<?php echo $field_name; ?>">Blood Group Certificate <span id="<?php echo 'err_' . $field_name; ?>" class="invalid-feedback small"></span></label>
					                  	<input type="file" class="form-control-file ajax-form-row supporting-document" id="<?php echo $field_name; ?>" data-field-name="Blood Group Certificate" name="<?php echo $field_name; ?>">
					                </div>
							    </div>
								<div class="col-4">
							  		<div class="form-group mb-3">
							            <?php $field_name = 'identification_mark'; $max_length = '200'; $validation_type_class = 'alphabets'; $type = 'text'; ?>
							            <label class="font-weight-normal" for="<?php echo $field_name; ?>"><?php echo ucwords(str_replace('_', ' ', $field_name)); ?> <span id="<?php echo 'err_' . $field_name; ?>" class="invalid-feedback small"></span></label>
							            <input type="<?php echo $type; ?>" maxlength="<?php echo $max_length; ?>" data-field-name="<?php echo ucwords(str_replace('_', ' ', $field_name)); ?>" id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>" class="form-control ajax-form-row">
							  		</div>
							    </div>
							    <div class="col-12">
							    	<div class="form-check mt-4 pt-2 mb-3">
							            <?php $field_name = 'is_disabled'; $max_length = '200'; $validation_type_class = 'alphabets'; $type = 'text'; ?>
									    <input type="checkbox" class="form-check-input" value="1" data-field-name="<?php echo ucwords(str_replace('_', ' ', $field_name)); ?>" id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>">
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
							            <input type="<?php echo $type; ?>" maxlength="<?php echo $max_length; ?>" data-field-name="<?php echo ucwords(str_replace('_', ' ', $field_name)); ?>" id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>" class="form-control ajax-form-row validation-require">
							  		</div>
							    </div>
								<div class="col-4">
							  		<div class="form-group mb-3">
							            <?php $field_name = 'contact_phone'; $max_length = '10'; $validation_type_class = 'alphabets'; $type = 'text'; ?>
							            <label class="font-weight-normal" for="<?php echo $field_name; ?>">Contact No <span id="<?php echo 'err_' . $field_name; ?>" class="invalid-feedback small"></span></label>
							            <input type="<?php echo $type; ?>" maxlength="<?php echo $max_length; ?>" data-field-name="Contact No" id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>" class="form-control ajax-form-row validation-require">
							  		</div>
							    </div>
								<div class="col-4">
							  		<div class="form-group mb-3">
							            <?php $field_name = 'alternate_contact'; $max_length = '10'; $validation_type_class = 'alphabets'; $type = 'text'; ?>
							            <label class="font-weight-normal" for="<?php echo $field_name; ?>">Emergency contact number <span id="<?php echo 'err_' . $field_name; ?>" class="invalid-feedback small"></span></label>
							            <input type="<?php echo $type; ?>" maxlength="<?php echo $max_length; ?>" data-field-name="Emergency contact number" id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>" class="form-control ajax-form-row validation-require">
							  		</div>
							    </div>
							    <div class="col-4">
							    	<div class="form-group mb-3">
							            <?php $field_name = 'profile_picture'; $max_length = '100'; $validation_type_class = 'alphabets'; $type = 'text'; ?>
							            <label class="font-weight-normal" for="<?php echo $field_name; ?>"><?php echo ucwords(str_replace('_', ' ', $field_name)); ?> <span id="<?php echo 'err_' . $field_name; ?>" class="invalid-feedback small"></span></label>
					                  	<input type="file" class="form-control-file ajax-form-row supporting-document" id="<?php echo $field_name; ?>" data-field-name="<?php echo ucwords(str_replace('_', ' ', $field_name)); ?>" name="<?php echo $field_name; ?>">
					                </div>
							    </div>
								<div class="col-4">
							  		<div class="form-group mb-3">
							            <?php $field_name = 'pan_number'; $max_length = '10'; $validation_type_class = 'alphabets'; $type = 'text'; ?>
							            <label class="font-weight-normal" for="<?php echo $field_name; ?>"><?php echo ucwords(str_replace('_', ' ', $field_name)); ?> <span id="<?php echo 'err_' . $field_name; ?>" class="invalid-feedback small"></span></label>
							            <input type="<?php echo $type; ?>" maxlength="<?php echo $max_length; ?>" data-field-name="<?php echo ucwords(str_replace('_', ' ', $field_name)); ?>" id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>" class="form-control ajax-form-row validation-require">
							  		</div>
							    </div>
							    <div class="col-4">
							    	<div class="form-group mb-3">
							            <?php $field_name = 'pan_card'; $max_length = '100'; $validation_type_class = 'alphabets'; $type = 'text'; ?>
							            <label class="font-weight-normal" for="<?php echo $field_name; ?>"><?php echo ucwords(str_replace('_', ' ', $field_name)); ?>  Document <small class="text-info">(Upload both side)</small> <span id="<?php echo 'err_' . $field_name; ?>" class="invalid-feedback small"></span></label>
					                  	<input type="file" class="form-control-file ajax-form-row validation-require supporting-document" id="<?php echo $field_name; ?>" data-field-name="<?php echo ucwords(str_replace('_', ' ', $field_name)); ?>" name="<?php echo $field_name; ?>">
					                </div>
							    </div>
								<div class="col-4">
							  		<div class="form-group mb-3">
							            <?php $field_name = 'aadhaar_number'; $max_length = '14'; $validation_type_class = 'alphabets'; $type = 'text'; ?>
							            <label class="font-weight-normal" for="<?php echo $field_name; ?>"><?php echo ucwords(str_replace('_', ' ', $field_name)); ?> <span id="<?php echo 'err_' . $field_name; ?>" class="invalid-feedback small"></span></label>
							            <input type="<?php echo $type; ?>" maxlength="<?php echo $max_length; ?>" data-field-name="<?php echo ucwords(str_replace('_', ' ', $field_name)); ?>" id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>" class="form-control ajax-form-row validation-require">
							  		</div>
							    </div>
							    <div class="col-4">
							    	<div class="form-group mb-3">
							            <?php $field_name = 'aadhaar_card'; $max_length = '100'; $validation_type_class = 'alphabets'; $type = 'text'; ?>
							            <label class="font-weight-normal" for="<?php echo $field_name; ?>"><?php echo ucwords(str_replace('_', ' ', $field_name)); ?> Document <span id="<?php echo 'err_' . $field_name; ?>" class="invalid-feedback small"></span></label>
					                  	<input type="file" class="form-control-file ajax-form-row validation-require supporting-document" id="<?php echo $field_name; ?>" data-field-name="<?php echo ucwords(str_replace('_', ' ', $field_name)); ?>" name="<?php echo $field_name; ?>">
					                </div>
							    </div>
								<div class="col-4">
							  		<div class="form-group mb-3">
							            <?php $field_name = 'uan'; $max_length = '10'; $validation_type_class = 'alphabets'; $type = 'text'; ?>
							            <label class="font-weight-normal" for="<?php echo $field_name; ?>">UAN <span id="<?php echo 'err_' . $field_name; ?>" class="invalid-feedback small"></span></label>
							            <input type="<?php echo $type; ?>" maxlength="<?php echo $max_length; ?>" data-field-name="UAN" id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>" class="form-control ajax-form-row">
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
			        </div>
			    </div>
			</div>
		</div>
	</div>
</div>

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