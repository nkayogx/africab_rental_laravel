@extends('layouts.app')
@section('content')

<section class="content-header">
      <h1>
        Property Units     
      </h1>
</section>



<!-- Main content -->
<section class="content">
@if(Session::has('message'))
  <div class="alert alert-success">
    {{ Session::get('message') }}
  </div>
@endif
<section class="content">

<div class="row">
  <div class="col-md-3">

    <!-- Profile Image -->
    <div class="box box-primary">
      <div class="box-body box-profile">
        
        <h3 class="profile-username text-center">{{ $property->property_name }}</h3>

        <p class="text-muted text-center"> {{ $property->property_code }}  </p>

        <ul class="list-group list-group-unbordered">
          <li class="list-group-item">
            <b>Total Units</b> <a class="pull-right">{{ $property->unit_total }}</a>
          </li>
          <li class="list-group-item">
            <b>Vacants</b> <a class="pull-right">543</a>
          </li>
          <li class="list-group-item">
            <b>Occupied</b> <a class="pull-right">13,287</a>
          </li>
        </ul>

         
      </div>
      <!-- /.box-body -->
    </div>
    <!-- /.box -->

    <!-- About Me Box -->
    <div class="box box-primary">
 
      <div class="box-body">
        <strong><i class="fa fa-book margin-r-5"></i> Company </strong>
        <p class="text-muted"> {{ $property->company->company_name  }} </p>
        <hr>
        <strong><i class="fa fa-book margin-r-5"></i> Address </strong>
        <p class="text-muted"> {{ $property->address  }} </p>
        <hr>
        <strong><i class="fa fa-map-marker margin-r-5"></i> Location</strong>
        <hr>
        <p class="text-muted"> {{ $property->region->name  }} </p>
      </div>
      <!-- /.box-body -->
    </div>
    <!-- /.box -->
  </div>
  <!-- /.col -->
  <div class="col-md-9">
    <div class="nav-tabs-custom">
      <ul class="nav nav-tabs">
        <li class="active"><a href="#activity" data-toggle="tab">Add Units</a></li>
        <li><a href="#units" data-toggle="tab"><span class="label bg-blue"> {{ $units->count() }}</span>Units List</a></li>
      </ul>
      <div class="tab-content">
        <div class="active tab-pane" id="activity">
          <!-- Post -->
          <div class="post">
          <form class="form-horizontal" action="{{ route('units.store') }}" method="post">
            <input type="hidden" name="property_id" value="{{ $property->id }}" require/>
            @csrf
            <div class="form-group">
              <div class="col-sm-2">
                <label for="inputName" class="col-sm-2 control-label">Name</label>
              </div>
              <div class="col-sm-10">
                <input type="text" name="unit_name" class="form-control" id="unit_name" placeholder="unit name">
              </div>
            </div>
            <div class="form-group">
              <label for="inputEmail" class="col-sm-2 control-label">Floor</label>
              <div class="col-sm-10">
                <input type="number" name="unit_floor" class="form-control" id="unit_floor" placeholder="unit floor">
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-2">
                <label for="inputName" class="col-sm-2 control-label">Rent Amount </label>
              </div>
              <div class="col-sm-10">
                <div class="row">
                  <div class="col-sm-6">
                    <input type="number" class="form-control" id="rent_amount" placeholder="rent amount">
                  </div>
                  <div class="col-sm-6">
                    <select class="form-control select2" data-placeholder="currency amount" id="rent_currency"  id="rent_amount_currency">
                    <option></option>
                    @foreach($currencies as $currency)
                      <option value=" {{$currency->code }}">{{ $currency->code }}</option>
                    @endforeach
                  </select>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-2">
               <label for="inputExperience" class="col-sm-2 control-label">Maintenance Fee</label>
              </div>
              <div class="col-sm-10">
                <div class="row">
                  <div class="col-sm-6">
                  <input type="number" name="maintenance_fee" class="form-control" id="maintenance_fee" placeholder="Maintenance Fee">
                  </div>
                  <div class="col-sm-6">
                    <select class="form-control select2" data-placeholder="Currency" id="maintenance_currency" name="maintenance_currency">
                    <option></option>
                    @foreach($currencies as $currency)
                      <option value=" {{$currency->code }}">{{ $currency->code }}</option>
                    @endforeach
                  </select> 
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="inputExperience" class="col-sm-2 control-label"> Unit Mode </label>
              <div class="col-sm-10">
                <select class="form-control select2"  data-placeholder="select unit mode" name="unit_mode_id" id="unit_mode_id">
                  <option></option>
                  @foreach($unitModes as $unitMode)
                    <option value="{{$unitMode->id}}">{{ $unitMode->unit_mode_name }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="form-group">
              <label for="inputExperience" class="col-sm-2 control-label">Unit Type </label>
              <div class="col-sm-10">
                <select class="form-control" name="unit_type_id" id="unit_type_id">
                  <option></option> 
                </select>
              </div>
            </div>
            <div class="form-group">
            <div class="col-sm-2">
                <label for="inputExperience" class="col-sm-2 control-label"> Total Rooms </label>
              </div>
              <div class="col-sm-4">
                <input class="form-control" type="number" name="total_rooms" id="total_rooms">
              </div>
              <div class="col-sm-2">
                <label for="inputExperience" class="col-sm-2 control-label"> square meter </label>
              </div>
              <div class="col-sm-4">
                <input class="form-control" type="number"  name="square_meter" id="square_meter">
              </div>
            </div>
            
            <div class="form-group">
              <div class="col-sm-offset-2 col-sm-10">
                <div class="checkbox">
                  <label>
                    <input type="checkbox"> I agree to the <a href="#">terms and conditions</a>
                  </label>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
            </div>
          </form>
          </div>
        </div>
  
        <div class="tab-pane" id="units">
          <table class="table">
            <thead>
              <tr>
                <th>Name</th><th>floor</th><th>number of rooms</th><th>Type</th><th>Mode</th>
              </tr>
            </thead>
            <tbody>
              @foreach($units as $unit)
                <tr>
                  <td>{{ $unit->unit_name }}</td>
                  <td>{{ $unit->unit_floor }}</td>
                  <td>{{ $unit->total_rooms }}</td>
                  <td>{{ $unit->unitType->unit_type_name }}</td>
                  <td>{{ $unit->unitMode->unit_mode_name }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        <!-- /.tab-pane -->
      </div>
      <!-- /.tab-content -->
    </div>
    <!-- /.nav-tabs-custom -->
  </div>
  <!-- /.col -->
</div>
<!-- /.row -->

</section>
<!-- /.content -->

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
            <label for="exampleInputEmail1">Name</label>
            <input type="text" name="name" class="form-control" id="name" placeholder="Enter fullname">
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
          <button type="submit" name ="property_and_units" class="btn btn-primary">Add Property & Units</button>
          <button type="submit" name ="property_only" class="btn btn-primary">Add Property Only</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
@push('after-scripts')
<script>
  $(document).ready(function(){
    $('.datatable').DataTable({
      'paging'      : true,
      'lengthChange': true,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    });

    $('#unit_mode_id').change(function(){
      unitType = $(this).val(); 
      url = "{{ route('unit_mode_types',':unitType') }}";
      url = url.replace(':unitType', unitType);
      $.ajax({
        url: url,
        type:'get',
        dataType: "json",
        success:function(data){
          var option ="";
          $.each(data,function(key,value){
            console.log(value);
            option += "<option value='"+value.id+"'>"+value.unit_type_name+"</option>";
          })
          $('#unit_type_id').html(option);
          console.log(option);
        },
        error:function(data){
          console.log(data);
        }
      });
    });

  });


</script>
@endpush
