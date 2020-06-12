<?php

$url = getcwd(); //récupère le chemin du repertoire courant
echo $url;

$contents = scandir($url); //liste les éléments (dossiers et fichiers) du répertoire

  foreach ($contents as $item) {
    if (is_dir($item)) {
      echo "<br><a href=''>".$item."</a>";


    }

  }



 ?>
