<?php
class User {
    private $conn;
    private $table = 'users';

    public $id;
    public $email;
    public $login;
    public $password;
    public $email_verified;
    public $verification_code;
    public $created_at;
    public $is_admin;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAll() {
        $stmt = $this->conn->query("SELECT id, email, login, email_verified, created_at, is_admin FROM $this->table ORDER BY created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT id, email, login, email_verified, created_at, is_admin FROM $this->table WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getByEmail($email) {
        $stmt = $this->conn->prepare("SELECT * FROM $this->table WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getByLogin($login) {
        $stmt = $this->conn->prepare("SELECT * FROM $this->table WHERE login = ? OR email = ?");
        $stmt->execute([$login, $login]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create() {
        $query = "INSERT INTO $this->table (email, login, password, email_verified, verification_code, created_at, is_admin) 
                  VALUES (:email, :login, :password, :email_verified, :verification_code, :created_at, :is_admin)";
        
        $stmt = $this->conn->prepare($query);
        
        $this->is_admin = $this->is_admin ?? 0;
        $this->email_verified = $this->email_verified ?? 0;
        $this->verification_code = $this->verification_code ?? rand(100000, 999999);
        
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":login", $this->login);
        $stmt->bindParam(":password", $this->password);
        $stmt->bindParam(":email_verified", $this->email_verified);
        $stmt->bindParam(":verification_code", $this->verification_code);
        $stmt->bindParam(":created_at", $this->created_at);
        $stmt->bindParam(":is_admin", $this->is_admin);
        
        return $stmt->execute();
    }

    public function verifyEmail() {
        $query = "UPDATE $this->table SET email_verified = 1, verification_code = NULL WHERE verification_code = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$this->verification_code]);
    }

    public function count() {
        $stmt = $this->conn->query("SELECT COUNT(*) FROM $this->table");
        return $stmt->fetchColumn();
    }

    public function toggleAdmin($id) {
        $query = "UPDATE $this->table SET is_admin = NOT is_admin WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$id]);
    }

    public function delete($id) {
        $query = "DELETE FROM $this->table WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$id]);
    }
}
?>
