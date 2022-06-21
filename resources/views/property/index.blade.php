@extends('layouts.app')
@section('content')

<section class="content-header">
  <h1>
    Property
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
      <h3 class="box-title">Property List</h3>
      <div class="pull-right box-tools">
        <button type="button" data-toggle="modal" data-target="#modal-default" class="btn btn-info btn-sm"><i class="fa fa-plus"></i> Add Property </button>
      </div>
    </div>

    <div class="box-body">
      <table id="example1" class="table table-bordered table-striped datatable">
        <thead>
          <tr>
            <th>Name</th>
            <th>Owner</th>
            <th>Location</th>
            <th>Total units</th>
            <th>Vacants</th>
            <th>Occupied</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach($properties as $property)
          <?php 
            $total_units =  $property->unit_total;
            $vacants = $property->vacant;
            $vacants   = $total_units - $vacants;

          ?>
          <tr>
            <td> {{ $property->property_name }}</td>
            <td> {{ $property->company_name }}</td>
            <td> {{ $property->region->name  }} </td>
            <td> {{ $total_units  }} </td>

            <td> {{   $vacants  }}</td>
            <td> {{ $vacants  }}</td>
            <td><a href="{{ route('property-units',$property->id) }}"> Add Units </a> | <a href="{{ route('properties.edit',$property->id) }}"> Deactivate </a> </td>
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

      <form action="{{ route('properties.store')}}" method="post">
        @csrf
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Property Details</h4>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="exampleInputEmail1">Company</label>
            <select class="form-control" name="company_id" id="company_id">
              <option></option>
              @foreach($companies as $company)
              <option value="{{$company->id}}">{{ $company->company_name }}</option>
              @endforeach
            </select>

          </div>
          <div class="form-group">
            <label for="exampleInputEmail1"> Property Name </label>
            <input type="text" class="form-control" id="property_name" name="property_name" placeholder="Enter property name">
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1"> Property Code </label>
            <input type="text" class="form-control" name="property_code" id="propertycode" placeholder="Enter property code">
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1"> Property Type </label>
            <select class="form-control" name="property_type_id" id="property_type_id">
              <option></option>
              @foreach($propertyTypes as $propertyType)

              <option value="{{$propertyType->id}}">{{ $propertyType->name }}</option>
              @endforeach
            </select>
          </div>


          <div class="form-group">
            <label for="exampleInputEmail1"> Location</label>
            <select class="form-control" name="region_id" id="region_id">
              <option></option>
              @foreach($regions as $region)
              <option value="{{$region->id}}">{{ $region->name }}</option>
              @endforeach
            </select>
          </div>

          <!-- <div class="form-group">
            <label for="exampleInputEmail1">TIN</label>
            <input type="ID" name="tin_number" class="form-control" id="tin_number" placeholder="Enter  TIN number">
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">VRN</label>
            <input type="ID" class="form-control" name="vrn_number" id="vrn_number" placeholder="Enter VRN Number">
          </div> -->
          <div class="form-group">
            <label for="exampleInputEmail1">Address</Address></label>
            <input type="ID" class="form-control" name="address" id="address" placeholder="Enter property address">
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          <button type="submit" name="property_and_units" class="btn btn-primary">Add Property & Units</button>
          <button type="submit" name="property_only" class="btn btn-primary">Add Property Only</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
@push('after-scripts')
<script>
  $('.datatable').DataTable({
    'paging': true,
    'lengthChange': true,
    'searching': false,
    'ordering': true,
    'info': true,
    'autoWidth': false
  });
</script>
@endpush