<?php
session_start();
error_reporting(0);
include('includes/config.php');

if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {
    if (isset($_POST['newQuantity']) && isset($_POST['bloodGroupId'])) {
        $newQuantity = intval($_POST['newQuantity']);
        $bloodGroupId = intval($_POST['bloodGroupId']);

        $sql = "UPDATE tblbloodcount SET Count = :newQuantity WHERE id = :bloodGroupId";
        $query = $dbh->prepare($sql);
        $query->bindParam(':newQuantity', $newQuantity, PDO::PARAM_INT);
        $query->bindParam(':bloodGroupId', $bloodGroupId, PDO::PARAM_INT);
        $query->execute();
    }
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

    <title>BBDMS | Blood Inventory</title>

    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-social.css">
    <link rel="stylesheet" href="css/bootstrap-select.css">
    <link rel="stylesheet" href="css/style.css">

    <style>
        .errorWrap {
            padding: 10px;
            margin: 0 0 20px 0;
            background: #fff;
            border-left: 4px solid #dd3d36;
            -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
            box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
        }
        .succWrap{
            padding: 10px;
            margin: 0 0 20px 0;
            background: #fff;
            border-left: 4px solid #5cb85c;
            -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
            box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
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
                    <h2 class="page-title">Blood Inventory</h2>
                    <div class="panel panel-default">
                        <div class="panel-heading">Blood Details</div>
                        <div class="panel-body">
                            <?php if($error){?><div class="errorWrap"><strong>ERROR</strong>: <?php echo htmlentities($error); ?> </div><?php } 
                            else if($msg){?><div class="succWrap"><strong>SUCCESS</strong>: <?php echo htmlentities($msg); ?> </div><?php }?>
                            <table id="zctb" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Blood Group</th>
                                        <th>Quantity (in Pints)</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>Blood Group</th>
                                        <th>Quantity (in Pints)</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php
                                    $sql = "SELECT * FROM tblbloodgroup";
                                    $query = $dbh->prepare($sql);
                                    $query->execute();
                                    $results=$query->fetchAll(PDO::FETCH_OBJ);
                                    $cnt=1;
                                    if($query->rowCount() > 0) {
                                        foreach($results as $result) { ?>
                                            <tr>
                                                <td><?php echo htmlentities($cnt); ?></td>
                                                <td><?php echo htmlentities($result->BloodGroup); ?></td>
                                                <td>
                                                    <form class="update-form">
                                                        <input type="hidden" name="bloodGroupId" value="<?php echo $result->id; ?>">
                                                        <input type="number" class="quantity-input" name="newQuantity" value="<?php echo isset($_SESSION['quantity_' . $result->id]) ? $_SESSION['quantity_' . $result->id] : 0; ?>">
                                                        <button type="submit" class="update-btn">Update</button>
                                                        <button type="button" class="reset-btn">Reset</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        <?php $cnt=$cnt+1;
                                        }
                                    } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Loading Scripts -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap-select.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>
    <script src="js/dataTables.bootstrap.min.js"></script>
    <script src="js/Chart.min.js"></script>
    <script src="js/fileinput.js"></script>
    <script src="js/chartData.js"></script>
    <script src="js/main.js"></script>

    <!-- JavaScript code for handling form submission and updating the quantity -->
    <script>
        $(document).ready(function () {
            $(".update-form").submit(function (e) {
                e.preventDefault();
                var form = $(this);
                var bloodGroupId = form.find("input[name=bloodGroupId]").val();
                var newQuantity = form.find(".quantity-input").val();

                localStorage.setItem("quantity_" + bloodGroupId, newQuantity);

                $.ajax({
                    type: "POST",
                    url: "inventory.php",
                    data: form.serialize(),
                    success: function (response) {
                        // Optionally handle success actions
                    },
                    error: function () {
                        // Optionally handle error actions
                    },
                });

                form.find(".update-btn").html("Updated");
            });

            $(".reset-btn").click(function () {
                var form = $(this).closest(".update-form");
                var bloodGroupId = form.find("input[name=bloodGroupId]").val();

                form.find(".quantity-input").val(0);
                localStorage.setItem("quantity_" + bloodGroupId, 0);

                form.find(".update-btn").html("Update");
            });

            $(".quantity-input").on("input", function () {
                var form = $(this).closest(".update-form");
                var bloodGroupId = form.find("input[name=bloodGroupId]").val();
                var updatedQuantity = parseInt($(this).val());

                localStorage.setItem("quantity_" + bloodGroupId, updatedQuantity);
                form.find(".update-btn").html("Update");
            });

            $(".update-form").each(function () {
                var form = $(this);
                var bloodGroupId = form.find("input[name=bloodGroupId]").val();
                var savedQuantity = localStorage.getItem("quantity_" + bloodGroupId);
                if (savedQuantity !== null) {
                    form.find(".quantity-input").val(savedQuantity);
                    form.find(".update-btn").html("Updated");
                }
            });

            
        });
    </script>

</body>

</html>
<?php } ?>
