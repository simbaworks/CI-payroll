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
          <th>Head Count</th>
          <th>Description</th>
          <th>Short Name</th>
          <th>Effect Type</th>
          <th>Applicable For</th>
          <th>Basic Dependent</th>
          <th class="text-center" style="width: 10%">Edit</th>
        </tr>
      </thead>
      <tbody>
       
      </tbody>
    </table>
  </div>
</div>