<?php 
session_start();
if (isset($_SESSION["adm_id"]) && !empty($_SESSION["adm_id"])) {
    unset($_SESSION["adm_id"]);
}
?>