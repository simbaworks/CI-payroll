<div class="row">
	<div class="col-6">
		<h3 class="card-title">Salary Details</h3>
	</div>
	<div class="col-6 mb-2">
		<button class="btn btn-success btn-sm add-new-employee-details float-right" href="<?php echo site_url($controller . '/add');?>" title="Add new record" data-row="salary" data-code="<?php echo base64_encode($employee_details['id']);?>"><i class="fas fa-plus-square mr-2"></i>Add New</button>
	</div>
	<div class="col-12 table-responsive">
        <table class="table table-striped border">
          	<thead>
            	<tr>
					<th style="width: 2%">#</th>
					<th>Scale</th>
					<th>Basics</th>
					<th>Special Pay</th>
					<th>Pay Protection</th>
					<th>DA Type</th>
					<th class="text-center" style="width: 10%">Action</th>
            	</tr>
          	</thead>
          	<tbody>
          		<?php if(isset($employee_salary_details)){$i = 1;?>
          			<?php foreach ($employee_salary_details as $esd) {?>
            			<tr>
							<td><?php echo $i;?></td>
							<td>
								<p><strong>Designation: </strong><?php echo isset($esd['description'])? $esd['description'] : '';?><br>
									<small><strong>Pay Pattern: </strong><?php echo isset($esd['scale'])? $esd['scale'] . '(' . $esd['scale_min'] . ' - ' . $esd['scale_max'] . ')' : '';?></small>
							</td>
							<td><?php echo isset($esd['basics'])? $esd['basics'] : '';?></td>
							<td><?php echo isset($esd['special_pay'])? $esd['special_pay'] : '';?></td>
							<td><?php echo isset($esd['pay_protection'])? $esd['pay_protection'] : '';?></td>
							<td><?php echo isset($esd['da_type'])? $esd['da_type'] : '';?></td>
							<td class="text-center">
								<a class="btn btn-info btn-sm edit-employee-details" href="javascript:void(0)" row-code="<?php echo base64_encode($esd['id']);?>" data-code="<?php echo base64_encode($esd['employee_id']);?>" row-type="salary" title="Edit record"><i class="far fa-edit mr-2"></i>Edit</a>
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