<?php
session_start();
require_once __DIR__ . '/../../include/db.php';
require_once __DIR__ . '/../models/Transaction.php';
header('Content-Type: application/json');
if (!isset($_SESSION['user_id'])) {
 echo json_encode(["success"=>false,"message"=>"not authenticated"]);
 exit;
}
$userId = $_SESSION['user_id'];
$transaction = new Transaction($pdo, $userId);

$filters = [];
 if (!empty($_GET['type']))$filters['type']=$_GET['type'];
 if (!empty($_GET['from']))$filters['from']=$_GET['from'];
 if (!empty($_GET['to']))$filters['to']=$_GET['to'];
 
$data = $transaction->getHistory($filters);
echo json_encode(["success" => true, "transactions" => $data]);
?>
