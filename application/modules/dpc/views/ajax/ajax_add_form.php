<form method="post" action="#" id="ajax-add-form">
	<div class="row">
		<div class="col-6">
	  		<div class="form-group mb-3">
	            <?php $field_name = 'vacant_post_id'; $max_length = '200'; $validation_type_class = 'alphabets'; $type = 'text'; ?>
	            <label for="<?php echo $field_name; ?>">Vacant Post <span id="<?php echo 'err_' . $field_name; ?>" class="invalid-feedback small"></span></label>
				<select class="form-control validation-require ajax-form-row" id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>" data-field-name="Vacant Post">
					<option value="">-Select Vacant Post-</option>
					<?php if(isset($vacant_post)){?>
						<?php foreach($vacant_post as $vp){?>
							<option value="<?php echo $vp['id'];?>"><?php echo  '[' . base64_decode($vp['centre_name']) . '] ' . $vp['description'];?></option>
						<?php }?>
					<?php }?>
				</select>
			</div>
		</div>
		<div class="col-6">
	  		<div class="form-group mb-3">
	            <?php $field_name = 'employee_ids'; $max_length = '200'; $validation_type_class = 'alphabets'; $type = 'text'; ?>
	            <label for="<?php echo $field_name; ?>">DPC Members <span id="<?php echo 'err_' . $field_name; ?>" class="invalid-feedback small"></span></label>
				<select class="form-control multiple-select ajax-form-row" id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>[]" data-field-name="DPC Members" multiple="" placeholder="-Select DPC Member-">
					<?php if(isset($employee_details)){?>
						<?php foreach($employee_details as $ed){?>
							<option value="<?php echo $ed['id'];?>"><?php echo  '[' . base64_decode($ed['emp_id']) . '] ' . base64_decode($ed['name']);?></option>
						<?php }?>
					<?php }?>
				</select>
			</div>
		</div>
	    <div class="col-12">
	    	<div class=" text-right mt-4">
	            <input type="hidden" name="_ftoken" class="_ftoken" id="_ftoken" value="<?php echo $_ftoken; ?>" />
	            <button class="btn btn-outline-primary my-2 btn-sm save-ajax-form-data btn-flat" type="submit"><i class="fa fa-save mr-1"></i> Save</button>
	        </div>
	    </div>
	</div>
</form>
<script type="text/javascript">
	$('.multiple-select').multipleSelect('destroy');
	$('.multiple-select').multipleSelect({
	    filter: true
	});
</script>