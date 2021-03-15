<?php
ob_start();
session_start();
$host = "localhost";
$user = "root";
$pass = "";
$db = "project_ocr";

$connect = mysqli_connect($host, $user, $pass, $db);

if(isset($_POST['login']) && $_POST['login'] == "login"){
    $username = mysqli_real_escape_string($connect, $_POST['username']);
    $password = mysqli_real_escape_string($connect, $_POST['password']);
    $query_pengguna = mysqli_query($connect, "select * from tbl_pengguna where username = '".$username."' and password = '".$password."'");
    if(mysqli_num_rows($query_pengguna) > 0){
        $hasil_pengguna = mysqli_fetch_array($query_pengguna);
        $_SESSION['username'] = $hasil_pengguna['username'];
        $_SESSION['password'] = "rahasia";
        header("location: index.php");
    } else {
        $salah = "salah";
    }
}

function set_active($param){
    $page = isset($_GET['page']) && $_GET['page'] != "" ? $_GET['page'] : "home";
    for($i = 0; $i < strlen($page); $i++){
        if(substr($page, $i, strlen($param)) == $param){
            return "nav-link active";
        }
    }
    return false;
}

function judul($param){
    $explode_dash = explode("-", $param);
    $hasil_huruf = "";
    $sepasi = "";
    for($i = 0; $i < sizeof($explode_dash); $i++){
        $hasil_huruf = $hasil_huruf . $sepasi . strtoupper(substr($explode_dash[$i], 0, 1)) . substr($explode_dash[$i], 1);
        $sepasi = " ";
    }
    $id = isset($_GET['id']) && $_GET['id'] != "" && is_numeric($_GET['id']) ? $_GET['id'] : "";
    return $id ? str_replace("Add", "Edit", $hasil_huruf) : $hasil_huruf; 
}

function set_menu(){
    global $connect;
    $query_menu = mysqli_query($connect, "select * from tbl_menu");
    if(mysqli_num_rows($query_menu) > 0){
        ?>
        <li class="nav-item has-treeview">
            <a href="index.php" class="nav-link <?php echo set_active("home"); ?>">
                <i class="nav-icon fas fa-home"></i>
                <p>
                    Home
                </p>
            </a>

        </li>
        <?php
        while($hasil_menu = mysqli_fetch_array($query_menu)){
            ?>
            <li class="nav-item has-treeview">
                <a href="<?php echo $hasil_menu['link_menu'] ?>" class="nav-link <?php echo set_active($hasil_menu['info_active']); ?>">
                    <i class="nav-icon fas <?php echo $hasil_menu['icon'] ?>"></i>
                    <p>
                        <?php echo $hasil_menu['nama_menu'] ?>
                    </p>
                </a>

            </li>
            <?php
        }
    }
}


include_once "action.php";