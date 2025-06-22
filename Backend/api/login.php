<?php
session_start();
require_once __DIR__ . '/../../include/db.php';
header('Content-Type: application/json');

if($_SERVER['REQUEST_METHOD']==='POST'){
    $email=$_POST['email']??'';
    $password=$_POST['password']??'';
    $stmt=$pdo->prepare("SELECT * FROM users WHERE email =?");
    $stmt->execute([$email]);
    $user=$stmt->fetch();
    if($user && password_verify($password,$user['password'])){
        $_SESSION['user_id']=$user['id'];
        echo json_encode([
            'success' =>true,
            'message' =>'Login successful',
            'redirect' =>'/digital-wallet/Frontend/wallet.html'
        ]);
    }else{
        echo json_encode([
             'success' =>false,
            'message' =>'Invalid email or password'
        ]);
    }
    exit;
}



?>