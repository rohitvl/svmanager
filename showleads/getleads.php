<?php

include '../Connection/connectionPDO.php';

$statement = $pdo->prepare("select * from leads ORDER BY lead_svd DESC");
$statement->execute();
$results = $statement->fetchAll(PDO::FETCH_ASSOC);
$json = json_encode($results);

echo '{
  "data": ';
echo $json;
echo "}";

?>