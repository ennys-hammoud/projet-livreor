<?php
class Comment {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function ajouterCommentaire($userId, $comment) {
        $stmt = $this->pdo->prepare("INSERT INTO comment (comment, id_user, date) VALUES (:comment, :id_user, NOW())");
        $stmt->bindParam(':comment', $comment);
        $stmt->bindParam(':id_user', $userId);
        return $stmt->execute();
    }

    public function supprimerCommentaire($commentId) {
        $stmt = $this->pdo->prepare("DELETE FROM comment WHERE id = :id");
        $stmt->bindParam(':id', $commentId);
        return $stmt->execute();
    }

    public function rechercherCommentaires($search) {
        $stmt = $this->pdo->prepare("SELECT c.comment, c.date, u.login 
                                     FROM comment c
                                     JOIN user u ON c.id_user = u.id
                                     WHERE c.comment LIKE :search
                                     ORDER BY c.date DESC");
        $stmt->bindValue(':search', "%$search%", PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCommentaires($page, $commentsPerPage) {
        $offset = ($page - 1) * $commentsPerPage;
        $stmt = $this->pdo->prepare("SELECT c.comment, c.date, u.login 
                                     FROM comment c
                                     JOIN user u ON c.id_user = u.id
                                     ORDER BY c.date DESC
                                     LIMIT :offset, :limit");
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $commentsPerPage, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countCommentaires($search = '') {
        $sql = "SELECT COUNT(*) FROM comment";
        if ($search) {
            $sql .= " WHERE comment LIKE :search";
        }
        $stmt = $this->pdo->prepare($sql);
        if ($search) {
            $stmt->bindValue(':search', "%$search%", PDO::PARAM_STR);
        }
        $stmt->execute();
        return $stmt->fetchColumn();
    }
}
?>