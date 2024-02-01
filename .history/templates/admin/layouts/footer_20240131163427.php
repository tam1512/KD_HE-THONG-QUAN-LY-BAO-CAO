<?php
if(!defined('_INCODE')) die('Access denied...');
?>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->
<footer class="main-footer">
   <strong>Copyright &copy; <?php echo date('Y') ?> Xây dựng bởi <a href="#">Kim Đức</a>.</strong>
   <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 1.0
   </div>
</footer>

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
   <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="<?php echo _WEB_HOST_TEMPLATE_ADMIN.'/assets/' ?>plugins/jquery/jquery.min.js"></script>

<!-- jQuery UI 1.12.1 -->
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
$.widget.bridge('uibutton', $.ui.button)
</script>

<!-- Bootstrap 4 -->
<script src="<?php echo _WEB_HOST_TEMPLATE_ADMIN.'/assets/' ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- jQuery Knob Chart -->
<script src="<?php echo _WEB_HOST_TEMPLATE_ADMIN.'/assets/' ?>plugins/jquery-knob/jquery.knob.min.js"></script>

<!-- daterangepicker -->
<script src="<?php echo _WEB_HOST_TEMPLATE_ADMIN.'/assets/' ?>plugins/moment/moment.min.js"></script>
<script src="<?php echo _WEB_HOST_TEMPLATE_ADMIN.'/assets/' ?>plugins/daterangepicker/daterangepicker.js"></script>

<!-- Tempusdominus Bootstrap 4 -->
<script
   src="<?php echo _WEB_HOST_TEMPLATE_ADMIN.'/assets/' ?>plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js">
</script>

<!-- Summernote -->
<script src="<?php echo _WEB_HOST_TEMPLATE_ADMIN.'/assets/' ?>plugins/summernote/summernote-bs4.min.js"></script>

<!-- overlayScrollbars -->
<script
   src="<?php echo _WEB_HOST_TEMPLATE_ADMIN.'/assets/' ?>plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js">
</script>

<!-- AdminLTE App -->
<script src="<?php echo _WEB_HOST_TEMPLATE_ADMIN.'/assets/' ?>js/adminlte.js"></script>

<!-- Lấy ra web host root -->
<?php 
   $body = getBody();
   $module = null;
   if(!empty($body['module'])) {
      $module = $body['module'];
   }
?>

<script type="text/javascript">
let rootUrlAdmin = "<?php echo _WEB_HOST_ROOT_ADMIN.'/' ?>";
let rootUrl = "<?php echo _WEB_HOST_ROOT ?>";
</script>

<!-- sign -->
<script type="text/javascript"
   src="<?php echo _WEB_HOST_TEMPLATE_ADMIN.'/assets/' ?>plugins/sign/js/jquery.signature.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js">
</script>

<!-- ChartJS -->
<script src="<?php echo _WEB_HOST_TEMPLATE_ADMIN.'/assets/' ?>plugins/chart.js/Chart.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/chart.js/dist/chart.umd.min.js"></script>

<!-- select.js for me -->
<script src="<?php echo _WEB_HOST_TEMPLATE_ADMIN.'/assets/' ?>js/select.js?ver=<?php echo rand() ?>"></script>
<!-- custom.js for me -->
<script src="<?php echo _WEB_HOST_TEMPLATE_ADMIN.'/assets/' ?>js/custom.js?ver=<?php echo rand() ?>"></script>
</body>

</html>