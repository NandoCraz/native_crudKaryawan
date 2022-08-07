<?php

session_start();
$_SESSION = [];
session_unset();
session_destroy();

setcookie('rhisd', '', time() - 3700);
setcookie('key', '', time() - 3700);

header("Location: login.php");
exit;
