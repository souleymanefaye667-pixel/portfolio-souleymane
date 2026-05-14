<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Détails Projets | SF.DESIGN</title>
    <link rel="icon" type="image/png" href="images/Logos.ico">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
<?php require 'composants/navigation.php'; ?>

    <main>
        <h1>DÉTAILS TECHNIQUES</h1>

        <section id="resto">
            <h2>01. Restaurant Online</h2>
            <img src="./images/resto exo.jpg" alt="Aperçu Restaurant"
                style="width: 100%; border-radius: 15px; margin-bottom: 25px; border: 1px solid var(--border);">

            <div style="padding-left: 20px;">
                <p>• <strong>Frontend :</strong> Utilisation de HTML5 et CSS3 pour une interface responsive.</p>
                <p>• <strong>Langage :</strong> JavaScript pour la gestion du panier et des calculs en temps réel.</p>
                <p>• <strong>Base de données :</strong> PHP et MySQL pour le stockage des menus et des commandes.</p>
                <p>• <strong>Objectif :</strong> Digitaliser la prise de commande pour réduire le temps d'attente.</p>
            </div>
        </section>

        <section id="jeu">
            <h2>02. Jeu Vidéo PC</h2>
            <img src="./images/jeu exe.jpg" alt="Aperçu Jeu"
                style="width: 100%; border-radius: 15px; margin-bottom: 25px; border: 1px solid var(--border);">

            <div style="padding-left: 20px;">
                <p>• <strong>Moteur :</strong> Développement réalisé sous Unreal Engine 5.</p>
                <p>• <strong>Programmation :</strong> Scripting logique en Python et Blueprints.</p>
                <p>• <strong>Graphismes :</strong> Modélisation des environnements et gestion de la physique des objets.
                </p>
                <p>• <strong>Expérience :</strong> Création d'un univers immersif avec gestion de la caméra à la
                    première personne.</p>
            </div>
        </section>

        <section id="pro">
            <h2>03. Biotech & Sécurité</h2>
            <img src="./images/pro exe.jpg" alt="Aperçu Sécurité"
                style="width: 100%; border-radius: 15px; margin-bottom: 25px; border: 1px solid var(--border);">

            <div style="padding-left: 20px;">
                <p>• <strong>Langage :</strong> Java pour le logiciel de contrôle biométrique.</p>
                <p>• <strong>Sécurité :</strong> Implémentation de protocoles de chiffrement pour protéger les données.
                </p>
                <p>• <strong>Interface :</strong> Monitoring en temps réel des capteurs via une console Java Swing.</p>
                <p>• <strong>Innovation :</strong> Algorithme d'analyse des signaux pour la précision des mouvements.
                </p>
            </div>
        </section>
         <section id="agro">
            <h2>04. Agro SOLARIS</h2>
            <img src="./images/agro exe.jpg" alt="Aperçu agro"
                style="width: 100%; border-radius: 15px; margin-bottom: 25px; border: 1px solid var(--border);">

            <div style="padding-left: 20px;">
                <p>• <strong>Langage :</strong> HTML CSS et PHP pour interactivité de l'interface le dynamisme</p>
                <p>• <strong>Utilité:</strong> Facilite la connexion entre les divers fournisseurs aux quatres coins du senegal
                </p>
                <p>• <strong>Adaptabilité:</strong> Interface cross platforme accessible sur divers appareils </p>
                <p>• <strong>Innovation :</strong> Utilisation de la resource solaire qui est souvent banalisée et négligée
                </p>
            </div>
        </section>
    </main>

    <?php require 'composants/pied-de-page.php'; ?>
</body>

</html>