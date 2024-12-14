<h1><?= $GLOBALS['meta']['title'] ?></h1>

<?php

$published = '';

if(!empty($GLOBALS['meta']['date'])) {
   $published .= '<label>Дата:</label> ' . $GLOBALS['meta']['date'];
}

if(!empty($GLOBALS['meta']['author'])) {
   if(!empty($published)) {
     $published .= "  \n";
   }
   $published .= '<label>Автор:</label> ' . $GLOBALS['meta']['author'];
}

if(!empty($published)) {
  echo "\n<div class=\"date\">\n" . markdown($published) . "</div>\n";
}
