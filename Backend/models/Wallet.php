<?php
require_once __DIR__ . '/Transaction.php';
const GLOBAL_LIMIT = 500.00;
class Wallet {
 private $pdo;
 private $userId;
 private $trans;

public function __construct($pdo, $userId) {
 $this->pdo = $pdo;
 $this->userId = $userId;
 $this->trans= new Transaction($pdo, $userId);
    }

public function getBalance() {
 $stmt = $this->pdo->prepare("SELECT (SELECT IFNULL(SUM(amount),0) FROM transactions WHERE user_id = ? AND type = 'deposit') -
            (SELECT IFNULL(SUM(amount),0) FROM transactions WHERE user_id = ? AND type = 'withdraw') AS balance");
 $stmt->execute([$this->userId, $this->userId]);
     return (float)$stmt->fetchColumn();
    }
public function deposit($amount) {
     return $this->trans->addTransaction('deposit', $amount);
    }

public function withdraw($amount) {
    $todayWithdrawn = $this->trans->getTodayTotal('withdraw');
    if (($todayWithdrawn + $amount) > GLOBAL_LIMIT) {
     throw new Exception("Daily withdrawal limit of $".  GLOBAL_LIMIT . "exceeded"); }
     $balance = $this->getBalance();
    if ($amount > $balance) {
    throw new Exception("Insufficient funds"); }
     return $this->trans->addTransaction('withdraw', $amount);
    }
}
?>