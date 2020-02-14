<?php

include '../Connection/connection.php';

$sqlOverview = "SELECT lead_svd, sv_status, lead_status, attend_status, sv_done from leads WHERE (lead_svd BETWEEN '2020-02-14 00:00:00' AND '2020-02-14 23:59:00')";
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

                if($leadstatus === "Tagged" || $leadstatus === "Pre WR" ||  $leadstatus === "AV" ||  $leadstatus === "Post WR" ||   $leadstatus === "Closing" ||   $leadstatus === "Booked" || $leadstatus === "Planned RSV") {
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
                    <a class="dropdown-item" href=""><i class="fas fa-edit"></i>&nbsp;Overview</a>
                    <a class="dropdown-item" href="../master"><i class="fas fa-edit"></i>&nbsp;Master</a>
                    <a class="dropdown-item" href="../logout.php"><i class="fas fa-sign-out-alt"></i>&nbsp;Logout</a>
                </div>
            </div>
            <span>Site Visit Manager</span>&nbsp;&nbsp;&nbsp;
        </h6>

    <div class="container-fluid overview-container p-0">

        <h6>Today's Overview</h6>

        <div class="row">
            <div class="col-8">
                Total Leads
            </div>
            <div class="col-4">
                <?php echo $total; ?>
            </div>
        </div>

        <div class="row">
            <div class="col-8">
                Total Arrived
            </div>
            <div class="col-4">
                <?php echo $totalArr; ?>
            </div>
        </div>

        <div class="row">
            <div class="col-8">
                Pending
            </div>
            <div class="col-4">
                <?php $pending = $total - $totalArr; echo $pending; ?>
            </div>
        </div>

        <div class="row">
            <div class="col-8">
                SV Done
            </div>
            <div class="col-4">
                <?php echo $svdone; ?>
            </div>
        </div>

        <div class="row">
            <div class="col-8">
                RSV Done
            </div>
            <div class="col-4">
                <?php echo $rsvdone; ?>
            </div>
        </div>

        <div class="row">
            <div class="col-8">
                Unattended
            </div>
            <div class="col-4">
                <?php echo $unattended; ?>
            </div>
        </div>

        <div class="row">
            <div class="col-8">
                Tagged
            </div>
            <div class="col-4">
                <?php echo $tagged; ?>
            </div>
        </div>

        <div class="row">
            <div class="col-8">
                AV
            </div>
            <div class="col-4">
                <?php echo $av; ?>
            </div>
        </div>

        <div class="row">
            <div class="col-8">
                Closing
            </div>
            <div class="col-4">
                <?php echo $closing; ?>
            </div>
        </div>

        <div class="row">
            <div class="col-8">
                Booked
            </div>
            <div class="col-4">
                <?php echo $booked; ?>
            </div>
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
</body>
</html>