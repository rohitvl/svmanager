<?php

include '../Connection/connectionPDO.php';

// Start the session
session_start();

$sessionproject = $_SESSION["project"];

$statement = $pdo->prepare("select * from leads where lead_project='$sessionproject' ORDER BY lead_svd DESC");
$statement->execute();
$results = $statement->fetchAll(PDO::FETCH_ASSOC);
$json = json_encode($results);

echo '{
  "data": ';
echo $json;
echo "}";

?>