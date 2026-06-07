<?php
session_start();
require_once __DIR__.'/../config/connexion.php';
if(!isset($_SESSION['admin_id'])){
    header('Location: connexion.php');
    exit();
}
$demandes=$bdd->query("SELECT* FROM demandes_projet ORDER BY date_demande DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demandes de Projets</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <main>
        <h1>Demandes de projets reçues</h1>
        <section>
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr>
                        <th style="border: 1px solid #31c5bb; padding: 8px;">Nom</th>
                        <th style="border: 1px solid #31c5bb; padding: 8px;">Email</th>
                        <th style="border: 1px solid #31c5bb; padding: 8px;">Service demandé</th>
                        <th style="border: 1px solid #31c5bb; padding: 8px;">Besoin exprimé</th>
                        <th style="border: 1px solid #31c5bb; padding: 8px;">Deadline</th>
                        <th style="border: 1px solid #31c5bb; padding: 8px;">Date de demande</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($demandes as $demande): ?>
                    <tr class="<?php echo ($demande['lu'] == 0) ? 'non-lu' : ''; ?>">
                        <td style="border: 1px solid ; padding: 8px;"><?php echo htmlspecialchars($demande['nom_p']); ?></td>
                        <td style="border: 1px solid ; padding: 8px;"><?php echo htmlspecialchars($demande['email_p']); ?></td>
                        <td style="border: 1px solid ; padding: 8px;"><?php echo htmlspecialchars($demande['type_projet']); ?></td>
                        <td style="border: 1px solid ; padding: 8px;"><?php echo nl2br(htmlspecialchars($demande['description'])); ?></td>
                        <td style="border: 1px solid ; padding: 8px;"><?php echo htmlspecialchars($demande['deadline']); ?></td>
                        <td style="border: 1px solid ; padding: 8px;"><?php echo htmlspecialchars($demande['date_demande']); ?></td>
                        <td style="padding:10px,">
                            <a href="voir_demande.php?id=<?php echo $demande['id']; ?>" style="color: var(--primary); text-decoration: none; font-weight: 600;">Voir</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
        <a href="dashboard.php" style="display: inline-block; margin-top: 20px; color: var(--primary); text-decoration: none;">← Retour au tableau de bord</a>
    </main>

    
</body>
</html>