<?php //echo "<pre>";print_r($employee_details);?>
<?php 
$gender[1] = 'Male';
$gender[2] = 'Female';
$gender[3] = 'Transgender';

$officers = array();
if(isset($reporting_officer_list)){
	foreach($reporting_officer_list as $rol){
		$officers[$rol['id']]['name'] = $rol['emp_name'];
		$officers[$rol['id']]['emp_id'] = $rol['emp_id'];
	}
}
?>
<div class="row" id="employee-details-page">
	<div class="col-3">
		<div class="card card-primary card-outline">
          	<div class="card-body box-profile">
                <div class="text-center">
                	<?php if ($employee_details['profile_picture'] !== '' && $employee_details['profile_picture'] !== NULL && file_exists('./assets/uploads/profile_pictures/' . $employee_details['profile_picture'])) { ?>
		            	<img class="profile-user-img img-fluid img-circle" src="<?php echo site_url('assets/uploads/profile_pictures/' . $employee_details['profile_picture']);?>" alt="Employee profile picture">
		            <?php }else{?>
                  		<img class="profile-user-img img-fluid img-circle" src="<?php echo site_url('assets/img/avatar4.png');?>" alt="Employee profile picture">
                  	<?php }?>
                </div>

                <h3 class="profile-username text-center"><?php echo isset($employee_details['emp_name'])? base64_decode($employee_details['emp_name']) : '';?></h3>
                <p class="text-muted text-center"><?php echo isset($employee_official_details[0]['description'])? $employee_official_details[0]['description'] : '';?></p>
                <ul class="list-group list-group-unbordered mb-3">
					<li class="list-group-item">
						Date of Joining <a class="float-right"><?php echo isset($employee_details['emp_doj'])? date('M d, Y', strtotime($employee_details['emp_doj'])) : '';?></a>
					</li>
					<li class="list-group-item">
						Date of Retirement <a class="float-right"><?php echo isset($employee_details['emp_dor'])? date('M d, Y', strtotime($employee_details['emp_dor'])) : '';?></a>
					</li>
				</ul>
            </div>
        </div>
        <div class="card card-primary">
		  	<div class="card-header">
		    	<h3 class="card-title">About Me</h3>
		  	</div>
		  	<div class="card-body">
		  		<!-- Personal Details(DOB and Other informations) -->
                <strong><i class="fas fa-address-card mr-1"></i> Personal Details</strong>
                <p class="mt-2">
                	DOB: <span class="text-info"><?php echo isset($employee_details['date_of_birth'])? date('M d, Y', strtotime($employee_details['date_of_birth'])) : '';?></span><br>
	                Gender: <span class="text-info"><?php echo isset($employee_details['emp_gender_id'])? $gender[$employee_details['emp_gender_id']] : '';?></span><br>
	                Caste: <span class="text-info"><?php echo isset($employee_details['caste_name'])? base64_decode($employee_details['caste_name']) : '';?></span><br>
	                Religion: <span class="text-info"><?php echo isset($employee_details['religion_name'])? base64_decode($employee_details['religion_name']) : '';?></span><br>
                	Blood Group: <span class="text-info"><?php echo isset($employee_details['group_name'])? base64_decode($employee_details['group_name']) : '';?></span><br>
                	Marital Status: <span class="text-info"><?php echo isset($employee_details['marital_status'])? base64_decode($employee_details['marital_status']) : '';?></span><br>
                	Is Disabled: <span class="text-info"><?php echo isset($employee_details['emp_pwd_status']) && $employee_details['emp_pwd_status'] == '1'? 'Yes' : 'No';?></span><br>
                	Identification Mark: <span class="text-info"><?php echo isset($employee_details['emp_identification_mark'])? base64_decode($employee_details['emp_identification_mark']) : 'NA';?></span>
            	</p>
                <hr>
                <!-- Contact Details -->
                <strong><i class="fas fa-address-book mr-1"></i> Contact Details</strong>
                <p class="mt-2">
                	Email: <span class="text-info"><?php echo isset($employee_details['emp_email'])? base64_decode($employee_details['emp_email']) : '';?></span><br>
                	Mobile No.: <span class="text-info"><?php echo isset($employee_details['emp_mobile'])? base64_decode($employee_details['emp_mobile']) : '';?></span><br>
                	Emergency Mobile No.: <span class="text-info"><?php echo isset($employee_details['emp_alternate_contact'])? base64_decode($employee_details['emp_alternate_contact']) : '';?></span><br>
	                <?php if(isset($employee_address_details)){?>
	                	<?php foreach($employee_address_details as $ead){?>
	                		<?php if(!in_array($ead['address_type'], array('1','2'))){continue;}?>
	                		<p class="text-muted">
	                			<b><?php echo $ead['address_type'] == '1'? 'Permanent' : 'Current';?> Address</b> <i>(<?php echo date('d M, Y', strtotime($ead['created']));?>)</i><br>
	                			<?php echo isset($ead['add_line1'])? base64_decode($ead['add_line1']) . ',' : '';?>
	                			<?php echo isset($ead['add_line2'])? base64_decode($ead['add_line2']) . ',' : '';?>
	                			<?php echo isset($ead['add_po'])? base64_decode($ead['add_po']) . ',' : '';?>
	                			<?php echo isset($ead['add_ps'])? base64_decode($ead['add_ps']) . ',' : '';?>
	                			<?php echo isset($ead['add_dist'])? base64_decode($ead['add_dist']) . ',' : '';?>
	                			<?php echo isset($ead['add_state'])? base64_decode($ead['add_state']) . ' - ' : '';?>
	                			<?php echo isset($ead['add_pin'])? base64_decode($ead['add_pin']) : '';?>
	                		</p>
		                <?php }?>
	                <?php }?>
                </p>
                <hr>
                <!-- Education Details -->
                <strong><i class="fas fa-book mr-1"></i> Education</strong>
                <?php if(isset($employee_education_details)){?>
                	<?php foreach($employee_education_details as $eed){?>
	                	<p class="text-muted">
	                		<?php echo isset($eed['degree_name'])? base64_decode($eed['degree_name']) : '';?> in
	                		<?php echo isset($eed['specialization'])? $eed['specialization'] : ''?> from
	                		<?php echo isset($eed['bu_name'])? base64_decode($eed['bu_name']) : ''?> with
	                		<?php echo isset($eed['marks_obtained'])? base64_decode($eed['marks_obtained']) : ''?>
	                	</p>
	                <?php }?>
                <?php }?>
            </div>
		</div>
		<?php if($employee_details['emp_pwd_status'] == '1'){?>
	        <div class="card card-primary">
			  	<div class="card-header">
			    	<h3 class="card-title">PWD Information</h3>
			  	</div>
			  	<div class="card-body">
	          		<?php if(isset($employee_pwd_details)){ $i = 1;?>
	      				<ul class="list-group list-group-unbordered mb-3">
							<li class="list-group-item">
								PWD Type <span class="float-right">Percentage</span>
							</li>
	          				<?php foreach ($employee_pwd_details as $epwd) {?>
								<li class="list-group-item">
									<?php echo isset($epwd['pwd_name'])? base64_decode($epwd['pwd_name']) : '';?> <a class="float-right"><?php echo isset($epwd['pwd_percentage'])? base64_decode($epwd['pwd_percentage']) . '%' : '';?></a>
								</li>
	      					<?php $i++;}?>
	      				</ul>
	            	<?php }?>
			  	</div>
		  	</div>
  		<?php }?>
	</div>
	<div class="col-9">
		<!-- Official Details -->
		<div class="card">
			<div class="card-body">
				<div class="row">
					<div class="col-12 border-bottom mb-2 pb-2"><h5 class="card-title">Official Details</h5></div>
					<div class="col-12">
		          		<?php if(isset($employee_official_details)){ $i = 1;?>
		          			<?php foreach ($employee_official_details as $eod) {?>
		          				<p class="text-muted">
		          					Employee Type: <span class="text-info"><?php echo isset($eod['type_name'])? base64_decode($eod['type_name']) : '';?></span><br>
		          					Posting: <span class="text-info"><?php echo base64_decode($eod['centre_name']) . ' (' . base64_decode($eod['centre_type_name']) . ' - ' . base64_decode($eod['ro_name']) . ')';?></span><br>
		          					Department: <span class="text-info"><?php echo isset($eod['department_name'])? $eod['department_name'] : '';?></span><br>
		          					Designation: <span class="text-info"><?php echo isset($eod['description'])? $eod['description'] . ' - ' . $eod['designation_type'] : '';?></span><br>
		          					Service Book Number: <span class="text-info"><?php echo isset($eod['service_book_no'])? $eod['service_book_no'] : '';?></span><br>
		          					Co-Opp Account No.: <span class="text-info"><?php echo isset($eod['co_opp_acc_no'])? base64_decode($eod['co_opp_acc_no']) : '';?></span><br><br>

		          					Reporting Officer: <span class="text-info"><?php echo isset($officers[$eod['rep_emp_id']])? base64_decode($officers[$eod['rep_emp_id']]['name']) . ' (' . base64_decode($officers[$eod['rep_emp_id']]['emp_id']) . ')' : '';?></span><br>
		          					Alternate-reporting Officer: <span class="text-info"><?php echo isset($officers[$eod['alternate_reporting_officer_id']])? base64_decode($officers[$eod['alternate_reporting_officer_id']]['name']) . ' (' . base64_decode($officers[$eod['alternate_reporting_officer_id']]['emp_id']) . ')' : '';?></span><br>
		          					Reviewing Officer: <span class="text-info"><?php echo isset($officers[$eod['reviewing_officer_id']])? base64_decode($officers[$eod['reviewing_officer_id']]['name']) . ' (' . base64_decode($officers[$eod['reviewing_officer_id']]['emp_id']) . ')' : '';?></span><br>
		          					Acceptance Officer: <span class="text-info"><?php echo isset($officers[$eod['acceptance_officer_id']])? base64_decode($officers[$eod['acceptance_officer_id']]['name']) . ' (' . base64_decode($officers[$eod['acceptance_officer_id']]['emp_id']) . ')' : '';?></span>
		          				</p>
		          				<?php echo $i !== count($employee_official_details)? '<hr>' : '';?>
	          				<?php $i++;}?>
		            	<?php }?>
					</div>
				</div>
			</div>
		</div>
		<!-- Bank Details -->
		<div class="card">
			<div class="card-body">
				<div class="row">
					<div class="col-12 border-bottom mb-2 pb-2"><h5 class="card-title">Bank Details</h5></div>
					<div class="col-12">
		          		<?php if(isset($employee_bank_details)){ $i = 1;?>
		          			<?php foreach ($employee_bank_details as $ebd) {?>
		          				<p class="text-muted">
		          					Bank Name: <span class="text-info"><?php echo isset($ebd['bank_name'])? base64_decode($ebd['bank_name']) : '';?></span><br>
		          					Branch Name: <span class="text-info"><?php echo isset($ebd['bank_branch'])? base64_decode($ebd['bank_branch']) : '';?></span><br>
		          					IFSC Code: <span class="text-info"><?php echo isset($ebd['bank_ifsc'])? base64_decode($ebd['bank_ifsc']) : '';?></span><br>
		          					Account No.: <span class="text-info"><?php echo isset($ebd['bank_acc_no'])? base64_decode($ebd['bank_acc_no']) : '';?></span><br>
		          					Account Type: <span class="text-info"><?php echo isset($ebd['bank_acc_type'])? ucwords(str_replace('_', ' ', base64_decode($ebd['bank_acc_type']))) : '';?></span>
		          				</p>
		          				<?php echo $i !== count($employee_bank_details)? '<hr>' : '';?>
	          				<?php $i++;}?>
		            	<?php }?>
          			</div>
				</div>
			</div>
		</div>
		<!-- Salary Details -->
		<div class="card">
			<div class="card-body">
				<div class="row">
					<div class="col-12 border-bottom mb-2 pb-2"><h5 class="card-title">Salary Details</h5></div>
					<div class="col-12">
		          		<?php if(isset($employee_salary_details)){ $i = 1;?>
		          			<?php foreach ($employee_salary_details as $esd) {?>
		          				<p class="text-muted">
		          					Pay Pattern: <span class="text-info"><?php echo isset($esd['scale'])? $esd['scale'] . '(' . number_format($esd['scale_min']) . '/-' . ' - ' . number_format($esd['scale_max']) . '/-' . ')' : '';?></span><br>
		          					Basics: <span class="text-info"><?php echo isset($esd['basics'])? number_format($esd['basics']) . '/-' : '';?></span><br>
		          					DA Type: <span class="text-info"><?php echo isset($esd['da_type'])? $esd['da_type'] : '';?></span><br>
		          					Special Pay: <span class="text-info"><?php echo isset($esd['special_pay'])? $esd['special_pay'] : '';?></span><br>
		          					Pay Protection: <span class="text-info"><?php echo isset($esd['pay_protection'])? $esd['pay_protection'] : '';?></span>
		          				</p>
		          				<?php echo $i !== count($employee_salary_details)? '<hr>' : '';?>
	          				<?php $i++;}?>
		            	<?php }?>
					</div>
				</div>
			</div>
		</div>
		<!-- LIC Information -->
		<div class="card">
			<div class="card-body">
				<div class="row">
					<div class="col-12 border-bottom mb-2 pb-2"><h5 class="card-title">LIC Information</h5></div>
					<div class="col-12">
		          		<?php if(isset($employee_lic_details)){ $i = 1;?>
		          			<?php foreach ($employee_lic_details as $eld) {?>
		          				<p class="text-muted">
		          					Policy No.: <span class="text-info"><?php echo isset($eld['policy_no'])? $eld['policy_no'] : '';?></span><br>
		          					Premium Amount: <span class="text-info"><?php echo isset($eld['premium_amount'])? number_format($eld['premium_amount']) . '/-' : '';?></span><br>
		          					Issue Date: <span class="text-info"><?php echo isset($eld['issue_date'])? date('d M, Y', strtotime($eld['issue_date'])) : '';?></span><br>
		          					Maturity Date: <span class="text-info"><?php echo isset($eld['maturity_date'])? date('d M, Y', strtotime($eld['maturity_date'])) : '';?></span>
		          				</p>
		          				<?php echo $i !== count($employee_lic_details)? '<hr>' : '';?>
	          				<?php $i++;}?>
		            	<?php }?>
					</div>
				</div>
			</div>
		</div>
		<!-- Dependents Details -->
		<div class="card">
			<div class="card-body">
				<div class="row">
					<div class="col-12 border-bottom mb-2 pb-2"><h5 class="card-title">Dependents Details</h5></div>
					<div class="col-12">
		          		<?php if(isset($employee_dependents_details)){ $i = 1;?>
		          			<?php foreach ($employee_dependents_details as $edd) {?>
		          				<p class="text-muted">
		          					Dependent Name: <span class="text-info"><?php echo isset($edd['rel_name'])? base64_decode($edd['rel_name']) : '';?></span><br>
		          					Dependent DOB: <span class="text-info"><?php echo isset($edd['rel_dob'])? date('d M, Y', strtotime($edd['rel_dob'])) : '';?></span><br>
		          					Relation: <span class="text-info"><?php echo isset($edd['relation'])? base64_decode($edd['relation']) : '';?></span><br>
		          					Dependent Address: <span class="text-info"><?php echo isset($edd['address'])? base64_decode($edd['address']) : '';?></span><br>
		          					Dependent Phone No.: <span class="text-info"><?php echo isset($edd['rel_contact'])? base64_decode($edd['rel_contact']) : '';?></span><br><br>
		          					Nominee CPF: <span class="text-info"><?php echo isset($edd['rel_cpf_nom_percent'])? $edd['rel_cpf_nom_percent'] : '0';?>%</span><br>
		          					Nominee Gratuity: <span class="text-info"><?php echo isset($edd['rel_gratuity_nom_percent'])? $edd['rel_gratuity_nom_percent'] : '0';?>%</span><br>
		          					Nominee Medical: <span class="text-info"><?php echo isset($edd['rel_med_app'])? ($edd['rel_med_app'] == '0'? 'No' : 'Yes') : '';?></span><br>
		          					Nominee LTC: <span class="text-info"><?php echo isset($edd['rel_med_app'])? ($edd['rel_med_app'] == '0'? 'No' : 'Yes') : '';?></span>
		          				</p>
		          				<?php echo $i !== count($employee_dependents_details)? '<hr>' : '';?>
	          				<?php $i++;}?>
		            	<?php }?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>