<div class="row">
	<div class="col-6">
		<h3 class="card-title">Adress</h3>
	</div>
	<div class="col-6 mb-2">
		<button class="btn btn-success btn-sm add-new-employee-details float-right" href="<?php echo site_url($controller . '/add');?>" title="Add new record" data-row="address" data-code="<?php echo base64_encode($employee_details['id']);?>"><i class="fas fa-plus-square mr-2"></i>Add New</button>
	</div>
</div>
<div class="row">
	<?php if(isset($employee_address_details)){?>
		<?php foreach ($employee_address_details as $value) {?>
			<div class="col-4 table-responsive">
		        <div class="card card-info">
		        	<div class="card-header">
		        		<h3 class="card-title">
	        				<?php if(isset($value['address_type'])){?>
	        					<?php if($value['address_type'] == '1'){
	        						echo "Permanent Address" . " <span class='font-italic small'>(" . date('d M, Y', strtotime($value['created'])) . ")</span>";
	        					}elseif($value['address_type'] == '2'){
	        						echo "Current Address" . " <span class='font-italic small'>(" . date('d M, Y', strtotime($value['created'])) . ")</span>";
	        					}else{
	        						echo "Old Address" . " <span class='font-italic small'>(" . date('d M, Y', strtotime($value['created'])) . ' - ' . date('d M, Y', strtotime($value['modified'])) . ")</span>";
	        					}
        					}?>
		        		</h3>
		        		<div class="card-tools">
							<a class="btn btn-secondary btn-sm edit-employee-details" href="javascript:void(0)" row-code="<?php echo base64_encode($value['id']);?>" data-code="<?php echo base64_encode($value['employee_id']);?>" row-type="address" title="Edit record"><i class="far fa-edit mr-2"></i>Edit</a>
						</div>
		        	</div>
		        	<div class="card-body">
		        		<p>
		        			<strong>Adress: </strong> <?php echo isset($value['add_line1'])? base64_decode($value['add_line1']) : '';?>
		        			<span><?php echo isset($value['add_line2']) && $value['add_line2'] !== ''? ', ' . base64_decode($value['add_line2']) : '';?></span><br>
		        			<strong>Post: </strong> <?php echo isset($value['add_po'])? base64_decode($value['add_po']) : '';?><br>
		        			<strong>P.S: </strong> <?php echo isset($value['add_ps'])? base64_decode($value['add_ps']) : '';?><br>
		        			<strong>district: </strong> <?php echo isset($value['add_dist'])? base64_decode($value['add_dist']) : '';?><br>
		        			<strong>State: </strong> <?php echo isset($value['add_state'])? base64_decode($value['add_state']) : '';?><br>
		        			<strong>PIN: </strong> <?php echo isset($value['add_pin'])? base64_decode($value['add_pin']) : '';?><br>
		        		</p>
		        	</div>
		        </div>
			</div>
		<?php }?>
	<?php }?>
</div>