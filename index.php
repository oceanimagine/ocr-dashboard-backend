<?php 

include_once "koneksi.php";

if(!isset($_SESSION['username']) && !isset($_SESSION['password'])){
    header("location: login.php");
}

function get_hapus($param){
    $address = 0;
    $param_s = (string) $param;
    while(isset($param_s{$address})){
        if(substr($param_s, $address, strlen("hapus")) == "hapus"){
            return true;
        }
        $address++;
    }
    return false;
}

if(get_hapus(isset($_GET['page']) && $_GET['page'] != "" ? $_GET['page'] : "")){
    $page = isset($_GET['page']) && $_GET['page'] != "" ? $_GET['page'] : "";
    if (file_exists("page/module-" . $page . ".php")) {
        include_once "page/module-" . $page . ".php";
        exit();
    }
}

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>OCR Dashboard</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
        <!-- Tempusdominus Bbootstrap 4 -->
        <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
        <!-- iCheck -->
        <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
        <!-- JQVMap -->
        <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="dist/css/adminlte.min.css">
        <!-- overlayScrollbars -->
        <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
        <!-- Daterange picker -->
        <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
        <!-- summernote -->
        <link rel="stylesheet" href="plugins/summernote/summernote-bs4.css">
        <link rel="stylesheet" href="http://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <!-- Google Font: Source Sans Pro -->
        <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    </head>
    <body class="hold-transition sidebar-mini layout-fixed">
        <div class="wrapper">

            <!-- Navbar -->
            <?php include_once "part/header.php"; ?>
            <!-- /.navbar -->

            <!-- Main Sidebar Container -->
            <?php include_once "part/menu.php"; ?>

            <!-- Content Wrapper. Contains page content -->
            <?php include_once "part/body.php"; ?>
            <!-- /.content-wrapper -->
            <?php include_once "part/footer.php"; ?>

            <!-- Control Sidebar -->
            
            <!-- /.control-sidebar -->
        </div>
        <!-- ./wrapper -->

        <!-- jQuery -->
        <script src="plugins/jquery/jquery.min.js"></script>
        <!-- jQuery UI 1.11.4 -->
        <script src="plugins/jquery-ui/jquery-ui.min.js"></script>
        <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
        <script>
            $.widget.bridge('uibutton', $.ui.button)
        </script>
        <!-- Bootstrap 4 -->
        <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="dist/js/adminlte.js"></script>
        <!-- AdminLTE dashboard demo (This is only for demo purposes)
        <script src="dist/js/pages/dashboard.js"></script> -->
        <!-- AdminLTE for demo purposes -->
        <script src="dist/js/demo.js"></script>
        <script type="text/javascript">
        
        var url_hapus = "";
        $(function(){
            <?php if(isset($_SESSION['keterangan']) && $_SESSION['keterangan'] != ""){ ?>
            $('#modal-default').modal('show');
            <?php } ?>
            var tombol_hapus = document.getElementById("tombol_hapus");
            tombol_hapus.onclick = function(){
                if(url_hapus !== ""){
                    document.location = url_hapus;
                }
            };
            $( "#tanggal_lahir" ).datepicker({
                dateFormat:"yy-mm-dd",
                changeYear:true,
                changeMonth: true,
                yearRange: "1920:2000"
            });
        });
        
        function konfirmasi(url){
            url_hapus = url;
            $('#modal-konfirmasi').modal('show');
        }
        
        </script>
    </body>
</html>

<?php

if(isset($_SESSION['count'])){
    $_SESSION['count']++;
    if($_SESSION['count'] == 3){
        unset($_SESSION['keterangan']);
        unset($_SESSION['count']);
    }
}
