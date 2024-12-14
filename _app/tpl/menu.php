<div class="nav">
<?php
//dump($GLOBALS['menu']);

    $p = preg_replace("#(^|/)".INDEX."$#", '', ITEM);
    $p = ($p == '') ? '/' : "$p/";
    $p = str_replace('//', '/', $p);
//dump($p, '$p');

  foreach($GLOBALS['menu'] AS $key=>$name) {
    $class = ($p == $key) ? ' class="active"' : '';
//    $key = ($key == '/') ? '' : $key;
//dump($key, '$key');
//dump($class, '$class');
//    echo '    <a', $class, ' href="', URL, $key, '">', $name, '</a>', "\n";
    echo '    <a', $class, ' href="', $key, '">', $name, '</a>', "\n";

  }
?>
      <? if(is_logged()) { ?>
        <?= htmlspecialchars($_SESSION['username']) ?>
        <a href="?logout" class="no-decoration" title="Log out">&#9746;</a>
      <?} else {?>
        <? if(!@HIDE_LOGIN) { ?>
        <a href="?login">Sign in</a>
        <? } ?>
      <?}?>

</div>
