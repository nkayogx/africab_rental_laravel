<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Africab Apartment Management System </title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  @stack('before-styles')
  <!-- Bootstrap 3.3.7 -->
  {!! Html::style(url('plugins/bootstrap/dist/css/bootstrap.min.css')) !!}
  <!-- Font Awesome -->
    {!! Html::style(url('plugins/font-awesome/css/font-awesome.min.css')) !!}
  <!-- Ionicons -->
    {!! Html::style(url('plugins/Ionicons/css/ionicons.min.css')) !!}
  <!-- Theme style -->
     {!! Html::style(url('css/app.min.css')) !!}
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
    {!! Html::style(url('css/skins/_all-skins.min.css')) !!}
  <!-- Pace-->
    {!! Html::style(url('plugins/pace/pace.min.css')) !!}
  <!-- datatable -->
    {!! Html::style(url('plugins/datatables.net-bs/css/dataTables.bootstrap.min.css')) !!}

  <!-- select 2 -->

    {!! Html::style(url('plugins/select2/dist/css/select2.min.css')) !!}

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  @stack('after-styles')
</head>
<!-- ADD THE CLASS fixed TO GET A FIXED HEADER AND SIDEBAR LAYOUT -->
<!-- the fixed layout is not compatible with sidebar-mini -->
<body class="hold-transition skin-blue fixed sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">

  @include('layouts.header_navbar')

  <!-- =============================================== -->

  <!-- Left side column. contains the sidebar -->
  @include('layouts.navigation')
  <!-- =============================================== -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    
     @yield("content")

    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 2.4.18
    </div>
    <strong>Copyright &copy; <?php echo date('Y'); ?> <a href="https://burhaniinfosys.com">Burhaniinfosys.com</a>.</strong> All rights
    reserved.
  </footer>

  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
 
</div>
@stack('before-scripts')
<!-- ./wrapper -->

<!-- jQuery 3 -->
<!-- <script src="../../bower_components/jquery/dist/jquery.min.js"></script> -->
{!! Html::script(url('plugins/jquery/dist/jquery.min.js')) !!}
<!-- Bootstrap 3.3.7 -->
{!! Html::script(url('plugins/bootstrap/dist/js/bootstrap.min.js')) !!}
<!-- <script src="../../bower_components/bootstrap/dist/js/bootstrap.min.js"></script> -->
<!-- SlimScroll -->
{!! Html::script(url('plugins/jquery-slimscroll/jquery.slimscroll.min.js')) !!}
<!-- FastClick -->
{!! Html::script(url('plugins/fastclick/lib/fastclick.js')) !!}
<!-- AdminLTE App -->
{!! Html::script(url('js/adminlte.min.js')) !!}
<!-- datatable -->
{!! Html::script(url('plugins/datatables.net/js/jquery.dataTables.min.js')) !!}
{!! Html::script(url('plugins/datatables.net-bs/js/dataTables.bootstrap.min.js')) !!}
<!-- Pace -->
{!! Html::script(url('plugins/pace/pace.min.js')) !!}
<!-- select2 -->
{!! Html::script(url('plugins/select2/dist/js/select2.full.min.js')) !!}

@stack('in-scripts')
<script>
  $(document).ajaxStart(function () {
      Pace.restart()
  });
  $(document).ready(function(){
    $('.select2').select2({
      placeholder: $(this).data('placeholder'),
      width: '100%',
    });

    $(".success-alert").fadeTo(2000, 500).slideUp(500, function(){
       $(".success-alert").slideUp(500);
    });
  });
   
</script>
@stack('after-scripts')
</body>
</html>

