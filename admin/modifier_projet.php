<?php
session_start();
require_once __DIR__.'/../config/connexion.php';
require_once __DIR__.'/../fonctions.php';
if(!isset($_SESSION['admin_id'])) { header('Location: connexion.php'); exit(); }

$id = $_GET['id'] ?? 0;

$stmt = $bdd->prepare("SELECT * FROM projets WHERE id = ?");
$stmt->execute([$id]);
$projet = $stmt->fetch();

if(!$projet) { die("Projet introuvable."); }

if($_SERVER['REQUEST_METHOD'] === 'POST'){
      if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        die("Erreur de sécurité : Jeton CSRF invalide.");
    }
    $titre = $_POST['titre'];
    $techno = $_POST['technologie'];
    $desc = $_POST['description'];
    
    if(isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK){
        $extension = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        $nouveau_nom = uniqid('projet_') . '.' . $extension;
        
        if(move_uploaded_file($_FILES['image']['tmp_name'], __DIR__.'/../images/projets/'.$nouveau_nom)){
        
            if(!empty($projet['image']) && file_exists(__DIR__.'/../images/projets/'.$projet['image'])){
                unlink(__DIR__.'/../images/projets/'.$projet['image']);
            }
            $sql = "UPDATE projets SET titre=?, description=?, technologies=?, image=? WHERE id=?";
            $bdd->prepare($sql)->execute([$titre, $desc, $techno, $nouveau_nom, $id]);
        }
    } else {
      
        $sql = "UPDATE projets SET titre=?, description=?, technologies=? WHERE id=?";
        $bdd->prepare($sql)->execute([$titre, $desc, $techno, $id]);
    }
    header('Location: gestion_projets.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier Projet</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <main style="max-width: 800px; margin: 40px auto; padding: 20px;">
        <h1>Modifier : <?php echo htmlspecialchars($projet['titre']); ?></h1>
        
        <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="csrf_token" value="<?php echo generer_token_csrf(); ?>">
            <input type="text" name="titre" value="<?php echo htmlspecialchars($projet['titre']); ?>" required style="width:100%; margin-bottom:15px; padding:10px;">
            
            <select name="technologie" required style="width:100%; margin-bottom:15px; padding:10px;">
                <?php 
                $techs = ['PHP & MySQL', 'Python & Arduino', 'C++ & Unreal', 'HTML/CSS', 'JavaScript'];
                foreach($techs as $t) {
                    $selected = ($projet['technologies'] == $t) ? 'selected' : '';
                    echo "<option value='$t' $selected>$t</option>";
                }
                ?>
            </select>

            <textarea name="description" required style="width:100%; margin-bottom:15px; padding:10px;"><?php echo htmlspecialchars($projet['description']); ?></textarea>
            
            <div style="margin-bottom:20px;">
                <p>Image actuelle : <img src="../images/projets/<?php echo $projet['image']; ?>" style="width:50px;"></p>
                <input type="file" name="image" accept="image/*">
            </div>
            
            <button type="submit" style="background:#00e5ff; padding:10px 20px; border:none; border-radius:5px;">Enregistrer</button><br>
           </form>
    </main>
     <a href="gestion_projets.php" style="background-color: #333; color: #fff; font-weight: bold; text-transform: uppercase; padding: 12px 24px; border-radius: 8px; text-decoration: none; text-align: center; flex: 1;">Retourner en arrière</a>
        
</body>
</html>