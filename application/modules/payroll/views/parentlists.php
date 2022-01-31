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
                		<h3 class="card-title">All Salary Lists</h3>
                	</div>
                	<div class="col">
                		<button class="btn btn-info btn-sm generate-payslip float-right" title="Add new record"><i class="fas fa-plus-square mr-2"></i>Generate Payslip</button>
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
					          		<?php if(!empty($headList)){ ?>
					          			<?php $i=1; ?>
					          			<?php foreach ($headList as $value) {?>
					            			<tr>
												<td> <?php echo $i; ?></td>
												<td>
													<?php  echo $value['year']?>

												</td>
												<td >
													<?php  echo $value['month']?>
												</td>
												<td>View</td>
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

<script type="text/javascript">
	$(document).ready(function(){
		$(".generate-payslip").on("click", function(e){
			// e.preventDefault();
			// alert("Sa")
			$.ajax({
		        beforeSend : function(){
		          $(".loader").show();
		        },
		        url: '<?php echo site_url('payroll/generate_payslip_ajax')?>',
		        type: "POST",
		        data: {
		            
		        },
		        success: function (data) {
		        	console.log(data)
		            if(data == 1){
		               alert('Payslip generated')
		            }
		            if( data == 0 ){
		                alert('Payslip already generated for this month')
		                $(".loader").hide();
		            }
		            // if( data == 5 ){
		            //     alert('Image upload problem!')
		            //     $(".loader").hide();
		            // }
		        },
		        error: function (data) {
		            console.log(data);
		        }
		    });//ajax
		})
		
	 });
</script>