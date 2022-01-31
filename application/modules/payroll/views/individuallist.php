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
                		<h3 class="card-title">My Salary Lists</h3>
                	</div>
                	<div class="col">
                		<button class="btn btn-info btn-sm add-new-ecord float-right" title="Add new record"><i class="fas fa-plus-square mr-2"></i>Generate Payslip</button>
                	</div>
                </div>
          	</div>
          	<!-- /.card-header -->
          	<div class="card-body p-0">
          		<!-- <div class="row p-3">
          			<div class="col-lg-8 col-md-8 col-sm-4 col-xs-4">
          			</div>
          			<div class="col-lg-4 col-md-4 col-sm-8 col-xs-8">
          				<input type="text" class="form-control search-input" placeholder="Search by Caste Name">
          			</div>
          		</div> -->
          		<div id="data_table">
          			<!-- <script src="<?php echo $js_path; ?>bootstrap-toggle.min.js"></script> -->
					<div class="row px-3">
						<div class="col table-responsive">
					        <table class="table table-striped border">
					          	<thead>
					            	<tr>
										<th style="width: 2%">#</th>
										<th>Year</th>
										<th>Month</th>
										<th class="text-center" style="width: 10%">Action</th>
					            	</tr>
					          	</thead>
					          	<tbody>
					          		<?php if(!empty($mySalary)){$i =1;?>
					          			<?php foreach ($mySalary as $value) {?>
					            			<tr>
												<td> <?php echo $i; ?></td>
												<td>
													<?php echo $value['year']?>
												</td>
												<td >
													<?php  echo $value['month']?>
												</td>
												<td>
													<div class="text-center">
														<a href="<?php echo site_url('payroll/single_slip/').$value['id'] ?>" class="btn btn-primary btn-sm">View</a>
													</div>	
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
					
          		</div>
			</div>
			<!-- /.card-body -->
        </div>
    </div>
</div>