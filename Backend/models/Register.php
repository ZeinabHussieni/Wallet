<?php
class Register{
private $pdo;
private $data;
public $message="";
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
      $stmt->execute([$name, $email, $password, $address, $contact]);
     $this->message="Registeration successful";
        return true;
    }catch(PDOException $e){
        $this->message="Error".$e->getMessage();
        return false;
    }
}
}

?>