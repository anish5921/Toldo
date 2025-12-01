<?php
include("../connection.php");

if (!isset($_SESSION['id']) || !isset($_SESSION['username'])) {
    header("Location: ../../toldo.php");
    exit;
} else {
    $id = $_SESSION['id'];
    $sql = "SELECT admin FROM users WHERE id = '$id'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $row = mysqli_fetch_assoc($result);

        if ($row['admin'] != '1') {
            header("Location: ../toldo.php");
            exit;
        }
    } else {
        echo "Error: " . mysqli_error($conn);
        exit;
    }
}
?>