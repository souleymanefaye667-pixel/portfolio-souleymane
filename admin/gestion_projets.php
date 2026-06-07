<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once __DIR__.'/../config/connexion.php';
require_once __DIR__.'/../fonctions.php';

if(!isset($_SESSION['admin_id'])){
    header('Location: connexion.php');
    exit();
}

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'supprimer') {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("Erreur : Jeton CSRF invalide.");
    }

    $id_projet = intval($_POST['id_projet']);
    if ($id_projet > 0) {
        $stmtImg = $bdd->prepare("SELECT image FROM projets WHERE id = ?");
        $stmtImg->execute([$id_projet]);
        $nom_image = $stmtImg->fetchColumn();

        $stmt = $bdd->prepare("DELETE FROM projets WHERE id = ?");
        if ($stmt->execute([$id_projet])) {
            if ($nom_image && file_exists(__DIR__.'/../images/projets/'.$nom_image)) {
                unlink(__DIR__.'/../images/projets/'.$nom_image);
            }
        }
    }
    header('Location: gestion_projets.php');
    exit();
}

$projets = $bdd->query("SELECT * FROM projets ORDER BY id DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Projets</title>
    <link rel="stylesheet" href="../css/style.css">
    
</head>
<body>
    <header class="admin-header" style="justify-content: space-between;">
        <nav style="display: flex; gap: 30px; align-items: center;">
            <strong style="color: white; font-size: 1.2rem; margin-right: 20px;">Panel Admin</strong>
            <a href="dashboard.php" style="color: var(--text-dim); text-decoration: none; transition: 0.3s;">Dashboard</a>
            <a href="gestion_admin.php" style="color: var(--text-dim); text-decoration: none; transition: 0.3s;">Gestion des Admins</a>
            <a href="gestion_projets.php" style="color: var(--primary); text-decoration: none; font-weight: bold;">Gestion des Projets</a>
        </nav>

        <div class="user-info">
            <span>Admin : <?php echo htmlspecialchars($_SESSION['admin_prenom']); ?></span>
            <a href="deconnexion.php" class="logout-btn">Déconnexion</a>
        </div>
    </header>

    <main>
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
            <h1 style="font-size: 2.2rem; color: #fff;">Liste des projets</h1>
        </div>

        <section class="table-container" style="background: rgba(255, 255, 255, 0.03); border-radius: 12px; padding: 20px; border: 1px solid rgba(255,255,255,0.05);">
            <table style="width: 100%; border-collapse: collapse;">

                <thead>
                    
            <a href="ajouter_projet.php" class="submit-button" style="background-color: #00e5ff; color: #000; font-weight: bold; text-transform: uppercase; padding: 12px 24px; border-radius: 8px; text-decoration: none; font-size: 0.9rem; letter-spacing: 0.5px;">+ Créer un projet</a>
            <br>
                    <tr style="border-bottom: 2px solid rgba(255,255,255,0.1); text-align: left; color: #aaa; font-size: 0.9rem;">
                        <th style="padding: 15px;">Image</th>
                        <th style="padding: 15px;">Titre</th>
                        <th style="padding: 15px;">Technologies</th>
                        <th style="padding: 15px; text-align: right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($projets)): ?>
                        <tr>
                            <td colspan="4" style="padding: 30px; text-align: center; color: #666;">Aucun projet en base de données.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach($projets as $p): ?>
                        <tr style="border-bottom: 1px solid rgba(255,255,255,0.05); color: #fff;">
                           <td style="padding: 15px;">
    <?php if(!empty($p['image'])): 
        
        $nom_fichier = basename($p['image']); 
    ?>
        <img src="../images/projets/<?php echo htmlspecialchars($nom_fichier); ?>" 
             alt="Aperçu" 
             style="width: 60px; height: 40px; object-fit: cover; border-radius: 6px; display: block;"
             onerror="this.style.display='none'; this.nextElementSibling.style.display='inline-flex';">
        <span class="img-placeholder" style="display: none;">Vide</span>
    <?php else: ?>
        <span class="img-placeholder">Aucune</span>
    <?php endif; ?>
</td>
                            <td style="padding: 15px; font-weight: 600;"><?php echo htmlspecialchars($p['titre']); ?></td>
                            <td style="padding: 15px;">
                                <span style="background: rgba(0, 229, 255, 0.1); color: #00e5ff; padding: 6px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: 500;">
                                    <?php echo htmlspecialchars($p['technologies']); ?>
                                </span>
                            </td>
                            <td style="padding: 15px; text-align: right;">
                                <div style="display: inline-flex; gap: 20px; align-items: center;">
                                    <a href="modifier_projet.php?id=<?php echo $p['id']; ?>" style="color: #ffcc00; text-decoration: none; font-weight: 600; font-size: 0.9rem;">Modifier</a>
                                    
                                    <form method="POST" action="" onsubmit="return confirm('Supprimer définitivement le projet « <?php echo htmlspecialchars($p['titre'], ENT_QUOTES); ?> » ?');" style="margin: 0;">
                                        <input type="hidden" name="action" value="supprimer">
                                        <input type="hidden" name="id_projet" value="<?php echo $p['id']; ?>">
                                        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                                        <button type="submit" style="background: none; border: none; color: #ff4d4d; font-weight: 600; cursor: pointer; font-size: 0.9rem; padding: 0; font-family: inherit;">Supprimer</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </section>
    </main>
</body>
</html>