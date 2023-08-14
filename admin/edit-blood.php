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

        $sql = "UPDATE tblbloodgroup SET Quantity = :newQuantity WHERE id = :id";
        $query = $dbh->prepare($sql);
        $query->bindParam(':newQuantity', $newQuantity, PDO::PARAM_INT);
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->execute();

        $msg = "Quantity updated successfully";
    }

    $id = intval($_GET['id']);

    $sql = "SELECT * FROM tblbloodgroup WHERE id = :id";
    $query = $dbh->prepare($sql);
    $query->bindParam(':id', $id, PDO::PARAM_INT);
    $query->execute();
    $result = $query->fetch(PDO::FETCH_ASSOC);
?>

<!doctype html>
<html lang="en" class="no-js">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="theme-color" content="#3e454c">

    <title>BBDMS | Edit Blood Group Quantity</title>

    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">

    <style>
        .errorWrap {
            padding: 10px;
            margin: 0 0 20px 0;
            background: #fff;
            border-left: 4px solid #dd3d36;
            -webkit-box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
            box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
        }

        .succWrap {
            padding: 10px;
            margin: 0 0 20px 0;
            background: #fff;
            border-left: 4px solid #5cb85c;
            -webkit-box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
            box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
        }
    </style>
</head>

<body>
    <?php include('includes/header.php');?>

    <div class="ts-main-content">
        <?php include('includes/leftbar.php');?>
        <div class="content-wrapper">
            <div class="container-fluid">
                <div class="col-md-12">
                    <h2 class="page-title">Edit Blood Group Quantity</h2>
                    <div class="panel panel-default">
                        <div class="panel-heading">Blood Group Details</div>
                        <div class="panel-body">
                            <?php if ($msg) { ?>
                                <div class="succWrap"><strong>SUCCESS</strong>: <?php echo htmlentities($msg); ?> </div>
                            <?php } ?>
                            <form method="post" class="form-horizontal">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Blood Group</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" value="<?php echo htmlentities($result['BloodGroup']); ?>" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Current Quantity (in mL)</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" value="<?php echo htmlentities($result['Quantity']); ?>" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">New Quantity (in mL)</label>
                                    <div class="col-sm-4">
                                        <input type="number" class="form-control" name="newQuantity" value="5" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-8 col-sm-offset-2">
                                        <button class="btn btn-primary" type="submit" name="update">Update Quantity</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>

</html>
<?php } ?>
