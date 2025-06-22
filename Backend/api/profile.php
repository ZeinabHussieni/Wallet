<?php
session_start();
require_once __DIR__ . '/../../include/db.php';
require_once __DIR__ . '/../models/Profile.php';
header('Content-Type: application/json');

if(!isset($_SESSION['user_id'])){
    echo json_encode(["success"=>false,"message"=>"Unauthorized"]);
    exit;
}

$profile=new Profile($pdo,$_SESSION['user_id']);
if($_SERVER['REQUEST_METHOD']==='GET'){
    $user=$profile->getUser();
    echo json_encode(["success"=>true,"user"=>$user]);
    exit;
}
if($_SERVER['REQUEST_METHOD']==='POST'){
    $success=$profile->update($_POST);
    echo json_encode([
        "success"=>$success,
        "message"=>$profile->message
    ]);
    exit;

}
echo json_encode(["success"=>false,"message"=>"Invalid request"]);
?>