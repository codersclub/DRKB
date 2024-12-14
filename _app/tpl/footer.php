<?= tpl('prev_next') ?>

<div class="footer">
    <div class="footer_inner">
        <span style="display:inline-block; float:right;">
            Powered by <?= ENGINE ?> v.<?= VERSION ?>,
            Ex.time: <?= round(microtime(TRUE) - _START_, 5) ?>s.
        </span>

  	<nobr>Copyright &copy; 2001-<?= date('Y'); ?></nobr>,
        <a href="<?= COPYRIGHT_URL ?>"><?= COPYRIGHT ?></a>
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
