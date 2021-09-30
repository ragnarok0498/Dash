 <script src="<?php echo RUTA_VENDOR;  ?>jquery/jquery.min.js"></script>
 <script src="<?php echo RUTA_VENDOR;  ?>bootstrap/js/bootstrap.bundle.min.js"></script>

 <script src="<?php echo RUTA_VENDOR;  ?>jquery-easing/jquery.easing.min.js"></script>

 <script src="<?php echo RUTA_JS;  ?>graficos-admin.min.js"></script>

 <script src="<?php echo RUTA_VENDOR;  ?>chart.js/Chart.min.js"></script>

 <script src="<?php echo RUTA_JS;  ?>demo/chart-area-demo.js"></script>
 <script src="<?php echo RUTA_JS;  ?>demo/chart-pie-demo.js"></script>


 <script src="<?php echo RUTA_VENDOR;  ?>datatables/jquery.dataTables.min.js"></script>
 <script src="<?php echo RUTA_VENDOR;  ?>datatables/dataTables.bootstrap4.min.js"></script>

 <script src="<?php echo RUTA_JS;  ?>sweetalert.min.js"></script>

 <?php
    if (isset($_SESSION['alerta']) && $_SESSION['alerta'] != '') {
    ?>
     <script>
         swal({
             title: "<?php echo $_SESSION['alerta'];  ?>",
             icon: "<?php echo $_SESSION['estado']; ?>",
             button: "Continuar",
         });
     </script>
 <?php
        unset($_SESSION['alerta']);
    }
    ?>

 <script src="<?php echo RUTA_JS;  ?>tablas.js"></script>

 </body>

 </html>