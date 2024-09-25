<?php
session_start();
if (!isset($_SESSION['manager_id'])) {
    header("Location: login.php");
    exit;
}
?>
