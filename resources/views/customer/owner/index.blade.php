@extends('layouts.app')
@section('content')

<section class="content-header">
      <h1>
        Owners       
      </h1>
</section>



<!-- Main content -->
<section class="content">
@if(Session::has('message'))
  <div class="alert alert-success">
    {{ Session::get('message') }}
  </div>
@endif
<div class="box">
<div class="box-header">
  <h3 class="box-title">Owners List</h3>
  <div class="pull-right box-tools">
    <button type="button" data-toggle="modal" data-target="#modal-default" class="btn btn-info btn-sm"><i class="fa fa-plus"></i> Add Ownership </button>
  </div>
</div>

<div class="box-body">
<table id="example1" class="table table-bordered table-striped datatable">
<thead>
  <tr>
    <th>Name</th>
    <th>phone</th>
    <th>Total units</th>
    <th>Units</th>
    <th>Action</th>
  </tr>
</thead>
<tbody>
  @foreach($tenants as $tenant)
    <tr>
      <td> {{ $tenant->first_name }}</td>
      <td> {{ $tenant->phone }} </td>
     
      <td> {{ '30' }}</td>
      <td> {{ '30' }}</td>
      <td><a href="{{ route('tenants.edit',$tenant->id) }}"> Edit </a> | <a href="{{ route('tenants.edit',$tenant->id) }}"> Deactivate </a> </td>
    </tr>
@endforeach
</tfoot>
</table>
</div>
</div>
</section>

<!-- Models  -->
<div class="modal fade" id="modal-default">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Tenant Details</h4>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label for="exampleInputEmail1">Name</label>
          <input type="text" name="name" class="form-control" id="name" placeholder="Enter fullname">
        </div>
        <div class="form-group">
          <label for="exampleInputEmail1">Phone</label>
          <input type="phone" class="form-control" id="phone" placeholder="Enter phone number">
        </div>
        <div class="form-group">
          <label for="exampleInputEmail1">Email</label>
          <input type="email" class="form-control" id="email" placeholder="Enter email">
        </div>
        <div class="form-group">
          <label for="exampleInputEmail1">NIDA/TIN</label>
          <input type="ID" class="form-control" id="exampleInputEmail1" placeholder="Enter NIDA or TIN number">
        </div>
        
        <div class="form-group">
          <label for="exampleInputFile">File input</label>
          <input type="file" id="tenant_id" nam="tenant_id">
          <p class="help-block">Attach Tenant ID.</p>
        </div>
      
        </div>
        
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Submit</button>
      </div>
    </div>
  </div>
</div>
@endsection
@push('after-scripts')
<script>
  $('.datatable').DataTable({
      'paging'      : true,
      'lengthChange': true,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    });
</script>
@endpush
