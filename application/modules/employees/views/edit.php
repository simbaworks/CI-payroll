<div class="row">
	<div class="col">
		<div class="card">
          	<div class="card-header">
				<div class="row">
				    <div class="col">
                		<h3 class="card-title pt-2">Edit Employee Details</h3>
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
	              		<h3 class="card-title p-3 text-info border-right"><strong>Employee: <?php echo isset($employee_details['emp_name'])? base64_decode($employee_details['emp_name']) : '';?></strong></h3>
		                <ul class="nav nav-pills ml-auto p-2">
							<li class="nav-item">
								<a class="nav-link active" data-toggle="tab" href="#custom-personal-details">Personal Details</a>
							</li>
							<?php if($employee_details['emp_pwd_status'] == '1'){?>
								<li class="nav-item">
									<a class="nav-link" data-toggle="tab" href="#custom-pwd">Disability Details</a>
								</li>
							<?php }?>
							<li class="nav-item">
								<a class="nav-link" data-toggle="tab" href="#custom-official-details">Official Details</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" data-toggle="tab" href="#custom-education">Education</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" data-toggle="tab" href="#custom-address">Address</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" data-toggle="tab" href="#custom-bank">Bank Details</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" data-toggle="tab" href="#custom-dependents">Family Details</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" data-toggle="tab" href="#custom-salary">Salary</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" data-toggle="tab" href="#custom-lic">LIC Info</a>
							</li>
		                </ul>
	              	</div>
	              	<div class="card-body">
		                <div class="tab-content">
		                  	<div class="tab-pane active" id="custom-personal-details">
		                  		<?php echo $personal_details;?>
		                  	</div>
							<?php if($employee_details['emp_pwd_status'] == '1'){?>
			                  	<div class="tab-pane fade" id="custom-pwd">
			             			<?php echo $pwd_details;?>
			                  	</div>
							<?php }?>
		                  	<div class="tab-pane fade" id="custom-official-details">
		             			<?php echo $official_details;?>
		                  	</div>
		                  	<div class="tab-pane fade" id="custom-education">
		             			<?php echo $education_details;?>
		                  	</div>
		                  	<div class="tab-pane fade" id="custom-address">
		             			<?php echo $address_details;?>
		                  	</div>
		                  	<div class="tab-pane fade" id="custom-bank">
		             			<?php echo $bank_details;?>
		                  	</div>
		                  	<div class="tab-pane fade" id="custom-dependents">
		             			<?php echo $dependents_details;?>
		                  	</div>
		                  	<div class="tab-pane fade" id="custom-salary">
		             			<?php echo $salary_details;?>
		                  	</div>
		                  	<div class="tab-pane fade" id="custom-lic">
		             			<?php echo $lic_details;?>
		                  	</div>
	                	</div>
	              	</div>
	              	<!-- /.card -->
	            </div>
	        </div>
	    </div>
	</div>
</div>