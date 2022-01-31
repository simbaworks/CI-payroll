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
                		<h3 class="card-title">All Centre Lists</h3>
                	</div>
                	<div class="col">
                		<button class="btn btn-info btn-sm add-new-ecord float-right" title="Add new record"><i class="fas fa-plus-square mr-2"></i>Add New</button>
                	</div>
                </div>
          	</div>
          	<!-- /.card-header -->
          	<div class="card-body p-0">
          		<div class="row p-3">
          			<div class="col-lg-1 col-md-1 col-sm-2 col-xs-1 mb-2">
          				<select class="form-control" id="centre-type-input">
							<option value="">Type</option>
							<?php if(isset($centre_types)){?>
								<?php foreach($centre_types as $ct){?>
									<option value="<?php echo $ct['id'];?>"><?php echo base64_decode($ct['centre_type_name']);?></option>
								<?php }?>
							<?php }?>
						</select>
          			</div>
          			<div class="col-lg-1 col-md-1 col-sm-2 col-xs-1 mb-2">
          				<select class="form-control" id="centre-region-input">
							<option value="">Region</option>
							<?php if(isset($regions)){?>
								<?php foreach($regions as $rgn){?>
									<option value="<?php echo $rgn['id'];?>"><?php echo base64_decode($rgn['ro_name']);?></option>
								<?php }?>
							<?php }?>
						</select>
          			</div>
          			<div class="col-lg-6 col-md-6 col-sm-1 col-xs-2 mb-2"></div>
          			<div class="col-lg-4 col-md-4 col-sm-7 col-xs-8 mb-2">
          				<input type="text" class="form-control centre-search-input" placeholder="Search by Centre Name">
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