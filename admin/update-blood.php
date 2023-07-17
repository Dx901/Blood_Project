<?php
session_start();
include('includes/config.php');

if (isset($_POST['submit'])) {
    $id = $_POST['id'];
    $bloodGroup = $_POST['bloodGroup'];
    
    // Update the blood information in the database
    $sql = "UPDATE tblbloodgroup SET BloodGroup = :bloodGroup WHERE id = :id";
    $query = $dbh->prepare($sql);
    $query->bindParam(':bloodGroup', $bloodGroup, PDO::PARAM_STR);
    $query->bindParam(':id', $id, PDO::PARAM_INT);
    $query->execute();
    
    if ($query) {
        // Update successful, redirect to the inventory page with success message
        $_SESSION['success'] = "Blood information updated successfully";
        header('location: manage-blood-groups.php');
        exit();
    } else {
        // Update failed, display error message
        $_SESSION['error'] = "Error updating blood information";
        header('location: manage-blood-groups.php');
        exit();
    }
} else {
    // Redirect if the form is not submitted
    header('location: manage-blood-groups.php');
    exit();
}
?>
