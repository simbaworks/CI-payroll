<div class="row">
	<div class="col">
		<div class="card">
          	<div class="card-header">
				<div class="row">
				    <div class="col">
                		<h3 class="card-title pt-2">Vacant Post Details</h3>
                	</div>
                	<div class="col">
                		<a class="btn btn-info btn-sm add-new-ecord float-right" href="<?php echo site_url($controller . '/lists');?>" title="Back to lists"><i class="fas fa-chevron-left mr-2"></i>Back</a>
                	</div>
                </div>
          	</div>
      	</div>
		<div class="row">
			<div class="col-12">
				<div class="card">
	              	<div class="card-header d-flex p-0">
		                <ul class="nav nav-pills ml-auto p-2">
							<li class="nav-item">
								<a class="nav-link active" data-toggle="tab" href="#custom-personal-details">Eligible Candidate</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" data-toggle="tab" href="#custom-official-details">Eligibility Test Result</a>
							</li>
		                </ul>
	              	</div>
	              	<div class="card-body">
		                <div class="tab-content">
		                  	<div class="tab-pane active" id="custom-personal-details">
		                  		<?php echo $personal_details;?>
		                  	</div>
		                  	<div class="tab-pane fade" id="custom-official-details">
		             			<?php echo $official_details;?>
		                  	</div>
	                	</div>
	              	</div>
	              	<!-- /.card -->
	            </div>
	        </div>
	    </div>
	</div>
</div>