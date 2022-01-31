<div class="row">
	<div class="col-6">
		<h3 class="card-title">LIC Details</h3>
	</div>
	<div class="col-6 mb-2">
		<button class="btn btn-success btn-sm add-new-employee-details float-right" href="<?php echo site_url($controller . '/add');?>" title="Add new record" data-row="lic" data-code="<?php echo base64_encode($employee_details['id']);?>"><i class="fas fa-plus-square mr-2"></i>Add New</button>
	</div>
	<div class="col-12 table-responsive">
        <table class="table table-striped border">
          	<thead>
            	<tr>
					<th style="width: 2%">#</th>
					<th>Policy Number</th>
					<th>Premium Amount</th>
					<th>Issue Date</th>
					<th>Maturity Date</th>
					<th class="text-center">Document</th>
					<th class="text-center" style="width: 10%">Action</th>
            	</tr>
          	</thead>
          	<tbody>
          		<?php if(isset($employee_lic_details)){$i = 1;?>
          			<?php foreach ($employee_lic_details as $eld) {?>
            			<tr>
							<td><?php echo $i;?></td>
							<td><?php echo isset($eld['policy_no'])? $eld['policy_no'] : '';?></td>
							<td><?php echo isset($eld['premium_amount'])? $eld['premium_amount'] : '';?></td>
							<td><?php echo isset($eld['issue_date'])? date('d M, Y', strtotime($eld['issue_date'])) : '';?></td>
							<td><?php echo isset($eld['maturity_date'])? date('d M, Y', strtotime($eld['maturity_date'])) : '';?></td>
							<td class="text-center">
                                <?php if (isset($eld['supporting_document']) && file_exists('./assets/uploads/employee_lic/' . $eld['supporting_document'])) { ?>
                                    <?php $file = explode('.', $eld['supporting_document']); $icon = in_array($file[1], array('jpg', 'jpeg', 'png'))? '<i class="fas fa-file-image"></i>' : '<i class="fas fa-file-pdf"></i>';?>
									<a class="btn btn-outline-info btn-sm" href="<?php echo site_url('assets/uploads/employee_lic/' . $eld['supporting_document']);?>" target="_blank" title="View supporting document"><?php echo $icon;?></a>
								<?php }?>
							</td>
							<td class="text-center">
								<a class="btn btn-info btn-sm edit-employee-details" href="javascript:void(0)" row-code="<?php echo base64_encode($eld['id']);?>" data-code="<?php echo base64_encode($eld['employee_id']);?>" row-type="lic" title="Edit record"><i class="far fa-edit mr-2"></i>Edit</a>
							</td>
            			</tr>
            		<?php $i++;}?>
            	<?php }else{?>
            		<tr>
            			<td colspan="7" class="text-center text-danger">No record found!</td>
            		</tr>
            	<?php }?>
          	</tbody>
        </table>
	</div>
</div>