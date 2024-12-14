<div class="breadcrumbs">

<?php
//$right_ico = '&#10148; ';
$right_ico = '&raquo;';

foreach ($GLOBALS['breadcrumbs'] as $i => $v) {
?>
  <?= $i ? $right_ico : '' ?>
  <a href="<?= URL ?><?= $v['url'] ?>"><?= $v['title'] ?></a>

<?php
  $i++;
}
?>

</div>
