<?php
session_start();
require_once __DIR__.'/../config/connexion.php';
require_once __DIR__.'/../fonctions.php';
if(!isset($_SESSION['admin_id'])){
    header('Location: connexion.php'); 
    exit();
}
$erreur = '';
$succes = '';

if($_SERVER['REQUEST_METHOD'] === 'POST'){
      if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        die("Erreur de sécurité : Jeton CSRF invalide.");
    }
    $prenom = $_POST['prenom'] ?? '';
    $nom = $_POST['nom'] ?? '';
    $email = $_POST['email'] ?? '';
    $mdp = $_POST['mot_de_passe'] ?? '';
    
    if(!empty($prenom) && !empty($nom) && !empty($email) && !empty($mdp)){
         $hash = password_hash($mdp, PASSWORD_DEFAULT);
         $stmt = $bdd->prepare("INSERT INTO administrateurs (prenom, nom, email, mot_de_passe) VALUES (?, ?, ?, ?)");
        
    
        if($stmt->execute([$prenom, $nom, $email, $hash])){
            $succes = "Administrateur ajouté avec succès.";
        } else {
            $erreur = "Erreur lors de l'ajout.";
        }
    } else {
        $erreur = "Tous les champs sont obligatoires.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter Administrateur</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <main>
        <section>
            <h1>Ajouter un administrateur</h1>
             <?php if($erreur): ?> <div class="error"><?php echo htmlspecialchars($erreur); ?></div> <?php endif; ?>
            <?php if($succes): ?> <div class="success-box"><?php echo htmlspecialchars($succes); ?></div> <?php endif; ?>
                <form method="POST" action="">
                    <input type="hidden" name="csrf_token" value="<?php echo generer_token_csrf(); ?>">
                <div class="input-group">
                    <label>Prénom</label>
                    <input type="text" name="prenom" required>
                </div>
                <div class="input-group">
                    <label>Nom</label>
                    <input type="text" name="nom" required>
                </div>
                <div class="input-group">
                    <label>Email</label>
                    <input type="email" name="email" required>
                </div>
                <div class="input-group">
                    <label>Mot de passe</label>
                    <input type="password" name="mot_de_passe" required>
                </div>
                <button type="submit" class="submit-button">Créer le compte</button>
            </form>
             <a href="gestion_admin.php" style="display:block; margin-top:20px; color:var(--primary);">Retour à la liste</a>
        </section>
    </main>
</body>
</html>