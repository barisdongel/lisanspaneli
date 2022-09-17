<footer class="main-footer">
  <div class="footer-left">
    Copyright &copy; 2022 <div class="bullet"></div> Design By <a href="http://inoception.com">Inoception</a>
  </div>
  <div class="footer-right">
  </div>
</footer>


<script src="<?= site ?>/assets/js/sweetalert2.all.min.js"></script>

<script src="https://code.jquery.com/jquery-1.11.3.js"></script>
<!-- General JS Scripts -->
<script src="<?= site ?>/assets/js/app.min.js"></script>
<!-- JS Libraies -->
<script src="<?= site ?>/assets/bundles/echart/echarts.js"></script>

<script src="<?= site ?>/assets/bundles/chartjs/chart.min.js"></script>
<script src="<?= site ?>/assets/bundles/apexcharts/apexcharts.min.js"></script>
<!-- Page Specific JS File -->
<script src="<?= site ?>/assets/js/page/index.js"></script>
<!--Bootstrap-->
<script src="<?= site ?>/assets/js/bootstrap.min.js"></script>
<!-- Template JS File -->
<script src="<?= site ?>/assets/js/scripts.js"></script>
<script src="<?= site ?>/assets/bundles/jquery.sparkline.min.js"></script>
<!-- dropzone js -->
<script src="<?= site ?>/assets/dropzone/dist/dropzone.js"></script>
<!--CK Editor-->
<script src="../ckeditor/ckeditor.js"></script>
<!--datatable-->
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.12.1/datatables.min.js"></script>
<script>
  CKEDITOR.replace('ckeditor1');
  $(document).ready(function() {
    $('#datatable').DataTable({
      "language": {
        "url": "https://cdn.datatables.net/plug-ins/1.12.1/i18n/tr.json"
      }
    });
  });
</script>
</body>

</html>