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
        <link rel="stylesheet" href="dist/css/jquery-ui.css">
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
        <script src="plugins/highchart.js"></script>
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
        
        function load_td(){
            
        }
        
        function numberFormat(labelValue) {
            return Math.abs(Number(labelValue)) >= 1.0e12 ?
                (Math.abs(Number(labelValue)) / 1.0e12).toFixed(1) + "T" : // Six Zeroes for Millions
                 Math.abs(Number(labelValue)) >= 1.0e9 ?
                (Math.abs(Number(labelValue)) / 1.0e9).toFixed(0) + "M" : // Six Zeroes for Millions
                 Math.abs(Number(labelValue)) >= 1.0e6 ?
                (Math.abs(Number(labelValue)) / 1.0e6).toFixed(0) + "Jt" : // Three Zeroes for Thousands
                 Math.abs(Number(labelValue)) >= 1.0e3 ?
                (Math.abs(Number(labelValue)) / 1.0e3).toFixed(0) + "Rb" :
                 Math.abs(Number(labelValue)).toFixed(0);
        }
        function create_tren_abs(id_active, categories, series) {
            Highcharts.chart(id_active, {
                chart: {
                    type: "area",
                    backgroundColor: "transparent"
                },
                title: {
                    text: ""
                },
                subtitle: {
                    text: ""
                },
                legend: {
                    enabled: false
                },
                credits: {
                    enabled: false
                },
                xAxis: {
                    categories: categories,
                    crosshair: true,
                    lineColor: "transparent",
                    visible: true,
                    gridLineWidth: 1,
                    gridLineColor: "#dee2e6",
                    labels: {
                        enabled: true
                    }
                },
                yAxis: {
                    title: {
                        text: ""
                    },
                    labels: {
                        formatter: function() {
                            return numberFormat(this.value);
                        },
                        enabled: true
                    },
                    gridLineWidth: 1,
                    gridLineColor: "#dee2e6"
                },
                plotOptions: {
                    area: {
                        fillColor: {
                            linearGradient: {
                                x1: 0,
                                y1: 0,
                                x2: 0,
                                y2: 1
                            },
                            stops: [
                                [0, "#0092AC"],
                                [1, "#FFFFFF"]
                            ]
                        },
                        lineColor: "transparent",
                        marker: {
                            enabled: false,
                            symbol: "circle",
                            radius: 2,
                            states: {
                                hover: {
                                    enabled: true
                                }
                            }
                        },
                        dataLabels: {
                            enabled: false,
                            formatter: function() {
                                return "Rp" + numberFormat(this.y);
                            }
                        }
                    }
                },
                series: [{
                    name: "Value",
                    data: series
                }]
            });
        };
        
        function create_batang(id_active, categories, series_) {
            Highcharts.chart(id_active, {
                credits: {
                    enabled: false
                },
                chart: {
                    type: 'column',
                    backgroundColor: "transparent"
                },
                title: {
                    text: ''
                },
                subtitle: {
                    text: ''
                },
                xAxis: {
                    categories: categories,
                    crosshair: true
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: ''
                    }
                },
                plotOptions: {
                    column: {
                        pointPadding: 0,
                        borderWidth: 0
                    }
                },
                series: [{
                    name: "Value",
                    color: "#439ca7",
                    data: series_
                }]
            });
        }
        
        function create_batang_horizontal(id_name, categories, series) {
            Highcharts.chart(id_name, {
                colors: ["#00BFFF", "#ffc107", "#8bc34a", "#DAA520"],
                chart: {
                    type: "bar",
                    backgroundColor: "transparent"
                },
                title: {
                    text: ""
                },
                credits: {
                    enabled: false
                },
                tooltip: {
                    headerFormat: ' {point.x}<br/>',
                    pointFormat: '{series.name}: <b> {point.y}</b><br/>'
                },
                xAxis: {
                    min: 0,
                    categories: categories,
                    crosshair: true,
                    lineColor: "transparent"
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: ""
                    },
                    labels: {
                        enabled: false
                    },
                    gridLineWidth: 0
                },
                plotOptions: {
                    bar: {
                        minPointLength: 5,
                        dataLabels: {
                            enabled: true,
                            formatter: function() {
                                return numberFormat(this.y);
                            },
                            color: "#000"
                        },
                        borderWidth: 0
                    },
                    series: {
                        borderRadius: 5,
                        cursor: "pointer",
                        point: {
                            events: {
                                click: function() {
                                    var rates_group = this.category;
                                    update_pln(rates_group);
                                }
                            }
                        }
                    }
                },
                series: [{
                    name: "Value",
                    data: series
                }]
            });
        }
        
        function chart_pie_radial(id_name, data){
            Highcharts.chart(id_name, {
                chart: {
                    plotBackgroundColor: null,
                    plotBorderWidth: 0,
                    height: 250,
                    backgroundColor: 'transparent'
                },
                title: {
                    text: '',
                    style: {"fontSize":"90%"},
                    verticalAlign: 'middle',
                    x: -60,
                    y: 0
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                },
                plotOptions: {
                    pie: {
                        center: ['50%', '50%'],
                        dataLabels: {
                            enabled: false
                        },
                        showInLegend: true
                    }
                },
                legend: {
                    itemStyle: {
                        fontWeight: 'normal',
                        fontSize: '9px'                
                    }
                },
                series: [{
                    type: 'pie',
                    innerSize: '70%',
                    data: data
                }]
            });
            console.log("selesai chart radial");
        }

        if(document.getElementById('chart_tren_abs_1') && 
           document.getElementById('chart_tren_abs_2') && 
           document.getElementById('chart_tren_abs_3') &&
           document.getElementById('chart_tren_abs_4')){
            create_tren_abs('chart_tren_abs_1',[
                "2020-01",
                "2020-02",
                "2020-03",
                "2020-04",
                "2020-05",
                "2020-06",
                "2020-07",
                "2020-08",
                "2020-09",
                "2020-10",
                "2020-11",
                "2020-12",
                "2021-01",
                "2021-02",
                "2021-03",
                "2021-04",
                "2021-05"
            ],[
                6934683,
                39358678,
                43875805,
                85926688,
                251573435,
                269670818,
                167884600,
                63837909,
                32962960,
                125579587,
                143781685,
                25120812,
                13259792,
                19850033,
                201536044,
                338253100,
                104330163 
            ]);

            create_batang('chart_tren_abs_2',[
                "2020-01",
                "2020-02",
                "2020-03",
                "2020-04",
                "2020-05",
                "2020-06",
                "2020-07",
                "2020-08",
                "2020-09",
                "2020-10",
                "2020-11",
                "2020-12",
                "2021-01",
                "2021-02",
                "2021-03",
                "2021-04",
                "2021-05"
            ],[
                6934683,
                39358678,
                43875805,
                85926688,
                251573435,
                269670818,
                167884600,
                63837909,
                32962960,
                125579587,
                143781685,
                25120812,
                13259792,
                19850033,
                201536044,
                338253100,
                104330163 
            ]);

            create_batang_horizontal('chart_tren_abs_3',[
                "2020-01",
                "2020-02",
                "2020-03",
                "2020-04",
                "2020-05",
                "2020-06",
                "2020-07",
                "2020-08",
                "2020-09",
                "2020-10",
                "2020-11",
                "2020-12",
                "2021-01",
                "2021-02",
                "2021-03",
                "2021-04",
                "2021-05"
            ],[
                6934683,
                39358678,
                43875805,
                85926688,
                251573435,
                269670818,
                167884600,
                63837909,
                32962960,
                125579587,
                143781685,
                25120812,
                13259792,
                19850033,
                201536044,
                338253100,
                104330163 
            ]);
            var categories_lingkaran = [
                "2020-01",
                "2020-02",
                "2020-03",
                "2020-04",
                "2020-05",
                "2020-06",
                "2020-07",
                "2020-08",
                "2020-09",
                "2020-10",
                "2020-11",
                "2020-12",
                "2021-01",
                "2021-02",
                "2021-03",
                "2021-04",
                "2021-05"
            ];

            var series_lingkaran = [
                6934683,
                39358678,
                43875805,
                85926688,
                251573435,
                269670818,
                167884600,
                63837909,
                32962960,
                125579587,
                143781685,
                25120812,
                13259792,
                19850033,
                201536044,
                338253100,
                104330163 
            ];
            var jumlah = 0;
            for(var i = 0; i < series_lingkaran.length; i++){
                jumlah = jumlah + series_lingkaran[i];
            }
            var persen = [];
            var key_lingkaran = [];
            for(var i = 0; i < series_lingkaran.length; i++){
                persen[i] = (series_lingkaran[i] / jumlah) * 100;
                key_lingkaran[i] = {};
                key_lingkaran[i].name = categories_lingkaran[i];
                key_lingkaran[i].y = (series_lingkaran[i] / jumlah) * 100;
                key_lingkaran[i].color = '#' + Math.floor(Math.random()*16777215).toString(16);
            }
            var jumlah_persen = 0;
            for(var i = 0; i < persen.length; i++){
                jumlah_persen = jumlah_persen + persen[i];
            }
            console.log(persen);
            console.log(jumlah_persen);
            console.log(jumlah);
            console.log(key_lingkaran);
            chart_pie_radial('chart_tren_abs_4', key_lingkaran);
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
