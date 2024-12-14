<?= tpl('header') ?>

<?= tpl('site_header') ?>

<?= tpl('message') ?>

<div class="main">
	<div class="article">
		<?= tpl('edit_button') ?>

		<?= tpl('article_header') ?>

		<?= content() ?>
	</div>

	<?= tpl('sidebar') ?>

</div>

<?= tpl('footer') ?>
