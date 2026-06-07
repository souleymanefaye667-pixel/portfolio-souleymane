<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Mon Parcours | Souleymane Faye</title>
    <link rel="icon" type="image/png" href="images/Logos.ico">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php require 'composants/navigation.php';
    require_once 'config/connexion.php';
    ?>
    <main>
        <h1>MON PARCOURS</h1>

        <section>
            <h2>Formation Académique</h2>
            <div style="border-left: 2px solid var(--primary); padding-left: 20px; margin-left: 10px;">
                <p><strong>2024 - 2025 :</strong> Licence 1 en Génie Logiciel (ESTM Dakar)</p>
                <p><strong>2024 :</strong> Baccalauréat en Sciences Expérimentales (Collège Saint Gabriel)</p>
                <p><strong>2021 :</strong> Obtention du BFEM</p>
            </div>
        </section>

        <section>
            <h2>Compétences Techniques</h2>
            <div class="grid">
                <div class="card" style="padding: 20px; text-align: center;">
                    <h3 style="font-size: 1rem; color: var(--primary);">FRONT-END</h3>
                    <p>HTML5 / CSS3 (Avancé)<br>JavaScript (Débutant)</p>
                </div>
                <div class="card" style="padding: 20px; text-align: center;">
                    <h3 style="font-size: 1rem; color: var(--primary);">DESIGN & MULTIMÉDIA</h3>
                    <p>Adobe Photoshop<br>CapCut / Montage Vidéo</p>
                </div>
                <div class="card" style="padding: 20px; text-align: center;">
                    <h3 style="font-size: 1rem; color: var(--primary);">BUREAUTIQUE</h3>
                    <p>Pack Office (Expert)<br>Gestion de projet</p>
                </div>
                <div class="card" style="padding: 20px; text-align: center;">
                    <h3 style="font-size: 1rem; color: var(--primary);">Java</h3>
                    <p>Développement d'applications robustes et POO.<br>Debutant</p>
                </div>
                <div class="card" style="padding: 20px; text-align: center;">
                    <h3 style="font-size: 1rem; color: var(--primary);">JavaScript</h3>
                    <p>Interactivité web et dynamisme des interfaces<br>Intermediaire</p>
                </div>
                <div class="card" style="padding: 20px; text-align: center;">
                    <h3 style="font-size: 1rem; color: var(--primary);">Python</h3>
                    <p>Scripting, automatisation et analyse de données.<br>Debutant</p>
                </div>
                <div class="card" style="padding: 20px; text-align: center;">
                    <h3 style="font-size: 1rem; color: var(--primary);">PHP</h3>
                    <p>Développement backend et gestion de bases de données SQL<br>Debutant</p>
                </div>
                <div class="card" style="padding: 20px; text-align: center;">
                    <h3 style="font-size: 1rem; color: var(--primary);">Cybersecurite</h3>
                    <p>Audit de vulnérabilités et protection des systèmes<br>Debutant</p>
                </div>

        </section>

        <section>
            <h2>Soft Skills</h2>
            <p>• <strong>Leadership :</strong> Habitude de prendre des directives et d'orienter les équipes.</p>
            <p>• <strong>Empathie :</strong> Capacité à comprendre et s'adapter aux émotions des collaborateurs.</p>
            <p>• <strong>Créativité :</strong> Curiosité constante pour les nouvelles tendances visuelles.</p>
            <p>• <strong>Esprit d'analyse :</strong> Forte aptitude à décomposer des problèmes complexes pour trouver
                des solutions
                logiques.</p>
            <p>• <strong>Adaptabilité :</strong> Capacité à apprendre rapidement de nouvelles technologies et à
                s'ajuster aux
                changements de planning.</p>
            <p>• <strong>Travail d'équipe :</strong> Collaboration efficace avec des profils variés pour atteindre des
                objectifs
                communs.</p>
            <p>• <strong>Communication :</strong> Aptitude à expliquer des concepts techniques de manière claire et
                accessible.</p>
            <p>• <strong>Autonomie :</strong> Gestion rigoureuse du temps et des priorités, même sur des tâches
                complexes.</p>
        </section>
    </main>
    <?php require 'composants/pied-de-page.php'; ?>

</body>

</html>