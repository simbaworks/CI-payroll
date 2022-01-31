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
      <h3 class="card-title">All Vacant Post Lists</h3>
    </div>
    <div class="col">
      <button class="btn btn-info btn-sm  float-right btn-primary" title="Add new record"  data-toggle="modal" data-target="#exampleModalCenter"><i class="fas fa-plus-square mr-2"></i>Add New</button>
    </div>
  </div>
</div>
<!-- /.card-header -->
<div class="card-body p-0">
<div class="row p-3">
</div>
<div id="data_table">
<div class="row px-3">
  <div class="col table-responsive">
    <table class="table table-striped border">
      <thead>
        <tr>
          <th style="width: 2%">#</th>
          <th>Type</th>
          <th>Effective From</th>
          <th>Effective Until</th>
          <th>Date Of Regulation</th>
          <th>Percentage</th>
          <th class="text-center" style="width: 10%">Status</th>
          <th class="text-center" style="width: 10%">Edit</th>
        </tr>
      </thead>
      <tbody>
        <?php if(!empty($dadetails)){ ?>
        <?php $i=1; ?>
        <?php foreach ($dadetails as $value) {?>
        <tr>
          <td>
            <?php echo  $i; ?>
          </td>
          <td>
            <?php echo  $value['type']; ?>
          </td>
          <td>
            <?php echo  date('d-m-Y', strtotime($value['effective_date'])); ?>
          </td>
          <td>
            <?php echo  date('d-m-Y', strtotime($value['end_date'])); ?>
          </td>
           <td>
            <?php echo  date('d-m-Y', strtotime($value['date_of_regulation'])); ?>
          </td>
          <td>
            <?php echo  $value['percentage']; ?>
          </td>
          <td class="text-center">
            <input type="checkbox" id="" class="status-action-da"  data-toggle="toggle" data-on="Active" data-off="Expired" data-onstyle="success" data-offstyle="warning" data-size="small" data-width="100" data-id=" <?php echo  $value['id']; ?>" data-status=" 



            <?php echo  $value['status']; ?>" <?php echo  ($value['status'] == "1")?"checked":""; ?>>
          </td>
          <td>
            <button class="btn btn-info btn-sm  float-right btn-primary"  data-toggle="modal" data-target="#EditModal" data-id=" <?php echo  $value['id']; ?>" data-effective-date="<?php echo  date('Y-m-d', strtotime($value['effective_date'])); ?>" data-end-date="<?php echo  date('Y-m-d', strtotime($value['end_date'])); ?>" data-regulation-date="<?php echo  date('Y-m-d', strtotime($value['date_of_regulation'])); ?>" data-percentage="<?php echo  $value['percentage']; ?>"> Edit</button>
          </td>
        </tr>
        <?php $i++;}?>
        <?php }else{?>
        <tr>
          <td colspan="5" class="text-center text-danger">No record found!</td>
        </tr>
        <?php }?>
      </tbody>
    </table>
  </div>
</div>




<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      	<div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
    	</div>
    	<form action="<?php echo site_url('payroll/insertdadetails'); ?>" method="post">
		    <div class="modal-body">
		    <label for="cars">Choose Type:</label>
				<select id="type" name="da_type">
				  <option value="CDA">CDA</option>
				  <option value="IDA">IDA</option>
				</select>
				<div class="form-group">
				    <label for="percentage">Percentage</label>
				    <input type="text" class="percentage" id="percentage" name="percentage">
				</div>
				<div class="form-group">
				    <label for="date">Effective Date</label>
				    <input type="date" class="effetv-date" id="effetv-date" name="effect_date">
				</div>
				<div class="form-group">
				    <label for="date">End Date</label>
				    <input type="date" class="end-date" id="end-date" name="end_date">
				</div>
        <div class="form-group">
          <label for="date">Date Of Regulation</label>
          <input type="date" class="regulation-date" id="regulation-date" name="regulation_date">
        </div>
		    </div>
		    <div class="modal-footer">
		        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		        <button type="submit" class="btn btn-primary">Add</button>
		    </div>
       	</form>
    </div>
  </div>
</div>

<div class="modal fade" id="EditModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">New message</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="<?php echo site_url('payroll/savedadetails'); ?>" method="post">
          <div class="modal-body">
            <input type="hidden" value="" name="da_id" id="da_id">
            <label for="cars">Choose Type:</label>
            <select id="Edittype" name="da_type">
              <option value="CDA">CDA</option>
              <option value="IDA">IDA</option>
            </select>
            <div class="form-group">
                <label for="percentage">Percentage</label>
                <input type="text" class="percentage" id="editpercentage" name="percentage" value="">
            </div>
            <div class="form-group">
                <label for="date">Effective Date</label>
                <input type="date" class="effetv-date" id="edit-effetv-date" name="effect_date" value="">
            </div>
            <div class="form-group">
                <label for="date">End Date</label>
                <input type="date" class="end-date" id="edit-end-date" name="end_date" value="">
            </div>
            <div class="form-group">
              <label for="date">Date Of Regulation</label>
              <input type="date" class="regulation-date" id="edit-regulation-date" name="regulation_date">
            </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>


<script type="text/javascript">
  $('#myModal').on('shown.bs.modal', function () {
  $('#myInput').trigger('focus')
})
</script>

<script type="text/javascript">
  $('#EditModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var id = button.data('id') 
    var effective_date = button.data('effective-date')
    var end_date = button.data('end-date') 
    var percentage = button.data('percentage') 
    var regulation_date = button.data('regulation-date') 


    // Extract info from data-* attributes
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
    var modal = $(this)
    // modal.find('.modal-title').text('New message to ' + recipient)
    modal.find('#editpercentage').val(percentage)
    modal.find('#edit-effetv-date').val(effective_date)
    modal.find('#edit-end-date').val(end_date)
    modal.find('#edit-regulation-date').val(regulation_date)
    modal.find('#da_id').val(id)
  })
  $('.status-action-da').on('change', function(){
    var id = $(this).attr("data-id");
    var status = $(this).attr("data-status");
    var dataObject = {
      id : id
    };
    if(status == 0){
      dataObject.status = 1;
    }else{
       dataObject.status = 0;
    }
    console.log(dataObject)
    $.ajax({
      type: "POST",
      url: "<?php echo site_url("/payroll/savedastatusajax") ?>",
      data: dataObject,
      cache: false,
      dataType: 'JSON',
      beforeSend: function() {
          $('.preloader').removeClass('d-none');
      },
      success: function (data) {
          if(data.code == '0'){
              alert(data.message);
              $(this).val(prev_value);
          }else{
              Toast.fire({
                  icon: 'success',
                  title: data.message
              });
              $('._ftoken').val(data.ftoken);
          }
          $('.preloader').addClass('d-none');
      }
    });
    
  });
</script>