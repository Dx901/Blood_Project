<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {
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

    <title>BBDMS | Donor List</title>

    <!-- Font awesome -->
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <!-- Sandstone Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- Bootstrap Datatables -->
    <link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
    <!-- Bootstrap social button library -->
    <link rel="stylesheet" href="css/bootstrap-social.css">
    <!-- Bootstrap select -->
    <link rel="stylesheet" href="css/bootstrap-select.css">
    <!-- Bootstrap file input -->
    <link rel="stylesheet" href="css/fileinput.min.css">
    <!-- Awesome Bootstrap checkbox -->
    <link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
    <!-- Admin Stye -->
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
                    <h3> Blood Requests Received</h3>
                    <hr />
                    <!-- Zero Configuration Table -->
                    <div class="panel panel-default">
                        <div class="panel-heading">Blood Info</div>
                        <div class="panel-body">
                            <table border="1" class="table table-responsive">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Name of Donor</th>
                                        <th>Contact Number of Donor</th>
                                        <th>Name of Patient</th>
                                        <th>Mobile Number of Patient</th>
                                        <th>Blood Require For</th>
                                        <th>Apply Date</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sdata = '%';
                                    try {
                                        // Database query execution
                                        // $sql = "SELECT tblbloodrequirer.BloodDonarID, tblbloodrequirer.name, tblbloodrequirer.ContactNumber, tblbloodrequirer.BloodRequirefor, tblbloodrequirer.Status, tblbloodrequirer.ApplyDate, tblblooddonars.id AS donid, tblblooddonars.FullName, tblblooddonars.MobileNumber FROM tblbloodrequirer JOIN tblblooddonars ON tblblooddonars.id = tblbloodrequirer.BloodDonarID WHERE tblblooddonars.FullName LIKE :sdata OR tblblooddonars.MobileNumber LIKE :sdata";
                                        // $sql = "SELECT tblbloodrequirer.BloodDonarID, tblbloodrequirer.name, tblbloodrequirer.ContactNumber, tblbloodrequirer.BloodRequireFor, tblbloodrequirer.Status, tblbloodrequirer.ApplyDate, tblblooddonars.id AS donid, tblblooddonars.FullName, tblblooddonars.MobileNumber FROM tblbloodrequirer JOIN tblblooddonars ON tblblooddonars.id = tblbloodrequirer.BloodDonarID WHERE tblblooddonars.FullName LIKE :sdata OR tblblooddonars.MobileNumber LIKE :sdata";
                                        $sql = "SELECT tblbloodrequirer.BloodDonarID, tblbloodrequirer.name, tblbloodrequirer.ContactNumber, tblbloodrequirer.BloodRequireFor, tblbloodrequirer.Status, tblbloodrequirer.ApplyDate, tblblooddonars.id AS donid, tblblooddonars.FullName, tblblooddonars.MobileNumber FROM tblbloodrequirer JOIN tblblooddonars ON tblblooddonars.id = tblbloodrequirer.BloodDonarID WHERE tblblooddonars.FullName LIKE :sdata OR tblblooddonars.MobileNumber LIKE :sdata";

                                        $query = $dbh->prepare($sql);
                                        $query->bindParam(':sdata', $sdata, PDO::PARAM_STR);
                                        $query->execute();
                                        $results = $query->fetchAll(PDO::FETCH_OBJ);
                                        
                                    } catch (PDOException $e) {
                                        
                                        echo "Error: " . $e->getMessage();
                                        echo "Blood Require For: " . $row->BloodRequireFor . "<br>";
                                    }
                                    if($query->rowCount() > 0) {
                                        $cnt = 1;
                                        foreach($results as $row) {
                                    ?>
                                    <tr>
                                        <td><?php echo htmlentities($cnt); ?></td>
                                        <td><?php echo htmlentities($row->FullName); ?></td>
                                        <td><?php echo htmlentities($row->MobileNumber); ?></td>
                                        <td><?php echo htmlentities($row->name); ?></td>
                                        <td><?php echo htmlentities($row->ContactNumber); ?></td>
                                        <td><?php echo htmlentities($row->BloodRequireFor); ?></td>
                                        <td><?php echo htmlentities($row->ApplyDate); ?></td>
                                        <td>
                                        <?php
                                            if ($row->Status == 0) {
                                                echo '<button id="approveBtn'.$row->donid.'" class="btn btn-danger btn-sm" onclick="toggleApproval(this)">Pending</button>';
                                            } else {
                                                echo '<button id="approveBtn'.$row->donid.'" class="btn btn-success btn-sm" onclick="toggleApproval(this)">Approved</button>';
                                            }
                                            // echo '<button class="btn btn-danger btn-sm ml-1" onclick="deleteRequest('.$row->donid.')">Delete</button>';
                                            // echo '<button class="btn btn-danger btn-sm ml-1" onclick="deleteRequest('.$row->donid.')">Delete</button>';

                                            ?>
                                        </td>

                            
                                    </tr>
                                    <?php
                                            $cnt++;
                                        }
                                    }
                                    ?>
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

    <!-- Custom Script -->
    <script>
        // function deleteRequest(SNo) {
        //     if (confirm("Are you sure you want to delete this request?")) {
        //         window.location.href = "delete-request.php?SNo=" + SNo;
        //     }
        // }

        function toggleApproval(button) {
            if (button.classList.contains("btn-danger")) {
                button.classList.remove("btn-danger");
                button.classList.add("btn-success");
                button.innerHTML = "Approved";
            } else if (button.classList.contains("btn-success")) {
                button.classList.remove("btn-success");
                button.classList.add("btn-danger");
                button.innerHTML = "Approve";
            }
        }

        function deleteRequest(donorID) {
    if (confirm("Are you sure you want to delete this request?")) {
        $.ajax({
            url: "delete-request.php",
            type: "POST", // Change the request method to POST
            data: { SNo: donorID },
            success: function(response) {
                if (response === "success") {
                    // If deletion is successful, remove the deleted row from the table
                    $("#row" + donorID).remove();
                } else {
                    console.log(response); // Log the error message for troubleshooting
                }
            },
            error: function(xhr, status, error) {
                console.log(error);
            }
        });
    }
}

    </script>
</body>

</html>
<?php } ?>
