<?php
session_start();

if (!isset($_SESSION["login"])) {
    header("location: login.php");
    exit;
}
// var_dump($_SESSION["login"]["foto_profile"]);
// die();

require 'config.php';

$users = queryData("SELECT * FROM users WHERE id =" . $_SESSION['login']['id']);
// foreach ($users as $user) {
//     return $fotoProfile = $user['foto_profile'];
// }
// var_dump($user['foto_profile']);
// die();

// cek tombol ditekan
// if (isset($_POST["ubah"])) {
//     if (ubahProfile($_POST) > 0) {
//         echo "
//         <script>
//             alert('Foto berhasil diganti');
//             document.location.href = 'index.php';
//         </script>";
//     } else {
//         echo "
//         <script>
//             alert('Foto gagal diganti');

//         </script>";
//     }
// }

$karyawans = queryData('SELECT * FROM karyawan');

if (isset($_POST['submit'])) {
    $karyawans = cari($_POST['keyword']);
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Karyawan Zachary Arno</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/9fcca3cd45.js" crossorigin="anonymous"></script>

    <style>
        table {
            overflow: auto;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-md navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <img src="logo/logo.jpg" alt="" width="40" height="40" class="rounded-circle">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="dashboard.php">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Karyawan</a>
                    </li>
                    <li class="nav-item me-5">
                        <?php if ($_SESSION["login"]["role"] == 'admin') : ?>
                            <a class="nav-link" href="users.php">Users</a>
                        <?php endif ?>
                    </li>
                    <li class="nav-item dropdown">
                        <?php foreach ($users as $user) : ?>
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="fotoProfile/<?= $user['foto_profile']; ?>" width="30" height="30" class="rounded-circle">
                            </a>
                        <?php endforeach ?>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#profile"><i class=" fa-solid fa-user"></i> Profile</a></li>
                            <!-- <li><a class="dropdown-item" href="" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ubahFoto"><i class="fa-solid fa-user-pen"></i> Ubah Foto Profile</a></li>
                            <li> -->
                            <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item" href="logout.php"><i class="fa-solid fa-person-running"></i> Logout</a></li>
                </ul>
                </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4 text-center">
        <h2 class="mb-5">Data Karyawan Perusahaan Zachary Arno</h2>
        <form action="" method="post" class="float-end mb-3 d-flex">
            <input class="form-control me-2" type="text" placeholder="Search" aria-label="Search" name="keyword" autocomplete="off" autofocus>
            <button type="submit" class="btn btn-dark" name="submit" class="form-control">Cari</button>
        </form>
        <?php if ($_SESSION["login"]["role"] == 'admin') : ?>
            <a href="tambah.php" class="btn btn-primary float-start my-4"><i class="fa-solid fa-plus"></i> Tambah Karyawan</a>
        <?php endif ?>

        <table class="table table-striped text-center">
            <tr>
                <th>No</th>
                <th>Foto</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th>Divisi</th>
                <th>Gaji</th>
                <th>Aksi</th>


            </tr>
            <?php $no = 1; ?>
            <?php foreach ($karyawans as $karyawan) : ?>
                <tr>
                    <td><?= $no; ?></td>
                    <td>
                        <img src="image/<?= $karyawan['foto'] ?>" class="rounded-circle" width="40" height="40">
                    </td>
                    <td><?= $karyawan['nama'] ?></td>
                    <td><?= $karyawan['alamat'] ?></td>
                    <td><?= $karyawan['divisi'] ?></td>
                    <td>Rp. <?= $karyawan['gaji'] ?></td>
                    <td>
                        <?php if ($_SESSION["login"]["role"] == 'admin') : ?>
                            <a href="edit.php?id=<?= $karyawan['id']; ?>" class="btn btn-success btn-sm"><i class="fa-solid fa-pen-to-square"></i></a>
                            <a href="hapus.php?id=<?= $karyawan['id']; ?>" onclick="return confirm('Yakin Hapus Karyawan?');" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i></a>
                        <?php endif ?>
                        <a href="detail.php?id=<?= $karyawan['id']; ?>" class="btn btn-primary btn-sm"><i class="fa-solid fa-book"></i></a>
                    </td>
                </tr>
                <?php $no++ ?>
            <?php endforeach ?>
        </table>
    </div>
    <div class="modal fade" id="profile" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Profile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center p-4">
                    <?php foreach ($users as $user) : ?>
                        <img src="fotoProfile/<?= $user['foto_profile']; ?>" class="mb-3 rounded-circle">
                    <?php endforeach ?>
                    <h3 class="mx-auto mt-3"><?= $_SESSION["login"]["username"]; ?></h3>
                    <h5><?= $_SESSION["login"]["role"]; ?></h5>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="ubahFoto" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ubah Foto Profile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form action="" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?= $_SESSION["login"]["id"] ?>">
                        <div class="mb-3">
                            <?php foreach ($users as $user) : ?>
                                <img src="fotoProfile/<?= $user['foto_profile']; ?>" width="130" class="mb-3">
                            <?php endforeach ?>
                            <input class="form-control" type="file" name="fotoProfile" id="foto" autocomplete="off" required>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-dark" name="ubah">Ganti</button>
                    </form>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</body>

</html>