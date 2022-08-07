<?php
session_start();
require 'config.php';

// cek cookie
if (isset($_COOKIE["rhisd"]) && isset($_COOKIE["key"])) {
    $rhisd = $_COOKIE["rhisd"];
    $key = $_COOKIE["key"];

    $query = mysqli_query($conn, "SELECT * FROM users WHERE id = $rhisd");
    $row = mysqli_fetch_assoc($query);

    // cek cookie dan username
    if ($key === hash('sha256', $row["username"])) {
        $_SESSION["login"] = $row;
    }
}

if (isset($_SESSION["login"])) {
    header("location: dashboard.php");
    exit;
}

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // cek username
    $sql = "SELECT * FROM users WHERE username = '$username'";
    $query = mysqli_query($conn, $sql);
    if (mysqli_num_rows($query) === 1) {
        // cek password
        $row = mysqli_fetch_assoc($query);
        if (password_verify($password, $row['pass_user'])) {

            // cek remember me
            if (isset($_POST['remember'])) {
                // set cookie
                setcookie('rhisd', $row["password"], time() + 3600);
                setcookie('key', hash('sha256', $row["username"]), time() + 3600);
            }


            // Set session
            $_SESSION["login"] = $row;
            header("Location: dashboard.php");
            exit;
        }
    }

    $error = true;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login User</title>
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
    <section class="vh-100 gradient-custom">
        <div class="container h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card bg-dark text-white" style="border-radius: 1rem;">
                        <div class="card-body p-5 text-center">

                            <div class="mb-md-5 mt-md-4 pb-3">

                                <h2 class="fw-bold mb-2 text-uppercase">Login</h2>
                                <p class="text-white-50 mb-4">Masukkan Username dan Passwordmu!</p>
                                <?php if (isset($error)) : ?>
                                    <p class="text-danger-50 mb-3">Username / Password Salah!</p>
                                <?php endif ?>

                                <form action="" method="post">
                                    <div class="form-outline form-white mb-4">
                                        <input type="text" id="typeEmailX" class="form-control form-control-lg" name="username" / autocomplete="off">
                                        <label class="form-label" for="typeEmailX">Username</label>
                                    </div>

                                    <div class="form-outline form-white mb-4">
                                        <input type="password" id="typePasswordX" class="form-control form-control-lg" name="password" />
                                        <label class="form-label" for="typePasswordX">Password</label>
                                    </div>

                                    <div class="pb-5">
                                        <input class="form-check-input" type="checkbox" value="" id="form1Example3" name="remember" />
                                        <label class="form-check-label" for="form1Example3">Ingat Saya</label>
                                    </div>

                                    <button class="btn btn-outline-light btn-lg px-5" type="submit" name="login">Login</button>
                                </form>

                            </div>

                            <div>
                                <p class="mb-0">Belum mempunyai Akun? <a href="register.php" class="text-white-50 fw-bold">Register!</a>
                                </p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- <h2>Halaman Login</h2>
    
    <form action="" method="post">
        <div class="label-grup">
            <label for="username">Username :</label><br>
            <input type="text" name="username" id="username">
        </div>
        <div class="label-grup">
            <label for="password">Password :</label><br>
            <input type="password" name="password" id="password">
        </div>
        <div class="label-grup">
            <input type="checkbox" name="remember" id="ingat">
            <label for="ingat">Remember Me</label><br>
        </div>
        <button type="submit" name="login">Login</button>
    </form> -->



    <!-- MDB -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/4.4.0/mdb.min.js"></script>
</body>

</html>