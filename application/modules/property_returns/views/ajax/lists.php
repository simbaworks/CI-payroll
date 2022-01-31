<?php 
$employees = array();
if(isset($employee_details)){
	foreach($employee_details as $ed){
		$employees[$ed['id']] = $ed['emp_name']; 
	}
}
?>
<div class="row px-3">
	<div class="col table-responsive">
        <table class="table table-striped border">
          	<thead>
            	<tr>
					<th style="width: 2%">#</th>
					<th>Employee</th>
					<th>Submission Date</th>
					<th class="text-right">Action</th>
            	</tr>
          	</thead>
          	<tbody>
          		<?php if(isset($results)){$i = $offset + 1;?>
          			<?php foreach ($results as $value) {?>
            			<tr>
							<td><?php echo $i;?></td>
							<td>
								<?php echo isset($employees[$value['employee_id']])? base64_decode($employees[$value['employee_id']]) : '';?>
							</td>
							<td>
								<?php echo isset($value['created'])? date('d M, Y', strtotime($value['created'])) : '';?>
							</td>
							<td>
                				<button class="btn btn-info btn-sm view-pr-record float-right" title="View record" data-code="<?php echo base64_encode($value['employee_id']);?>"><i class="far fa-eye mr-2"></i>View</button>	

	                			<?php if(isset($property_returns_date_settings) && strtotime($property_returns_date_settings['start_date']) <= time() && strtotime($property_returns_date_settings['end_date']) >= time()){?>							
	                				<a class="btn btn-info btn-sm edit-pr-record float-right mr-2" href="<?php echo site_url($controller . '/edit_pr_data/' . base64_encode($value['employee_id']));?>" title="Edit record"><i class="far fa-edit mr-2"></i>Edit</a>
	                			<?php }?>
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