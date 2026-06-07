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
    $titre = $_POST['titre'] ?? '';
    $description = $_POST['description'] ?? '';
$technologies = $_POST['technologie'] ?? ''; 
    $lien = $_POST['lien'] ?? '';
    
    if(!empty($titre) && !empty($description) && !empty($technologies)){
        
       
        if(isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK){
            
            $dossier_cible = __DIR__.'/../images/projets/';
            $nom_fichier_original = $_FILES['image']['name'];
            $extension = strtolower(pathinfo($nom_fichier_original, PATHINFO_EXTENSION));
            
          
            $extensions_autorisees = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
            
            if(in_array($extension, $extensions_autorisees)){
                
                $nouveau_nom = uniqid('projet_') . '.' . $extension;
                $chemin_complet = $dossier_cible . $nouveau_nom;
                
    
                if(move_uploaded_file($_FILES['image']['tmp_name'], $chemin_complet)){
                    
                
                    $stmt = $bdd->prepare("INSERT INTO projets (titre, description, technologies, lien, image) VALUES (?, ?, ?, ?, ?)");
                    if($stmt->execute([$titre, $description, $technologies, $lien, $nouveau_nom])){
                        $succes = "Le projet a été publié avec succès !";
                    } else {
                        $erreur = "Erreur lors de l'enregistrement dans la base de données.";
                    }
                    
                } else {
                    $erreur = "Erreur lors de l'enregistrement physique du fichier.";
                }
            } else {
                $erreur = "Format d'image non autorisé. Utilisez uniquement : jpg, jpeg, png, webp ou gif.";
            }
        } else {
            $erreur = "Veuillez sélectionner une image valide pour ce projet.";
        }
    } else {
        $erreur = "Les champs Titre, Description et Technologies sont obligatoires.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un projet</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <header class="admin-header" style="justify-content: space-between;">
        <nav style="display: flex; gap: 30px; align-items: center;">
            <strong style="color: white; font-size: 1.2rem; margin-right: 20px;">Panel Admin</strong>
            <a href="dashboard.php" style="color: var(--text-dim); text-decoration: none; transition: 0.3s;">Dashboard</a>
            <a href="gestion_projets.php" style="color: var(--primary); text-decoration: none; font-weight: bold;">Gestion des Projets</a>
        </nav>
        <div class="user-info">
            <span>Admin : <?php echo htmlspecialchars($_SESSION['admin_prenom']); ?></span>
            <a href="deconnexion.php" class="logout-btn">Déconnexion</a>
        </div>
    </header>

    <main>
        <section style="max-width: 800px; margin: 0 auto; background: rgba(255,255,255,0.03); padding: 30px; border-radius: 12px; border: 1px solid rgba(255,255,255,0.05);">
            <h1 style="margin-bottom: 20px;">Créer un nouveau projet</h1>
            
            <?php if($erreur): ?>
                <div style="background: rgba(255, 77, 77, 0.1); border: 1px solid #ff4d4d; color: #ff4d4d; padding: 15px; border-radius: 6px; margin-bottom: 20px;">
                    <?php echo htmlspecialchars($erreur); ?>
                </div>
            <?php endif; ?>
            
            <?php if($succes): ?>
                <div style="background: rgba(46, 204, 113, 0.1); border: 1px solid #2ecc71; color: #2ecc71; padding: 15px; border-radius: 6px; margin-bottom: 20px;">
                    <?php echo htmlspecialchars($succes); ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="" enctype="multipart/form-data">
                <input type="hidden" name="csrf_token" value="<?php echo generer_token_csrf(); ?>">
                <div class="input-group" style="margin-bottom: 15px;">
                    <label style="display:block; margin-bottom:5px; color:#aaa;">Titre du projet</label>
                    <input type="text" name="titre" required style="width:100%; padding:10px; border-radius:6px; background:rgba(0,0,0,0.2); border:1px solid rgba(255,255,255,0.1); color:#fff;">
                </div>
                
                 <div class="input-group" style="margin-bottom: 15px;">
              <label style="display:block; margin-bottom:5px; color:#aaa;">Technologie principale</label>
             <select name="technologie" required style="width:100%; padding:10px; border-radius:6px; background:rgba(0,0,0,0.2); border:1px solid rgba(255,255,255,0.1); color:#fff;">
        <option value="" disabled selected>-- Choisir une technologie --</option>
        <option value="PHP & MySQL">PHP & MySQL</option>
        <option value="Python & Arduino">Python & Arduino</option>
        <option value="C++ & Unreal">C++ & Unreal</option>
        <option value="HTML/CSS">HTML/CSS</option>
        <option value="JavaScript">JavaScript</option>
         <option value="Autre">Autre</option>

    </select>
</div>
                <div class="input-group" style="margin-bottom: 15px;">
                    <label style="display:block; margin-bottom:5px; color:#aaa;">Lien externe (optionnel)</label>
                    <input type="url" name="lien" placeholder="https://..." style="width:100%; padding:10px; border-radius:6px; background:rgba(0,0,0,0.2); border:1px solid rgba(255,255,255,0.1); color:#fff;">
                </div>

                <div class="input-group" style="margin-bottom: 20px;">
                    <label style="display:block; margin-bottom:5px; color:#aaa;">Description du projet</label>
                    <textarea name="description" rows="5" required style="width:100%; padding:10px; border-radius:6px; background:rgba(0,0,0,0.2); border:1px solid rgba(255,255,255,0.1); color:#fff;"></textarea>
                </div>

                <div class="input-group" style="margin-bottom: 30px; background: rgba(0, 229, 255, 0.05); padding: 20px; border-radius: 8px; border: 1px dashed #00e5ff;">
                    <label style="display:block; margin-bottom:10px; color:#00e5ff; font-weight:bold;">Image d'illustration (jpg, jpeg, png, webp, gif)</label>
                    <input type="file" name="image" accept=".jpg,.jpeg,.png,.webp,.gif" required style="color: #fff;">
                </div>

                <div style="display: flex; gap: 15px;">
                    <button type="submit" style="background-color: #00e5ff; color: #000; font-weight: bold; text-transform: uppercase; padding: 12px 24px; border-radius: 8px; border: none; cursor: pointer; flex: 1;">Publier le projet</button>
                    <a href="gestion_projets.php" style="background-color: #333; color: #fff; font-weight: bold; text-transform: uppercase; padding: 12px 24px; border-radius: 8px; text-decoration: none; text-align: center; flex: 1;">Annuler</a>
                </div>
            </form>
        </section>
    </main>
</body>
</html>