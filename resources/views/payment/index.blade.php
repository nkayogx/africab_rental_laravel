@extends('layouts.app')
@section('content')

<section class="content-header">
  <h1>
    Payment
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
      <h3 class="box-title">Payment List</h3>
      <div class="pull-right box-tools">
        <button type="button" data-toggle="modal" data-target="#modal-default" class="btn btn-info btn-sm"><i class="fa fa-plus"></i> Add Payment </button>
      </div>
    </div>

    <div class="box-body">
      <table id="example1" class="table table-bordered table-striped datatable">
        <thead>
          <tr>
            <th> Date </th>
            <th> Amount </th>
            <th> Currency </th>
            <th> Payment Method </th>
            <th> Customer </th>
            <th> Paid For </th>
            <th> Property</th>
            <th> status </th>
            <th> Action </th>
          </tr>
        </thead>
        <tbody>
          @foreach($payments as $payment)
          <tr>
            <td> {{ date('d-m-Y', strtotime($payment->created_at)) }}</td>
            <td> {{ $payment->amount }}</td>
            <td> {{ $payment->currency }}</td>
            <td> {{ $payment->payment_method_name }} </td>
            <td> {{ $payment->customer }}</td>
            <td> {{ $payment->paid_for }}</td>
            <td> {{ $payment->property }}</td>
            <td> {!! ($payment->status == 'approved') ? "<label class='label  bg-green'>approved</label>": "<label class='label  bg-red'>pending</label>" !!}</td>
            <td><a href="{{ route('payments.edit',$payment->payment_id) }}"> Edit </a> | <a href="{{ route('payments.edit',$payment->payment_id) }}"> Deactivate </a> </td>
          </tr>
          @endforeach
          </tfoot>
      </table>
    </div>
  </div>
</section>

<!-- Models  -->
<div class="modal fade" id="modal-default">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"> Add Payment </h4>
      </div>
      <div class="modal-body">
        <div class="form-group row">
          <div class="col-sm-2">
            <label for="exampleInputEmail1"> Payment For </label>
          </div>
          <form method="post" action="{{ route('payments.store') }}">
            @csrf
            <div class="col-sm-8">
              <select class="form-control select2" data-placeholder="select payment resouces" id="paid_for" name="paid_for" required>
                <option></option>
                @foreach($paymentResources as $paymentResource)
                <option value="{{ $paymentResource->id }}"> {{ $paymentResource->name }} </option>
                @endforeach
              </select>
            </div>
        </div>
        <div class="form-group row">
          <div class="col-sm-2">
            <label for="exampleInputEmail1"> Property </label>
          </div>
          <div class="col-sm-8">
            <select class="form-control select2" data-placeholder="select property" id="property_id" name="property_id">
              <option></option>
              @foreach($properties as $property)
              <option value="{{$property->id}}">{{ $property->property_name }}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="form-group row">
          <div class="col-sm-2">
            <label for="exampleInputEmail1"> Unit </label>
          </div>
          <div class="col-sm-8">
            <select class="form-control select2" id="unit_id" data-placeholder="select unit">
              <option></option>
            </select>
          </div>
        </div>
        <div class="form-group row">
          <div class="col-sm-2">
            <label for="exampleInputEmail1">Tenant Details </label>
          </div>
          <div class="col-sm-8 tenant-details">
          </div>
        </div>
        <div class="form-group row">
          <div class="col-sm-2">
            <label for="exampleInputEmail1">Lease Details </label>
          </div>
          <div class="col-sm-8 lease-details">
          </div>
        </div>
        <input type="hidden" id="lease_id" name="lease_id" value="" required>
        <div class="form-group row">
          <div class="col-sm-2">
            <label for="exampleInputEmail1"> Payment Amount </label>
          </div>
          <div class="col-sm-3">
            <input type="number" name="amount" id="amount" class="form-control" id="exampleInputEmail1" placeholder="Amount">
          </div>
          <div class="col-sm-3">
            <select class="form-control select2" data-placeholder="currency" id="currency" name="currency">
              <option></option>
              @foreach($currencies as $currency)
              <option value=" {{$currency->code }}">{{ $currency->code }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-sm-3">
            <input type="text" name="tax" class="form-control" id="tax" placeholder="tax">
          </div>
        </div>
        <div class="form-group row">
          <div class="col-sm-2">
            <label for="exampleInputEmail1"> Lease Deposite </label>
          </div>
          <div class="col-sm-8">
            <input type="text" class="form-control" readonly>
          </div>
        </div>
        <div class="form-group row">
          <div class="col-sm-2">
            <label for="exampleInputEmail1"> Payment Method </label>
          </div>
          <div class="col-sm-8">
            <select class="form-control select2" data-placeholder="payment_method_id" id="payment_method_id" required name="payment_method_id">
              <option></option>
              @foreach($paymentMethods as $paymentMethod)
                <option value=" {{$paymentMethod->id }}">{{ $paymentMethod->payment_method_name  }}</option>
              @endforeach
            </select>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Submit</button>
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

  $(document).on('change', '#property_id', function() {
    property_id = $(this).val();
    url = "{{ route('propety_units',':property_id') }}";
    url = url.replace(':property_id', property_id);
    $.ajax({
      url: url,
      type: 'get',
      dataType: "json",
      success: function(data) {
        var option = "";
        $.each(data, function(key, value) {
          option = "<option></option>";
          option += "<option value='" + value.id + "'>" + value.unit_name + "</option>";
        })
        $('#unit_id').html(option);

      },
      error: function(data) {

      }
    });
  });

  $(document).on('change', '#unit_id', function() {
    unit_id = $(this).val();
    url = "{{ route('current-tenant',':unit_id') }}";
    url = url.replace(':unit_id', unit_id);
    $.ajax({
      url: url,
      type: 'get',
      dataType: "json",
      success: function(data) {

        $.each(data.tenants, function(key, value) {
          tenant_info = "<div class='d-inline-block text-primary'>";
          tenant_info += "<label class='col-sm-3'>Full Name</label>";
          tenant_info += "<div class='col-sm-3'>" + value.full_name + "</div>";
          tenant_info += "<label class='col-sm-3'>Address</label>";
          tenant_info += "<div class='col-sm-3'>" + value.address + "</div>";
          tenant_info += "</div>";

        })
        $('.tenant-details').html(tenant_info);

        var lease = data.lease;
        lease_info = "<div class='d-inline-block text-primary'>";
        lease_info += "<label class='col-sm-2'>lease number</label>";
        lease_info += "<div class='col-sm-2'>" + lease.lease_number + "</div>";
        lease_info += "<label class='col-sm-2'>start</label>";
        lease_info += "<div class='col-sm-2'>" + lease.start_date + "</div>";
        lease_info += "<label class='col-sm-2'>End </label>";
        lease_info += "<div class='col-sm-2'>" + lease.end_date + "</div>";
        lease_info += "</div>";
        $('.lease-details').html(lease_info);

        $("#lease_id").val(lease.lease_id);


      },
      error: function(data) {}
    });
  });
</script>
@endpush