<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Mes Réalisations | SF</title>
    <link rel="icon" type="image/png" href="images/Logos.ico">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
   <?php require 'composants/navigation.php'; ?>
   <?php 
     require_once 'config/connexion.php';
    $recherche=isset($_GET['q'])? strtolower(trim($_GET['q'])):'';
    if(!empty($recherche)){
        $sql ="SELECT* FROM projets WHERE titre LIKE :recherche OR technologies LIKE :recherche ORDER BY id DESC";
        $stmt=$bdd->prepare($sql);
        $stmt->execute(['recherche'=>'%'.$recherche.'%']);

        }else{
            $sql="SELECT* FROM projets ORDER BY id DESC";
            $stmt=$bdd->query($sql);
        }
        $projets=$stmt->fetchAll();
    
   ?>

    <main>
        <section class="search-section">
            <form action="#" method="GET" class="search-bar">
                <label for="search" class="sr-only">Rechercher un projet :</label>
                <div class="search-wrapper">
                    <input type="text" id="search" name="q" class="search-input"
                        placeholder="Ex: PHP, Arduino, MySQL...">
                    <button type="submit" class="search-button">Filtrer</button>
                </div>
            </form>
        </section>
        </section>
        <h1>RÉALISATIONS</h1>
       <div class="grid">
    <?php 
    foreach($projets as $p):
        $nom_image = basename($p['image']); 
        $chemin_image = 'images/projets/' . $nom_image;
    ?>
    
    <div class="card">
        <img src="<?php echo htmlspecialchars($chemin_image); ?>" 
             alt="<?php echo htmlspecialchars($p['titre']); ?>"
             style="width: 100%; height: 200px; object-fit: cover;">
        
        <div class="card-body">
            <h3><?php echo htmlspecialchars($p['titre']); ?></h3>
            <p style="color: var(--text-dim); font-size: 0.9rem; margin-bottom: 15px;">
                <?php echo htmlspecialchars($p['description']); ?>
            </p>
            <p style="font-weight: bold; color: var(--primary);">
                Techno: <?php echo htmlspecialchars($p['technologies']); ?>
            </p>
            <a href="grand.php?id=<?php echo htmlspecialchars($p['id']); ?>" 
               style="color: var(--primary); text-decoration: none; font-weight: 600;">VOIR DÉTAILS →</a>
        </div>
    </div>
    <?php endforeach; ?>
</div>
    </main>

   <?php require 'composants/pied-de-page.php'; ?>
</body>

</html>