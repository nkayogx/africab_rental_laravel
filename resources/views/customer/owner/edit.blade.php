@extends('layouts.app')
@section('content')
<section class="content-header">
      <h1>
        Tenants       
      </h1>
</section>


<!-- Main content -->
<section class="content">
<div class="box">
<div class="box-header">
  <h3 class="box-title">Edit</h3>
  <div class="pull-right box-tools">  
  </div>
</div>

<div class="box-body">
  <form method="post" action="{{ route('tenants.update',$tenant->id ) }}" enctype="form/multi-data">
        @csrf
        @method('put')
       <div class="form-group">
          <label for="exampleInputEmail1">Name</label>
          <input type="text" name="name" value="{{ $tenant->first_name }}" class="form-control" id="name" placeholder="Enter fullname">
        </div>
        <div class="form-group">
          <label for="exampleInputEmail1">Phone</label>
          <input type="phone"  name="phone" value="{{ $tenant->phone }}" class="form-control" id="phone" placeholder="Enter phone number">
        </div>
        <div class="form-group">
          <label for="exampleInputEmail1">Email</label>
          <input type="email" class="form-control" name="email" value="{{ $tenant->email }}"  id="email" placeholder="Enter email">
        </div>
        <div class="form-group">
          <label for="exampleInputEmail1">NIDA/TIN</label>
          <input type="ID" class="form-control" name="id_passport_number" value="{{ $tenant->id_passport_number }}" id="exampleInputEmail1" placeholder="Enter NIDA or TIN number">
        </div>
        
        <div class="form-group">
          <label for="exampleInputFile">File input</label>
          <input type="file" id="tenant_id" nam="tenant_id">
          <p class="help-block">Attach Tenant ID.</p>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Update</button>
    </div>
  </form>
</div>
</div>
</section>
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
