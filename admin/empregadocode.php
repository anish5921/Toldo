<?php
include('../connection.php');
session_start();

if(isset($_POST['delete_clientes']))
{
    $id = $_POST['delete_id'];
    $query = "DELETE FROM users WHERE id=:id";
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id', $id);
    $statement->execute();

    header('Location: empregado.php');                       
}  

if(isset($_POST['update_clientes']))
{
    $id = $_POST['edit_id'];
    $username = $_POST['edit_username'];
    $password = $_POST['edit_password'];
    $query = "UPDATE users SET username=:username, password=:password WHERE id=:id";
    $statement = $pdo->prepare($query);
    $statement->bindParam(':username', $username);
    $statement->bindParam(':password', $password);
    $statement->bindParam(':id', $id);
    $statement->execute();

    header('Location: empregado.php');     
}

if(isset($_POST['admin_btn']))
{
    $id = $_POST['edit_admin'];
    $statement = $pdo->prepare("SELECT admin FROM users WHERE id = :id");
    $statement->bindParam(':id', $id);
    $statement->execute();
    $row = $statement->fetch(PDO::FETCH_ASSOC);
    $admin = $row['admin'];
    $new_admin = $admin == 1 ? 0 : 1;
    $statement = $pdo->prepare("UPDATE users SET admin = :admin WHERE id = :id");
    $statement->bindParam(':admin', $new_admin);
    $statement->bindParam(':id', $id);
    $statement->execute();

    header("Location: empregado.php");
    exit();
}
?>