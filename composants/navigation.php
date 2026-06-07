<?php

$page_courante = basename($_SERVER['PHP_SELF']);
?>

<nav class="navbar">
    <div class="nav-container" >
        <div style="font-weight:800; color:var(--primary); font-size: 1.2rem;">SF.DESIGN </div>
        <div  class="nav-links">
  <a href='index.php'
    <?php if ($page_courante === 'index.php') echo 'class="actif"'; ?>>
    Accueil
  </a>
  <a href='about.php'
    <?php if ($page_courante === 'about.php') echo 'class="actif"'; ?>>
    Parcours
  </a>
  <a href='projects.php'
    <?php if ($page_courante === 'projects.php') echo 'class="actif"'; ?>>
    Projets
  </a>
  
   <a href='video.php'
    <?php if ($page_courante === 'video.php') echo 'class="actif"'; ?>>
    Video
  </a>
   <a href='contact.php'
    <?php if ($page_courante === 'contact.php') echo 'class="actif"'; ?>>
    Contact
  </a>
  </div>
</div>
</nav>