<div class="row">
	<div class="col-6">
		<h3 class="card-title">PWD Information</h3>
	</div>
	<div class="col-6 mb-2">
		<button class="btn btn-success btn-sm add-new-employee-details float-right" href="<?php echo site_url($controller . '/add');?>" title="Add new record" data-row="diability" data-code="<?php echo base64_encode($employee_details['id']);?>"><i class="fas fa-plus-square mr-2"></i>Add New</button>
	</div>
	<div class="col-12 table-responsive">
        <table class="table table-striped border">
          	<thead>
            	<tr>
					<th style="width: 2%">#</th>
					<th>PWD Type</th>
					<th>Percentage</th>
					<th class="text-center">Disability Certificate</th>
					<th class="text-center" style="width: 10%">Action</th>
            	</tr>
          	</thead>
          	<tbody>
          		<?php if(isset($employee_pwd_details)){$i = 1;?>
          			<?php foreach ($employee_pwd_details as $epd) {?>
            			<tr>
							<td><?php echo $i;?></td>
							<td><?php echo isset($epd['pwd_name'])? base64_decode($epd['pwd_name']) : '';?></td>
							<td><?php echo isset($epd['pwd_percentage'])? base64_decode($epd['pwd_percentage']) . '%' : '';?></td>
							<td class="text-center">
                                <?php if (isset($epd['disability_certificate']) && file_exists('./assets/uploads/disability_certificates/' . $epd['disability_certificate'])) { ?>
                                    <?php $file = explode('.', $epd['disability_certificate']); $icon = in_array($file[1], array('jpg', 'jpeg', 'png'))? '<i class="fas fa-file-image"></i>' : '<i class="fas fa-file-pdf"></i>';?>
									<a class="btn btn-outline-info btn-sm" href="<?php echo site_url('assets/uploads/disability_certificates/' . $epd['disability_certificate']);?>" target="_blank" title="View supporting document"><?php echo $icon;?></a>
								<?php }?>
							</td>
							<td class="text-center">
								<a class="btn btn-info btn-sm edit-employee-details" href="javascript:void(0)" row-code="<?php echo base64_encode($epd['id']);?>" data-code="<?php echo base64_encode($epd['emp_id']);?>" row-type="diability" title="Edit record"><i class="far fa-edit mr-2"></i>Edit</a>
							</td>
            			</tr>
            		<?php $i++;}?>
            	<?php }else{?>
            		<tr>
            			<td colspan="5" class="text-center text-danger">No record found!</td>
            		</tr>
            	<?php }?>
          	</tbody>
        </table>
	</div>
</div>