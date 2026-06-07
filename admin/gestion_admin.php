<?php
session_start();
require_once __DIR__.'/../config/connexion.php';
if(!isset($_SESSION['admin_id'])){
    header('location:connexion.php');exit();
}
$admins=$bdd->query("SELECT id,prenom,nom,email,date_creation FROM administrateurs")->fetchAll();

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion Admins</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <header>
             <a href="dashboard.php" style="display: inline-block; margin-top: 20px; color: var(--primary); text-decoration: none;"> <-Retour au tableau de bord</a>
             <div class="user-info">
            <span>Admin : <?php echo htmlspecialchars($_SESSION['admin_prenom']); ?></span>
            <a href="deconnexion.php" class="logout-btn">Déconnexion</a>
        </div>
    </header>
    <main>
        <h1>Gestions des Administrateurs</h1>
        <section>
            <table style=width:100%;>
                <thead>
                    <tr>
                        <th>Prenom</th><th>Nom</th><th>Email</th><th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($admins as $a): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($a['prenom']);?></td>
                            <td><?php echo htmlspecialchars($a['nom']);?></td>
                            <td><?php echo htmlspecialchars($a['email']);?></td>
                            <td>
                                <a href="modifier_admin.php?id=<?php echo htmlspecialchars($a['id']); ?>"style="color: #f39c12;margin-right: 15px;">Modifier</a>
                                <a href="supprimer_admin.php?id=<?php echo htmlspecialchars($a['id']) ; ?>" style="color:red">Supprimer</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                </tbody>
            </table>
            <br>
            <a href="ajouter_admin.php" class="submit-button">Ajouter Un Administrateur</a>
            <br>
        </section>

    </main>
</body>
</html>