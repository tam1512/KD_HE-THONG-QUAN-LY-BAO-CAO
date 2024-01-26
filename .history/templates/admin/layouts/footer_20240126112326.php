<?php
if(!defined('_INCODE')) die('Access denied...');
?>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->
<footer class="main-footer">
   <strong>Copyright &copy; <?php echo date('Y') ?> Xây dựng bởi <a
         href="https://online.unicode.vn/">Unicode</a>.</strong>
   All rights reserved.
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
<!-- jQuery UI 1.11.4 -->
<!-- <script src="<?php echo _WEB_HOST_TEMPLATE_ADMIN.'/assets/' ?>plugins/jquery-ui/jquery-ui.min.js"></script> -->
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
$.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="<?php echo _WEB_HOST_TEMPLATE_ADMIN.'/assets/' ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="<?php echo _WEB_HOST_TEMPLATE_ADMIN.'/assets/' ?>plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="<?php echo _WEB_HOST_TEMPLATE_ADMIN.'/assets/' ?>plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="<?php echo _WEB_HOST_TEMPLATE_ADMIN.'/assets/' ?>plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="<?php echo _WEB_HOST_TEMPLATE_ADMIN.'/assets/' ?>plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
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
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="<?php echo _WEB_HOST_TEMPLATE_ADMIN.'/assets/' ?>js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo _WEB_HOST_TEMPLATE_ADMIN.'/assets/' ?>js/demo.js"></script>

<!-- Xử lý service modal search -->
<script
   src="<?php echo _WEB_HOST_ROOT.'/templates/admin/assets/js/services/hidden_select.js?ver=<?php echo rand() ?>' ?>">
</script>
<script
   src="<?php echo _WEB_HOST_ROOT.'/templates/admin/assets/js/services/modal_search.js?ver=<?php echo rand() ?>' ?>">
</script>

<!-- Lấy ra web host root và prefix link để hiển thị link ở slug -->
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
let prefixLink = "<?php echo getPrefixLink($module) ?>"
</script>
<script src="https://cdn.jsdelivr.net/npm/es6-promise@4/dist/es6-promise.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/es6-promise@4/dist/es6-promise.auto.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.0/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>


<!-- sign -->
<script type="text/javascript"
   src="<?php echo _WEB_HOST_TEMPLATE_ADMIN.'/assets/' ?>plugins/sign/js/jquery.signature.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js">
</script>

<!-- chartJs -->
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/chart.js/dist/chart.umd.min.js"></script>



<!-- select.js for me -->
<script src="<?php echo _WEB_HOST_TEMPLATE_ADMIN.'/assets/' ?>js/select.js?ver=<?php echo rand() ?>"></script>
<!-- custom.js for me -->
<script src="<?php echo _WEB_HOST_TEMPLATE_ADMIN.'/assets/' ?>js/custom.js?ver=<?php echo rand() ?>"></script>
</body>

</html>