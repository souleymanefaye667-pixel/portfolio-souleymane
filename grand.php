<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Détails Projets | SF.DESIGN</title>
    <link rel="icon" type="image/png" href="images/Logos.ico">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
<?php require 'composants/navigation.php'; 
require_once 'config/connexion.php';
$id_projet = isset($_GET['id']) ? intval($_GET['id']) : 0;
if($id_projet > 0){
    $sql = "SELECT* FROM projets WHERE id=:id";
    $stmt=$bdd->prepare($sql);  
    $stmt->execute(['id'=>$id_projet]);
    $projet=$stmt->fetch();
    if(!$projet){
        header("Location: projects.php");
        exit;
    }
?>

    <main>
        <h1>DÉTAILS TECHNIQUES</h1>
        <?php if(isset($projet) && $projet): ?>
            <section id="projet-unique">
                <h2><?php echo htmlspecialchars($projet['titre']); ?></h2>
<?php 
    $chemin_correct = 'images/projets/' . basename($projet['image']); 
?>
<img src="<?php echo htmlspecialchars($chemin_correct); ?>" 
     alt="<?php echo htmlspecialchars($projet['titre']); ?>" 
     style="width: 100%; border-radius: 15px; margin-bottom: 25px; border: 1px solid var(--border);"
     >
            <div style="padding-left:20px;">
                <p><?php echo nl2br(htmlspecialchars($projet['description'])); ?></p>
                <p style="margin-top:15px;"><strong>Technologies utilisées :</strong> <?php echo htmlspecialchars($projet['technologies']); ?></p>
            </div>
            <br>

            </section>
            <?php else: ?>
                <p>Projet non trouvé.</p>
            <?php endif; ?>
        <?php } ?>

    </main>
     <a href="projects.php" style="background-color: #333; color: #fff; font-weight: bold; text-transform: uppercase; padding: 12px 24px; border-radius: 8px; text-decoration: none; text-align: center; flex: 1;">Retourner en arrière</a>
        
</body>

    <?php require 'composants/pied-de-page.php'; ?>
</body>

</html>