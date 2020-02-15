<?php

include '../Connection/connection.php';

if(
isset($_POST['id']) && isset($_POST['name']) && isset($_POST['number']) && isset($_POST['leadstatus']) && isset($_POST['token']) && 
isset($_POST['config']) && isset($_POST['svdate']) && isset($_POST['svstatus']) && isset($_POST['closewho']) && isset($_POST['closename']) && 
isset($_POST['attended']) && isset($_POST['svdone']) && isset($_POST['visitresult']) && isset($_POST['remarks']) && isset($_POST['otherclose'])
) {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $number = $_POST['number'];
        $leadstatus = $_POST['leadstatus'];
        $token = $_POST['token'];
        $config = $_POST['config'];
        $svdate = $_POST['svdate'];
        $svstatus = $_POST['svstatus'];
        $closewho = $_POST['closewho'];
        $closename = $_POST['closename'];
        $otherclosename = $_POST['otherclose'];
        $attended = $_POST['attended'];
        $svdone = $_POST['svdone'];
        $visitresult = $_POST['visitresult'];
        $remarks = $_POST['remarks'];

        $sqlUpdate = "UPDATE `leads` SET `lead_name`='$name',`lead_number`='$number',`lead_config`='$config',`lead_svd`='$svdate',`sv_status`='$svstatus',`lead_status`='$leadstatus',`lead_token`='$token',`closing_who`='$closewho',`closing_name`='$closename',
            `closing_other`='$otherclosename',`attend_status`='$attended',`sv_done`='$svdone',`visit_result`='$visitresult',`lead_remarks`='$remarks' WHERE `lead_id`='$id'";

        // echo $sqlUpdate;

        if ($conn->query($sqlUpdate) === TRUE) {
            echo "**Lead updated successfully**";
        } else {
            echo "Error updating record: " . $conn->error;
        }
        
        $conn->close();
    }

?>