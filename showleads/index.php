<?php

include '../Connection/connection.php';

// Start the session
session_start();


if(isset($_SESSION['username'])) {
} else {
    echo "<script type='text/javascript'> window.location.href = '../index.php'; </script>";
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
    <!-- Datatables styles -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
    <!-- common styles -->
    <link rel="stylesheet" href="../Styles/primarystyles.css">
    <!-- custom showleads styles -->
    <link rel="stylesheet" href="showleads-styles.css">
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
                    <a class="dropdown-item" href=""><i class="fas fa-list"></i>&nbsp;Lead Manage</a>
                    <a class="dropdown-item" href="../report"><i class="fas fa-edit"></i>&nbsp;Report</a>
                    <a class="dropdown-item" href="../master"><i class="fas fa-edit"></i>&nbsp;Master</a>
                    <a class="dropdown-item" href="../logout.php"><i class="fas fa-sign-out-alt"></i>&nbsp;Logout</a>
                </div>
            </div>
            <span>Site Visit Manager</span>&nbsp;&nbsp;&nbsp;
        </h6>
    </div>

    <div class="container-fluid leads-container p-0">

        <div class="filter-sl text-center">
            <input type="text" id="sldr" readonly>
            <select id="filterstatus" size="1" multiple>
                <option value="" hidden selected>--Select Lead Status--</option>
                <option value="SV">SV</option>
                <option value="RSV">RSV</option>
                <option value="Arrived">Arrived</option>
                <option value="Tagged">Tagged</option>
                <option value="AV">AV Room</option>
                <option value="Closing">Closing Table</option>
                <option value="Booked">Booked</option>
                <option value="Planned RSV">Planned RSV</option>
            </select>
            <button type="submit" id="filter_button">Filter</button>
        </div>

        <div class="filter-pills text-center">
            <span id="pending-pill">Today Pending</span>
            <span id="all-pill">ALL</span>
        </div>

        <table id="leads" class="display">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Number</th>
                    <th>Status</th>
                    <th>Token</th>

                    <th class="hideth">Configuration</th>
                    <th>SV Date</th>
                    <th class="hideth">SV Status</th>
                    <th class="hideth">Who Closed</th>
                    <th class="hideth">Closing Name</th>
                    <th class="hideth">Attend Status</th>
                    <th class="hideth">SV Done</th>
                    <th class="hideth">Visit Result</th>
                    <th class="hideth">Remarks</th>
                    <th class="hideth">Sourced By</th>
                    <th class="hideth">Closing Other</th>
                    <th class="hideth">ID</th>
                </tr>
            </thead>
        </table>


        <div class="leadInfo">
            <div class="top-info">
                <p class="name-on-modal">Lead Name: </p>
                <p class="close-modal"><i class="fas fa-times-circle"></i></p>
            </div>

            <div class="modal-name-container">
                <small>Name :</small><br />
                <input type="text" id="lname">
            </div>

            <div class="modal-number-container">
                <small>Number :</small><br />
                <input type="tel" id="lnumber">
            </div>

            <div class="modal-config-container">
                <small>Configuration :</small><br />
                <select id="lconfig">
                    <option value="" hidden selected>--Select Configuration--</option>
                    <option value="1 BHK">1 BHK</option>
                    <option value="Jodi 1 BHK">Jodi 1 BHK</option>
                </select>
            </div>

            <div class="modal-svd-container">
                <small>Site Visit Date :</small><br />
                <input type="text" id="svd-modal">
            </div>

            <div class="modal-svstatus-container">
                <small>SV or RSV :</small><br />
                <select id="lsvstatus">
                    <option value="" hidden selected>--Select SV Status--</option>
                    <option value="SV">Site Visit</option>
                    <option value="RSV">ReSite Visit</option>
                </select>
            </div>

            <div class="modal-status-container">
                <small>Lead Status :</small><br />
                <select onchange="lstatusflip(this.value)" id="lstatus">
                    <option value="" hidden selected>--Select Lead Status--</option>
                    <option value="Not Arrived">Not Arrived</option>
                    <option value="Arrived">Arrived</option>
                    <option value="Tagged">Tagged</option>
                    <option value="Pre WR">Pre AV Waiting Area</option>
                    <option value="AV">AV Room</option>
                    <option value="Post WR">Post AV Waiting Area</option>
                    <option value="Closing">Closing Table</option>
                    <option value="Booked">Booked</option>
                    <option value="Planned RSV">Planned RSV</option>
                    <option value="Feedback Awaited">Feedback Awaited</option>
                    <option value="Did Not Like">Did Not Like</option>
                </select>
            </div>

            <div class="modal-token-container">
                <small>Lead Token No. :</small><br />
                <input type="text" id="token-input">
            </div>

            <div class="modal-closing-container">
                <p class="text-center"><small>Closing Managers Assigned :</small></p>

                <small>Livnest Managers Assigned :</small><br />
                <select id="whoClosing">
                    <option value="" hidden selected>--LN Managers--</option>
                    <option value="Vikas Tripathi">Vikas Tripathi</option>
                    <option value="Rahul">Rahul</option>
                    <option value="Nishant">Nishant</option>
                    <option value="Pooja Godbole">Pooja Godbole</option>
                    <option value="Priyanka Shinde">Priyanka Shinde</option>
                    <option value="Virendra Shukla">Virendra Shukla</option>

                </select>

                <!-- <div class="modal-closing-names-container"> -->
                <small>Raunak Managers Assigned :</small><br />
                <select id="closingName" onchange="rmassigned(this.value)">
                    <option value="" hidden selected>--Raunak Managers--</option>
                    <?php

                        $sqlremp = "SELECT * FROM raunak_managers ORDER BY remp_name ASC";
                        $result = $conn->query($sqlremp);

                        if ($result->num_rows > 0) {
                            // output data of each row
                            while($row = $result->fetch_assoc()) {
                                $name = $row['remp_name'];
                                echo '
                                    <option value="' . $name . '">' . $name . '</option>
                                ';
                                }
                        } else {

                        }
                    ?>
                    <option value="Other">Other</option>
                </select>

                <input type="text" placeholder="Specify Not Listed Name" id="otherrm">
                <!-- </div> -->
            </div>

            <div class="modal-attended-container">
                <small>Client Attended Status :</small><br />
                <select onchange="attendFlip(this.value)" id="attendStatus">
                    <option value="" hidden selected>--Lead is attended?--</option>
                    <option value="Attended">Attended</option>
                    <option value="Unattended">Unattended</option>
                </select>
            </div>

            <div class="checkbox-container modal-svdonecheck-container">
                <p><label><input type="checkbox" id="issvdone">&nbsp;&nbsp;<small>Is SV Done?</small></label></p>    
            </div>

            <div class="modal-visitresult-container">
                <small>Visit Result?</small><br />
                <select id="visitresult" onchange="vrselected(this.value)">
                    <option value="" hidden selected>--Select Visit Result--</option>
                    <option value="Booked">Booked</option>
                    <option value="Planned RSV">Planned RSV</option>
                    <option value="Feedback Awaited">Feedback Awaited</option>
                    <option value="Did Not Like">Did Not Like</option>
                </select>
            </div>

            <small>Lead Remarks</small><br />
            <textarea id="lremarks" rows="4"></textarea>

            <small>Sourced By</small><br />
            <input type="text" id="lsourceby" readonly>

            <div class="row my-3 text-center">
                <div class="col-6">
                    <button id="save">Save</button>
                </div>
                <div class="col-6">
                    <button id="restore">Restore</button>
                </div>
            </div>

            <span class="feedback"></span>

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

    <!-- datatables script -->
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>

    <!-- Custom showleads JavaScript -->
    <script src="showleads-scripts.js"></script>
</body>
</html>