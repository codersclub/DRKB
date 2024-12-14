<table class="prev_next">
  <tr>
  <td style="width:45%; text-align:left;">
    Previous page:<br>
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

<div class="footer">
    <div class="footer_inner">
        <span style="display:inline-block; float:right;">
            Powered by <?= ENGINE ?> v.<?= VERSION ?>,
            Ex.time: <?= round(microtime(TRUE) - _START_, 5) ?>s.
        </span>

  	<nobr>Copyright &copy; 2001-<?= date('Y'); ?></nobr>,
        <a href="<?= URL ?>/" title="My site description">mysite.tld</a>
        All rights reserved. 
    </div>
</div>


<link rel="stylesheet" href="<?= APP ?>/js/prettify/prettify.css" type="text/css" media="all">
<script type="text/javascript" src="<?= APP ?>/js/prettify/prettify.min.js"></script>

<script type="text/javascript">
  prettyPrint();
</script>


</body>
</html>
