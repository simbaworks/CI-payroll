<?php 
// echo "<pre>";
// print_r($employee_dependents_details);
?>
<form method="post" action="#" id="ajax-add-form">
	<div class="container shadow">	
		<div class="row border" style="padding: 80px;">
			<div class="col-12 text-center">
		        <p class="font-weight-bold mb-0">FORM No.II</p>
		        <h5 class="font-weight-bold">Statement of the movable assets of self, spouse and dependent children: </h5>
		    </div>
		    <div class="col-12 pt-4 px-4 border cash-in-hand-div">
	            <div class="row">
	            	<div class="col-12 border-bottom">
	            		<p class="font-weight-bold text-info">(i) Cash in hand</p>
	            	</div>
	            	<div class="col-12 pt-3">
		    			<div class="form-group row border-bottom">
						    <label for="cash_in_hand_0" class="col-sm-1 font-weight-normal mt-2">Self</label>
						    <div class="col-sm-11 pb-3">
									<input type="hidden" name="dependent_row_code[]" value="0">
						      	<input type="text" class="form-control" id="cash_in_hand_0" name="cash_in_hand[]" value="" placeholder="Amount in Rupees">
						    </div>
						</div>
		          		<?php if(isset($employee_dependents_details)){$i=1;?>
		          			<?php foreach($employee_dependents_details as $edd){?>
				    			<div class="form-group row <?php echo $i == count($employee_dependents_details)? '' : 'border-bottom';?>">
								    <label for="cash_in_hand_<?php echo $edd['id'];?>" class="col-sm-1 font-weight-normal mt-2">
								    	<?php echo isset($edd['relation'])? base64_decode($edd['relation']) : '';?>
								    </label>
								    <div class="col-sm-11 <?php echo $i == count($employee_dependents_details)? '' : 'pb-3';?>">
      									<input type="hidden" name="dependent_row_code[]" value="<?php echo base64_encode($edd['id']);?>">
								      	<input type="text" class="form-control" id="cash_in_hand_<?php echo $edd['id'];?>" name="cash_in_hand[]" value="" placeholder="Amount in Rupees">
								    </div>
								</div>
							<?php $i++;}?>
						<?php }?>
	            	</div>
	            </div>
		    </div>
		    <div class="col-12 mt-3 p-4 border deposits-div">
	            <div class="row">
	            	<div class="col-12">
	            		<p class="font-weight-bold text-info">(ii) Details  of deposit in Bank accounts (FDRs,Term Deposits and all other types of deposits including(saving accounts), Deposits with financial Institutions, Non-Banking financial Companies and Cooperative societies and the amount in  each such deposit</p>
	            	</div>
	            </div>
	            <div class="row border p-3">
	            	<div class="col-6 pb-2">
					    <p>Self</p>
					</div>
					<div class="col-6 pb-2">
						<button class="btn btn-outline-info btn-sm btn-flat float-right add-more-bank-deposite" row-code="0" row-count="0"><i class="fas fa-plus mr-2"></i>Add More</button>
					</div>
					<div class="col-11">
						<div class="row">
							<div class="col-6 d-none">
								<input type="hidden" name="input_type[]" value="deposites">
							</div>
							<div class="col-6 d-none">
								<input type="hidden" name="dependent_row[]" value="<?php echo base64_encode(0);?>">
							</div>
							<div class="col-4">
						      	<input type="text" class="form-control" id="deposit_amount_0" name="deposit_amount[]" value="" placeholder="Name of Bank/ Financial Institutions">
		          			</div>
							<div class="col-4">
						      	<input type="text" class="form-control" id="deposit_amount_0" name="deposit_amount[]" value="" placeholder="Nature of Deposit">
		          			</div>
							<div class="col-4">
						      	<input type="text" class="form-control" id="deposit_amount_0" name="deposit_amount[]" value="" placeholder="Amount in Rupees">
		          			</div>
		          		</div>
	            	</div>
	            	<div class="col-1"></div>
	            	<div class="col-12" id="deposit_0_0"></div>
	            </div>
          		<?php if(isset($employee_dependents_details)){?>
          			<?php foreach($employee_dependents_details as $edd){?>
			            <div class="row border p-3 mt-3">
			            	<div class="col-6 pb-2">
							    <p><?php echo isset($edd['relation'])? base64_decode($edd['relation']) : '';?></p>
							</div>
							<div class="col-6 pb-2">
								<button class="btn btn-outline-info btn-sm btn-flat float-right add-more-bank-deposite" row-code="<?php echo $edd['id'];?>" row-count="0"><i class="fas fa-plus mr-2"></i>Add More</button>
							</div>
							<div class="col-11">
								<div class="row">
									<div class="col-6 d-none">
										<input type="hidden" name="input_type[]" value="deposites">
									</div>
									<div class="col-6 d-none">
										<input type="hidden" name="dependent_row[]" value="<?php echo base64_encode($edd['id']);?>">
									</div>
									<div class="col-4">
								      	<input type="text" class="form-control" id="deposit_amount_<?php echo $edd['id'];?>" name="deposit_amount[]" value="" placeholder="Name of Bank/ Financial Institutions">
				          			</div>
									<div class="col-4">
								      	<input type="text" class="form-control" id="deposit_amount_<?php echo $edd['id'];?>" name="deposit_amount[]" value="" placeholder="Nature of Deposit">
				          			</div>
									<div class="col-4">
								      	<input type="text" class="form-control" id="deposit_amount_<?php echo $edd['id'];?>" name="deposit_amount[]" value="" placeholder="Amount in Rupees">
				          			</div>
				          		</div>
			            	</div>
			            	<div class="col-1"></div>
	            			<div class="col-12" id="deposit_<?php echo $edd['id'];?>_0"></div>
			            </div>
					<?php }?>
				<?php }?>
		    </div>
		    <div class="col-12 mt-3 p-4 border investment-in-bonds-div">
	            <div class="row">
	            	<div class="col-12">
	            		<p class="font-weight-bold text-info">(iii)	Details of  investment  in Bonds. Debentures/ shares and units in companies/ mutual funds and others Name of company</p>
	            	</div>
	            </div>
	            <div class="row border p-3">
	            	<div class="col-6 pb-2">
					    <p>Self</p>
					</div>
					<div class="col-6 pb-2">
						<button class="btn btn-outline-info btn-sm btn-flat float-right add-more-investment-in-bonds" row-code="0" row-count="0"><i class="fas fa-plus mr-2"></i>Add More</button>
					</div>
					<div class="col-11">
						<div class="row">
							<div class="col-6">
						      	<input type="text" class="form-control" name="investment_in_bonds_company[]" value="" placeholder="Name of Company">
		          			</div>
							<div class="col-6">
						      	<input type="text" class="form-control" name="investment_in_bonds_amount[]" value="" placeholder="Amount in Rupees">
		          			</div>
		          		</div>
	            	</div>
	            	<div class="col-1"></div>
	            	<div class="col-12" id="investment_in_bonds_0_0"></div>
	            </div>
          		<?php if(isset($employee_dependents_details)){?>
          			<?php foreach($employee_dependents_details as $edd){?>
			            <div class="row border p-3 mt-3">
			            	<div class="col-6 pb-2">
							    <p><?php echo isset($edd['relation'])? base64_decode($edd['relation']) : '';?></p>
							</div>
							<div class="col-6 pb-2">
								<button class="btn btn-outline-info btn-sm btn-flat float-right add-more-investment-in-bonds" row-code="<?php echo $edd['id'];?>" row-count="0"><i class="fas fa-plus mr-2"></i>Add More</button>
							</div>
							<div class="col-11">
								<div class="row">
									<div class="col-6">
								      	<input type="text" class="form-control" name="deposit_amount[]" value="" placeholder="Name of Company">
				          			</div>
									<div class="col-6">
								      	<input type="text" class="form-control" name="deposit_amount[]" value="" placeholder="Amount in Rupees">
				          			</div>
				          		</div>
			            	</div>
			            	<div class="col-1"></div>
	            			<div class="col-12" id="investment_in_bonds_<?php echo $edd['id'];?>_0"></div>
			            </div>
					<?php }?>
				<?php }?>
		    </div>
		    <div class="col-12">
		    	<!-- <button class="btn btn-info btn-sm float-right save-form-1-data"><i class="fas fa-save mr-2"></i>Save</button> -->
		    </div>
		    <div class="col-12" style="padding:200px;"></div>
		</div>
	</div>
</form>

<script type="text/javascript">
	$(document).on('click', '.add-more-bank-deposite', function(evt){
		evt.preventDefault();
		var row_code = $(this).attr('row-code');
		var row_count = $(this).attr('row-count');
		var new_row_count = parseInt(row_count) + 1;

		if(row_code !== ''){
			var html = '<div class="col-12 pt-3" id="deposit_' + row_code + '_' + new_row_count + '">';
			html += '<div class="row">';
			html += '<div class="col-11">';
			html += '<div class="row">';
			html += '<div class="col-6 d-none">';
			html += '<input type="hidden" name="input_type[]" value="deposites">';
			html += '</div>';
			html += '<div class="col-6 d-none">';
			html += '<input type="hidden" name="dependent_row[]" value="' + row_code + '">';
			html += '</div>';
			html += '<div class="col-4">';
			html += '<input type="text" class="form-control" id="deposit_amount_' + row_code + '" name="deposit_amount[]" value="" placeholder="Name of Bank/ Financial Institutions">';
			html += '</div>';
			html += '<div class="col-4">';
			html += '<input type="text" class="form-control" id="deposit_amount_' + row_code + '" name="deposit_amount[]" value="" placeholder="Nature of Deposit">';
			html += '</div>';
			html += '<div class="col-4">';
			html += '<input type="text" class="form-control" id="deposit_amount_' + row_code + '" name="deposit_amount[]" value="" placeholder="Amount in Rupees">';
			html += '</div>';
			html += '</div>';
			html += '</div>';
			html += '<div class="col-1">';
			html += '<button class="btn btn-outline-danger btn-sm btn-flat float-right remove-bank-deposite" row-code="' + row_code + '" row-count="' + new_row_count + '"><i class="fas fa-minus px-2"></i></button>';
			html += '</div>';
			html += '</div>';
			html += '</div>';

			$('#deposit_' + row_code + '_0').before(html);
			$(this).attr('row-count', new_row_count);
		}
	});

	$(document).on('click', '.remove-bank-deposite', function(evt){
		evt.preventDefault();
		var row_code = $(this).attr('row-code');
		var row_count = $(this).attr('row-count');

		if(row_code !== ''){
			$('#deposit_' + row_code + '_' + row_count).remove();
		}
	});

	// investment-in-bonds
	$(document).on('click', '.add-more-investment-in-bonds', function(evt){
		evt.preventDefault();
		var row_code = $(this).attr('row-code');
		var row_count = $(this).attr('row-count');
		var new_row_count = parseInt(row_count) + 1;

		if(row_code !== ''){
			var html = '<div class="col-12 pt-3" id="investment_in_bonds_' + row_code + '_' + new_row_count + '">';
			html += '<div class="row">';
			html += '<div class="col-11">';
			html += '<div class="row">';
			html += '<div class="col-6 d-none">';
			html += '<input type="hidden" name="input_type[]" value="investment">';
			html += '</div>';
			html += '<div class="col-6 d-none">';
			html += '<input type="hidden" name="dependent_row[]" value="' + row_code + '">';
			html += '</div>';
			html += '<div class="col-6">';
			html += '<input type="text" class="form-control" name="deposit_amount[]" value="" placeholder="Name of Company">';
			html += '</div>';
			html += '<div class="col-6">';
			html += '<input type="text" class="form-control" name="deposit_amount[]" value="" placeholder="Amount in Rupees">';
			html += '</div>';
			html += '</div>';
			html += '</div>';
			html += '<div class="col-1">';
			html += '<button class="btn btn-outline-danger btn-sm btn-flat float-right remove-investment-in-bonds" row-code="' + row_code + '" row-count="' + new_row_count + '"><i class="fas fa-minus px-2"></i></button>';
			html += '</div>';
			html += '</div>';
			html += '</div>';

			$('#investment_in_bonds_' + row_code + '_0').before(html);
			$(this).attr('row-count', new_row_count);
		}
	});

	$(document).on('click', '.remove-investment-in-bonds', function(evt){
		evt.preventDefault();
		var row_code = $(this).attr('row-code');
		var row_count = $(this).attr('row-count');

		if(row_code !== ''){
			$('#investment_in_bonds_' + row_code + '_' + row_count).remove();
		}
	});
</script>