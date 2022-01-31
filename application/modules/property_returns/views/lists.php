<?php 
// echo "<pre>";
// print_r($property_returns_details);
// exit();
?>
<style type="text/css">
label:not(.form-check-label):not(.custom-file-label) {
    font-weight: 400 !important;
}
</style>
<div class="row">
	<div class="col">
		<div class="card">
          	<div class="card-header">
				<div class="row">
				    <div class="col">
                		<h3 class="card-title">All Property Returns Lists</h3>
                	</div>
                	<div class="col">
                		<?php if(isset($property_returns_date_settings) && strtotime($property_returns_date_settings['start_date']) <= time() && strtotime($property_returns_date_settings['end_date']) >= time() && !isset($property_returns_details)){?>
                			<a class="btn btn-info btn-sm float-right"  href="<?php echo site_url($controller . '/add/' . base64_encode($this->session->userdata($this->data['sess_code'] . 'user_id')));?>" title="Property Return"><i class="fas fa-plus-square mr-2"></i>Property Return</a>
                		<?php }?>
                		<?php if ($this->session->userdata($this->data['sess_code'] . 'user_type') == '0') {?>
                			<a class="btn btn-success btn-sm float-right mr-2" href="<?php echo site_url($controller . '/property_return_settings');?>" title="Add new record"><i class="fas fa-cogs mr-2"></i>Property Return Settings</a>
                		<?php }?>
                	</div>
                </div>
          	</div>
          	<!-- /.card-header -->
          	<div class="card-body p-0">
          		<div class="row p-3">
          		</div>
          		<div id="data_table">
          			<?php echo $data_table;?>
          		</div>
			</div>
			<!-- /.card-body -->
        </div>
    </div>
</div>