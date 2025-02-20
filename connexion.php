<?php
session_start();
require_once 'Config/Database.php';
require_once 'Classes/User.php';
require_once 'Classes/Comment.php';


// Initialisation de la classe User
$user = new User($pdo);

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $login = trim($_POST['login']);
    $password = trim($_POST['password']);

    if ($user->connecter($login, $password)) {
        $_SESSION['user'] = [
            'id' => $user->getId(),
            'login' => $user->getLogin()
        ];
        header('Location: commentaire.php');
        exit();
    } else {
        $message = 'Identifiants incorrects';
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="styles.css">
    <title>Connexion</title>
</head>
<body class="page-connexion">
    <h1>Connexion</h1>

    <?php if ($message): ?>
        <p><?php echo $message; ?></p>
    <?php endif; ?>

    <form method="POST" action="connexion.php">
        <label for="login">Pseudo :</label>
        <input type="text" id="login" name="login" required>

        <label for="password">Mot de passe :</label>
        <input type="password" id="password" name="password" required>

        <button type="submit">Se connecter</button>
    </form>
    <p>Retour           <a href="index.php">Accueil</a></p>
</body>
</html>