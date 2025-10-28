<?php
session_start();
require_once 'config.php';

if(isset($_POST['id'])){
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $role = $_POST['role'];

    $stmt = $conn->prepare("UPDATE users SET name=?, email=?, role=? WHERE id=?");
    $stmt->bind_param("sssi",$name,$email,$role,$id);
    $stmt->execute();
    $stmt->close();

    header("Location: index.php");
    exit();
}
?>
