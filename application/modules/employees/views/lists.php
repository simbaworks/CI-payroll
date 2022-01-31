<?php 
// echo "<pre>";
// print_r($results);
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
                		<h3 class="card-title pt-1">All Employee Lists</h3>
                	</div>
        			<?php if($this->session->userdata($this->data['sess_code'] . 'user_type') == '0'){?>
	                	<!-- <div class="col">
	                		<a class="btn btn-info btn-sm add-new-ecord float-right" href="<?php echo site_url($controller . '/add');?>" title="Add new record"><i class="fas fa-plus-square mr-2"></i>Add New</a>
	                	</div> -->
	                <?php }?>
                </div>
          	</div>
          </div>
          <div class="card">
          	<div class="card-body p-0">
          		<div class="row p-3">
          			<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 mb-2">
          				<select class="form-control" id="employee-search-filter">
							<option value="">Filter</option>
							<option value="emp_id">Employee Id</option>
							<option value="emp_email">Email Id</option>
							<option value="emp_mobile">Phone Number</option>
							<option value="emp_name">Name</option>
						</select>
          			</div>
          			<div class="col-lg-4 col-md-4 col-sm-7 col-xs-8 mb-2 d-none" id="employee-search-input-div">
          				<input type="text" class="form-control d-none" id="employee-search-input" placeholder="Search by Employee Name">
          			</div>
          			<div class="col-lg-6 col-md-6 col-sm-1 col-xs-2 mb-2">
          				<button class="btn btn-outline-info" id="reset-filter"><i class="fas fa-redo mr-2"></i>Reset</button>
          			</div>
          		</div>
          		<div class="mt-2" id="data_table">
          			<?php echo $data_table;?>
          		</div>
	            <input type="hidden" name="_ftoken" class="_ftoken" id="_ftoken" value="<?php echo $_ftoken; ?>" />
			</div>
			<!-- /.card-body -->
        </div>
    </div>
</div>