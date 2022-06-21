<?php $__env->startSection('content'); ?>

<section class="content-header">
  <h1>
    Payment
  </h1>
</section>



<!-- Main content -->
<section class="content">
  <?php if(Session::has('message')): ?>
  <div class="alert alert-success">
    <?php echo e(Session::get('message')); ?>

  </div>
  <?php endif; ?>
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
          <?php $__currentLoopData = $payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <tr>
            <td> <?php echo e(date('d-m-Y', strtotime($payment->created_at))); ?></td>
            <td> <?php echo e($payment->amount); ?></td>
            <td> <?php echo e($payment->currency); ?></td>
            <td> <?php echo e($payment->payment_method_name); ?> </td>
            <td> <?php echo e($payment->customer); ?></td>
            <td> <?php echo e($payment->paid_for); ?></td>
            <td> <?php echo e($payment->property); ?></td>
            <td> <?php echo ($payment->status == 'approved') ? "<label class='label  bg-green'>approved</label>": "<label class='label  bg-red'>pending</label>"; ?></td>
            <td><a href="<?php echo e(route('payments.edit',$payment->payment_id)); ?>"> Edit </a> | <a href="<?php echo e(route('payments.edit',$payment->payment_id)); ?>"> Deactivate </a> </td>
          </tr>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
          <form method="post" action="<?php echo e(route('payments.store')); ?>">
            <?php echo csrf_field(); ?>
            <div class="col-sm-8">
              <select class="form-control select2" data-placeholder="select payment resouces" id="paid_for" name="paid_for" required>
                <option></option>
                <?php $__currentLoopData = $paymentResources; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $paymentResource): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($paymentResource->id); ?>"> <?php echo e($paymentResource->name); ?> </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
              <?php $__currentLoopData = $properties; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $property): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <option value="<?php echo e($property->id); ?>"><?php echo e($property->property_name); ?></option>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
              <?php $__currentLoopData = $currencies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $currency): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <option value=" <?php echo e($currency->code); ?>"><?php echo e($currency->code); ?></option>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
              <?php $__currentLoopData = $paymentMethods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $paymentMethod): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value=" <?php echo e($paymentMethod->id); ?>"><?php echo e($paymentMethod->payment_method_name); ?></option>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
<?php $__env->stopSection(); ?>
<?php $__env->startPush('after-scripts'); ?>
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
    url = "<?php echo e(route('propety_units',':property_id')); ?>";
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
    url = "<?php echo e(route('current-tenant',':unit_id')); ?>";
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
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\africab_rental\resources\views/payment/index.blade.php ENDPATH**/ ?>