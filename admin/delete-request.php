<?php
session_start();
include('includes/config.php');

if(isset($_GET['SNo']) && !empty($_GET['SNo'])) {
    $sno = $_GET['SNo'];

    try {
        // Delete the row from the database
        // $sql = "DELETE FROM tblbloodrequirer WHERE `S.No` = :sno";
        $sql = "DELETE FROM tblbloodrequirer WHERE ID = :sno";

        $query = $dbh->prepare($sql);
        $query->bindParam(':sno', $sno, PDO::PARAM_INT);
        $query->execute();

        // Check if the row was deleted successfully
        if($query->rowCount() > 0) {
            // Redirect back to the dashboard
            header('Location: requests-received.php');
            exit;
        } else {
            // Record not found
            header('Location: requests-received.php?error=notfound');
            exit;
        }
    } catch (PDOException $e) {
        // Handle database error
        echo "Error deleting record: " . $e->getMessage();
        exit;
    }
} else {
    // If the S.No parameter is missing or empty, redirect back to the dashboard
    header('Location: requests-received.php');
    exit;
}
?>
