<div class="row">
	<div class="col-6">
		<h3 class="card-title">Bank Details</h3>
	</div>
	<div class="col-6 mb-2">
		<button class="btn btn-success btn-sm add-new-employee-details float-right" href="<?php echo site_url($controller . '/add');?>" title="Add new record" data-row="bank" data-code="<?php echo base64_encode($employee_details['id']);?>"><i class="fas fa-plus-square mr-2"></i>Add New</button>
	</div>
	<div class="col-12 table-responsive">
        <table class="table table-striped border">
          	<thead>
            	<tr>
					<th style="width: 2%">#</th>
					<th>Bank Name</th>
					<th>Branch</th>
					<th>IFSC Code</th>
					<th>Account</th>
					<th class="text-center">Document</th>
					<th class="text-center" style="width: 10%">Action</th>
            	</tr>
          	</thead>
          	<tbody>
          		<?php if(isset($employee_bank_details)){$i = 1;?>
          			<?php foreach ($employee_bank_details as $ebd) {?>
            			<tr>
							<td><?php echo $i;?></td>
							<td><?php echo isset($ebd['bank_name'])? base64_decode($ebd['bank_name']) : '';?></td>
							<td><?php echo isset($ebd['bank_branch'])? base64_decode($ebd['bank_branch']) : '';?></td>
							<td><?php echo isset($ebd['bank_ifsc'])? base64_decode($ebd['bank_ifsc']) : '';?></td>
							<td>
								<p><strong>Account Type: </strong><?php echo isset($ebd['bank_acc_type'])? ucwords(str_replace('_', ' ', base64_decode($ebd['bank_acc_type']))) : '';?><br>
							    <small><strong>Account No.: </strong><?php echo isset($ebd['bank_acc_no'])? base64_decode($ebd['bank_acc_no']) : '';?></small></p>
							</td>
							<td class="text-center">
                                <?php if (isset($ebd['supporting_document']) && file_exists('./assets/uploads/employee_bank_details/' . $ebd['supporting_document'])) { ?>
                                    <?php $file = explode('.', $ebd['supporting_document']); $icon = in_array($file[1], array('jpg', 'jpeg', 'png'))? '<i class="fas fa-file-image"></i>' : '<i class="fas fa-file-pdf"></i>';?>
									<a class="btn btn-outline-info btn-sm" href="<?php echo site_url('assets/uploads/employee_bank_details/' . $ebd['supporting_document']);?>" target="_blank" title="View supporting document"><?php echo $icon;?></a>
								<?php }?>
							</td>
							<td class="text-center">
								<a class="btn btn-info btn-sm edit-employee-details" href="javascript:void(0)" row-code="<?php echo base64_encode($ebd['id']);?>" data-code="<?php echo base64_encode($ebd['employee_id']);?>" row-type="bank" title="Edit record"><i class="far fa-edit mr-2"></i>Edit</a>
							</td>
            			</tr>
            		<?php $i++;}?>
            	<?php }else{?>
            		<tr>
            			<td colspan="8" class="text-center text-danger">No record found!</td>
            		</tr>
            	<?php }?>
          	</tbody>
        </table>
	</div>
</div>