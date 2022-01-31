<div class="row">
	<div class="col-6 mb-2">
		<h3 class="card-title">Family Details</h3>
	</div>
	<div class="col-6 mb-2">
		<?php if(!isset($employee_dependents_details)){?>
			<button class="btn btn-success btn-sm add-new-employee-details float-right" href="<?php echo site_url($controller . '/add');?>" title="Add new record" data-row="dependent" data-code="<?php echo base64_encode($employee_details['id']);?>"><i class="fas fa-plus-square mr-2"></i>Add New</button>
		<?php }?>
	</div>
	<div class="col-12 table-responsive">
        <table class="table table-striped border">
          	<thead>
            	<tr>
					<th style="width: 2%">#</th>
					<th>Name</th>
					<th>Relation</th>
					<th>Address</th>
					<th>Nominee CPF & Gratuity</th>
					<th>Nominee Medical  & LTC</th>
					<th class="text-center">Document</th>
					<th class="text-center" style="width: 10%">Action</th>
            	</tr>
          	</thead>
          	<tbody>
          		<?php if(isset($employee_dependents_details)){$i = 1;?>
          			<?php foreach ($employee_dependents_details as $value) {?>
            			<tr>
							<td><?php echo $i;?></td>
							<td>
								<p><?php echo isset($value['rel_name'])? base64_decode($value['rel_name']) : '';?><br>
								<small><strong>DOB: </strong><?php echo isset($value['rel_dob'])? date('d M, Y', strtotime($value['rel_dob'])) : '';?></small></p>
							</td>
							<td><?php echo isset($value['relation'])? base64_decode($value['relation']) : '';?></td>
							<td>
								<p><strong>Address: </strong><?php echo isset($value['address'])? base64_decode($value['address']) : '';?><br>
								<small><strong>Phone Number: </strong><?php echo isset($value['rel_contact'])? base64_decode($value['rel_contact']) : '';?></small></p>
							</td>
							<td>
								<p><strong>CPF: </strong><?php echo isset($value['rel_cpf_nom_percent'])? $value['rel_cpf_nom_percent'] : '0';?>%<br>
								<small><strong>Gratuity: </strong><?php echo isset($value['rel_gratuity_nom_percent'])? $value['rel_gratuity_nom_percent'] : '0';?>%</small></p>
							</td>
							<td>
								<p><strong>Medical: </strong><?php echo isset($value['rel_med_app'])? ($value['rel_med_app'] == '0'? 'No' : 'Yes') : '';?><br>
								<small><strong>LTC: </strong><?php echo isset($value['rel_ltc_app'])? ($value['rel_ltc_app'] == '0'? 'No' : 'Yes') : '';?></small></p>
							</td>
							<td class="text-center">
                                <?php if (isset($value['supporting_document']) && $value['supporting_document'] !== '' && file_exists('./assets/uploads/employee_dependent/' . $value['supporting_document'])) { ?>
                                    <?php $file = explode('.', $value['supporting_document']); $icon = in_array($file[1], array('jpg', 'jpeg', 'png'))? '<i class="fas fa-file-image"></i>' : '<i class="fas fa-file-pdf"></i>';?>
									<a class="btn btn-outline-info btn-sm" href="<?php echo site_url('assets/uploads/employee_dependent/' . $value['supporting_document']);?>" target="_blank" title="View supporting document"><?php echo $icon;?></a>
								<?php }?>
							</td>
							<?php if($i==1){?>
								<td rowspan="<?php echo count($employee_dependents_details);?>" class="text-center bg-light align-middle">
									<a class="btn btn-info btn-sm edit-employee-details" href="javascript:void(0)" data-code="<?php echo base64_encode($employee_details['id']);?>" row-type="dependent" title="Edit record"><i class="far fa-edit mr-2"></i>Edit</a>
								</td>
							<?php }?>
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