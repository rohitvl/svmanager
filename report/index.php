<?php

include '../Connection/connection.php';

// Start the session
session_start();


if(isset($_SESSION['username'])) {
} else {
    echo "<script type='text/javascript'> window.location.href = '../index.php'; </script>";
}

if(isset($_POST['sub_reportdr'])) {

    $time = $_POST['reportdr'];
    $time1 = substr($time, 6, 4) . '-' . substr($time, 3, 2) . '-' . substr($time, 0, 2) . ' 00:00:00';
    $time2 = substr($time, 19, 4) . '-' . substr($time, 16, 2) . '-' . substr($time, 13, 2) . ' 23:59:59';

} else {

    $time1 = date('Y-m-d') . " 00:00:00";
    $time2 = date('Y-m-d') . " 23:59:59";

}

$sqlOverview = "SELECT lead_svd, sv_status, lead_status, attend_status, sv_done from leads WHERE (lead_svd BETWEEN '$time1' AND '$time2')";
$result = $conn->query($sqlOverview);

$total = $totalArr = $pending = $svdone = $rsvdone = $unattended = $tagged = $av = $closing = $booked = 0;

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {

        $svstatus = $row['sv_status'];
        $leadstatus = $row['lead_status'];
        $attendstatus = $row['attend_status'];
        $leadsvdone = $row['sv_done'];

        $total++;

        if($leadstatus !== "Not Arrived") {
            if($leadstatus !== "") {

                $totalArr++;

                if($leadsvdone === "Yes") {
                    if($svstatus === "SV") {
                        $svdone++;
                    } else if ($svstatus === "RSV") {
                        $rsvdone++;
                    } else {

                    }
                }
                
                if ($attendstatus === "Unattended") {
                    $unattended++;
                }

                if($leadstatus === "Tagged" || $leadstatus === "Pre WR" ||  $leadstatus === "AV" ||  $leadstatus === "Post WR" ||   $leadstatus === "Closing" ||   $leadstatus === "Booked" || $leadstatus === "Planned RSV" ||   $leadstatus === "Feedback Awaited" || $leadstatus === "Did Not Like") {
                    $tagged++;
                }

                if($leadstatus === "AV" || $leadstatus === "Post WR") {
                    $av++;
                }

                if($leadstatus === "Closing") {
                    $closing++;
                }

                if($leadstatus === "Booked") {
                    $booked++;
                }

            }

        }


    }
} else {
}

?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Site Visit Leads Manager</title>
    <!--Bootstrap Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <!--fontawesome cdn -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">
    
    <!-- datetimepicker styles -->
    <link rel="stylesheet" href="../Styles/jquery.datetimepicker.min.css">
    <!-- daterangepicker styles -->
    <link rel="stylesheet" href="../Styles/daterangepicker.css">
    <!-- common styles -->
    <link rel="stylesheet" href="../Styles/primarystyles.css">
    <!-- overview styles -->
    <link rel="stylesheet" href="overview-styles.css">
    <!-- manifest file -->
    <link rel="manifest" href="../manifest.json">
    <!-- ios support -->
    <link rel="apple-touch-icon" href="../Images/icon-96x96.png">
    <meta name="apple-mobile-web-app-status-bar" content="#5f9ea0">
</head>
<body>

    <div class="container-fluid text-center header-container p-0">
        <h6 class="py-2">
            <div class="dropdown">
                <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown">
                    More
                </button>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="../svleads"><i class="fas fa-user-plus"></i>&nbsp;Lead Enter</a>
                    <a class="dropdown-item" href="../showleads"><i class="fas fa-list"></i>&nbsp;Lead Manage</a>
                    <a class="dropdown-item" href=""><i class="fas fa-edit"></i>&nbsp;Report</a>
                    <a class="dropdown-item" href="../master"><i class="fas fa-edit"></i>&nbsp;Master</a>
                    <a class="dropdown-item" href="../logout.php"><i class="fas fa-sign-out-alt"></i>&nbsp;Logout</a>
                </div>
            </div>
            <span>Site Visit Manager</span>&nbsp;&nbsp;&nbsp;
        </h6>

    <div class="container-fluid overview-container p-0">

        <!-- <h6>Today's Overview</h6> -->

        <form action="" method="POST">
            <input type="text" id="reportdr" name="reportdr" required readonly autocomplete="off">
            <input type="submit" name="sub_reportdr">
        </form>

        <div>
            <table>
                <tr>
                    <th>Total Leads</th>
                    <td><?php echo $total; ?></td>
                </tr>
                <tr>
                    <th>Total Arrived</th>
                    <td><?php echo $totalArr; ?></td>
                </tr>
                <tr>
                    <th>Pending</th>
                    <td><?php $pending = $total - $totalArr; echo $pending; ?></td>
                </tr>
                <tr>
                    <th>SV Done</th>
                    <td><?php echo $svdone; ?></td>
                </tr>
                <tr>
                    <th>RSV Done</th>
                    <td><?php echo $rsvdone; ?></td>
                </tr>
                <tr>
                    <th>Unattended</th>
                    <td><?php echo $unattended; ?></td>
                </tr>
                <tr>
                    <th>Tagged</th>
                    <td><?php echo $tagged; ?></td>
                </tr>
                <tr>
                    <th>AV</th>
                    <td><?php echo $av; ?></td>
                </tr>
                <tr>
                    <th>Closing</th>
                    <td><?php echo $closing; ?></td>
                </tr>
                <tr>
                    <th>Booked</th>
                    <td><?php echo $booked; ?></td>
                </tr>
            </table>
        </div>

    </div>


    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

    <!-- Bootstrap Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

    <!-- datetimepicker script -->
    <script src="../Scripts/jquery.datetimepicker.full.js"></script>

    <!-- daterange picker script -->
    <script src="../Scripts/moment.min.js"></script>
    <script src="../Scripts/daterangepicker.js"></script>

    <!-- custom script -->
    <script src="reportscripts.js"></script>

</body>
</html>