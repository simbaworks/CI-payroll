<?php 
$centre_info = array();
$designation_info = array();
if(isset($centre_details)){
	foreach($centre_details as $cd){
		$centre_info[$cd['id']] = base64_decode($cd['centre_type_name']) . '-' . base64_decode($cd['centre_name']) . '-' . base64_decode($cd['ro_name']);
	}
}
if(isset($designation_master)){
	foreach($designation_master as $dm){
		$designation_info[$dm['id']] = $dm['description'] . '-' . $dm['type'] . '(' . $dm['shortname'] . ')';
	}

}
?>
<div class="row px-3">
	<div class="col table-responsive">
        <table class="table table-striped border">
          	<thead>
            	<tr>
					<th style="width: 2%">#</th>
					<th>Center</th>
					<th>Vacant Post</th>
					<th class="text-center" style="width: 10%">Action</th>
            	</tr>
          	</thead>
          	<tbody>
          		<?php if(isset($results)){$i = $offset + 1;?>
          			<?php foreach ($results as $value) {?>
            			<tr>
							<td><?php echo $i;?></td>
							<td><?php echo isset($centre_info[$value['office_id']])? $centre_info[$value['office_id']] : '';?></td>
							<td><?php echo isset($designation_info[$value['designation_id']])? $designation_info[$value['designation_id']] : '';?></td>
							<td class="text-center">
								<a class="btn btn-outline-info btn-sm btn-flat" href="<?php echo site_url($controller . '/details/' . base64_encode($value['id']));?>">View</a>
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