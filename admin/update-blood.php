<?php
session_start();
error_reporting(0);
include('includes/config.php');

if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {
    if (isset($_POST['update'])) {
        $id = intval($_GET['id']);
        $newQuantity = intval($_POST['newQuantity']);

        // Update the quantity in the database
        $sql = "UPDATE tblbloodgroup SET Quantity = :newQuantity WHERE id = :id";
        $query = $dbh->prepare($sql);
        $query->bindParam(':newQuantity', $newQuantity, PDO::PARAM_INT);
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->execute();

        $msg = "Quantity updated successfully";
    }

    header('Location: inventory.php');
    exit;
}
?>
