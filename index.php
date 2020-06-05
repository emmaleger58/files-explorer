<?php

include 'header.php';

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

  // if (!file_exists("newfile.txt")) {
  // $myfile = fopen("newfile.txt", "w") or die("Unable to open file!"); // Si on utilise fopen avec un fichier qui n'existe pas, le fichier va être créé dans le même répertoire que le script qui lance la commande, si on uilise l'option "w" ou "a"
  // $txt = "John Doe\n";
  // fwrite($myfile, $txt);
  // $txt = "Jane Doe\n";
  // fwrite($myfile, $txt);
  // fclose($myfile);
  // } //[ne m'apporte rien pour l'instant]

  $url = getcwd(); //récupère le chemin du repertoire courant
  echo $url; //affiche le contenu de la variable $url
  $contents = scandir($url); //liste les éléments (dossiers et fichiers) du répertoire
  //echo $contents; //affiche le contenu de la variable $contents - [ne fonctionne pas car la fonction scandir renvoie un tableau]
?>

<table class="table table-sm table-hover">
  <thead>
    <tr>
      <th scope="col">Nom</th>
      <th scope="col">Taille</th>
      <th scope="col">Type</th>
      <th scope="col">Date modification</th>
    </tr>
  </thead>
  <tbody>

<?php

  foreach ($contents as $item) { //boucle foreach pour parcourir un tableau
    $size = filesize($item);
    $type = mime_content_type($item);
    $date = date(("d-m-Y H:i:s"),filemtime($item)); //initialise des variables (taille, type, date) qui récupère des informations pour chaque élément du tableau

    if (is_dir($item) == true) {
      echo "<br<tr><td><i class=\"far fa-folder\"></i><a href=\"$item\">$item</a><td>$size</td><td>$type</td><td>$date</td></tr>"; //affiche les variables pour les répertoires, dossiers
    }
    elseif (exif_imagetype($item)) {
      echo "<br<tr><td><i class=\"far fa-image\"></i><a href=\"$item\">$item</a><td>$size</td><td>$type</td><td>$date</td></tr>"; //affiche les variables pour les images
    }
    elseif (is_file($item) == true) {
      echo "<br<tr><td><i class=\"far fa-file\"></i><a href=\"$item\">$item</a><td>$size</td><td>$type</td><td>$date</td></tr>"; //affiche les variables pour les fichiers
    }
    else {
      echo "<br<tr><td><i class=\"far fa-question-circle\"></i><a href=\"$item\">$item</a><td>$size</td><td>$type</td><td>$date</td></tr>"; //affiche les variables pour les autres docs
    }
  } //fin foreach

?>

</tbody>
</table>
