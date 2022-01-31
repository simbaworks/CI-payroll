<div class="row">
	<div class="col">
		<div class="card">
          	<div class="card-header">
				<div class="row">
				    <div class="col">
                		<h3 class="card-title">Property Return Date Settings</h3>
                	</div>
                	<div class="col">
                		<a class="btn btn-info btn-sm float-right" href="<?php echo site_url($controller);?>" title="Add new record"><i class="fas fa-chevron-left mr-2"></i>Back</a>
                		<button class="btn btn-success btn-sm add-new-pr-settings float-right mr-2" title="Add new record"><i class="fas fa-plus-square mr-2"></i>Add New</button>
                	</div>
                </div>
          	</div>
          	<!-- /.card-header -->
          	<div class="card-body p-0">
          		<div class="row p-3">
          		</div>
          		<div id="data_table">
          			<?php echo isset($data_table)? $data_table : '';?>
          		</div>
			</div>
			<!-- /.card-body -->
        </div>
    </div>
</div>

<script type="text/javascript">
	$(document).on('click', '.add-new-pr-settings', function(){
		var dataStr = {};
	    var dataUrl = SITEURL + CONTROLLER + '/ajax_load_pr_settings_add_form';
	    $.ajax({
	        type: "POST",
	        url: dataUrl,
	        data: dataStr,
	        cache: false,
	        dataType: 'JSON',
	        beforeSend: function() {
	            $('.preloader').removeClass('d-none');
	        },
	        error: function(){
	        	$('.preloader').addClass('d-none');
	        	Toast.fire({
                    icon: 'error',
                    title: 'Some error occured. Please try again!'
                });
	        },
	        success: function (data) {
	            $('.preloader').addClass('d-none');

	            var modalTitle = data.title;
	            $('.modal-title').html(modalTitle);
	            $('.modal-body').html(data.html);
	            $('#hrmsModal').modal('show');
	        }
	    });
	});
</script>