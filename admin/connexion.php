<?php
session_start();
if(isset($_SESSION['admin_id'])){
    header('Location: dashboard.php');
    exit();
}
require_once __DIR__.'/../config/connexion.php';
if(empty($_SESSION['csrf_token'])){
    $_SESSION['csrf_token']=bin2hex(random_bytes(32));

}

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])){
        die('ERREUR CSRF');
    }
    $email=$_POST['email'];
    $sql="SELECT* FROM administrateurs WHERE email=:email";
    $stmt=$bdd->prepare($sql);
    $stmt->execute(['email'=>$email]);
    $admin=$stmt->fetch();

    if($admin && password_verify($_POST['password'], $admin['mot_de_passe'])){
        session_regenerate_id(true);
        $_SESSION['admin_id']=$admin['id'];
        $_SESSION['admin_prenom']=$admin['prenom'];
        header('Location: dashboard.php');
        exit();

    }else{
        $erreur="Email ou mot de passe incorrect.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../css/style.css">
    <body>
        <h1>Connexion Administrateur</h1>
        <?php if(isset($erreur)) echo "<p style='color: red;'>$erreur</p>"; ?>
        <form action="connexion.php" method="POST">
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
            <div>
                <label for="email">Email :</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div>
                <label for="password">Mot de passe :</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Se connecter</button>
        </form>
    </body>