<?php
  session_start();
  session_unset();
  session_destroy(); 
  echo '<p>Vous avez été déconnecté</p>';
  echo '<a href="connexion.php">Retourner a la page de connexion</a>';
?>