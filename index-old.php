<?php 
include_once "koneksi.php";
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>App Kuis</title>
        <style type="text/css">
            html, body {
                font-family: consolas, monospace;
                width: 100%;
                height: 100%;
                padding: 0px;
                margin: 0px;
                cursor: default;
            }
            pre {
                font-family: consolas, monospace;
            }
            input, textarea, select {
                font-family: consolas, monospace;
                -webkit-box-sizing: border-box;
                   -moz-box-sizing: border-box;
                    -ms-box-sizing: border-box;
                        box-sizing: border-box;
            }
        </style>
    </head>
    <body>
        <?php
        // put your code here
        $page = isset($_GET['page']) && $_GET['page'] != "" ? $_GET['page'] : "login";
        if(file_exists("page/module-" . $page . ".php")){
            include_once "page/module-" . $page . ".php";
        } else {
            echo "File tidak tersedia.";
        }
        ?>
    </body>
</html>
