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
                		<h3 class="card-title">Employee Details</h3>
                	</div>
                	
                </div>
          	</div>
          	<!-- /.card-header -->
          	<div class="card-body p-0">
          		<div class="fluid-container mt-4">
          			<div class="row">
	          			<div class="col-md-2 text-center">
	          				<p>	
	          					
	          					<b>Employee Code - </b> <?php echo base64_decode($empdetails['emp_id']); ?>    
	          				</p>
	          			</div>
	          			<div class="col-md-2 text-center">
	          				<p>
	          					
	          					<b>Month </b> <?php echo $salarydetails['month']; ?>
	          				    
	          				</p>
	          			</div>
	          			<div class="col-md-2 text-center">
	          				<p>
	          					
	          					<b>Year </b> <?php echo $salarydetails['year']; ?>
	          				    
	          				</p>
	          			</div>
	          			<div class="col-md-2 text-center">
	          				<p>
	          					
	          					<b>Designation - </b> <?php echo ($empdetails['description']); ?>
	          				  
	          				</p>
	          			</div>
	          			<div class="col-md-2 text-center">
	          				<p>
	          					<b>Department - </b> <?php echo ($empdetails['name']); ?>
	          				</p>
	          			</div>
	          			
	          		</div>

          		</div>
          		
			</div>
			<!-- /.card-body -->
        </div>
    </div>
</div>

<div class="row">
	<div class="col">
		<div class="card">
          	<div class="card-header">
				<div class="row">
				    <div class="col">
                		<h3 class="card-title">Employee Earnings</h3>
                	</div>
                	
                </div>
          	</div>
          	<!-- /.card-header -->
          	<div class="card-body p-0">
          		<div class="fluid-container mt-4">
          			<div class="row">
	          			<div class="col-md-3 text-center">
	          				<p>
	          					<b>Basics </b> <?php echo $salarydetails['basics']; ?>
	          				</p>
	          			</div>
	          			<div class="col-md-3 text-center">
	          				<p>
	          					<b>DA - </b> <?php echo $salarydetails['da_amount']; ?>
	          				</p>
	          			</div>
	          			<div class="col-md-3 text-center">
	          				<p>
	          					<b>HRA - </b> <?php echo $salarydetails['hra_amount']; ?>
	          				</p>
	          			</div>
	          			<div class="col-md-3 text-center">
	          				<p>
	          					<b>TA - </b> 10
	          				</p>
	          			</div>
	          		</div>

          		</div>
          		
			</div>
			<!-- /.card-body -->
			<div class="card-footer">
				<div class="row">
          			<div class="col-md-12 text-center">
          				<p>
          					<b>Total Income : </b> <?php echo $salarydetails['total_income']; ?>
          				</p>
          			</div>
          			
          		</div>
			</div>
        </div>
    </div>
</div>

<div class="row">
	<div class="col">
		<div class="card">
          	<div class="card-header">
				<div class="row">
				    <div class="col">
                		<h3 class="card-title">Employee Deduction</h3>
                	</div>
                	
                </div>
          	</div>
          	<!-- /.card-header -->
          	<div class="card-body p-0">
          		<div class="fluid-container mt-4">
          			<div class="row">
	          			<div class="col-md-3 text-center">
	          				<p>
	          					<b>PF </b> 33
	          				</p>
	          			</div>
	          		</div>

          		</div>
          		
			</div>
			<div class="card-footer">
				<div class="row">
          			<div class="col-md-12 text-center">
          				<p>
          					<b>Total Deduction : </b> <?php echo $salarydetails['total_deduction']; ?>
          				</p>
          			</div>
          			
          		</div>
			</div>
			<!-- /.card-body -->
        </div>
    </div>
</div>
<div class="row">
	<div class="col text-center">
		<div class="card">
          	<div class="card-header">
				<div class="row">
				    <div class="col">
                		<h3 class="card-title ">Total - <?php echo $salarydetails['total']; ?></h3>
                	</div>
                </div>
          	</div>
        </div>
    </div>
</div>