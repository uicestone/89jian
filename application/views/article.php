<?php $this->view('header'); ?>
<div class="article-page">
	<h1><?=$article['name']?></h1>
	<?=end($article['meta']['内容'])?>
</div>
<?php $this->view('footer'); ?>