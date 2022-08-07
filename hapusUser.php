<?php
session_start();

if(!isset($_SESSION["login"])) {
    header("location: login.php");
    exit;
}
require('config.php');

$id = $_GET['id'];
if( hapusUser($id) > 0 ) {
    echo "
    <script>
            alert('User berhasil dihapus');
            document.location.href = 'users.php';
    </script>;";
} else {
    echo "
    <script>
            alert('User gagal dihapus');
            document.location.href = 'users.php';
    </script>;";
}
