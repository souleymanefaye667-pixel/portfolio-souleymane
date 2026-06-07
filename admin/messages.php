<?php
session_start();
require_once __DIR__.'/../config/connexion.php';
if(!isset($_SESSION['admin_id'])){
    header('Location: connexion.php');
    exit();
}
$messages=$bdd->query("SELECT* FROM messages_contact ORDER BY date_envoi DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages de contact</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <main>
        <h1>Messages reçus</h1>
        <section>
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr>
                        <th style="border: 1px solid #ccc; padding: 8px;">Nom</th>
                        <th style="border: 1px solid #ccc; padding: 8px;">Email</th>
                        <th style="border: 1px solid #ccc; padding: 8px;">Message</th>
                        <th style="border: 1px solid #ccc; padding: 8px;">Date d'envoi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($messages as $message): ?>
                    <tr class="<?php echo ($message['lu'] == 0) ? 'non-lu' : ''; ?>">
                        <td style="border: 1px solid ; padding: 8px;"><?php echo htmlspecialchars($message['nom']); ?></td>
                        <td style="border: 1px solid ; padding: 8px;"><?php echo htmlspecialchars($message['email']); ?></td>
                        <td style="border: 1px solid ; padding: 8px;"><?php echo nl2br(htmlspecialchars($message['message'])); ?></td>
                        <td style="border: 1px solid ; padding: 8px;"><?php echo htmlspecialchars($message['date_envoi']); ?></td>
                        <td style="padding:10px,">
                            <a href="voir_message.php?id=<?php echo $message['id']; ?>" style="color: var(--primary); text-decoration: none; font-weight: 600;">Voir</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
        </section>
        <a href="dashboard.php" style="display: inline-block; margin-top: 20px; color: var(--primary); text-decoration: none;">← Retour au tableau de bord</a>
    </main>
    
</body>
</html>