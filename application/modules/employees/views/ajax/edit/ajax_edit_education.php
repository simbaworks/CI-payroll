<form method="post" action="#" id="ajax-employee-details-add-form">	
	<div class="row">
		<div class="col-6">
	  		<div class="form-group mb-3">
	            <?php $field_name = 'degree'; $max_length = '100'; $validation_type_class = 'alphabets'; $type = 'text'; ?>
	            <label class="font-weight-normal" for="<?php echo $field_name; ?>"><?php echo ucwords(str_replace('_', ' ', $field_name)); ?> <span id="<?php echo 'err_' . $field_name; ?>" class="invalid-feedback small"></span></label>
	            <select class="custom-select ajax-validation-require ajax-form-row" id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>" data-field-name="Degree">
					<option value="">-Select Degree-</option>
					<?php if(isset($degrees)){?>
						<?php foreach($degrees as $values){?>
							<option value="<?php echo $values['id'];?>" <?php echo $education_details['degree_code'] == $values['id']? 'selected' : '';?>><?php echo base64_decode($values['degree_name']);?></option>
						<?php }?>
					<?php }?>
				</select>
	  		</div>
	    </div>
		<div class="col-6">
	  		<div class="form-group mb-3">
	            <?php $field_name = 'type_of_degree'; $max_length = '200'; $validation_type_class = 'alphabets'; $type = 'text'; ?>
	            <label class="font-weight-normal" for="<?php echo $field_name; ?>">Degree Type <span id="<?php echo 'err_' . $field_name; ?>" class="invalid-feedback small"></span></label>
	            <select class="custom-select ajax-validation-require ajax-form-row" id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>" data-field-name="Degree Type">
					<option value="">-Select Degree Type-</option>
					<option value="full_time" <?php echo $education_details['type_of_degree'] == 'full_time'? 'selected' : '';?>>Full Time</option>
					<option value="distance_education" <?php echo $education_details['type_of_degree'] == 'distance_education'? 'selected' : '';?>>Distance Education</option>
				</select>
	  		</div>
	    </div>
	    <div class="col-6">
	  		<div class="form-group mb-3">
	            <?php $field_name = 'specialization'; $max_length = '255'; $validation_type_class = 'alphabets'; $type = 'text'; ?>
	            <label class="font-weight-normal" for="<?php echo $field_name; ?>"><?php echo ucwords(str_replace('_', ' ', $field_name)); ?> <span id="<?php echo 'err_' . $field_name; ?>" class="invalid-feedback small"></span></label>
	            <input type="<?php echo $type; ?>" maxlength="<?php echo $max_length; ?>" data-field-name="<?php echo ucwords(str_replace('_', ' ', $field_name)); ?>" id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>" class="form-control ajax-form-row ajax-validation-require" value="<?php echo isset($education_details['specialization'])? $education_details['specialization'] : '';?>">
	  		</div>
	    </div>
		<div class="col-6">
	  		<div class="form-group mb-3">
	            <?php $field_name = 'yop'; $max_length = '200'; $validation_type_class = 'alphabets'; $type = 'text'; ?>
	            <label class="font-weight-normal" for="<?php echo $field_name; ?>">Date of Passing <span id="<?php echo 'err_' . $field_name; ?>" class="invalid-feedback small"></span></label>
	            <input type="<?php echo $type; ?>" maxlength="<?php echo $max_length; ?>" data-field-name="Date of Passing" id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>" class="form-control  ajax-validation-require datepicker ajax-form-row" readonly value="<?php echo isset($education_details['date_of_passing'])? date('d/m/Y', strtotime($education_details['date_of_passing'])) : '';?>">
				</select>
	  		</div>
	    </div>
		<div class="col-6">
	  		<div class="form-group mb-3">
	            <?php $field_name = 'mark'; $max_length = '5'; $validation_type_class = 'alphabets'; $type = 'number'; ?>
	            <label class="font-weight-normal" for="<?php echo $field_name; ?>">Marks Obtained <span id="<?php echo 'err_' . $field_name; ?>" class="invalid-feedback small"></span></label>
	            <input type="<?php echo $type; ?>" maxlength="<?php echo $max_length; ?>" data-field-name="Marks Obtained" id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>" class="form-control ajax-form-row ajax-validation-require" min="0" value="<?php echo isset($education_details['marks_obtained'])? base64_decode($education_details['marks_obtained']) : '';?>">
	  		</div>
	    </div>
		<div class="col-6">
	  		<div class="form-group mb-3">
	            <?php $field_name = 'board_univ'; $max_length = '200'; $validation_type_class = 'alphabets'; $type = 'text'; ?>
	            <label class="font-weight-normal" for="<?php echo $field_name; ?>">Board/University <span id="<?php echo 'err_' . $field_name; ?>" class="invalid-feedback small"></span></label>
	            <select class="custom-select ajax-validation-require ajax-form-row" id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>" data-field-name="Board/University">
					<option value="">-Select Board/University-</option>
					<?php if(isset($board_univ)){?>
						<?php foreach($board_univ as $values){?>
							<option value="<?php echo $values['id'];?>" <?php echo $education_details['board_univ_code'] == $values['id']? 'selected' : '';?>><?php echo base64_decode($values['bu_name']);?></option>
						<?php }?>
					<?php }?>
				</select>
	  		</div>
	    </div>
	    <div class="col-6">
	  		<div class="form-group mb-3">
	            <?php $field_name = 'certificate_number'; $max_length = '255'; $validation_type_class = 'alphabets'; $type = 'text'; ?>
	            <label class="font-weight-normal" for="<?php echo $field_name; ?>"><?php echo ucwords(str_replace('_', ' ', $field_name)); ?> <span id="<?php echo 'err_' . $field_name; ?>" class="invalid-feedback small"></span></label>
	            <input type="<?php echo $type; ?>" maxlength="<?php echo $max_length; ?>" data-field-name="<?php echo ucwords(str_replace('_', ' ', $field_name)); ?>" id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>" class="form-control ajax-form-row ajax-validation-require" value="<?php echo isset($education_details['certificate_number'])? $education_details['certificate_number'] : '';?>">
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
            <?php if ($education_details['supporting_document'] !== '' && $education_details['supporting_document'] !== NULL && file_exists('./assets/uploads/employee_education/' . $education_details['supporting_document'])) { ?>
            	<a class="btn btn-outline-info btn-sm" href="<?php echo site_url('assets/uploads/employee_education/' . $education_details['supporting_document']);?>" target="_blank" title="View supporting document"><i class="far fa-file-image"></i></a>
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
	            <button class="btn btn-outline-primary my-2 btn-sm update-employee-ajax-form-data btn-flat" type="submit" form-type="education"><i class="fa fa-save mr-1"></i> Update</button>
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