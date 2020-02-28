<?php

include '../../Connection/connectionPDO.php';

// Start the session
session_start();

$sessionproject = $_SESSION["project"];

$time1 = date('Y-m-d') . " 00:00:00";
$time2 = date('Y-m-d') . " 23:59:59";

$statement = $pdo->prepare("select * from leads WHERE (lead_status = 'Not Arrived' OR lead_status = '') AND (lead_svd BETWEEN '$time1' AND '$time2' AND lead_project='$sessionproject') ORDER BY lead_id DESC");
$statement->execute();
$results = $statement->fetchAll(PDO::FETCH_ASSOC);
$json = json_encode($results);

echo '{
  "data": ';
echo $json;
echo "}";

?>