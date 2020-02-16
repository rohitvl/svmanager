<?php

include '../../Connection/connectionPDO.php';

$time1 = date('Y-m-d') . " 00:00:00";
$time2 = date('Y-m-d') . " 23:59:59";

$statement = $pdo->prepare("select * from leads WHERE (lead_svd BETWEEN '$time1' AND '$time2') ORDER BY lead_svd ASC");
$statement->execute();
$results = $statement->fetchAll(PDO::FETCH_ASSOC);
$json = json_encode($results);

echo '{
  "data": ';
echo $json;
echo "}";

?>