<?php
class Profile{
private $pdo;
private $userid;
public $message="";
public function __construct($pdo,$userid){
    $this->pdo=$pdo;
    $this->userid=$userid;
}
public function getuser(){
    $stmt=$this->pdo->prepare("SELECT name,email,address,contact FROM users WHERE id=?");
    $stmt->execute([$this->userid]);
    return $stmt->fetch();
}
public function update($data){
    $name=$data['name']??'';
    $address=$data['address']??'';
    $contact=$data['contact']??'';
    try{
      $stmt = $this->pdo->prepare("UPDATE users SET name=?,address=?,contact=? WHERE id=?");
      $stmt->execute([$name,$address, $contact,$this->userid]);
     $this->message="Profile updated successful";
        return true;
    }catch(PDOException $e){
        $this->message="Error".$e->getMessage();
        return false;
    }
}
}

?>