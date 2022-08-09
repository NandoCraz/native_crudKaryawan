<?php
require 'config.php';

// cek tombol submit ditekan
if (isset($_POST['submit'])) {
    // cek berhasil masuk ke database
    if (register($_POST) > 0) {
        echo "
        <script>
            alert('User berhasil dibuat, silahkan login!');
            document.location.href = 'login.php';
        </script>";
        // header("Location: login.php");
        // exit;
    } else {
        echo mysqli_error($conn);
    }
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/9fcca3cd45.js" crossorigin="anonymous"></script>
    <!-- mdb -->
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
    <!-- MDB -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/4.4.0/mdb.min.css" rel="stylesheet" />
    <style>
        .gradient-custom {
            /* fallback for old browsers */
            background: #6a11cb;

            /* Chrome 10-25, Safari 5.1-6 */
            background: -webkit-linear-gradient(to right, rgba(106, 17, 203, 1), rgba(37, 117, 252, 1));

            /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
            background: linear-gradient(to right, rgba(106, 17, 203, 1), rgba(37, 117, 252, 1))
        }
    </style>
</head>

<body>
    <section class="min-vh-100 py-5 gradient-custom">
        <div class="container h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card bg-dark text-white" style="border-radius: 1rem;">
                        <div class="card-body p-5 text-center">

                            <div class="mb-md-5 mt-md-4 pb-3">

                                <h2 class="fw-bold mb-2 text-uppercase">Register</h2>
                                <p class="text-white-50 mb-5">Daftarkan Akunmu sekarang juga!</p>

                                <form action="" method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="role" value="user">
                                    <input type="hidden" name="fotoDefault" value="defaultFoto.jpeg">
                                    <div class="form-outline form-white mb-4">
                                        <input type="text" id="username" class="form-control form-control-lg" name="username" required autocomplete="off" />
                                        <label class="form-label" for="username">Username</label>
                                    </div>

                                    <div class="form-outline form-white mb-4">
                                        <input type="password" id="password" class="form-control form-control-lg" name="password" required />
                                        <label class="form-label" for="password">Password</label>
                                    </div>

                                    <div class="form-outline form-white mb-4">
                                        <input type="password" id="confpass" class="form-control form-control-lg" name="confPass" required />
                                        <label class="form-label" for="confpass">Konfirmasi Password</label>
                                    </div>

                                    <div class="form-outline form-white mb-5">
                                        <input type="file" class="form-control mb-1" id="customFile" name="fotoProfile" required />
                                        <label class="form-label mt-5" for="customFile">Pilih Foto Profile</label>
                                    </div>


                                    <button class="btn btn-outline-light btn-lg mt-4 px-5" type="submit" name="submit">Register</button>
                                </form>

                            </div>

                            <div>
                                <p class="mb-0">Sudah punya Akun? <a href="login.php" class="text-white-50 fw-bold">Login!</a>
                                </p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- <form action="" method="post" enctype="multipart/form-data">
        <input type="hidden" name="role" value="user">
        <input type="hidden" name="fotoDefault" value="defaultFoto.jpeg">
        <div class="label-grup">
            <label for="username">Username :</label><br>
            <input type="text" id="username" name="username">
        </div>
        <div class="label-grup">
            <label for="password">Password :</label><br>
            <input type="password" id="password" name="password">
        </div>
        <div class="label-grup">
            <label for="confPass">Konfirmasi Password :</label><br>
            <input type="password" id="confPass" name="confPass">
        </div>
        <div class="label-grup">
            <label for="foto">Pilih Foto Profile :</label>
            <input type="file" id="foto" name="fotoProfile" required>
        </div>
        <button type="submit" name="submit">Register</button>
    </form> -->

    <!-- MDB -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/4.4.0/mdb.min.js"></script>
</body>

</html>