<?php

$id = $_SERVER['REQUEST_URI'];
$id = preg_replace('/\?.*$/', '', $id);
$id = ltrim($id, '/');
$id = substr($id, strlen(URL));
$id = explode('/', $id);
$id = $id[0];

$host = strtolower($_SERVER['HTTP_HOST']);

if($host=='drkb.ru' || $host=='www.drkb.ru') {
} else {
//  header("HTTP/1.0 404 Not Found");
//  exit;
}

$id = preg_replace("/\.\w+$/",'',$id);

if($id=='index') $id = '';

//DEBUG
//echo "<pre>";
//print_r($_SERVER);
//echo "URL=",URL,"\n";
//echo "id=",$id,"\n";
//echo "</pre>";

?>
  <link rel="stylesheet" href="<?= CSS ?>/tree.css">

<div>
    <h1>Page Tree</h1>

    <p>
        <a href="javascript:;" onclick="tree_open_all();">
            <i class="fa fa-folder-open fa-2x"></i>
            Раскрыть все
        </a>
    </p>

    <br>

    <div>
