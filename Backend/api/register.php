<?php
session_start(); 
require_once __DIR__ . '/../../include/db.php';
require_once __DIR__ . '/../models/Register.php';

header('Content-Type: application/json');

if($_SERVER['REQUEST_METHOD']==='POST'){
    $register=new Register($pdo,$_POST);
    $success=$register->createuser();
     if ($success) {
    $_SESSION['user_id'] = $register->getUserId(); 
    }
    echo json_encode(
        [
           "success" => $success,
        "message" => $register->message,
        "redirect" => "/digital-wallet/Frontend/wallet.html"
        ]
        );
        
        exit;
}
echo json_encode(["success" => false, "message" => "Invalid request"]);
?>