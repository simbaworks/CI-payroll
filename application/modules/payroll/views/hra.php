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
          <th>City Class</th>
          <th>Rate</th>
          <th>Start Date</th>
          <th>End Date</th>
          <th class="text-center" style="width: 10%">Status</th>
          <th class="text-center" style="width: 10%">Edit</th>
        </tr>
      </thead>
      <tbody>
        <?php if(!empty($hradetails)){ ?>
        <?php $i=1; ?>
        <?php foreach ($hradetails as $value) {?>
        <tr>
          <td>
            <?php echo  $i; ?>
          </td>
           <td>
            <?php echo  $value['type']; ?>
          </td>
          <td>
            <?php echo  $value['city_class']; ?>
          </td>
          <td>
            <?php echo  $value['rate']; ?>
          </td>
          <td>
            <?php echo  date('d-m-Y', strtotime($value['start_date'])); ?>
          </td>
          <td>
            <?php echo  date('d-m-Y', strtotime($value['end_date'])); ?>
          </td>
          <td class="text-center">
            <input type="checkbox" id="" class="status-action-hra"  data-toggle="toggle" data-on="Active" data-off="Expired" data-onstyle="success" data-offstyle="warning" data-size="small" data-width="100" data-row-id="" data-id=" <?php echo  $value['id']; ?>" data-status=" <?php echo  $value['status']; ?>" <?php echo  ($value['status'] == "1")?"checked":""; ?>>
          </td>
          <td>
            <button class="btn btn-info btn-sm  float-right btn-primary"  data-toggle="modal" data-target="#EditModal" data-id=" <?php echo  $value['id']; ?>" data-city-class="<?php echo  $value['city_class']; ?>" data-rate="<?php echo  $value['rate']; ?>" data-start-date="<?php echo  date('Y-m-d', strtotime($value['start_date'])); ?>" data-end-date="<?php echo  date('Y-m-d', strtotime($value['end_date'])); ?>" > Edit</button>
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
    	<form action="<?php echo site_url('payroll/inserthradetails'); ?>" method="post">
		    <div class="modal-body">
          <label for="cars">Choose Type:</label>
          <select id="type" name="da_type">
            <option value="CDA">CDA</option>
            <option value="IDA">IDA</option>
          </select>
          <div class="form-group">
              <label for="city_class">City Class</label>
              <input type="text" class="city_class" id="city_class" name="city_class">
          </div>
          <div class="form-group">
              <label for="rate">Rate</label>
              <input type="text" class="rate" id="rate" name="rate">
          </div>
  				<div class="form-group">
  				    <label for="date">Start Date</label>
  				    <input type="date" class="start-date" id="start-date" name="start_date">
  				</div>
  				<div class="form-group">
  				    <label for="date">End Date</label>
  				    <input type="date" class="end-date" id="end-date" name="end_date">
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
        <form action="<?php echo site_url('payroll/savehradetails'); ?>" method="post">
          <div class="modal-body">
            <input type="hidden" value="" name="hra_id" id="hra_id">
            <label for="cars">Choose Type:</label>
            <select id="type" name="da_type">
              <option value="CDA">CDA</option>
              <option value="IDA">IDA</option>
            </select>
            <div class="form-group">
                <label for="city_class">City Class</label>
                <input type="text" class="city_class" id="city_class" name="city_class">
            </div>
            <div class="form-group">
                <label for="rate">Rate</label>
                <input type="text" class="rate" id="rate" name="rate">
            </div>
            <div class="form-group">
                <label for="date">Start Date</label>
                <input type="date" class="start-date" id="start_date" name="start_date">
            </div>
            <div class="form-group">
                <label for="date">End Date</label>
                <input type="date" class="end-date" id="end_date" name="end_date">
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
  var city_class = button.data('city-class') 
  var rate = button.data('rate') 
  var start_date = button.data('start-date')
  var end_date = button.data('end-date') 
 
  // Extract info from data-* attributes
  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
  var modal = $(this)
  // modal.find('.modal-title').text('New message to ' + recipient)
  modal.find('#city_class').val(city_class)
  modal.find('#rate').val(rate)
  modal.find('#start_date').val(start_date)
  modal.find('#end_date').val(end_date)
  modal.find('#hra_id').val(id)
})
$('.status-action-hra').on('change', function(){
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
    url: "<?php echo site_url("/payroll/savehrastatusajax") ?>",
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