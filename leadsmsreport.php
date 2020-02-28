<?php

include 'Connection/connection.php';

date_default_timezone_set('Asia/Kolkata');

$time = date('Y-m-d H:i:s');
$timefiltered = strtotime($time);


$sql = "SELECT * FROM leads WHERE (lead_svd > '$time')";
echo $sql . '<br />';
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {

        $sv  = strtotime($row['lead_svd']);
        $differenceInSeconds = $sv - $timefiltered;

        if($differenceInSeconds < 900) {
            // // Authorisation details.
            // $username = "vikas.tripathi@livnest.com";
            // $hash = "f98846d928c0b5fb758517a757220dcb13509e468f9c3ce96b09948e114d98e8";
        
            // // Config variables. Consult http://api.textlocal.in/docs for more info.
            // $test = "0";
        
            // // Data for text message. This is the text message data.
            // $sender = "TXTLCL"; // This is who the message appears to be from.
            // $numbers = "7506605530"; // A single number or a comma-seperated list of numbers
            // $message = "$name has enquired for configuration $configuration . Contact is $contact for Lodha Upper Thane";
            // // 612 chars or less
            // // A single number or a comma-seperated list of numbers
            // $message = urlencode($message);
            // $data = "username=".$username."&hash=".$hash."&message=".$message."&sender=".$sender."&numbers=".$numbers."&test=".$test;
            // $ch = curl_init('http://api.textlocal.in/send/?');
            // curl_setopt($ch, CURLOPT_POST, true);
            // curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            // $result = curl_exec($ch); // This is the result from the API
            // curl_close($ch);

            
        }

    }
} else {
    echo "0 results";
}

?>