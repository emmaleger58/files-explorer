<?php

include "header.php";

date_default_timezone_set('Europe/Paris'); //heure française

$home = "home";
  if (!is_dir($home)) {
    mkdir("home");
}

if (!isset($_POST["cwd"])) {
  $cwd = getcwd() . DIRECTORY_SEPARATOR . $home;
} else {
  $cwd = $_POST["cwd"];
}

chdir($cwd);

$all_contents = scandir($cwd);
$contents = [];
$contents_size = [];
$contents_date = [];
$contents_type = [];

foreach ($all_contents as $item) {
  if ($item !== "." && $item !== "..") {
    $contents[$item] = $item;
    $contents_date[$item] = filemtime($cwd . DIRECTORY_SEPARATOR . $item);
    if (is_dir($cwd . DIRECTORY_SEPARATOR . $item)) {
      $contents_size[$item] = "";
      $contents_type[$item] = "Folder";
    } else {
      $contents_size[$item] = filesize($cwd . DIRECTORY_SEPARATOR . $item);
      if (strpos($item, ".")) {
        $type = explode(".", $item);
        $contents_type[$item] = end($type);
      }
      else {
        $contents_type[$item] = "undefined";
      }
    }
  }
}

foreach ($all_contents as $item) {
  if ($item !== "." && $item !== "..") {
    $contents[$item] = $item;
  }
}

$breadcrumbs = explode(DIRECTORY_SEPARATOR, $cwd);
$cwd_road = "";

$is_home = false;

echo "<form id='changecwd' method='POST'></form>";
echo "<form id='sort' method='POST'></form>";

echo "<div class='container'>";
  echo "<div class='row'>";
    foreach ($breadcrumbs as $name) {
      $cwd_road .= $name . DIRECTORY_SEPARATOR;
      if ($name === $home) {
        $is_home = true;
      }
      if ($is_home) {
        echo "<div class='d-flex'>";
          echo "<button type='submit' form='changecwd' name ='cwd' value='" . substr($cwd_road, 0, -1) . "'>";
            echo $name;
          echo "</button>";
        echo "<input type='hidden' name='cwd' value='" . substr($cwd_road, 0, -1) . "'>";
        echo "</div>";
      }
    }
  echo "</div>";
echo "</div>";

  echo "<div class='container'>";
    echo "<div class='breadcrumb'>";
      echo "<div class='w-25'>";
        echo "<button type='submit' form='changecwd' name ='sort' value=''>";
          echo "Name";
        echo "</button>";
      echo "</div>";
      echo "<div class='w-25'>";
        echo "<button type='submit' form='changecwd' name ='sort' value=''>";
          echo "Date";
        echo "</button>";
      echo "</div>";
      echo "<div class='w-25'>";
        echo "<button type='submit' form='changecwd' name ='sort' value=''>";
          echo "Size";
        echo "</button>";
      echo "</div>";
      echo "<div class='w-25'>";
        echo "<button type='submit' form='changecwd' name ='sort' value=''>";
          echo "Type";
        echo "</button>";
    echo "</div>";
  echo "</div>";

foreach ($contents as $name) {
  echo "<div class='breadcrumb'>";
    echo "<div class='w-25'>";
      echo "<button type='submit' form='changecwd' name ='cwd' value='". $cwd . DIRECTORY_SEPARATOR . $name ."'>";
        echo $name;
      echo "</button>";
    echo "</div>";
    echo "<div class='w-25'>";
      echo date("d-m-Y H:i:s", $contents_date[$name]);
    echo "</div>";
    echo "<div class='w-25'>";
      echo $contents_size[$name];
    echo "</div>";
    echo "<div class='w-25'>";
      echo $contents_type[$name];
    echo "</div>";
  echo "</div>";
}





include "footer.php";
