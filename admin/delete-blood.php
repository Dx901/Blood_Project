<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0) {
    header('location:index.php');
} else {
    $id=intval($_GET['id']);

    $sql = "DELETE FROM tblbloodgroup WHERE id=:id";
    $query = $dbh->prepare($sql);
    $query->bindParam(':id',$id,PDO::PARAM_STR);
    $query->execute();

    $msg="Blood details deleted successfully";
}

header('location:inventory.php');
?>
