<?php
require_once 'Config/Database.php';
require_once 'Classes/User.php';
require_once 'Classes/Comment.php';

$message = '';

if (isset($_POST['submit_inscription'])) {
    $login = htmlspecialchars(trim($_POST['login_inscription']));
    $password = trim($_POST['password_inscription']);

    try {
        $checkUser = $pdo->prepare('SELECT id FROM user WHERE login = ?');
        $checkUser->execute([$login]);

        if ($checkUser->rowCount() == 0) {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $insertUser = $pdo->prepare('INSERT INTO user (login, password) VALUES (?, ?)');
            $insertUser->execute([$login, $hashedPassword]);

            $message = 'Inscription réussie! Vous pouvez maintenant vous connecter.';
            header('Location: connexion.php');
            exit();
        } else {
            $message = 'Ce login est déjà pris.';
        }
    } catch (PDOException $e) {
        $message = 'Erreur lors de l\'inscription : ' . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body class="page-inscription-connexion">
        <h1>Inscription</h1>

        <?php if (!empty($message)) : ?>
            <p class="message"><?php echo htmlspecialchars($message); ?></p>
        <?php endif; ?>

        <form action="inscription_connection.php" method="POST">
            <label for="login_inscription">Pseudo :</label>
            <input type="text" name="login_inscription" id="login_inscription" required>

            <label for="password_inscription">Mot de passe :</label>
            <input type="password" name="password_inscription" id="password_inscription" required>

            <button type="submit" name="submit_inscription">S'inscrire</button>
        </form>

        <p>Déjà inscrit ? <a href="connexion.php">Se connecter</a></p>
    </div>
</body>
</html>