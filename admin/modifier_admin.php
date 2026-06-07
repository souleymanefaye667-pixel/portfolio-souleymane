<?php
session_start();
require_once __DIR__.'/../config/connexion.php';
require_once __DIR__.'/../fonctions.php';
if(!isset($_SESSION['admin_id'])){header('location: connexion.php'); exit();}
$id=$_GET['id']??0;
$erreur='';
$succes='';

if($_SERVER['REQUEST_METHOD']==='POST'){
      if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        die("Erreur de sécurité : Jeton CSRF invalide.");
    }
    $prenom=$_POST['prenom']??'';
    $nom=$_POST['nom']??'';
    $email=$_POST['email']??'';
    $nouveau_mdp=$_POST['mot_de_passe']??'';
    if(!empty($prenom) && !empty($nom) && !empty($email)){
        if(empty($nouveau_mdp)){
            $stmt=$bdd->prepare("UPDATE administrateurs SET prenom=?,nom=?,email=?WHERE id=?");
            $stmt->execute([$prenom,$nom,$email,$id]);

        }else{
            $hash=password_hash($nouveau_mdp, PASSWORD_DEFAULT);
            $stmt=$bdd->prepare("UPDATE administrateurs SET prenom=?,nom=?,email=?,mot_de_passe=? WHERE id=?");
            $stmt->execute([$prenom,$nom,$email,$hash,$id]);

        }
        $succes="Administrateur mis à jour avec succès.";

    }else{
        $erreur="Le prénom, le nom et l'email sont obligatoires.";

    }
}
$stmt=$bdd->prepare("SELECT * FROM administrateurs WHERE id=?");
$stmt->execute([$id]);
$admin=$stmt->fetch();

if(!$admin){
    die("Administrateur Introuvable.");
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Administrateurs</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <main>
        <section>
            <h1>Modifier L'administrateur</h1>
            <?php if($erreur): ?><div class="error"<?php echo htmlspecialchars($erreur); ?>></div> <?php endif; ?>
            <?php if($succes): ?> <div class="success-box"><?php echo $succes; ?></div> <?php endif; ?>

            <form method="POST" action="">
                <input type="hidden" name="csrf_token" value="<?php echo generer_token_csrf(); ?>">
                <div class="input-group">
                    <label>Prénom</label>
                    <input type="text" name="prenom" value="<?php echo htmlspecialchars($admin['prenom']); ?>" required>
                </div>
                <div class="input-group">
                    <label>Nom</label>
                    <input type="text" name="nom" value="<?php echo htmlspecialchars($admin['nom']); ?>" required>
                </div>
                <div class="input-group">
                    <label>Email</label>
                    <input type="email" name="email" value="<?php echo htmlspecialchars($admin['email']); ?>" required>
                </div>
                <div class="input-group">
                    <label>Nouveau mot de passe (laisser vide pour ne pas changer)</label>
                    <input type="password" name="mot_de_passe">
                </div>
                <button type="submit" class="submit-button">Mettre à jour</button>
            </form>
            <a href="gestion_admin.php" style="display:block; margin-top:20px; color:var(--primary);">Retour à la liste</a>
        </section>
    </main>
</body>
</html>

