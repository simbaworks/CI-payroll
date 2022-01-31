<div class="row">
	<div class="col-6">
		<h3 class="card-title">Educational History</h3>
	</div>
	<div class="col-6 mb-2">
		<button class="btn btn-success btn-sm add-new-employee-details float-right" href="<?php echo site_url($controller . '/add');?>" title="Add new record" data-row="education" data-code="<?php echo base64_encode($employee_details['id']);?>"><i class="fas fa-plus-square mr-2"></i>Add New</button>
	</div>
	<div class="col-12 table-responsive">
        <table class="table table-striped border">
          	<thead>
            	<tr>
					<th style="width: 2%">#</th>
					<th>Degree</th>
					<th>Degree Type</th>
					<th>Specialization</th>
					<th>Marks Obtained</th>
					<th>Year of Passing</th>
					<th>Board/University</th>
					<th>Certificate Number </th>
					<th class="text-center">Document</th>
					<th class="text-center" style="width: 10%">Action</th>
            	</tr>
          	</thead>
          	<tbody>
          		<?php if(isset($employee_education_details)){$i = 1;?>
          			<?php foreach ($employee_education_details as $value) {?>
            			<tr>
							<td><?php echo $i;?></td>
							<td><?php echo isset($value['degree_name'])? base64_decode($value['degree_name']) : '';?></td>
							<td><?php echo isset($value['type_of_degree'])? ucwords(str_replace('_', ' ', $value['type_of_degree'])) : '';?></td>
							<td><?php echo isset($value['specialization'])? $value['specialization'] : '';?></td>
							<td><?php echo isset($value['marks_obtained'])? base64_decode($value['marks_obtained']) : '';?></td>
							<td><?php echo isset($value['date_of_passing'])? date('d M, Y', strtotime($value['date_of_passing'])) : '';?></td>
							<td><?php echo isset($value['bu_name'])? base64_decode($value['bu_name']) : '';?></td>
							<td><?php echo isset($value['certificate_number'])? $value['certificate_number'] : '';?></td>
							<td class="text-center">
                                <?php if (isset($value['supporting_document']) && file_exists('./assets/uploads/employee_education/' . $value['supporting_document'])) { ?>
                                    <?php $file = explode('.', $value['supporting_document']); $icon = in_array($file[1], array('jpg', 'jpeg', 'png'))? '<i class="fas fa-file-image"></i>' : '<i class="fas fa-file-pdf"></i>';?>
									<a class="btn btn-outline-info btn-sm" href="<?php echo site_url('assets/uploads/employee_education/' . $value['supporting_document']);?>" target="_blank" title="View supporting document"><?php echo $icon;?></a>
								<?php }?>
							</td>
							<td class="text-center">
								<a class="btn btn-info btn-sm edit-employee-details" href="javascript:void(0)" row-code="<?php echo base64_encode($value['id']);?>" data-code="<?php echo base64_encode($value['employee_id']);?>" row-type="education" title="Edit record"><i class="far fa-edit mr-2"></i>Edit</a>
							</td>
            			</tr>
            		<?php $i++;}?>
            	<?php }else{?>
            		<tr>
            			<td colspan="10" class="text-center text-danger">No record found!</td>
            		</tr>
            	<?php }?>
          	</tbody>
        </table>
	</div>
</div>