<?php
session_start();
header('Content-Type: application/json');
require_once __DIR__ . '/../../include/db.php';
require_once __DIR__ . '/../models/Transaction.php';
require_once __DIR__ . '/../models/Wallet.php';
if (!isset($_SESSION['user_id'])) {
 echo json_encode(["success"=>false,"message"=>"not authenticated"]);
 exit;
}
$userId = $_SESSION['user_id'];
$wallet = new Wallet($pdo, $userId);

if ($_SERVER['REQUEST_METHOD']==='POST'){
 $action = $_POST['action'] ??'';
 $amount = floatval($_POST['amount'] ?? 0);
 try {
     if ($amount <= 0) throw new Exception("Amount must be greater than zero");
     if ($action==='deposit') {
     $wallet->deposit($amount);
     echo json_encode(["success"=>true,"message"=>"Deposit successful"]);
    } elseif ($action==='withdraw') {
     $wallet->withdraw($amount);
     echo json_encode(["success"=>true,"message"=>"Withdrawal successful"]);
     } else {
     throw new Exception("Invalid action");
    }
    } catch (Exception $e) {
        echo json_encode(["success"=>false,"message"=>$e->getMessage()]);
    }
 exit;
}

$balance = $wallet->getBalance();
echo json_encode(["success"=>true,"balance" => $balance,"daily_limit" => 500.00]);
?>