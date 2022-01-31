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
                		<h3 class="card-title">All Degree Lists</h3>
                	</div>
                	<div class="col">
                		<button class="btn btn-info btn-sm add-new-ecord float-right" title="Add new record"><i class="fas fa-plus-square mr-2"></i>Add New</button>
                	</div>
                </div>
          	</div>
          	<!-- /.card-header -->
          	<div class="card-body p-0">
          		<div class="row p-3">
          			<div class="col-lg-8 col-md-8 col-sm-4 col-xs-4">
          			</div>
          			<div class="col-lg-4 col-md-4 col-sm-8 col-xs-8">
          				<input type="text" class="form-control search-input" placeholder="Search by Degree">
          			</div>
          		</div>
          		<div id="data_table">
          			<?php echo $data_table;?>
          		</div>
			</div>
			<!-- /.card-body -->
        </div>
    </div>
</div>