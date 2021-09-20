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
                                        <?php 
                                        if(isset($_GET['page']) && $_GET['page'] == "form-pelamar-open-position-perperson-add" && !isset($_GET['id_open_position'])){
                                            echo "Module " . str_replace("Edit", "Add", judul($page_header));
                                        } else {
                                        ?>
                                        Module <?php echo judul($page_header); ?> 
                                        <?php } ?>
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
                                        <?php if($page_header == "upload-sso-view"){ ?>
                                        <button type="submit" class="btn btn-primary" onclick="document.location='index.php?page=upload-sso';">Upload Excel</button>
                                        <?php } ?>
                                        <?php if($page_header == "upload-sso"){ ?>
                                        <button type="submit" class="btn btn-primary" onclick="document.location='index.php?page=upload-sso-view';">Lihat Excel</button>
                                        <?php } ?>
                                        <?php if($page_header == "form-pelamar-open-position-perperson"){ ?>
                                        <button type="submit" class="btn btn-primary" onclick="document.location='index.php?page=form-pelamar-open-position-perperson-add&id=<?php echo isset($_GET['id']) && $_GET['id'] != "" && is_numeric($_GET['id']) ? mysqli_real_escape_string($connect, $_GET['id']) : ""; ?>';">Add Open Position</button>
                                        <button type="submit" class="btn btn-primary" onclick="document.location='index.php?page=form-pelamar';">Back</button>
                                        <?php } ?>
                                        <?php if($page_header == "form-pelamar-open-position-perperson-add"){ ?>
                                        <button type="submit" class="btn btn-primary" onclick="document.location='index.php?page=form-pelamar-open-position-perperson&id=<?php echo isset($_GET['id']) && $_GET['id'] != "" && is_numeric($_GET['id']) ? mysqli_real_escape_string($connect, $_GET['id']) : ""; ?>';">Back</button>
                                        <?php } ?> 
                                        <?php if($page_header == "form-pelamar-languague-perperson&"){ ?>
                                        <button type="submit" class="btn btn-primary" onclick="document.location='index.php?page=form-pelamar';">Back</button>
                                        <?php } ?>
                                        <?php if($page_header == "form-pelamar-skill-perperson"){ ?>
                                        <button type="submit" class="btn btn-primary" onclick="document.location='index.php?page=form-pelamar-skill-perperson-add&id=<?php echo isset($_GET['id']) && $_GET['id'] != "" && is_numeric($_GET['id']) ? mysqli_real_escape_string($connect, $_GET['id']) : ""; ?>';">Add</button>
                                        <button type="submit" class="btn btn-primary" onclick="document.location='index.php?page=form-pelamar';">Back</button>
                                        <?php } ?>
                                        <?php if($page_header == "form-pelamar-show-transkrip-image" || $page_header == "form-pelamar-show-ijazah-image" || $page_header == "form-pelamar-show-transkrip-s2-image" || $page_header == "form-pelamar-show-ijazah-s2-image"){ ?>
                                        <button type="submit" class="btn btn-primary" onclick="document.location='index.php?page=form-pelamar';">Back</button>
                                        <?php } ?>
                                        <?php if($page_header == "form-pelamar-other-cert"){ ?>
                                        <button type="submit" class="btn btn-primary" onclick="document.location='index.php?page=form-pelamar-other-cert-add&id=<?php echo isset($_GET['id']) && $_GET['id'] != "" && is_numeric($_GET['id']) ? mysqli_real_escape_string($connect, $_GET['id']) : ""; ?>';">Add</button>
                                        <button type="submit" class="btn btn-primary" onclick="document.location='index.php?page=form-pelamar';">Back</button>
                                        <?php } ?>
                                        <?php if($page_header == "form-pelamar-languague-perperson"){ ?>
                                        <button type="submit" class="btn btn-primary" onclick="document.location='index.php?page=form-pelamar-languague-perperson-add&id=<?php echo isset($_GET['id']) && $_GET['id'] != "" && is_numeric($_GET['id']) ? mysqli_real_escape_string($connect, $_GET['id']) : ""; ?>';">Add</button>
                                        <button type="submit" class="btn btn-primary" onclick="document.location='index.php?page=form-pelamar';">Back</button>
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