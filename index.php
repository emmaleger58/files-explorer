  <?php

include('header.php');
echo "<body>";

  date_default_timezone_set('Europe/Paris'); //heure française

  $count = 0;
  while ($count <= 10) {
    $myfile = fopen("newfile".$count.".txt", "w") or die("Unable to open file!");
    $txt = "John Doe\n";
    fwrite($myfile, $txt);
    $txt = "Jane Doe\n";
    fwrite($myfile, $txt);
    fclose($myfile);
    $count++;
  } //création de 10 fichiers identiques automatiquement


  $url = getcwd(); //récupère le chemin du repertoire courant
  echo $url; //affiche le contenu de la variable $url
  $contents = scandir($url); //liste les éléments (dossiers et fichiers) du répertoire
?>

<table class="table table-sm table-hover">
  <thead>
    <tr>
      <th width="33%" scope="col">Nom</th>
      <th width="33%" scope="col">Modifié le</th>
      <th width="17%" scope="col">Type</th>
      <th width="17%" scope="col">Taille (bytes)</th>
    </tr>
  </thead>
  <tbody>

<?php

  foreach ($contents as $item) { //boucle foreach pour parcourir un tableau
    $size = filesize($item);
    $type = mime_content_type($item);
    $date = date(("d-m-Y H:i:s"),filemtime($item)); //initialise des variables (taille, type, date) qui récupère des informations pour chaque élément du tableau

    if (is_dir($item) == true) {
      echo "<tr><td><i class=\"far fa-folder\"></i><a href=\"$item\">$item</a><td>$date</td><td>$type</td><td>$size</td></tr>"; //affiche les variables pour les répertoires, dossiers
    }
    elseif (isset($type) && in_array($type, array("image/png", "image/jpeg", "image/jpg", "image/gif"))) {
    //echo 'This is an image file'
    echo "<br<tr><td><i class=\"far fa-image\"></i><a href=\"$item\">$item</a><td>$date</td><td>$type</td><td>$size</td></tr>"; //affiche les variables pour les images
    }
    elseif (is_file($item) == true) {
      echo "<br<tr><td><i class=\"far fa-file\"></i><a href=\"$item\">$item</a><td>$date</td><td>$type</td><td>$size</td></tr>"; //affiche les variables pour les fichiers
    }
    else {
      echo "<br<tr><td><i class=\"far fa-question-circle\"></i><a href=\"$item\">$item</a><td>$date</td><td>$type</td><td>$size</td></tr>"; //affiche les variables pour les autres docs
    }
  } //fin foreach



?>

</tbody>
</table>
</body>
