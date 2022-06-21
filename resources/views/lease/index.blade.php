@extends('layouts.app')
@section('content')

<section class="content-header">
      <h1>
        Lease       
      </h1>
</section>


<!-- Main content -->
<section class="content">
@if(Session::has('message'))
  <div class="alert alert-success success-alert">
    {{ Session::get('message') }}
  </div>
@endif
<div class="box">
<div class="box-header">
  <h3 class="box-title">Leases List</h3>
  <div class="pull-right box-tools">
    <button type="button" data-toggle="modal" data-target="#modal-default" class="btn btn-info btn-sm"><i class="fa fa-plus"></i> Add Lease </button>
  </div>
</div>

<div class="box-body">
<table id="example1" class="table table-bordered table-striped datatable">
<thead>
  <tr>
    <th> Number </th>
    <th> Customer </th>
    <th> Property </th>
    <th> Units </th>
    <th> Lease Amount </th>
    <th> Start  </th>
    <th> End  </th>
    <th>Actions</th>
  </tr>
</thead>
<tbody>
  @foreach($leases as $lease)
    <tr>
      <td> {{ $lease->lease_number }}</td>
      <td> {{ $lease->customer }}</td>
      <td> {{ $lease->property  }} </td>
      <td> {{ $lease->unit }} </td>
      <td> {{ $lease->rent_amount }} </td>
      <td> {{ $lease->start }} </td>
      <td> {{ $lease->end }} </td>
      <td><a href="{{ route('property-units',$lease->lease_id) }}"> Add Units </a> | <a href="{{ route('properties.edit',$lease->lease_id) }}"> Deactivate </a> </td>
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
      
        <form action="{{ route('leases.store')}}" method="post">
          @csrf  
        <div class="modal-header">    
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Lease Details</h4>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label >Customer </label>
            
              <select class="form-control select2" name="customer_id[]" id="customer_id[]" multiple data-placeholder="select customers">
                <option></option>
                @foreach($customers as $customer)
                        <option value=" {{$customer->id }}">{{ $customer->full_name }}</option>
                @endforeach
              </select>
          
          </div>
          <div class="form-group">
            <label>Company</label>
            
              <select class="form-control select2" name="company_id" id="company_id" data-placeholder="select company name">
                <option></option>
                @foreach($companies as $company)
                        <option value=" {{$company->id }}">{{ $company->company_name }}</option>
                @endforeach
              </select>
          
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1"> Property  </label>
            <select class="form-control select2" name="property_id" id="property_id" data-placeholder="select property name">
              <option></option>
            </select>
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1"> Unit  </label>
            <select class="form-control select2" name="unit_id[]" id="unit_id" data-placeholder="select units" multiple>
              <option></option>
            </select>
          </div>
          
          <div class="form-group row">
            <div class="col-sm-2">
              <label for="exampleInputEmail1"> Start  </label>
            </div>
            <div class="col-sm-4"> 
              <input class="form-control"  type="date" name="start_date" id="end_id" placeholder="start date" required>
            </div>
            <div class="col-sm-2">
              <label for="exampleInputEmail1"> End  </label>
            </div>
            <div class="col-sm-4">  
                <input class="form-control" type="date" name="end_date" id="end_id" placeholder="end date" required>
            </div>
          </div>
          <div class="form-group row">
           
              <div class="col-sm-2"> 
                <label for="exampleInputEmail1"> Monthly Rent  </label>
              </div>
              <div class="col-sm-4"> 
                <input class="form-control"  type="number" name="rent_amount" id="end_id" placeholder="Monthly Rent" required>
              </div>
              <div class="col-sm-2"> 
                <label for="exampleInputEmail1"> Currency </label>
              </div>
              <div class="col-sm-4">
                  <select class="form-control select2" data-placeholder="currency" id="rent_currency"  name="currency">
                      <option></option>
                      @foreach($currencies as $currency)
                        <option value=" {{$currency->code }}">{{ $currency->code }}</option>
                      @endforeach
                    </select>
              </div> 
        
          </div>

       
 
  
          </div>
          
        <div class="modal-footer">
          <button type="submit" name ="property_only" class="btn btn-primary">submit</button>
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

    $('#company_id').change(function(){
      company_id = $(this).val(); 
      url = "{{ route('company-properties') }}";
      $.ajax({
        url: url,
        type:'get',
        dataType: "json",
        data:{ company: company_id}, 
        success:function(data){
          var option ="";
          $.each(data,function(key,value){
            console.log(value);
            option += "<option value='"+value.id+"'>"+value.property_name+"</option>";
          })
          $('#property_id').html(option);
        },
        error:function(data){
        }
      });
    });

    $(document).on('change','#property_id',function(){
      property_id = $(this).val(); 
      url = "{{ route('property-unitlist',':property_id') }}";
      url = url.replace(':property_id', property_id);
      $.ajax({
        url: url,
        type:'get',
        dataType: "json",
        success:function(data){
          var option ="";
          $.each(data,function(key,value){
            console.log(value);
            option += "<option value='"+value.id+"'>"+value.unit_name+"</option>";
          })
          $('#unit_id').html(option);
        },
        error:function(data){
        }
      });
    });

   
  });
  
</script>
@endpush
