<?php
session_start();
error_reporting(0);
include('includes/config.php');

if(isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = md5($_POST['password']);
    
    $sql = "SELECT id FROM tblblooddonars WHERE EmailId=:email AND Password=:password";
    $query = $dbh->prepare($sql);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->bindParam(':password', $password, PDO::PARAM_STR);
    $query->execute();
    
    $results = $query->fetchAll(PDO::FETCH_OBJ);
    
    if ($query->rowCount() > 0) {
        foreach ($results as $result) {
            $_SESSION['bbdmsdid'] = $result->id;
        }
        $_SESSION['login'] = $_POST['email'];
        echo "<script type='text/javascript'> document.location ='index.php'; </script>";
    } else {
        echo "<script>alert('Invalid Details');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="zxx">

<head>
    <title>Blood Bank Donor Management System | Login</title>
    <!-- Meta tag Keywords -->
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/style.css" type="text/css" media="all" />
    <link rel="stylesheet" href="css/fontawesome-all.css">
</head>

<body>
    <?php include('includes/header.php');?>

    <!-- Rest of the HTML code goes here -->

    <div class="login px-4 mx-auto mw-100">
        <h5 class="text-center mb-4">Login Now</h5>
        <form action="#" method="post" name="login">
            <div class="form-group">
                <label>Email ID</label>
                <input type="email" class="form-control" name="email" placeholder="" required="">
            </div>
            <div class="form-group">
                <label class="mb-2">Password</label>
                <input type="password" class="form-control" name="password" id="password" placeholder="" required="">
            </div>
            <button type="submit" class="btn submit mb-4" name="login">Login</button>
            <p class="account-w3ls text-center pb-4" style="color: #000;">
                Don't have an account?
                <a href="sign-up.php">Create one now</a>
            </p>
        </form>
    </div>

    <?php include('includes/footer.php');?>

    <script src="js/jquery-2.2.3.min.js"></script>
    <script src="js/bootstrap.js"></script>
</body>

</html>
