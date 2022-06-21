<?php $__env->startSection('content'); ?>

<section class="content-header">
      <h1>
        Lease       
      </h1>
</section>


<!-- Main content -->
<section class="content">
<?php if(Session::has('message')): ?>
  <div class="alert alert-success success-alert">
    <?php echo e(Session::get('message')); ?>

  </div>
<?php endif; ?>
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
  <?php $__currentLoopData = $leases; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lease): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <tr>
      <td> <?php echo e($lease->lease_number); ?></td>
      <td> <?php echo e($lease->customer); ?></td>
      <td> <?php echo e($lease->property); ?> </td>
      <td> <?php echo e($lease->unit); ?> </td>
      <td> <?php echo e($lease->rent_amount); ?> </td>
      <td> <?php echo e($lease->start); ?> </td>
      <td> <?php echo e($lease->end); ?> </td>
      <td><a href="<?php echo e(route('property-units',$lease->lease_id)); ?>"> Add Units </a> | <a href="<?php echo e(route('properties.edit',$lease->lease_id)); ?>"> Deactivate </a> </td>
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
      
        <form action="<?php echo e(route('leases.store')); ?>" method="post">
          <?php echo csrf_field(); ?>  
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
                <?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value=" <?php echo e($customer->id); ?>"><?php echo e($customer->full_name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </select>
          
          </div>
          <div class="form-group">
            <label>Company</label>
            
              <select class="form-control select2" name="company_id" id="company_id" data-placeholder="select company name">
                <option></option>
                <?php $__currentLoopData = $companies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $company): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value=" <?php echo e($company->id); ?>"><?php echo e($company->company_name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                      <?php $__currentLoopData = $currencies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $currency): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value=" <?php echo e($currency->code); ?>"><?php echo e($currency->code); ?></option>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
<?php $__env->stopSection(); ?>
<?php $__env->startPush('after-scripts'); ?>
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
      url = "<?php echo e(route('company-properties')); ?>";
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
      url = "<?php echo e(route('property-unitlist',':property_id')); ?>";
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
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\africab_rental\resources\views/lease/index.blade.php ENDPATH**/ ?>