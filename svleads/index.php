<?php

include '../Connection/connection.php';

// Start the session
session_start();

$sessionproject = $_SESSION["project"];


if(isset($_SESSION['username'])) {
} else {
    echo "<script type='text/javascript'> window.location.href = '../index.php'; </script>";
}

function secure($value) {
    $value = htmlspecialchars($value);
    $value = trim($value);
    $value = addslashes($value);
    return $value;
}

 if(isset($_POST['submit'])) {
    $name = secure($_POST['lname']);
    $number = secure($_POST['lnumber']);
    $configuration = secure($_POST['lconfig']);
    $getsvdt = secure($_POST['ldt']);
    $svdt = substr($getsvdt,6,4) . "-" . substr($getsvdt,3,2) . "-" . substr($getsvdt,0,2) . " " . substr($getsvdt,11);
    $source = secure($_POST['lnemp']);
    $svs = secure($_POST['lsvs']);

    $feedback = "";

    $sqlExist = "SELECT * FROM leads WHERE lead_number = '$number' AND lead_project='$sessionproject'";
    $result_sqlExist = $conn->query($sqlExist);

    if ($result_sqlExist->num_rows == 0) {

        $sql = "INSERT INTO leads (lead_name, lead_number, lead_config, lead_svd, lead_source_by, sv_status, lead_project) VALUES ('$name', '$number', '$configuration', '$svdt', '$source', '$svs', '$sessionproject')";

        if ($conn->query($sql) === TRUE) {
            $feedback = "Lead Added Successfully";
        } else {
            $feedback = "Error: " . $sql . "<br>" . $conn->error;
        }

    } else {

        $feedback = "Lead Already Exist";

    }

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
    <!-- custom svleads styles -->
    <link rel="stylesheet" href="svleads-styles.css">
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
                    <a class="dropdown-item" href=""><i class="fas fa-user-plus"></i>&nbsp;Lead Enter</a>
                    <a class="dropdown-item" href="../showleads"><i class="fas fa-list"></i>&nbsp;Lead Manage</a>
                    <a class="dropdown-item" href="../report"><i class="fas fa-edit"></i>&nbsp;Report</a>
                    <a class="dropdown-item" href="../master"><i class="fas fa-edit"></i>&nbsp;Master</a>
                    <a class="dropdown-item" href="../logout.php"><i class="fas fa-sign-out-alt"></i>&nbsp;Logout</a>
                </div>
            </div>
            <span>Site Visit Manager</span>&nbsp;&nbsp;&nbsp;
        </h6>

    <div class="container-fluid text-center svleads-container p-0">
        <p class="text-info"><small><b><?php if(isset($feedback)) { echo $feedback; } ?></b></small></p>


        <form action="" method="POST" autocomplete="off">
            <div class="div-nondd">
                <label for="lname">Lead Name</label>
                <input type="text" name="lname" id="lname" onfocus="labelUp(this.id)" onblur="labelDown(this.id)" required>
            </div>

            <div class="div-nondd">
                <label for="lnumber">Lead Number</label>
                <input type="tel" name="lnumber" id="lnumber" onfocus="labelUp(this.id)" onblur="labelDown(this.id)" required>
            </div>

            <div class="div-nondd">
                <label for="lconfig">Configuration</label>
                <input type="text" name="lconfig" id="lconfig" onfocus="labelUp(this.id)" readonly required>
            </div>

            <div class="text-left div-dd div-dd-config">
                <p class="m-0"><label for="1bhk"><input type="radio" name="config" value="1 BHK" id="1bhk"><span>&nbsp;&nbsp;1BHK</span></label></p>
                <p class="m-0"><label for="jodi1bhk"><input type="radio" name="config" value="Jodi 1 BHK" id="jodi1bhk"><span>&nbsp;&nbsp;Jodi 1BHK</span></label></p>
            </div>

            <div class="div-nondd">
                <label for="svs">Site Visit Status</label>
                <input type="text" name="lsvs" id="lsvs" onfocus="labelUp(this.id)" readonly required>
            </div>
            <div class="text-left div-dd div-dd-svs">
                <p class="m-0"><label for="svdd"><input type="radio" name="svsdd" value="SV" id="svdd"><span>&nbsp;&nbsp;SV</span></label></p>
                <p class="m-0"><label for="rsvdd"><input type="radio" name="svsdd" value="RSV" id="rsvdd"><span>&nbsp;&nbsp;RSV</span></label></p>
            </div>

            <div class="div-nondd">
                <label for="ldt">SV Date & Time</label>
                <input type="text" name="ldt" id="ldt" onfocus="labelUp(this.id)" onblur="labelDown(this.id)" required>
            </div>

            <div class="div-nondd">
                <label for="lnemp">Source By</label>
                <input type="text" name="lnemp" id="lnemp" onfocus="labelUp(this.id)" readonly required>
            </div>

            <div class="text-left div-dd div-dd-source">
                <?php

                    $sqlemp = "SELECT * FROM ln_emp";
                    $result = $conn->query($sqlemp);

                    if ($result->num_rows > 0) {
                        // output data of each row
                        while($row = $result->fetch_assoc()) {
                            $id = $row['emp_id'];
                            $name = $row['emp_name'];
                            echo '
                                <p class="m-0"><label for="ddemp_' . $id . '"><input type="radio" name="ddlnemp" value="' . $name . '" id="ddemp_' . $id . '"><span>&nbsp;&nbsp;' . $name . '</span></label></p>
                            ';
                            }
                    } else {
                    }

                ?>
            </div>

            <div class="div-nondd">
                <input type="submit" name="submit">
            </div>
        </form>
    </div>


    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

    <!-- Bootstrap Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

    <!-- datetimepicker script -->
    <script src="../Scripts/jquery.datetimepicker.full.js"></script>

    <!-- Custom svleads JavaScript -->
    <script src="svleads-scripts.js"></script>
</body>
</html>