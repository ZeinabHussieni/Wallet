<?php
class Register{
private $pdo;
private $data;
public $message="";
private $userId;
public function __construct($pdo,$data){
    $this->pdo=$pdo;
    $this->data=$data;
}
public function createuser(){
    $name=$this->data['name']??'';
    $email=$this->data['email']??'';
    $password=password_hash( $this->data['password']??'',PASSWORD_DEFAULT);
    $address=$this->data['address']??'';
    $contact=$this->data['contact']??'';
    try{
      $stmt = $this->pdo->prepare("INSERT INTO users (name, email, password, address, contact) VALUES (?, ?, ?, ?, ?)");
      $success = $stmt->execute([$name, $email, $password, $address, $contact]);
     if ($success) {
     $this->userId = $this->pdo->lastInsertId();
     $this->message = "Registration successful";
     } else {$this->message = "Failed to register user.";}
     return $success;

    }catch(PDOException $e){
    $this->message="Error".$e->getMessage();
    return false;
    }
}
 public function getUserId() {
    return $this->userId;
    }
}

?>