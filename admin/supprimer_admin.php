<?php
session_start();
require_once __DIR__.'/../config/connexion.php';
require_once __DIR__.'/../fonctions.php';
if(!isset($_SESSION['admin_id'])){
    header('Location: connexion.php'); 
    exit();
}

$id_a_supprimer = $_GET['id'] ?? 0;
$mon_id = $_SESSION['admin_id'];
$erreur = '';

if ($id_a_supprimer == $mon_id) {
    $erreur = "Alerte de sécurité : Vous ne pouvez pas supprimer votre propre compte.";
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && empty($erreur)) {
      if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        die("Erreur de sécurité : Jeton CSRF invalide.");
    }
    $stmt = $bdd->prepare("DELETE FROM administrateurs WHERE id = ?");
    $stmt->execute([$id_a_supprimer]);
    header('Location: gestion_admin.php');
    exit();
}

$stmt = $bdd->prepare("SELECT prenom, nom FROM administrateurs WHERE id = ?");
$stmt->execute([$id_a_supprimer]);
$admin_cible = $stmt->fetch();

if (!$admin_cible && empty($erreur)) {
    $erreur = "Cet administrateur n'existe pas ou a déjà été supprimé.";
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Supprimer Administrateur</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <main>
        <section style="text-align: center; padding: 50px 30px;">
            <h1>Suppression de compte</h1>
            
            <?php if($erreur): ?>
                <div style="background: rgba(255, 77, 77, 0.1); border: 1px solid #ff4d4d; padding: 20px; border-radius: 10px; color: #ff4d4d; font-size: 1.1rem; margin-bottom: 30px;">
                    <strong><?php echo htmlspecialchars($erreur); ?></strong>
                </div>
                <a href="gestion_admin.php" class="submit-button" style="display: inline-block;">Retour à la liste</a>
            
            <?php else: ?>
                <p style="font-size: 1.2rem; margin-bottom: 40px;">
                    Êtes-vous sûr de vouloir supprimer définitivement le compte de <br>
                    <strong style="color: #ff4d4d; font-size: 1.8rem; display: block; margin-top: 10px;">
                        <?php echo htmlspecialchars($admin_cible['prenom'] . ' ' . $admin_cible['nom']); ?>
                    </strong>
                </p>

                <form method="POST" action="">
                    <input type="hidden" name="csrf_token" value="<?php echo generer_token_csrf(); ?>">
                    <div style="display: flex; justify-content: center; gap: 20px; align-items: center;">
                        <a href="gestion_admin.php" class="btn-cancel">Annuler</a>
                        <button type="submit" class="btn-danger">Oui, supprimer</button>
                    </div>
                </form>
            <?php endif; ?>

        </section>
    </main>
</body>
</html>