<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once __DIR__.'/../config/connexion.php';
if(!isset($_SESSION['admin_id'])){
    header('Location: connexion.php');
    exit();
}
$stmt=$bdd->query("SELECT COUNT(*) FROM messages_contact WHERE lu=0");
$messages_non_lus=$stmt->fetchColumn();
$stmt=$bdd->query("SELECT COUNT(*) FROM demandes_projet WHERE lu=0");
$demandes_non_lus=$stmt->fetchColumn();
$visites=$bdd->query("SELECT adresse_ip, page ,date_visite FROM visites ORDER BY date_visite DESC LIMIT 10")->fetchAll();
$dernieres_demandes=$bdd->query("SELECT nom_p, email_p, type_projet, date_demande FROM demandes_projet ORDER BY date_demande DESC LIMIT 5")->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Administration</title>
    <link rel="stylesheet" href="../css/style.css">
   
</head>
<body>
     <header class="admin-header" style="justify-content: space-between;">
    <nav style="display: flex; gap: 30px; align-items: center;">
        <strong style="color: white; font-size: 1.2rem; margin-right: 20px;">Panel Admin</strong>
        <a href="dashboard.php" style="color: var(--primary); text-decoration: none; font-weight: bold;">Dashboard</a>
        <a href="gestion_admin.php" style="color: var(--text-dim); text-decoration: none; transition: 0.3s;">Gestion des Admins</a>
        <a href="gestion_projets.php" style="color: var(--text-dim); text-decoration: none; transition: 0.3s;">Gestion des Projets</a>
        </nav>

    <div class="user-info">
        <span>Admin : <?php echo htmlspecialchars($_SESSION['admin_prenom']); ?></span>
        <a href="deconnexion.php" class="logout-btn">Déconnexion</a>
    </div>
</header>
    <main>
        <h1>Tableau de bord</h1>
        <div class="stats-grid">
            <div class="stat-card">
                <h2>Messages</h2>
                <span class="stat-number <?php echo $messages_non_lus > 0 ? 'non-lu-red' : 'lu-green'; ?>">
                    <?php echo $messages_non_lus; ?>
                </span>
                <a href="messages.php" class="submit-button" style="padding: 10px 20px;">Voir tout</a>
            </div>
            <div class="stat-card">
                <h2>Demandes</h2>
                <span class="stat-number <?php echo $demandes_non_lus > 0 ? 'non-lu-red' : 'lu-green'; ?>">
                    <?php echo $demandes_non_lus; ?>
                </span>
                <a href="demandes.php" class="submit-button" style="padding: 10px 20px;">Voir tout</a>
            </div>
        </div>

        <section>
            <h2>Dernières visites</h2>
            <table style="width:100%; border-collapse: collapse; margin-top:15px;">
                <?php foreach($visites as $v): ?>
                <tr style="border-bottom: 1px solid var(--border);">
                    <td style="padding: 10px;"><?php echo htmlspecialchars($v['adresse_ip']); ?></td>
                    <td style="padding: 10px;"><?php echo htmlspecialchars($v['page']); ?></td>
                    <td style="padding: 10px; opacity: 0.6;"><?php echo htmlspecialchars($v['date_visite']); ?></td>
                </tr>
                <?php endforeach; ?>
            </table>
        </section>

        <section>
            <h2>Dernières demandes</h2>
            <table style="width:100%; border-collapse: collapse; margin-top:15px;">
                <?php foreach($dernieres_demandes as $d): ?>
                <tr style="border-bottom: 1px solid var(--border);">
                    <td style="padding: 10px; font-weight: bold;"><?php echo htmlspecialchars($d['nom_p']); ?></td>
                    <td style="padding: 10px;"><?php echo htmlspecialchars($d['type_projet']); ?></td>
                    <td style="padding: 10px; opacity: 0.6;"><?php echo htmlspecialchars($d['date_demande']); ?></td>
                </tr>
                <?php endforeach; ?>
            </table>
            
        </section>

    </main>
</body>
</html>