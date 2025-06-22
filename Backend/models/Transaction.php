<?php
class Transaction {
    private $pdo;
    private $userId;
 public function __construct($pdo,$userId) {
      $this->pdo=$pdo;
      $this->userId=$userId;
    }
 public function addTransaction($type,$amount) {
    $stmt=$this->pdo->prepare("INSERT INTO transactions (user_id,type,amount,transaction_date) VALUES (?,?,?,CURDATE())");
    return $stmt->execute([$this->userId,$type,$amount]);
    }
 public function getTodayTotal($type) {
    $stmt=$this->pdo->prepare("SELECT SUM(amount) FROM transactions WHERE user_id = ? AND transaction_date = CURDATE() AND type = ?");
     $stmt->execute([$this->userId,$type]);
     $total=$stmt->fetchColumn();
     return $total ?: 0;
    }
public function getHistory($filters = []) {
    $sql = "SELECT * FROM transactions WHERE user_id = ?";
    $params = [$this->userId];
    if (!empty($filters['type'])) {
      $sql .= " AND type = ?";
      $params[] = $filters['type'];
    }
    if (!empty($filters['from'])) {
      $sql .= " AND transaction_date >= ?";
      $params[] = $filters['from'];
    }
    if (!empty($filters['to'])) {
       $sql .= " AND transaction_date <= ?";
      $params[] = $filters['to'];
    }
     $sql .= " ORDER BY transaction_date DESC, created_at DESC";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll();
}

}
?>