  <?php
include('function_size.php');
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

  if (isset($_POST['selected'])) {
    $selected = $_POST['selected'];
    if (chdir($selected)) {
    chdir($selected);
  }
    else {
    chdir(getcwd());
    }
  } //pour pouvoir entrer dans un dossier

  $url = getcwd(); //récupère le chemin du repertoire courant

  // if(!empty($_POST['envoyer'])){
  //   $new_dir = $_POST["new_dir"];
  //   if (!file_exists($selected . "/" . $new_dir)) {
  //     mkdir($selected . "/" . $new_dir, 0777, true);
  //   }
  // } //créer un dossier

// This function will take $_SERVER['REQUEST_URI'] and build a breadcrumb based on the user's current path
function breadcrumbs($separator = ' &raquo; ', $home = 'Home') {
    // This gets the REQUEST_URI (/path/to/file.php), splits the string (using '/') into an array, and then filters out any empty values
    $path = array_filter(explode('/', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)));
    // This will build our "base URL" ... Also accounts for HTTPS :)
    $base = (isset($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/';
    // Initialize a temporary array with our breadcrumbs. (starting with our home page, which I'm assuming will be the base URL)
    $breadcrumbs = Array("<a href=\"$base\">$home</a>");
    // Find out the index for the last value in our path array
    $pathkeys = array_keys($path);
    $last = end($pathkeys);
    // Build the rest of the breadcrumbs
    foreach ($path AS $x => $crumb) {
        // Our "title" is the text that will be displayed (strip out .php and turn '_' into a space)
        $title = ucwords(str_replace(Array('.php', '_'), Array('', ' '), $crumb));
        // If we are not on the last index, then display an <a> tag
        if ($x != $last)
            $breadcrumbs[] = "<a href=\"$base$crumb\">$title</a>";
        // Otherwise, just display the title (minus)
        else
            $breadcrumbs[] = $title;
    }
    // Build our temporary array (pieces of bread) into one big string :)
    return implode($separator, $breadcrumbs);
}
?>
<p><?= breadcrumbs() ?></p>

<?php
  $contents = scandir($url); //liste les éléments (dossiers et fichiers) du répertoire
?>

<table class="table table-sm table-hover">
  <thead>
    <tr>
      <th width="33%" scope="col">Nom</th>
      <th width="33%" scope="col">Modifié le</th>
      <th width="17%" scope="col">Type</th>
      <th width="17%" scope="col">Taille</th>
    </tr>
  </thead>
  <tbody>

<?php

  foreach ($contents as $item) { //boucle foreach pour parcourir un tableau
    $size = formatSizeUnits(filesize($item));
    $type = mime_content_type($item);
    $date = date(("d-m-Y H:i:s"),filemtime($item)); //initialise des variables (taille, type, date) qui récupère des informations pour chaque élément du tableau

    if (is_dir($item) == true) {
      $path2 = realpath($item);
      echo "<form method='POST'><input type='hidden' name='selected'><a href=".$path2."><button type='submit'>".$item."</button></a></form>";


        echo "<br<tr><td><i class=\"far fa-image\"></i><a href=\"$item\">$item</a><td>$date</td><td>$type</td><td>$size</td></tr>"; //affiche les variables pour les images

      // echo "<tr><td><i class=\"far fa-folder\"><form method='POST'><input type='hidden' name='selected' value=''".realpath($item)."><a href=".realpath($item)."><button type='submit'>".$item."</button></a></form><td>$date</td><td>$type</td><td>$size</td></tr>"; //affiche les variables pour les répertoires, dossiers
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

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
  <input type="text" name="new_dir" placeholder="">
  <input type="submit" id="envoyer" name="envoyer" value="Créer un dossier">
</form>

</tbody>
</table>
</body>
