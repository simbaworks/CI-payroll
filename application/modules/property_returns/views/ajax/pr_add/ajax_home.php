<form method="post" action="#" id="ajax-add-pr-home-data-form">
	<div class="container shadow">	
		<div class="row border" style="padding: 80px;">
			<div class="col-12">
				<p class="text-right"><b>APPENDIX-I<br>[Rule 3(1)]</b></p>
			</div>
			<div class="col-12">
		        <p class="mb-0">Return of Assets and Liabilities on First Appointment or as on the <?php echo date('d F Y');?></p>
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
						      	<input type="text" class="form-control" id="public_position" name="public_position" value="<?php echo isset($property_returns_details['public_position'])? $property_returns_details['public_position'] : '';?>">
						    </div>
						    <div class="col-sm-12">(Designation, name and address of organization)</div>
						</div>
		    			<div class="form-group row">
						    <label for="belonged_service" class="col-sm-4 font-weight-normal">(b) Service to which belongs</label>
						    <div class="col-sm-8">
						      	<input type="text" class="form-control" id="belonged_service" name="belonged_service" value="<?php echo isset($property_returns_details['belonged_service'])? $property_returns_details['belonged_service'] : '';?>">
						    </div>
						</div>
		    		</li>
		    	</ol>
		    </div>
		    <div class="col-12">
		    	<p>I hereby declare that the return enclosed namely, Forms I to IV are complete, true and correct to the best of my knowledge and belief, in respect of information due to the furnished by me under the provisions of section 44 of the Lokpal and Lokayuktas Act, 2013.</p>
		    </div>
		    <div class="col-6">
		    	Date: <?php echo date('d/m/Y');?>
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
		    <div class="col-12">
	            <input type="hidden" name="pr_home_row" class="pr_home_row" id="pr_home_row" value="<?php echo isset($property_returns_details['id'])? base64_encode($property_returns_details['id']) : '';?>" />
		    	<button class="btn btn-info btn-sm btn-flat float-right save-pr-home-data" type="submit">Next<i class="fas fa-chevron-right ml-2"></i></button>
		    </div>
		    <div class="col-12" style="padding:240px;"></div>
		</div>
	</div>
</form>

<script type="text/javascript">
	$(document).on('click', '.save-pr-home-data', function (evt) {
	    evt.preventDefault();
	    var valid = 1;
	    $(this).html('<i class="fas fa-cog fa-spin"></i> Saving..');
	    $(this).prop('disabled', true);

	    if (valid == 1) {
	        var formData = new FormData($('#ajax-add-pr-home-data-form')[0]);
	        var dataUrl = SITEURL + CONTROLLER + '/ajax_save_pr_home_data';
	        $.ajax({
	            type: "POST",
	            url: dataUrl,
	            data: formData,
	            cache: false,
	            processData: false,
	            contentType: false,
	            dataType: 'JSON',
	            error:function () {
	            	alert('Some error occured. Please try again!');
	            	$('.save-pr-home-data').html('<i class="fa fa-save mr-2"></i>Next');
	                $('.save-pr-home-data').prop('disabled', false);
	            },
	            success: function (data) {
	                if(data.code == '1'){
	                    Toast.fire({
	                        icon: 'success',
	                        title: data.message
	                    });
	                    $('.pr_home_row').val(data.html);
	                    $('.save-form-one-data').removeClass('d-none');
	                    $('#home-form-link').removeClass('active');
	                    $('#home-form').removeClass('active');
	                    $('#home-form').addClass('fade');
	                    $('#form-one-link').addClass('active');
	                    $('#form-one').addClass('active');
	                    $('#form-one').removeClass('fade');
	                    window.scrollTo({ top: 0, behavior: 'smooth' });
	                }else{
	                    alert(data.message);
	                }
	                $('.save-pr-home-data').html('Next<i class="fas fa-chevron-right ml-2"></i>');
	                $('.save-pr-home-data').prop('disabled', false);
	            }
	        });
	    } else {
	        $(this).html('Next<i class="fas fa-chevron-right ml-2"></i>');
	        $(this).prop('disabled', false);
	    }
	});
</script>