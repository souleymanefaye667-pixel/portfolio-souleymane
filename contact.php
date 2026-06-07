<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Contact | SF</title>
    <link rel="icon" type="image/png" href="images/Logos.ico">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php require 'composants/navigation.php'; ?>
    <?php 
    require_once 'fonctions.php';
    require_once 'config/connexion.php';
    $erreurs =[];
    $nom=$email=$message="";
       $nom_p=$email_p=$service=$besoin=$deadline="";
        $erreurs_projet=[];
        $succes_projet=false;
    if($_SERVER["REQUEST_METHOD"]=="POST" && isset($_POST['submit_message'])){
          if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        die("Erreur de sécurité : Jeton CSRF invalide.");
    }
        $nom= nettoyer($_POST['nom']?? '');
        $email=nettoyer($_POST['email']?? '');
        $message =nettoyer($_POST['message']??'');

        if(champs_est_vide($nom))$erreurs['nom']="le nom est obligatoire.";
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) $erreurs['email']="Email Invalide";
        if (champs_est_vide($message)) $erreurs['message']="Le message ne peut pas etre vide ";
        if(empty($erreurs)){
          try{
            $sql="INSERT INTO messages_contact (nom,email,message, date_envoi) VALUES (:nom,:email,:message, NOW())";
            $stmt=$bdd->prepare($sql);
            $stmt->execute(['nom'=>$nom,'email'=>$email,'message'=>$message]);
            $succes="Merci pour votre message, je vous reponds dans les plus brefs delais.";
            $nom=$email=$message="";
          }catch(Exception $e){
            $erreurs['global']="Une erreur est survenue lors de l'envoi du message. Veuillez réessayer plus tard.". $e->getMessage();
          }
         
        }
    }
    if($_SERVER["REQUEST_METHOD"]=="POST" && isset($_POST['submit_projet'])){
          if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        die("Erreur de sécurité : Jeton CSRF invalide.");
    }
        $nom_p=nettoyer($_POST['nom_p']??'');
        $email_p=nettoyer($_POST['email_p']??'');
        $service=nettoyer($_POST['service']??'');
        $besoin=nettoyer($_POST['besoin']??'');
        $deadline=nettoyer($_POST['deadline']??'');
        if(champs_est_vide($nom_p))$erreurs_projet['nom_p']="Veuillez entrer votre nom complet";
        if(!filter_var($email_p, FILTER_VALIDATE_EMAIL)) $erreurs_projet['email_p']="Email Invalide";
        if (champs_est_vide($service))$erreurs_projet['service']="veuillez choisir un service";
        if (champs_est_vide($besoin))$erreurs_projet['besoin']="veuillez decrire votre projet";
        if (champs_est_vide($deadline)) $erreurs_projet['deadline']="Veuillez indiquer une date";
        if(empty($erreurs_projet)){ 
            try{
                $sql="INSERT INTO demandes_projet (nom_p,email_p,type_projet,description,date_demande,deadline) VALUES (:nom_p,:email_p,:service,:besoin,NOW(),:deadline)";
                $stmt=$bdd->prepare($sql);
                $stmt->execute(['nom_p'=>$nom_p,'email_p'=>$email_p,'service'=>$service,'besoin'=>$besoin,'deadline'=>$deadline]);
                $succes_projet=true;
            }catch(Exception $e){
                $erreurs_projet['global']="Une erreur est survenue lors de l'envoi de votre demande. Veuillez réessayer plus tard.". $e->getMessage();
            }
            
        }
    }
    ?>
    <main>
        <h1>RESTONS EN CONTACT</h1>
        <section>
            <div class="contact-container">
                <div class="contact-info">
                    <h2>Mes Coordonnées</h2>
                    <div class="info-item">
                        <img src="./images/mail (1).jpg" alt="Email">
                        <p>souleymanefaye667@gmail.com</p>
                    </div>
                    <div class="info-item">
                        <img src="./images/phone.jpg" alt="Téléphone">
                        <p>+221 78 541 44 14</p>
                    </div>
                    <div class="info-item">
                        <img src="./images/insta.jpg" alt="Instagram">
                        <p>@souleymane_faye_</p>
                    </div>
                    <div class="info-item">
                        <img src="./images/th.jpg" alt="tiktok">
                        <p>@theyluv_souley</p>
                    </div>
                    <div class="info-item">
                        <img src="./images/snap.jpg" alt="snapchat">
                        <p>@sfaye4304</p>
                    </div>
                    <div class="info-item">
                        <img src="./images/linkedin.jpg" alt="linkedin">
                        <p>@ souleymane Faye</p>
                    </div>
                </div>
                <?php if (isset($succes)) echo "<p style='color: #00ffcc;'>$succes</p>"; ?>
                <?php if (isset($erreurs['global'])) echo "<p class='error'>" . $erreurs['global'] . "</p>"; ?>
                <form action="contact.php" method="POST" name="submit_message" action="contact.php">
                    <input type="hidden" name="csrf_token" value="<?php echo generer_token_csrf(); ?>">
                    <div class="form-group"><input type="text" placeholder="Votre nom complet" name="nom" value="<?php echo htmlspecialchars($nom); ?>">
                    <?php if(isset($erreurs['nom'])) echo "<span class = 'error'>".$erreurs['nom']."</span>"; ?>
                </div>
                    <div class="form-group"><input type="email" placeholder="Votre adresse mail"  name="email"  value= "<?php echo htmlspecialchars($email); ?>">
                <?php if(isset($erreurs['email'])) echo "<span class='error'>".$erreurs['email']."</span>"; ?>
                </div>
                    <div class="form-group"><textarea rows="4" placeholder="Votre message" name="message" ><?php echo htmlspecialchars($message); ?> </textarea>
                <?php if (isset($erreurs['message'])) echo "<span class= 'error'>".$erreurs['message']."</span>"; ?>
                </div>
                    <button type="submit" name="submit_message">ENVOYER</button>
                </form>
            </div>
        </section>
        <section class="card request-container">
            <h2 class="form-title">🚀 Me confier un projet</h2>
            <?php if (isset($erreurs_projet['global'])) echo "<p class='error'>" . $erreurs_projet['global'] . "</p>"; ?>
            <?php if ($succes_projet) :?>
                <div class= "success-box">
                <h3>Demande recue et enregistrée!</h3>
                <p>Voici le recapitulatif de votre besoin :</p>
                <ul>
                    <li><strong>email:</strong> <?php echo htmlspecialchars($email_p); ?></li>
                    <li><strong>Nom:</strong> <?php echo htmlspecialchars($nom_p); ?></li>
                    <li><strong>Service:</strong> <?php echo htmlspecialchars($service); ?></li>
                    <li><strong>Description:</strong><?php echo htmlspecialchars($besoin); ?></li>
                    <li><strong>Délai souhaité:</strong><?php echo htmlspecialchars($deadline); ?></li>
                    
                </ul>
                <p>Je reviens vers vous très prochainement.</p>
            </div>
            <?php endif;?>
              <form class="project-form"  action="contact.php" method="POST" name="submit_projet">
                <input type="hidden" name="csrf_token" value="<?php echo generer_token_csrf(); ?>">
             <div class="input-group">
                    <Label for="Nom">Votre nom complet :</Label>
                    <input type="text" id="nom_p" name="nom_p" value="<?php echo htmlspecialchars($nom_p); ?>">
                     <?php if(isset($erreurs_projet['nom_p'])) :?>
                        <span class="error"><?php echo $erreurs_projet['nom_p']; ?></span>
                        <?php endif; ?>
                </div>
                 <div class="input-group">
                    <label for="email_p">Votre adresse email :</label>
                    <input type="email" id="email_p" name="email_p" value="<?php echo htmlspecialchars($email_p); ?>">
                     <?php if(isset($erreurs_projet['email_p'])) :?>
                        <span class="error"><?php echo $erreurs_projet['email_p']; ?></span>
                        <?php endif; ?>
                </div>
              <div class="input-group">

                    <label for="service">Type de service recherché :</label>
                    <select id="service" name="service" >
                        <option value="web" <?php if($service=='web') echo 'selected';?>>Développement Web (HTML/CSS)</option>
                        <option value="app"  <?php if($service=='app') echo 'selected';?>>Application Desktop (Java/Python)</option>
                        <option value="arduino"<?php if($service=='arduino') echo 'selected';?>>Système Embarqué (Arduino)</option>
                        <option value="design"<?php if($service=='design') echo 'selected';?>>Design Graphique</option>
                        <option value="maintenance"<?php if($service=='maintenance') echo 'selected';?>>Maintenance & Supports </option>
                        <option value="initiation"<?php if($service=='initiation') echo 'selected';?>>Initiation Programmation</option>
                        <option value="algorithme"<?php if($service=='algorithme') echo 'selected';?>>Algorithmie</option>
                    </select>
                    <?php if(isset($erreurs_projet['service'])) :?>
                        <span class="error"><?php echo $erreurs_projet['service']; ?></span>
                        <?php endif; ?>
                </div>
               
                    <label for="besoin">Décrivez votre besoin :</label>
                    <textarea id="besoin" name="besoin" rows="4" 
                        placeholder="Ex: Je veux un site pour ma boutique..."> <?php echo htmlspecialchars($besoin ?? ''); ?></textarea>
                         <?php if(isset($erreurs_projet['besoin'])) :?>
                        <span class="error"><?php echo $erreurs_projet['besoin']; ?></span>
                        <?php endif; ?>
                </div>

                <div class="input-group">
                    <label for="deadline">Délai souhaité :</label>
                    <input type="date" id="deadline" name="deadline" value="<?php echo htmlspecialchars($deadline ?? ''); ?>">
                     <?php if(isset($erreurs_projet['deadline'])) :?>
                        <span class="error"><?php echo htmlspecialchars($erreurs_projet['deadline']); ?></span>
                        <?php endif; ?>
                </div>
                <button type="submit" class="submit-button" name="submit_projet">Envoyer la demande</button>
            </form>
        </section>
    </main>
   <?php require 'composants/pied-de-page.php'; ?>
</body>

</html>