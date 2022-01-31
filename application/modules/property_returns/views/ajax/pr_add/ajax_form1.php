<?php 
$form_one_data = array(); 
if(isset($pr_form_one_details)){
	foreach($pr_form_one_details as $prfod){
		$dependent_id = base64_decode($prfod['dependent_id']);
		$form_one_data[$dependent_id]['public_positions'] = base64_decode($prfod['public_positions']);
		$form_one_data[$dependent_id]['is_separately_return'] = base64_decode($prfod['is_separately_return']);
	}
}
// echo "<pre>";
// print_r($employee_dependents_details);
?>
<form method="post" action="#" id="ajax-add-pr-form-one">
	<div class="container shadow">	
		<div class="row border" style="padding: 80px;">
			<div class="col-12">
				<p class="text-right"><b>APPENDIX-II<br>[Rule 3(1)]</b></p>
			</div>
			<div class="col-12 text-center">
		        <p class="font-weight-bold mb-0">FORM No.I</p>
		        <h5 class="font-weight-bold">Details of Public Servant,   his/ her spouse and dependent children</h5>
		    </div>
		    <div class="col-12 pt-4">
		    	<table class="table table-bordered">
		          	<thead>
		            	<tr>
							<th style="width: 5%;">SL No.</th>
							<th style="width: 10%;"></th>
							<th style="width: 15%;">Name</th>
							<th style="width: 50%">Public Position held, if any</th>
							<th style="width: 20%">Whether return being filed by him/ her, separately</th>
		            	</tr>
		          	</thead>
		          	<tbody>
		          		<tr>
	      					<td>1</td>
	      					<td>
	      						Self
	      						<input type="hidden" name="dependent_row_code[]" value="<?php echo base64_encode(0);?>">
	      					</td>
	      					<td><?php echo base64_decode($employee_details['emp_name']);?></td>
	      					<td><input type="text" class="form-control" name="public_positions[]" value="<?php echo isset($form_one_data[0]['public_positions'])? $form_one_data[0]['public_positions'] : '';?>"></td>
	      					<td><input type="text" class="form-control" name="is_separately_return[]" value="<?php echo isset($form_one_data[0]['public_positions'])? $form_one_data[0]['is_separately_return'] : '';?>"></td>
	      				</tr>
		          		<?php if(isset($employee_dependents_details)){$i=2;?>
		          			<?php foreach($employee_dependents_details as $edd){?>
		          				<tr>
		          					<td><?php echo $i;?></td>
		          					<td>
		          						<?php echo isset($edd['relation'])? base64_decode($edd['relation']) : '';?>
	      								<input type="hidden" name="dependent_row_code[]" value="<?php echo base64_encode($edd['id']);?>">
		          					</td>
		          					<td><?php echo isset($edd['rel_name'])? base64_decode($edd['rel_name']) : '';?></td>
		          					<td>
		          						<input type="text" class="form-control" name="public_positions[]" value="<?php echo isset($form_one_data[$edd['id']]['public_positions'])? $form_one_data[$edd['id']]['public_positions'] : '';?>">
		          					</td>
		          					<td>
		          						<input type="text" class="form-control" name="is_separately_return[]" value="<?php echo isset($form_one_data[$edd['id']]['public_positions'])? $form_one_data[$edd['id']]['is_separately_return'] : '';?>">
		          					</td>
		          				</tr>
	          				<?php $i++;}?>
	          			<?php }?>
		          	</tbody>
	          	</table>
		    </div>
		    <div class="col-12">
	            <input type="hidden" name="pr_home_row" class="pr_home_row" id="pr_home_row" value="<?php echo isset($property_returns_details['id'])? base64_encode($property_returns_details['id']) : '';?>" />
		    	<button class="btn btn-info btn-sm btn-flat float-right save-form-one-data <?php echo isset($property_returns_details['id'])? '' : 'd-none';?>">Next<i class="fas fa-chevron-right ml-2"></i></button>
		    </div>
		    <div class="col-12" style="padding:200px;"></div>
		</div>
	</div>
</form>

<script type="text/javascript">
	$(document).on('click', '.save-form-one-data', function (evt) {
	    evt.preventDefault();
	    var valid = 1;
	    $(this).html('<i class="fas fa-cog fa-spin"></i> Saving..');
	    $(this).prop('disabled', true);

	    if (valid == 1) {
	        var formData = new FormData($('#ajax-add-pr-form-one')[0]);
	        var dataUrl = SITEURL + CONTROLLER + '/ajax_save_pr_form_one_data';
	        $.ajax({
	            type: "POST",
	            url: dataUrl,
	            data: formData,
	            cache: false,
	            processData: false,
	            contentType: false,
	            dataType: 'JSON',
	            success: function (data) {
	                if(data.code == '1'){
	                    Toast.fire({
	                        icon: 'success',
	                        title: data.message
	                    });

	                    //$('.pr_home_row').val(data.html);
	                    //$('.save-form-one-data').removeClass('d-none');
	                    $('#form-one-link').removeClass('active');
	                    $('#form-one').removeClass('active');
	                    $('#form-one').addClass('fade');
	                    $('#form-two-link').addClass('active');
	                    $('#form-two').addClass('active');
	                    $('#form-two').removeClass('fade');
	                    window.scrollTo({ top: 0, behavior: 'smooth' });
	                }else{
	                    alert(data.message);
	                }
	                $('.save-form-one-data').html('Next<i class="fas fa-chevron-right ml-2"></i>');
	                $('.save-form-one-data').prop('disabled', false);
	            }
	        });
	    } else {
	        $(this).html('Next<i class="fas fa-chevron-right ml-2"></i>');
	        $(this).prop('disabled', false);
	    }
	});
</script>