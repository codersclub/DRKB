<table class="prev_next container">
  <tr>
  <td style="width:45%; text-align:left;">
    Previous page:
    <br>
<? if (@$GLOBALS['prev'] > 0) { ?>
    <a href="<?= URL . $sitemap[$GLOBALS['prev']]['url'] ?>">
      <?= $sitemap[$GLOBALS['prev']]['title'] ?>
    </a>
<? } ?>
  </td>
  <td style="width:10%; text-align:center;">
    Top:<br>
    <a href="<?= URL ?>/">
      <?= HOME_TITLE ?>
    </a>
  </td>
  <td style="width:45%; text-align:right;">
    Next page:<br>
<? if ($GLOBALS['next']) { ?>
    <a href="<?= URL . $sitemap[$GLOBALS['next']]['url'] ?>">
      <?= $sitemap[$GLOBALS['next']]['title'] ?>
    </a>
<? } ?>
  </td>
  </tr>
</table>
