<?php 
function nettoyer($données){
    $données= trim($données);
    $données=stripslashes($données);
    $données= htmlspecialchars($données);
    return $données;
}
function champs_est_vide($valeur){
    return empty(trim($valeur));}
function enregistrer_visite($bdd){
    if(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
        $adresse_ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $adresse_ip = $_SERVER['REMOTE_ADDR'];
    }
    if(strpos($adresse_ip, ',') !== false){
        $adresse_ip = explode(',', $adresse_ip)[0];
        $page= $_SERVER['PHP_SELF'];
        $sql="INSERT INTO visites (adresse_ip,page,date_visite) VALUES (:adresse_ip,:page,NOW())";
        $stmt=$bdd->prepare($sql);
        $stmt->execute(['adresse_ip'=>$adresse_ip,'page'=>$page]);
    }}
   function generer_token_csrf(){
    if(empty($_SESSION['csrf_token'])){
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}
?>
