<div class="row">
	<div class="col-6">
		<h3 class="card-title">Official Details</h3>
	</div>
	<div class="col-6 mb-2">
		<button class="btn btn-success btn-sm add-new-employee-details float-right" href="<?php echo site_url($controller . '/add');?>" title="Add new record" data-row="official" data-code="<?php echo base64_encode($employee_details['id']);?>"><i class="fas fa-plus-square mr-2"></i>Add New</button>
	</div>
	<div class="col-12 table-responsive">
        <table class="table table-striped border">
          	<thead>
            	<tr>
					<th style="width: 2%">#</th>
					<th>Posting</th>
					<th>Employee Type</th>
					<th>Department</th>
					<th>Reporting Officer </th>
					<th>Service Book Number</th>
					<th>Account Details</th>
					<th class="text-center" style="width: 10%">Action</th>
            	</tr>
          	</thead>
          	<tbody>
          		<?php if(isset($employee_official_details)){$i = 1;?>
          			<?php foreach ($employee_official_details as $value) {?>
            			<tr>
							<td><?php echo $i;?></td>
							<td>
								<p><?php echo isset($value['centre_name'])? base64_decode($value['centre_name']) : '';?><br>
									<small><?php echo isset($value['centre_type_name'])? base64_decode($value['centre_type_name']) . '(' . base64_decode($value['ro_name']) . ')' : '';?></small>
								</p>
							</td>
							<td><?php echo isset($value['type_name'])? base64_decode($value['type_name']) : '';?></td>
							<td>
								<p><strong>Department: </strong><?php echo isset($value['department_name'])? $value['department_name'] : '';?><br>
							    <small><strong>Designation: </strong><?php echo isset($value['description'])? $value['description'] . $value['designation_type'] : '';?></small></p>
							</td>
							<td><?php echo isset($value['emp_name'])? base64_decode($value['emp_name']) : '';?></td>
							<td><?php echo isset($value['service_book_no']) && $value['service_book_no'] !== '0'? $value['service_book_no'] : '';?></td>
							<td>
							    <strong>Co-Opp Acc: </strong><?php echo isset($value['co_opp_acc_no'])? base64_decode($value['co_opp_acc_no']) : '';?>
							</td>
							<td class="text-center">
								<a class="btn btn-info btn-sm edit-employee-details" href="javascript:void(0)" row-code="<?php echo base64_encode($value['id']);?>" data-code="<?php echo base64_encode($value['employee_id']);?>" row-type="official" title="Edit record"><i class="far fa-edit mr-2"></i>Edit</a>
							</td>
            			</tr>
            		<?php $i++;}?>
            	<?php }else{?>
            		<tr>
            			<td colspan="9" class="text-center text-danger">No record found!</td>
            		</tr>
            	<?php }?>
          	</tbody>
        </table>
	</div>
</div>