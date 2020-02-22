<?php

include '../../Connection/connectionPDO.php';

if(isset($_GET['date']) && isset($_GET['status'])) {
    $date = $_GET['date'];
    $status = $_GET['status'];
    $statusArr = explode(',', $status);

    $where = "";

    if (in_array("SV", $statusArr)) {
        $where .= "sv_status = 'SV' OR ";
    }

    if (in_array("RSV", $statusArr)) {
        $where .= "sv_status = 'RSV' OR ";
    }

    if (in_array("Arrived", $statusArr)) {
        $where .= "(NOT lead_status = 'Not Arrived' AND NOT lead_status = '') OR ";
    }

    if (in_array("Tagged", $statusArr)) {
        $where .= "lead_status IN ('Tagged', 'Pre WR', 'AV', 'Post WR', 'Closing', 'Booked', 'Planned RSV', 'Feedback Awaited', 'Did Not Like') OR ";
    }

    if (in_array("AV", $statusArr)) {
        $where .= "lead_status IN ('AV', 'Post WR') OR ";
    }

    if (in_array("Closing", $statusArr)) {
        $where .= "lead_status IN ('Closing') OR ";
    }

    if (in_array("Booked", $statusArr)) {
        $where .= "lead_status IN ('Booked') OR ";
    }

    if (in_array("Planned RSV", $statusArr)) {
        $where .= "lead_status IN ('Planned RSV') OR ";
    }

    if($date === "Today") {

        $time1 = date('Y-m-d') . " 00:00:00";
        $time2 = date('Y-m-d') . " 23:59:59";

    } else {

        $time1 = substr($date, 6, 4) . '-' . substr($date, 3, 2) . '-' . substr($date, 0, 2) . ' 00:00:00';
        $time2 = substr($date, 19, 4) . '-' . substr($date, 16, 2) . '-' . substr($date, 13, 2) . ' 23:59:59';    

    }


}


$where = substr($where, 0, -4);


$statement = $pdo->prepare("select * from leads WHERE ($where) AND (lead_svd BETWEEN '$time1' AND '$time2') ORDER BY lead_id DESC");
$statement->execute();
$results = $statement->fetchAll(PDO::FETCH_ASSOC);
$json = json_encode($results);

echo '{
  "data": ';
echo $json;
echo "}";

// echo "select * from leads WHERE ($where) AND (lead_svd BETWEEN '$time1' AND '$time2') ORDER BY lead_id DESC";

?>