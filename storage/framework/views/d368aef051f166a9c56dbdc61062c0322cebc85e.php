<?php $__env->startSection('content'); ?>
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
  <form method="post" action="<?php echo e(route('tenants.update',$tenant->id )); ?>" enctype="form/multi-data">
        <?php echo csrf_field(); ?>
        <?php echo method_field('put'); ?>
       <div class="form-group">
          <label for="exampleInputEmail1">Name</label>
          <input type="text" name="name" value="<?php echo e($tenant->first_name); ?>" class="form-control" id="name" placeholder="Enter fullname">
        </div>
        <div class="form-group">
          <label for="exampleInputEmail1">Phone</label>
          <input type="phone"  name="phone" value="<?php echo e($tenant->phone); ?>" class="form-control" id="phone" placeholder="Enter phone number">
        </div>
        <div class="form-group">
          <label for="exampleInputEmail1">Email</label>
          <input type="email" class="form-control" name="email" value="<?php echo e($tenant->email); ?>"  id="email" placeholder="Enter email">
        </div>
        <div class="form-group">
          <label for="exampleInputEmail1">NIDA/TIN</label>
          <input type="ID" class="form-control" name="id_passport_number" value="<?php echo e($tenant->id_passport_number); ?>" id="exampleInputEmail1" placeholder="Enter NIDA or TIN number">
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
<?php $__env->stopSection(); ?>
<?php $__env->startPush('after-scripts'); ?>
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
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\africab_rental\resources\views/customer/tenant/edit.blade.php ENDPATH**/ ?>