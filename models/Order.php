<?php
class Order {
    private $conn;
    private $table = 'orders';

    public $id;
    public $user_id;
    public $order_number;
    public $total_amount;
    public $status;
    public $created_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAll() {
        $stmt = $this->conn->query("SELECT o.*, u.email FROM $this->table o 
                                    LEFT JOIN users u ON o.user_id = u.id 
                                    ORDER BY o.created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getByNumber($orderNumber) {
        $stmt = $this->conn->prepare("SELECT o.*, u.email FROM $this->table o 
                                      LEFT JOIN users u ON o.user_id = u.id 
                                      WHERE o.order_number = ?");
        $stmt->execute([$orderNumber]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create() {
        $query = "INSERT INTO $this->table (user_id, order_number, total_amount, status, created_at) 
                  VALUES (:user_id, :order_number, :total_amount, :status, :created_at)";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->bindParam(":order_number", $this->order_number);
        $stmt->bindParam(":total_amount", $this->total_amount);
        $stmt->bindParam(":status", $this->status);
        $stmt->bindParam(":created_at", $this->created_at);
        
        return $stmt->execute();
    }

    public function updateStatus($orderId, $status) {
        $query = "UPDATE $this->table SET status = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$status, $orderId]);
    }

    public function count() {
        $stmt = $this->conn->query("SELECT COUNT(*) FROM $this->table");
        return $stmt->fetchColumn();
    }

    public function getRecent($limit = 10) {
        $limit = (int)$limit;
        $stmt = $this->conn->query("SELECT o.*, u.email FROM $this->table o 
                                    LEFT JOIN users u ON o.user_id = u.id 
                                    ORDER BY o.created_at DESC LIMIT $limit");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getByUserId($userId) {
        $stmt = $this->conn->prepare("SELECT o.*, u.email FROM $this->table o 
                                      LEFT JOIN users u ON o.user_id = u.id 
                                      WHERE o.user_id = ? 
                                      ORDER BY o.created_at DESC");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
