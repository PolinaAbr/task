<?php

session_start();

include "header.html";
include "login/logModal.html";
include "register/regModal.html";
include "login/login.php";
include "register/register.php";
include "footer.html";

if (login()) {
    echo "<script>welcome('".$_SESSION['login']."')</script>";
}
if(isset($_GET['action']) && $_GET['action'] == "logout") {
	logout();
}

?>