<div class="row">
	<div class="col">
		<div class="card">
          	<div class="card-header">
				<div class="row">
                	<div class="col">
                		<a class="btn btn-info btn-sm add-new-ecord float-right" href="<?php echo site_url($controller);?>" title="Back to lists"><i class="fas fa-chevron-left mr-2"></i>Back</a>
                	</div>
                </div>
          	</div>
			<div class="card-body">
				<div class="row">
					<div class="col-12">
						<div class="card">
			              	<div class="card-header d-flex p-0">
				                <ul class="nav nav-pills ml-auto p-2">
									<li class="nav-item">
										<a class="nav-link active" id="home-form-link" data-toggle="tab" href="#home-form">Home</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" id="form-one-link" data-toggle="tab" href="#form-one">Form No.1</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" id="form-two-link" data-toggle="tab" href="#form-two">Form No.2</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" data-toggle="tab" href="#custom-address">Form No.3</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" data-toggle="tab" href="#custom-bank">Form No.4</a>
									</li>
				                </ul>
			              	</div>
			              	<div class="card-body">
				                <div class="tab-content">
				                  	<div class="tab-pane active" id="home-form">
				                  		<?php echo $home;?>
				                  	</div>
				                  	<div class="tab-pane fade" id="form-one">
				             			<?php echo $form1;?>
				                  	</div>
				                  	<div class="tab-pane fade" id="form-two">
				             			<?php echo $form2;?>
				                  	</div>
				                  	<div class="tab-pane fade" id="custom-address">
				             			<?php //echo $address_details;?>
				                  	</div>
				                  	<div class="tab-pane fade" id="custom-bank">
				             			<?php //echo $bank_details;?>
				                  	</div>
			                	</div>
			              	</div>
			              	<!-- /.card -->
			            </div>
			        </div>
			    </div>
			</div>
		</div>
	</div>
</div>