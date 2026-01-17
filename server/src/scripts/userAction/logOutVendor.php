<?php 
session_start();
session_destroy();

if(isset($_SESSION['vendor_user_id']) && !empty($_SESSION["vendor_user_id"])) {
    unset($_SESSION["vendor_user_id"]);
}
?>