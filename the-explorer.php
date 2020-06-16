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

if (!isset($_POST["sort"])) {
  $sort_by = "name";
} else {
  $sort_by = $_POST["sort"];
}

if (!isset($_POST["sort_order"])) {
  $sort_order = "up";
} else {
  if ($_POST["sort_order" === "up"]) {
  $sort_order = "down";
  } else {
    $sort_order = "up";
  }
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
      if (strpos(substr($item), ".")) {
        $type = explode(".", $item);
        $contents_type[$item] = end($type);
      }
      else {
        $contents_type[$item] = "undefined";
      }
    }
  }
}

if ($sort_by === "date") {
  $sorted_contents = $contents_date;
  asort($sorted_contents);
} elseif ($sort_by === "size") {
  $sorted_contents = $contents_size;
  asort($sorted_contents);
} elseif ($sort_by === "type") {
  $sorted_contents = $contents_type;
  natcasesort($sorted_contents);
} else {
  $sorted_contents = $contents;
  natcasesort($sorted_contents);
}

if ($sort_order === "down") {
  $keys = [];
  $values = [];
  $reversed = [];

  foreach ($sorted_contents as $key => $value) {
    array_push($keys, $key);
    array_push($values, $value);
  }

  for ($i=count($keys)-1; $i >= 0 ; $i--) {
    $reversed[$keys[$i]] = $values[$i];
  }

  $sorted_contents = &$reversed;
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

echo "<form id='sort' method='POST'>";
  echo "<input type='hidden' name='cwd' value='$cwd'>";
  echo "<input type='hidden' name='sort_order' value='$sort_order'>";
echo "</form>";

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
        echo "<button type='submit' form='changecwd' name ='sort' value='name'>";
          echo "Name";
        echo "</button>";
      echo "</div>";
      echo "<div class='w-25'>";
        echo "<button type='submit' form='changecwd' name ='sort' value='date'>";
          echo "Date";
        echo "</button>";
      echo "</div>";
      echo "<div class='w-25'>";
        echo "<button type='submit' form='changecwd' name ='sort' value='size'>";
          echo "Size";
        echo "</button>";
      echo "</div>";
      echo "<div class='w-25'>";
        echo "<button type='submit' form='changecwd' name ='sort' value='type'>";
          echo "Type";
        echo "</button>";
    echo "</div>";
  echo "</div>";

foreach ($sorted_contents as $name => $value) {
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
