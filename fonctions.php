<?php 
function nettoyer($données){
    $données= trim($données);
    $données=stripslashes($données);
    $données= htmlspecialchars($données);
    return $données;
}
function champs_est_vide($valeur){
    return empty(trim($valeur));
}
?>