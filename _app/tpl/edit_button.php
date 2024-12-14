<? if(is_logged()) { ?>
  <? if(MODE == 'show' && FOUND) { ?>
  <a href="<?= URL ?><?= ITEM ?>/?edit" title="Edit page">
    <img style="float:right; padding-top:1em;" src="<?= IMG ?>/edit.png" />
  </a>
  <? } ?>
<? } ?>
