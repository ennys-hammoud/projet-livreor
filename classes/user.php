<?php
class User {
    private $pdo;
    private $id;
    private $login;
    private $password;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function inscrire($login, $password) {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $this->pdo->prepare("INSERT INTO user (login, password) VALUES (:login, :password)");
        $stmt->bindParam(':login', $login);
        $stmt->bindParam(':password', $hashedPassword);
        return $stmt->execute();
    }

    public function connecter($login, $password) {
        $stmt = $this->pdo->prepare("SELECT id, password FROM user WHERE login = :login");
        $stmt->bindParam(':login', $login);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $this->id = $user['id'];
            $this->login = $login;
             // Mise en session
        $_SESSION['user_id'] = $this->id;
        $_SESSION['user_login'] = $this->login;

            return true;
        }
        return false;
    }

    public function modifierProfil($newLogin, $newPassword) {
        $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
        $stmt = $this->pdo->prepare("UPDATE user SET login = :login, password = :password WHERE id = :id");
        $stmt->bindParam(':login', $newLogin);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':id', $this->id);
        return $stmt->execute();
    }

    public function getId() {
        return $this->id;
    }

    public function getLogin() {
        return $this->login;
    }

    
}
?>