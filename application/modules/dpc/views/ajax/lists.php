<?php 
$employees = array();
$vacant_post_details = array();
if(isset($employee_details)){
	foreach($employee_details as $ed){
		$employees[$ed['id']] = $ed['name']; 
	}
}
if(isset($vacant_post)){
	foreach($vacant_post as $vp){
		$vacant_post_details[$vp['id']] = '[' . base64_decode($vp['centre_name']) . '] ' . $vp['description'];
	}
}
?>
<div class="row px-3">
	<div class="col table-responsive">
        <table class="table table-striped border">
          	<thead>
            	<tr>
					<th style="width: 2%">#</th>
					<th>Vacant Post</th>
					<th>DPC Members</th>
					<th class="text-center" style="width: 10%">Action</th>
            	</tr>
          	</thead>
          	<tbody>
          		<?php if(isset($results)){$i = $offset + 1;?>
          			<?php foreach ($results as $value) {?>
            			<tr>
							<td><?php echo $i;?></td>
							<td>
								<?php echo isset($vacant_post_details[$value['vacant_post_id']])? $vacant_post_details[$value['vacant_post_id']] : '';?>
							</td>
							<td>
								<?php 
									$employee_list = isset($value['employee_ids'])? explode(',', $value['employee_ids']) : array(); 
									$employee = array();
									if(count($employee_list) > 0){
										for($i = 0; $i < count($employee_list); $i++){
											$employee[] = isset($employees[$employee_list[$i]])? base64_decode($employees[$employee_list[$i]]) : '';
										}
									}
								?>
								<?php echo implode(', ', $employee);?>
							</td>
							<td class="text-center">
								<input type="checkbox" id="toggle-buttton-<?php echo $value['id'];?>" class="status-action" <?php echo $value['status'] == '1'? 'checked' : '';?> data-toggle="toggle" data-on="Show" data-off="Hide" data-onstyle="success" data-offstyle="warning" data-size="small" data-width="100" data-row-id="<?php echo base64_encode($value['id']);?>">
							</td>
            			</tr>
            		<?php $i++;}?>
            	<?php }else{?>
            		<tr>
            			<td colspan="4" class="text-center text-danger">No record found!</td>
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