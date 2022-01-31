<script src="<?php echo $js_path; ?>bootstrap-toggle.min.js"></script>
<div class="row px-3">
	<div class="col table-responsive">
        <table class="table table-striped border">
          	<thead>
            	<tr>
					<th style="width: 2%">#</th>
					<th>Name</th>
					<th class="text-center" style="width: 10%">Action</th>
            	</tr>
          	</thead>
          	<tbody>
          		<?php if(isset($results)){$i = $offset + 1;?>
          			<?php foreach ($results as $value) {?>
            			<tr>
							<td><?php echo $i;?></td>
							<td>
								<input type="text" class="form-control auto-update-content-enc" placeholder="Caste Name" value="<?php echo base64_decode($value['union_name']);?>" data-row-id="<?php echo base64_encode($value['id']);?>" data-row-field="union_name">
							</td>
							<td class="text-center">
								<input type="checkbox" id="toggle-buttton-<?php echo $value['id'];?>" class="status-action" <?php echo $value['status'] == '1'? 'checked' : '';?> data-toggle="toggle" data-on="Show" data-off="Hide" data-onstyle="success" data-offstyle="warning" data-size="small" data-width="100" data-row-id="<?php echo base64_encode($value['id']);?>">
							</td>
            			</tr>
            		<?php $i++;}?>
            	<?php }else{?>
            		<tr>
            			<td colspan="3" class="text-center text-danger">No record found!</td>
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