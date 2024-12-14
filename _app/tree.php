<?php

session_start();

require_once ('lib/functions.php');

init(__FILE__);

define('BASE_DIR', URL);
//dump(BASE_DIR, 'BASE_DIR');

//dump(URL, 'URL');
//dump(DIR, 'DIR');
//dump(APP_DIR, 'APP_DIR');

global $sitemap;

//----------------------------------------------------
//Check the last-modified-date of the data file
$file = DATA_DIR . '/sitemap.json';
//dump($file, '$file');

check_modified($file);

//dump(URL, 'URL');
//dump(date("d.m.Y H:i:s", $last_modified) . '(' . $last_modified . ')', 'Last modified');
//dump(@$_SERVER['HTTP_IF_MODIFIED_SINCE'], '$_SERVER[HTTP_IF_MODIFIED_SINCE]');

$sitemap = json_load($file);
//dump($sitemap, '$sitemap');

// Remove the items used in Menu
foreach($GLOBALS['menu_items'] as $k=>$v) {
//dump($k, '$k');
//dump($v, '$v');
    if($v <> '/') {
        $id = get_index($v);
//dump($id, '$id');
        if(!($id === false)) {
            unset($sitemap[$id]);
        }
    }
}
//dump($sitemap, '$sitemap');
//exit;

?>

<?=tpl('header') ?>

<?= tpl('tree_start') ?>


<?php
show_tree();

//dump($array, '$array');
//exit;

?>

<?= tpl('tree_stop') ?>
