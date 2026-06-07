<?php
session_start();
require_once __DIR__.'/../config/connexion.php';
if(!isset($_SESSION['admin_id'])){
    header('Location: connexion.php');
    exit();
}
$id=$_GET['id'] ?? 0;

$update=$bdd->prepare("UPDATE messages_contact SET lu=1 WHERE id=:id");
$update->execute(['id'=>$id]);

$stmt=$bdd->prepare("SELECT* FROM messages_contact WHERE id=:id");
$stmt->execute(['id'=>$id]);
$message=$stmt->fetch();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lecture Message</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <main>
        <section>
            <h1>Message de <?php echo htmlspecialchars($message['nom']); ?></h1>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($message['email']); ?></p>
            <p><strong>Date d'envoi:</strong> <?php echo htmlspecialchars($message['date_envoi']); ?></p>
            <p><strong>Message:</strong></p>
            <p><?php echo nl2br(htmlspecialchars($message['message'])); ?></p>
            <a href="messages.php" style="display: inline-block; margin-top: 20px; color: var(--primary); text-decoration: none;">← Retour à la liste des messages</a>
        </section>
    </main>
</body>
</html>