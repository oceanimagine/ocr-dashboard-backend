<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">OCR Dashboard</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->

            <!-- /.row -->
            <!-- Main row -->
            <div class="row">
                <!-- Left col -->
                <section class="col-lg-12 connectedSortable">
                    <!-- Custom tabs (Charts with tabs)-->
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-sm-6">
                                    <h3 class="card-title">
                                        <i class="fas fa-chart-pie mr-1"></i>
                                        <?php
                                        $page_header = isset($_GET['page']) && $_GET['page'] != "" ? $_GET['page'] : "Home";
                                        $back_url = call_back_button();
                                        ?>
                                        Module <?php echo judul($page_header); ?>                            
                                    </h3>
                                </div>
                                <div class="col-sm-6">
                                    <div style="text-align: right;">
                                        <?php if($back_url){ ?>
                                        <button type="submit" class="btn btn-primary" onclick="document.location='index.php?page=<?php echo $back_url; ?>';">Back</button>
                                        <?php } else { ?>
                                        <?php if($page_header == "openposition"){ ?>
                                        <button type="submit" class="btn btn-primary" onclick="reset();">Reset All</button>
                                        <?php } ?>
                                        <?php if($page_header == "form-pelamar"){ ?>
                                        <button type="submit" class="btn btn-primary" onclick="document.location='index.php?page=form-pelamar-add';">Add Applicant</button>
                                        <?php } ?>
                                        <?php if($page_header == "form-pelamar-add"){ ?>
                                        <button type="submit" class="btn btn-primary" onclick="document.location='index.php?page=form-pelamar';">Back</button>
                                        <?php } ?>
                                        <?php if($page_header == "form-jurusan"){ ?>
                                        <button type="submit" class="btn btn-primary" onclick="document.location='index.php?page=form-jurusan-add';">Add Jurusan</button>
                                        <?php } ?>
                                        <?php if($page_header == "form-universitas"){ ?>
                                        <button type="submit" class="btn btn-primary" onclick="document.location='index.php?page=form-universitas-add';">Add Universitas</button>
                                        <?php } ?>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content p-0" style="overflow-y: hidden; overflow-x: hidden;">
                                <!-- Morris chart - Sales -->
                                <?php
                                // put your code here
                                $page = isset($_GET['page']) && $_GET['page'] != "" ? $_GET['page'] : "home";
                                if (file_exists("page/module-" . $page . ".php")) {
                                    include_once "page/module-" . $page . ".php";
                                } else {
                                    echo "File tidak tersedia.";
                                }
                                ?>
                            </div>
                        </div><!-- /.card-body -->
                    </div>
                    <!-- /.card -->

                    <!-- DIRECT CHAT -->

                    <!--/.direct-chat -->

                    <!-- TO DO List -->

                    <!-- /.card -->
                </section>
                <!-- /.Left col -->
                <!-- right col (We are only adding the ID to make the widgets sortable)-->

                <!-- right col -->
            </div>
            <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
    <?php if(isset($_SESSION['keterangan']) && $_SESSION['keterangan'] != ""){ ?>
    <div class="modal fade" id="modal-default">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Keterangan</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p style="margin-bottom: 0px;"><?php echo $_SESSION['keterangan']; ?></p>
                </div>
                <div class="modal-footer justify-content-between">
                    
                    <button type="button" class="btn btn-default" data-dismiss="modal" style="width: 100%;">OK</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
        
    </div>
    <?php } ?>
    
    
    <div class="modal fade" id="modal-konfirmasi">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Konfirmasi</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p style="margin-bottom: 0px;">Apakah Anda Yakin ?</p>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" style="width: 100px;" data-dismiss="modal">No</button>
                    <button type="button" class="btn btn-primary" style="width: 100px;" id="tombol_hapus">Ya</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
        
    </div>
    
    
    <div class="modal fade" id="modal-api-reset">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Result</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p style="margin-bottom: 0px;" id="keterangan_api_reset"></p>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal" style="width: 100%;">OK</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
        
    </div>
    
</div>