<div class="row px-3">
	<div class="col table-responsive">
        <table class="table table-striped border">
          	<thead>
            	<tr>
					<th style="width: 2%">#</th>
					<th>Center</th>
					<th>Designation</th>
					<th>Vacant Post</th>
					<th class="text-center" style="width: 10%">Action</th>
            	</tr>
          	</thead>
          	<tbody>
          		<?php if(isset($results)){$i = $offset + 1;?>
          			<?php foreach ($results as $value) {?>
            			<tr>
							<td><?php echo $i;?></td>
							<td>
								<select class="custom-select auto-update-content-no-enc" id="office_id" data-row-id="<?php echo base64_encode($value['id']);?>" data-row-field="office_id">
									<option value="">-Select Office-</option>
									<?php if(isset($centre_details)){?>
										<?php foreach($centre_details as $cd){?>
											<option value="<?php echo $cd['id'];?>" <?php echo $value['office_id'] == $cd['id']? 'selected' : '';?>><?php echo base64_decode($cd['centre_type_name']) . '-' . base64_decode($cd['centre_name']) . '-' . base64_decode($cd['ro_name']);?></option>
										<?php }?>
									<?php }?>
								</select>
							</td>
							<td>
								<select class="custom-select auto-update-content-no-enc" id="designation_id" data-row-id="<?php echo base64_encode($value['id']);?>" data-row-field="designation_id">
									<option value="">-Select Designation-</option>
									<?php if(isset($designation_master)){?>
										<?php foreach($designation_master as $dm){?>
											<option value="<?php echo $dm['id'];?>" <?php echo $value['designation_id'] == $dm['id']? 'selected' : '';?>><?php echo $dm['description'] . '-' . $dm['type'] . '(' . $dm['shortname'] . ')';?></option>
										<?php }?>
									<?php }?>
								</select>
							</td>
							<td>
								<input type="number" class="form-control auto-update-content-enc" placeholder="Vacant Post" value="<?php echo $value['vacant_post_count'];?>" data-row-id="<?php echo base64_encode($value['id']);?>" data-row-field="vacant_post_count">
							</td>
							<td class="text-center">
								<input type="checkbox" id="toggle-buttton-<?php echo $value['id'];?>" class="status-action" <?php echo $value['status'] == '1'? 'checked' : '';?> data-toggle="toggle" data-on="Show" data-off="Hide" data-onstyle="success" data-offstyle="warning" data-size="small" data-width="100" data-row-id="<?php echo base64_encode($value['id']);?>">
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
<input type="hidden" id="_ftoken" class="_ftoken"  name="_ftoken" value="<?php echo $_ftoken;?>">
<?php if($total_rows > 0){ ?>
	<div class="row border-top p-3">
	    <div class="col">Showing <span class="font-italic"><?php echo 1 + $offset; ?></span> - <span class="font-italic"><?php echo $i - 1; ?></span> of <span class="font-italic"><?php echo $total_rows; ?></span></div>
	    <div class="col"><?php echo $this->pagination->create_links(); ?></div>
	</div>
<?php }?>