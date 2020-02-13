<?php

include '../Connection/connection.php';

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

    $feedback = "";

    $sqlExist = "SELECT * FROM leads WHERE lead_number = '$number'";
    $result_sqlExist = $conn->query($sqlExist);

    if ($result_sqlExist->num_rows == 0) {

        $sql = "INSERT INTO leads (lead_name, lead_number, lead_config, lead_svd) VALUES ('$name', '$number', '$configuration', '$svdt')";

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

            <div class="text-left div-dd">
                <p class="m-0"><label for="1bhk"><input type="radio" name="config" value="1 BHK" id="1bhk"><span>&nbsp;&nbsp;1BHK</span></label></p>
                <p class="m-0"><label for="jodi1bhk"><input type="radio" name="config" value="Jodi 1 BHK" id="jodi1bhk"><span>&nbsp;&nbsp;Jodi 1BHK</span></label></p>
            </div>

            <div class="div-nondd">
                <label for="ldt">SV Date & Time</label>
                <input type="text" name="ldt" id="ldt" onfocus="labelUp(this.id)" onblur="labelDown(this.id)" required>
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