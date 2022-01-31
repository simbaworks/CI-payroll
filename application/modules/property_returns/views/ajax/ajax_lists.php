<?php 
$employees = array();
if(isset($employee_details)){
	foreach($employee_details as $ed){
		$employees[$ed['id']] = $ed['name']; 
	}
}
?>
<div class="row px-3">
	<div class="col table-responsive">
        <table class="table table-striped border">
          	<thead>
            	<tr>
					<th style="width: 2%">#</th>
					<th>Year</th>
					<th>Employee</th>
					<th>Reviewing Officer</th>
					<th>Document</th>
            	</tr>
          	</thead>
          	<tbody>
          		<?php if(isset($results)){$i = $offset + 1;?>
          			<?php foreach ($results as $value) {?>
            			<tr>
							<td><?php echo $i;?></td>
							<td>
								<?php echo isset($value['year'])? $value['year'] : '';?>
							</td>
							<td>
								<?php echo isset($employees[$value['employee_id']])? base64_decode($employees[$value['employee_id']]) : '';?>
							</td>
							<td>
								<?php echo isset($employees[$value['reviewing_off_id']])? base64_decode($employees[$value['reviewing_off_id']]) : '';?>
							</td>
							<td>
								<?php if (isset($value['supporting_document']) && file_exists('./assets/uploads/property_returns/' . $value['supporting_document'])) { ?>
                                    <?php $file = explode('.', $value['supporting_document']); $icon = in_array($file[1], array('jpg', 'jpeg', 'png'))? '<i class="fas fa-file-image"></i>' : '<i class="fas fa-file-pdf"></i>';?>
									<a class="btn btn-outline-info btn-sm" href="<?php echo site_url('assets/uploads/property_returns/' . $value['supporting_document']);?>" target="_blank" title="View supporting document"><?php echo $icon;?></a>
								<?php }?>
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