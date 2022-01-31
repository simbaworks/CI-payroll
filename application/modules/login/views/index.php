<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" href="<?php echo $img_path . 'Logo.png' ?>" type="image/png" sizes="16x16">
	<title><?php echo $site_title; ?></title>

	<!-- Font Awesome -->
	<link rel="stylesheet" href="<?php echo $assets_path; ?>plugins/fontawesome-free/css/all.min.css">

	<link rel="stylesheet" href="<?php echo $css_path; ?>style.css">
</head>
<body>
	<section class="ftco-section">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-6 text-center mb-5">
					<h2 class="heading-section"><?php echo $title;?></h2>
				</div>
			</div>
			<div class="row justify-content-center">
				<div class="col-md-12 col-lg-10">
					<div class="wrap d-md-flex border">
						<div class="img" style="background-image: url(<?php echo $img_path . 'bg-2.jpg';?>);"></div>
						<div class="login-wrap p-4 p-md-5">
				      		<div class="d-flex">
					      		<div class="w-100">
					      			<h3 class="mb-4 text-center">Sign In</h3>
        							<?php if($this->session->flashdata('flash_message')){ echo $this->session->flashdata('flash_message');}?>
					      		</div>
				      		</div>
							<form method="post" action="<?php echo site_url('login'); ?>" class="signin-form" onsubmit="return form_validation();">
					      		<div class="form-group mb-3">
					      			<label class="label" for="name">Username</label> <span class="text-danger" id="err_username"></span>
					      			<input type="text" id="username" name="username" class="form-control validation-require" placeholder="Username" data-field-name="username">
					      		</div>
					            <div class="form-group mb-3">
					            	<label class="label" for="password">Password</label> <span class="text-danger" id="err_password"></span>
					              	<input type="password" id="password" name="password" class="form-control validation-require" placeholder="Password" data-field-name="password">
					            </div>
				            	<div class="form-group d-md-flex">
									<div class="w-100 text-md-right">
										<a href="#">Forgot Password</a>
									</div>
				            	</div>
					            <div class="form-group">
        							<input type="hidden" name="_ltoken" id="_ltoken" value="<?php echo $_ltoken; ?>" />
					            	<button type="submit" class="form-control btn btn-primary rounded px-3 save-form-data">Sign In<i class="fas fa-sign-in-alt ml-2"></i></button>
					            </div>
				          	</form>
			        	</div>
	      			</div>
				</div>
			</div>
		  	<div class="row text-center my-2">
		      	<div class="col">
		          	<span class="text-dark h6"><?php echo $footer_text; ?></span>
		      	</div>
		  	</div>
		  	<?php if($version_status == 'Development'){ ?>
		  		<div class="row text-center">
		      		<div class="col">
		          		<span class="text-dark h6 small">Development Mode</span>
		      		</div>
		  		</div>
		  	<?php }?>
		</div>
	</section>

	<!-- jQuery -->
	<script src="<?php echo $assets_path; ?>plugins/jquery/jquery.min.js"></script>
	<!-- Bootstrap 4 -->
	<script src="<?php echo $assets_path; ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
	<script type="text/javascript">
		function form_validation() {
		    var valid = 1;
		    $('.save-form-data').html('<i class="fas fa-cog fa-spin"></i> Validating..');
		    $('.save-form-data').prop('disabled', true);

		    $('.validation-require').each(function (e) {
		        var id          = $.trim($(this).attr('id'));
		        var val         = $.trim($(this).val());
		        var field_name  = $.trim($(this).attr('data-field-name'));
		        if (val == '') {
		            $('#err_' + id).text('*Please enter ' + field_name).show();
		            valid = 0;
		        }
		    });
		    
		    if (valid == 1) {
		        $('.save-form-data').html('<i class="fas fa-cog fa-spin"></i> Logging in..');
		        return true;
		    } else {
		        $('.save-form-data').html('Sign In<i class="fas fa-sign-in-alt ml-2"></i>');
		        $('.save-form-data').prop('disabled', false);
		        return false;
		    }
		}
	</script>
</body>
</html>