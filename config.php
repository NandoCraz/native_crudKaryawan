<?php

// koneksi ke database
$host = 'localhost';
$username = 'root';
$password = '';
$db = 'pt_zacharno';
$conn = mysqli_connect($host, $username, $password, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function query all data
function queryData($query)
{
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}


// Function tambah data
function create($data)
{
    var_dump($data['nama']);
    global $conn;
    $nama = htmlspecialchars($data['nama']);
    $alamat = htmlspecialchars($data['alamat']);
    $divisi = htmlspecialchars($data['divisi']);
    $gaji = htmlspecialchars(strval($data['gaji']));

    $foto = uploadFoto();
    if (!$foto) {
        return false;
    }

    $sql = "INSERT INTO karyawan VALUES('','$nama', '$alamat', '$divisi', '$gaji', '$foto')";

    mysqli_query($conn, $sql);

    return mysqli_affected_rows($conn);
}

// Function upload foto
function uploadFoto()
{
    $namaFoto = $_FILES['foto']['name'];
    $ukuranFoto = $_FILES['foto']['size'];
    $penyimpanan = $_FILES['foto']['tmp_name'];
    $error = $_FILES['foto']['error'];

    // Cek foto sudah dipilih
    if ($error === 4) {
        echo "
        <script>
            alert('Pilih foto terlebih dahulu!');
        </script>";
        return false;
    }

    // cek kesesuaian ekstensi foto
    $ekstensiFotoValid = ['jpg', 'jpeg', 'png'];
    $pecahNamaFoto = explode('.', $namaFoto);
    $ekstensiFoto = strtolower(end($pecahNamaFoto));
    if (!in_array($ekstensiFoto, $ekstensiFotoValid)) {
        echo "
        <script>
            alert('File/foto yang anda kirim tidak valid!');
        </script>";
        return false;
    }

    // cek ukuran foto
    if ($ukuranFoto > 1000000) {
        echo "
        <script>
            alert('Foto yang anda kirim melebihi batas ukuran!');
        </script>";
        return false;
    }

    // rubah ke nama baru
    $namaFotoBaru = uniqid();
    $namaFotoBaru .= '.';
    $namaFotoBaru .= $ekstensiFoto;

    move_uploaded_file($penyimpanan, 'image/' . $namaFotoBaru);

    return $namaFotoBaru;
}

// Function hapus
function hapus($id)
{
    global $conn;
    $sql = "DELETE FROM karyawan WHERE id = '$id'";
    $sqlAll = "SELECT * FROM karyawan WHERE id = '$id'";
    $delFoto = mysqli_query($conn, $sqlAll);
    $execute = mysqli_fetch_assoc($delFoto);
    unlink("image/" . $execute['foto']);
    mysqli_query($conn, $sql);
    return mysqli_affected_rows($conn);
}


// Function update
function update($data)
{
    global $conn;
    $id = $data['id'];
    $nama = htmlspecialchars($data['nama']);
    $alamat = htmlspecialchars($data['alamat']);
    $divisi = htmlspecialchars($data['divisi']);
    $gaji = htmlspecialchars(strval($data['gaji']));
    $fotoLama = htmlspecialchars($data['fotoLama']);

    // cek user pilih gambar baru
    if ($_FILES['foto']['error'] === 4) {
        $foto = $fotoLama;
    } else {
        $sqlAll = "SELECT * FROM karyawan WHERE id = '$id'";
        $delFoto = mysqli_query($conn, $sqlAll);
        $execute = mysqli_fetch_assoc($delFoto);
        unlink("image/" . $execute['foto']);
        $foto = uploadFoto();
    }

    $sql = "UPDATE karyawan SET nama = '$nama', alamat = '$alamat', divisi = '$divisi', gaji = '$gaji', foto = '$foto' WHERE id = $id";

    mysqli_query($conn, $sql);

    return mysqli_affected_rows($conn);
}


// Function cari
function cari($cari)
{
    $sql = "SELECT * FROM karyawan WHERE nama LIKE '%$cari%' OR alamat LIKE '%$cari%' OR divisi LIKE '%$cari%'";
    return queryData($sql);
}


// function register
function register($data)
{
    global $conn;
    $username = strtolower(stripslashes($data["username"]));
    $password = mysqli_real_escape_string($conn, $data['password']);
    $confPass = mysqli_real_escape_string($conn, $data['confPass']);
    $role = $data['role'];
    $fotoDefault = $data['fotoDefault'];

    // cek username sudah ada atau belum
    $result = mysqli_query($conn, "SELECT username FROM users WHERE username = '$username'");
    if (mysqli_fetch_assoc($result)) {
        echo "<script>alert('Username sudah digunakan!')</script>";
        return false;
    }

    // cek kesamaan password dan konfirmasi password
    if ($password !== $confPass) {
        echo "<script>alert('Password yang anda masukkan tidak sesuai!')</script>";
        return false;
    }

    $password = password_hash($password, PASSWORD_DEFAULT);

    // cek validasi foto
    if ($_FILES['fotoProfile']['error'] === 4) {
        $fotoProfile = $fotoDefault;
    } else {
        $fotoProfile = uploadFotoProfile();
    }

    $sql = "INSERT INTO users VALUES('', '$username', '$password', '$role', '$fotoProfile')";
    mysqli_query($conn, $sql);
    return mysqli_affected_rows($conn);
}

// Function upload foto
function uploadFotoProfile()
{
    $namaFoto = $_FILES['fotoProfile']['name'];
    $ukuranFoto = $_FILES['fotoProfile']['size'];
    $penyimpanan = $_FILES['fotoProfile']['tmp_name'];
    $error = $_FILES['fotoProfile']['error'];

    // Cek foto sudah dipilih
    if ($error === 4) {
        echo "
        <script>
            alert('Pilih foto terlebih dahulu!');
        </script>";
        return false;
    }

    // cek kesesuaian ekstensi foto
    $ekstensiFotoValid = ['jpg', 'jpeg', 'png'];
    $pecahNamaFoto = explode('.', $namaFoto);
    $ekstensiFoto = strtolower(end($pecahNamaFoto));
    if (!in_array($ekstensiFoto, $ekstensiFotoValid)) {
        echo "
        <script>
            alert('File/foto yang anda kirim tidak valid!');
        </script>";
        return false;
    }

    // cek ukuran foto
    if ($ukuranFoto > 1000000) {
        echo "
        <script>
            alert('Foto yang anda kirim melebihi batas ukuran!');
        </script>";
        return false;
    }

    // rubah ke nama baru
    $namaFotoBaru = uniqid();
    $namaFotoBaru .= '.';
    $namaFotoBaru .= $ekstensiFoto;

    move_uploaded_file($penyimpanan, 'fotoProfile/' . $namaFotoBaru);

    return $namaFotoBaru;
}

// Function ubah foto profile
function ubahProfile($data)
{
    global $conn;
    $id = $data["id"];
    $sqlAll = "SELECT * FROM users WHERE id = $id";
    $delFoto = mysqli_query($conn, $sqlAll);
    $execute = mysqli_fetch_assoc($delFoto);
    // var_dump($execute['foto_profile']);
    // die();
    unlink("fotoProfile/" . $execute['foto_profile']);
    $fotoBaru = uploadFotoProfile();
    if (!$fotoBaru) {
        return false;
    }

    $sql = "UPDATE users SET foto_profile = '$fotoBaru' WHERE id = $id";
    mysqli_query($conn, $sql);
    return mysqli_affected_rows($conn);
}

function hapusUser($id)
{
    global $conn;
    $sql = "DELETE FROM users WHERE id = $id";
    $sqlAll = "SELECT * FROM users WHERE id = $id";
    $delFoto = mysqli_query($conn, $sqlAll);
    $execute = mysqli_fetch_assoc($delFoto);
    unlink("fotoProfile/" . $execute['foto_profile']);
    mysqli_query($conn, $sql);
    return mysqli_affected_rows($conn);
}

function cariUser($cariUser) {
    $sql = "SELECT * FROM users WHERE username LIKE '%$cariUser%' && role = 'user'";
    return queryData($sql);
}
