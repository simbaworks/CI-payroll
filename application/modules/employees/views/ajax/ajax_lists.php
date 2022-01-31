<script src="<?php echo $js_path; ?>bootstrap-toggle.min.js"></script>
<div class="row px-3">
	<div class="col table-responsive">
        <table class="table table-striped border">
          	<thead>
            	<tr>
					<th style="width: 2%">#</th>
					<th>Employee Id</th>
					<th>Name</th>
					<th>Date of Joining</th>
					<th>Email Id</th>
					<th>Phone Number</th>
					<th class="text-center">Status</th>
					<th class="text-center" style="width: 20%">Action</th>
            	</tr>
          	</thead>
          	<tbody>
          		<?php if(isset($results)){$i = $offset + 1;?>
          			<?php foreach ($results as $value) {?>
            			<tr>
							<td><?php echo $i;?></td>
							<td><?php echo isset($value['emp_id'])? base64_decode($value['emp_id']) : '';?></td>
							<td><?php echo isset($value['emp_name'])? base64_decode($value['emp_name']) : '';?></td>
							<td><?php echo isset($value['emp_doj'])? date('d M, Y', strtotime($value['emp_doj'])) : '';?></td>
							<td><?php echo isset($value['emp_email'])? base64_decode($value['emp_email']) : '';?></td>
							<td><?php echo isset($value['emp_mobile'])? base64_decode($value['emp_mobile']) : '';?></td>
							<td class="text-center">
								<input type="checkbox" id="toggle-buttton-<?php echo $value['id'];?>" class="status-action" <?php echo $value['status'] == '1'? 'checked' : '';?> data-toggle="toggle" data-on="<i class='fas fa-user-lock mr-2'></i> Lock Mode" data-off="<i class='fas fa-user-edit mr-2'></i> Edit Mode" data-onstyle="success" data-offstyle="warning" data-size="small" data-width="150" data-height="35" data-row-id="<?php echo base64_encode($value['id']);?>">
							</td>
							<td class="text-center">
								<a class="btn btn-info btn-sm" href="<?php echo site_url($controller . '/edit/' . base64_encode($value['id']));?>" title="Edit record"><i class="far fa-edit mr-2"></i>Edit</a>

								<a class="btn btn-secondary btn-sm view-employee-record" href="javascript:void(0)" data-code="<?php echo base64_encode($value['id']);?>" title="View record"><i class="far fa-eye mr-2"></i>View</a>
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
<input type="hidden" id="_ftoken" class="_ftoken"  name="_ftoken" value="<?php echo $_ftoken;?>">
<?php if($total_rows > 0){ ?>
	<div class="row border-top p-3">
	    <div class="col">Showing <span class="font-italic"><?php echo 1 + $offset; ?></span> - <span class="font-italic"><?php echo $i - 1; ?></span> of <span class="font-italic"><?php echo $total_rows; ?></span></div>
	    <div class="col"><?php echo $this->pagination->create_links(); ?></div>
	</div>
<?php }?>