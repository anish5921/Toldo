<?php
header("Content-Type: text/html; charset=UTF-8");
session_start();
if (!$_SESSION['id']) {
    header("Location: index.php");
    exit;
}
?>