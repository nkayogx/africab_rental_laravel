<?php $__env->startSection('content'); ?>

<section class="content-header">
  <h1>
    Property
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
          <?php $__currentLoopData = $properties; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $property): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <?php 
            $total_units =  $property->unit_total;
            $vacants = $property->vacant;
            $vacants   = $total_units - $vacants;

          ?>
          <tr>
            <td> <?php echo e($property->property_name); ?></td>
            <td> <?php echo e($property->company_name); ?></td>
            <td> <?php echo e($property->region->name); ?> </td>
            <td> <?php echo e($total_units); ?> </td>

            <td> <?php echo e($vacants); ?></td>
            <td> <?php echo e($vacants); ?></td>
            <td><a href="<?php echo e(route('property-units',$property->id)); ?>"> Add Units </a> | <a href="<?php echo e(route('properties.edit',$property->id)); ?>"> Deactivate </a> </td>
          </tr>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </tfoot>
      </table>
    </div>
  </div>
</section>

<!-- Models  -->
<div class="modal fade" id="modal-default">
  <div class="modal-dialog">
    <div class="modal-content">

      <form action="<?php echo e(route('properties.store')); ?>" method="post">
        <?php echo csrf_field(); ?>
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
              <?php $__currentLoopData = $companies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $company): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <option value="<?php echo e($company->id); ?>"><?php echo e($company->company_name); ?></option>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
              <?php $__currentLoopData = $propertyTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $propertyType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

              <option value="<?php echo e($propertyType->id); ?>"><?php echo e($propertyType->name); ?></option>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
          </div>


          <div class="form-group">
            <label for="exampleInputEmail1"> Location</label>
            <select class="form-control" name="region_id" id="region_id">
              <option></option>
              <?php $__currentLoopData = $regions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $region): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <option value="<?php echo e($region->id); ?>"><?php echo e($region->name); ?></option>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\africab_rental\resources\views/property/index.blade.php ENDPATH**/ ?>