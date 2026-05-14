<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Présentation Vidéo | SF</title>
    <link rel="icon" type="image/png" href="images/Logos.ico">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
   <?php require 'composants/navigation.php'; ?>
    <main>
        <h1>MA PRÉSENTATION</h1>
        <section>
            <div class="video-wrapper">
                <video controls poster="./images/photos.png">
                    <source src="./videos/WhatsApp Vidéo 2025-03-21 à 02.57.13_a59173d0.mp4" type="video/mp4">
                    Votre navigateur ne supporte pas la vidéo.
                </video>
            </div>
            <p style="margin-top: 20px; text-align: center; color: var(--text-dim);">
                Découvrez mon univers, mes motivations et ma vision du métier de développeur en 2 minutes.
            </p>
        </section>
    </main>
   <?php require 'composants/pied-de-page.php'; ?>
</body>

</html>