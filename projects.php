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
   $projets=[
    [
        "id"=> "resto",
        "titre"=> "Restaurant Online",
        "image"=> "./images/resto.jpg",
        "description"=> "Interface de commmande digitalisée pour services de livraison.",
        "techno"=>"PHP & MySQL"
    ],
     [
        "id"=> "jeu",
        "titre"=> "Jeu Video PC",
        "image"=> "./images/jeux.jpg",
        "description"=> "Concept de jeu immersif developpé sous Unreal Engine.",
        "techno"=>"C++ & Unreal"
    ],
     [
        "id"=> "pro",
        "titre"=> "Biotech Software",
        "image"=> "./images/prothèse.jpg",
        "description"=> "Logiciel de paramètrae pour prothèses intelligentes.",
        "techno"=>"Python & Arduino"
    ],
       [
        "id"=> "agro",
        "titre"=> "Agro Solaris",
        "image"=> "./images/agro.jpg",
        "description"=> "Plateforme alternative pour une agriculture durable et l'utilisation du solaire.",
        "techno"=>"PHP && HTML/CSS"
    ],
   ];
   $recherche=isset($_GET['q'])? strtolower(trim($_GET['q'])):'';
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
                if($recherche !==''&& strpos(strtolower($p['titre']),$recherche)===false&&
                strpos(strtolower($p['techno']),$recherche)===false){
                    continue;
                }
                ?>
                
            <div class="card">
                <img src="<?php echo $p['image'];?>" alt="<?php echo $p['titre'];?>">
                <div class="card-body">
                    <h3><?php echo $p['titre']; ?></h3>
                    <p style="color: var(--text-dim); font-size: 0.9rem; margin-bottom: 15px;"><?php echo $p['description']; ?></p>
                    <a href="grand.php#<?php echo $p['id']; ?>"
                        style="color: var(--primary); text-decoration: none; font-weight: 600;">VOIR DÉTAILS →</a>
                </div>
            </div>
            <?php endforeach;  ?>
        </div>
    </main>

   <?php require 'composants/pied-de-page.php'; ?>
</body>

</html>