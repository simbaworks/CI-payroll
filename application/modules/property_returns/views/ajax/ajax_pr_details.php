<?php
$form_one_data = array(); 
if(isset($pr_form_one_details)){
	foreach($pr_form_one_details as $prfod){
		$dependent_id = base64_decode($prfod['dependent_id']);
		$form_one_data[$dependent_id]['public_positions'] = base64_decode($prfod['public_positions']);
		$form_one_data[$dependent_id]['is_separately_return'] = base64_decode($prfod['is_separately_return']);
	}
}
// echo "<pre>";
// print_r($form_one_data);
?>
<div class="row">
	<div class="col-12" id="pr-home-data">
		<div class="container shadow">	
			<div class="row border" style="padding: 80px;">
				<div class="col-12">
					<p class="text-right"><b>APPENDIX-I<br>[Rule 3(1)]</b></p>
				</div>
				<div class="col-12">
			        <p class="mb-0">Return of Assets and Liabilities on First Appointment or as on the <?php echo date('d F Y', strtotime($property_returns_details['created']));?></p>
			        <p>(Under Sec 44 of the Lokpal and Lokayuktas Act, 2013)</p>
			    </div>
			    <div class="col-12">
			    	<ol>
			    		<li>Name of the Public servant in full<span class="font-weight-bold pl-2"><?php echo strtoupper(base64_decode($employee_details['emp_name']));?></span><br>
			    			(in block letters)
			    		</li>
			    		<li>
			    			<div class="form-group row">
							    <label for="public_position" class="col-sm-4 font-weight-normal">(a) Present public position held</label>
							    <div class="col-sm-8">
							      	<span class="form-control">
							      		<?php echo isset($property_returns_details['public_position'])? $property_returns_details['public_position'] : '';?>
							      	</span>
							    </div>
							    <div class="col-sm-12">(Designation, name and address of organization)</div>
							</div>
			    			<div class="form-group row">
							    <label for="belonged_service" class="col-sm-4 font-weight-normal">(b) Service to which belongs</label>
							    <div class="col-sm-8">
							      	<span class="form-control">
							      		<?php echo isset($property_returns_details['belonged_service'])? $property_returns_details['belonged_service'] : '';?>
							      	</span>
							    </div>
							</div>
			    		</li>
			    	</ol>
			    </div>
			    <div class="col-12">
			    	<p>I hereby declare that the return enclosed namely, Forms I to IV are complete, true and correct to the best of my knowledge and belief, in respect of information due to the furnished by me under the provisions of section 44 of the Lokpal and Lokayuktas Act, 2013.</p>
			    </div>
			    <div class="col-6">
			    	Date: <?php echo date('d/m/Y', strtotime($property_returns_details['created']));?>
			    </div>
			    <div class="col-6">
			    	Signature:
			    </div>
			    <div class="col-12">
			    	<p>*In case of first appointment please indicate date of appointment.</p>
			    </div>
			    <div class="col-2"></div>
			    <div class="col-8 border-bottom"></div>
			    <div class="col-2"></div>
			    <div class="col-12 pt-3">
			    	<p>Note 1. This return shall contain particulars of all assets and liabilities of the public servant either in his/ her own name or in the name of any other person. The return should include details in respect of assets/ liabilities of spouse and dependent children as provided in Section 44 (2) of the Lokpal and Lokayuktas Act, 2013.</p>
			    	<p>(Section 44(2): A public servant shall, within a period of thirty days from the date on which he makes and subscribes on oath or affirmation to enter upon his office, furnish to the competent authority the information relating to —
			    		<ol type="a">
			    			<li>the assets of which he, his spouse and his dependent children are, jointly or separately, owners or beneficiaries;</li>
			    			<li>his liabilities and that of his spouse and his dependent children.)</li>
			    		</ol>
			    	</p>
			    	<p>Note 2: If a public servant is a member of Hindu Undivided Family with co- parcenary rights in the properties of the family either as a 'Karta' or as a member, he should indicate in the return in Form No. III the value of his share in such property and where it is not possible to indicate the exact value of such share, its approximate value. Suitable explanatory notes may be added wherever necessary.</p>
			    	<p>Note 3: "dependent children" means sons and daughters who have no separate means of earning and are wholly dependent on the public servant for their livelihood. (Explanation below Section 44(3) of Lokpal and Lokayuktas Act, 2013).</p>
			    </div>
			    <div class="col-12" style="padding:240px;"></div>
			</div>
		</div>
	</div>
	<div class="col-12 pt-3" id="pr-form-one-data">
		<div class="container shadow">	
			<div class="row border" style="padding: 80px;">
				<div class="col-12">
					<p class="text-right"><b>APPENDIX-II<br>[Rule 3(1)]</b></p>
				</div>
				<div class="col-12 text-center">
			        <p class="font-weight-bold mb-0">FORM No.I</p>
			        <h5 class="font-weight-bold">Details of Public Servant,   his/ her spouse and dependent children</h5>
			    </div>
			    <div class="col-12 pt-4">
			    	<table class="table table-bordered">
			          	<thead>
			            	<tr>
								<th style="width: 5%;">SL No.</th>
								<th style="width: 10%;"></th>
								<th style="width: 15%;">Name</th>
								<th style="width: 50%">Public Position held, if any</th>
								<th style="width: 20%">Whether return being filed by him/ her, separately</th>
			            	</tr>
			          	</thead>
			          	<tbody>
			          		<tr>
		      					<td>1</td>
		      					<td>Self</td>
		      					<td><?php echo base64_decode($employee_details['emp_name']);?></td>
		      					<td>
		      						<span class="form-control">
		      							<?php echo isset($form_one_data[0]['public_positions'])? $form_one_data[0]['public_positions'] : '';?>
		      						</span>
		      					</td>
		      					<td>
		      						<span class="form-control">
		      							<?php echo isset($form_one_data[0]['public_positions'])? $form_one_data[0]['is_separately_return'] : '';?>
		      						</span>
		      					</td>
		      				</tr>
			          		<?php if(isset($employee_dependents_details)){$i=2;?>
			          			<?php foreach($employee_dependents_details as $edd){?>
			          				<tr>
			          					<td><?php echo $i;?></td>
			          					<td><?php echo isset($edd['relation'])? base64_decode($edd['relation']) : '';?></td>
			          					<td><?php echo isset($edd['rel_name'])? base64_decode($edd['rel_name']) : '';?></td>
				      					<td>
				      						<span class="form-control">
				      							<?php echo isset($form_one_data[$edd['id']]['public_positions'])? $form_one_data[$edd['id']]['public_positions'] : '';?>
				      						</span>
				      					</td>
				      					<td>
				      						<span class="form-control">
				      							<?php echo isset($form_one_data[$edd['id']]['public_positions'])? $form_one_data[$edd['id']]['is_separately_return'] : '';?>
				      						</span>
				      					</td>
			          				</tr>
		          				<?php $i++;}?>
		          			<?php }?>
			          	</tbody>
		          	</table>
			    </div>
			    <div class="col-12" style="padding:200px;"></div>
			</div>
		</div>
	</div>
</div>