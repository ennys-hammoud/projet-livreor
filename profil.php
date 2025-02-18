<?php
session_start();

if (!isset($_SESSION['user']['id'])) {
    header('Location: connexion.php');
    exit();
}

require_once 'database.php';

$message = '';

// Récupérer les informations actuelles
$userData = $pdo->prepare('SELECT login FROM user WHERE id = ?');
$userData->execute([$_SESSION['user']['id']]);
$user = $userData->fetch(PDO::FETCH_ASSOC);

if (isset($_POST['submit'])) {
    $new_login = htmlspecialchars(trim($_POST['login']));
    $new_password = trim($_POST['password']);

    if (!empty($new_login) && !empty($new_password)) {
        $hashedPassword = password_hash($new_password, PASSWORD_DEFAULT);

        try {
            $updateUser = $pdo->prepare('UPDATE user SET login = ?, password = ? WHERE id = ?');
            $updateUser->execute([$new_login, $hashedPassword, $_SESSION['user']['id']]);

            // Mise à jour de la session
            $_SESSION['user']['login'] = $new_login;

            $message = 'Profil mis à jour avec succès!';
            $user['login'] = $new_login;
        } catch (PDOException $e) {
            $message = 'Erreur : ' . $e->getMessage();
        }
    } else {
        $message = 'Veuillez remplir tous les champs.';
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier mon profil</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body class="page-profil">
    <h1>Modifier mon profil</h1>

    <?php if ($message) : ?>
        <p><?php echo $message; ?></p>
    <?php endif; ?>

    <form action="profil.php" method="POST">
        <label for="login">Pseudo :</label>
        <input type="text" name="login" id="login" value="<?php echo htmlspecialchars($user['login']); ?>" required>

        <label for="password">Mot de passe :</label>
        <input type="password" name="password" id="password" required>

        <button type="submit" name="submit">Mettre à jour</button>
    </form>
        <p><a href="deconnexion.php">Se déconnecter</a></p>
</body>
</html>