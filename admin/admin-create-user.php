<?php
session_start();
include('includes/config.php');

if (isset($_POST['createUser'])) {
    $fullName = $_POST['fullName'];
    $email = $_POST['email'];
    $password = md5($_POST['password']);

    $sql = "INSERT INTO tblblooddonars (FullName, EmailId, Password) VALUES (:fullName, :email, :password)";
    $query = $dbh->prepare($sql);
    $query->bindParam(':fullName', $fullName, PDO::PARAM_STR);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->bindParam(':password', $password, PDO::PARAM_STR);

    if ($query->execute()) {
        $msg = "User created successfully.";
    } else {
        $msg = "Error creating user.";
    }
}
?>

<!DOCTYPE html>
<html lang="zxx">

<head>
    <title>Blood Bank Donor Management System | Admin Create User</title>
    <!-- Meta tag Keywords -->
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/style.css" type="text/css" media="all" />
    <link rel="stylesheet" href="css/fontawesome-all.css">
</head>

<body>
    <?php include('includes/header.php');?>

    <!-- Rest of the HTML code goes here -->

    <section class="about py-5">
        <div class="container py-xl-5 py-lg-3">
            <div class="login px-4 mx-auto mw-100">
                <h5 class="text-center mb-4">Create User</h5>
                <form action="#" method="post" name="createUser">
                    <div class="form-group">
                        <label>Full Name</label>
                        <input type="text" class="form-control" name="fullName" placeholder="" required="">
                    </div>
                    <div class="form-group">
                        <label>Email ID</label>
                        <input type="email" class="form-control" name="email" placeholder="" required="">
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" class="form-control" name="password" placeholder="" required="">
                    </div>
                    <button type="submit" class="btn submit mb-4" name="createUser">Create User</button>
                </form>
            </div>
        </div>
    </section>

    <?php include('includes/footer.php');?>

    <script src="js/jquery-2.2.3.min.js"></script>
    <script src="js/bootstrap.js"></script>
</body>

</html>
