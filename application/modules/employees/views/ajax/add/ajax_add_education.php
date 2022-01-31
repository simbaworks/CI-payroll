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
							<option value="<?php echo $values['id'];?>"><?php echo base64_decode($values['degree_name']);?></option>
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
					<option value="full_time">Full Time</option>
					<option value="distance_education">Distance Education</option>
				</select>
	  		</div>
	    </div>
	    <div class="col-6">
	  		<div class="form-group mb-3">
	            <?php $field_name = 'specialization'; $max_length = '255'; $validation_type_class = 'alphabets'; $type = 'text'; ?>
	            <label class="font-weight-normal" for="<?php echo $field_name; ?>"><?php echo ucwords(str_replace('_', ' ', $field_name)); ?> <span id="<?php echo 'err_' . $field_name; ?>" class="invalid-feedback small"></span></label>
	            <input type="<?php echo $type; ?>" maxlength="<?php echo $max_length; ?>" data-field-name="<?php echo ucwords(str_replace('_', ' ', $field_name)); ?>" id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>" class="form-control ajax-form-row ajax-validation-require">
	  		</div>
	    </div>
		<div class="col-6">
	  		<div class="form-group mb-3">
	            <?php $field_name = 'yop'; $max_length = '200'; $validation_type_class = 'alphabets'; $type = 'text'; ?>
	            <label class="font-weight-normal" for="<?php echo $field_name; ?>">Year of Passing <span id="<?php echo 'err_' . $field_name; ?>" class="invalid-feedback small"></span></label>
	            <input type="<?php echo $type; ?>" maxlength="<?php echo $max_length; ?>" data-field-name="Date of Passing" id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>" class="form-control ajax-validation-require ajax-form-row datepicker" readonly>
	  		</div>
	    </div>
		<div class="col-6">
	  		<div class="form-group mb-3">
	            <?php $field_name = 'mark'; $max_length = '5'; $validation_type_class = 'alphabets'; $type = 'number'; ?>
	            <label class="font-weight-normal" for="<?php echo $field_name; ?>">Marks Obtained <span id="<?php echo 'err_' . $field_name; ?>" class="invalid-feedback small"></span></label>
	            <input type="<?php echo $type; ?>" maxlength="<?php echo $max_length; ?>" data-field-name="Marks Obtained" id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>" class="form-control ajax-form-row ajax-validation-require" min="0">
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
							<option value="<?php echo $values['id'];?>"><?php echo base64_decode($values['bu_name']);?></option>
						<?php }?>
					<?php }?>
				</select>
	  		</div>
	    </div>
	    <div class="col-6">
	  		<div class="form-group mb-3">
	            <?php $field_name = 'certificate_number'; $max_length = '255'; $validation_type_class = 'alphabets'; $type = 'text'; ?>
	            <label class="font-weight-normal" for="<?php echo $field_name; ?>"><?php echo ucwords(str_replace('_', ' ', $field_name)); ?> <span id="<?php echo 'err_' . $field_name; ?>" class="invalid-feedback small"></span></label>
	            <input type="<?php echo $type; ?>" maxlength="<?php echo $max_length; ?>" data-field-name="<?php echo ucwords(str_replace('_', ' ', $field_name)); ?>" id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>" class="form-control ajax-form-row ajax-validation-require">
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
	            <button class="btn btn-outline-primary my-2 btn-sm save-employee-ajax-form-data btn-flat" type="submit" form-type="education"><i class="fa fa-save mr-1"></i> Save</button>
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