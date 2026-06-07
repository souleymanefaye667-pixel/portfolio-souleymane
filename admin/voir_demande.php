<?php
session_start();
require_once __DIR__.'/../config/connexion.php';
if(!isset($_SESSION['admin_id'])){
    header('Location: connexion.php');
    exit();
}
$id=$_GET['id'] ?? 0;
$bdd->prepare("UPDATE demandes_projet SET lu=1 WHERE id=:id")->execute(['id'=>$id]);
$stmt=$bdd->prepare("SELECT* FROM demandes_projet WHERE id=:id");
$stmt->execute(['id'=>$id]);
$demande=$stmt->fetch();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Projet</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <main>
        <section>
            <h1>Demande de projet de <?php echo htmlspecialchars($demande['nom_p']); ?></h1>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($demande['email_p']); ?></p>
            <p><strong>Service demandé:</strong> <?php echo htmlspecialchars($demande['type_projet']); ?></p>
            <p><strong>Besoin exprimé:</strong></p>
            <p><?php echo nl2br(htmlspecialchars($demande['description'])); ?></p>
            <p><strong>Deadline:</strong> <?php echo htmlspecialchars($demande['deadline']); ?></p>
            <p><strong>Date de demande:</strong> <?php echo htmlspecialchars($demande['date_demande']); ?></p>
            <a href="demandes.php" style="display: inline-block; margin-top: 20px; color: var(--primary); text-decoration: none;">← Retour à la liste des demandes</a>
        </section>
    </main>
    
</body>
</html>