<?php $this->view('header'); ?>
<div class="container" style="padding:30px">
<?php foreach($packages['data'] as $package){ ?>
	<div style="display:inline-block;vertical-align:top;border:3px #1e2f36 double;padding:30px;margin:20px">
		<h1><?=$package['name']?></h1>
		<div class="text-right"><?=get_tag($package, '内容分类')?> ¥<?=get_meta($package, '价格')?></div>
		<hr>
		<div><?=get_meta($package, '组成')?></div>
	</div>
<? } ?>
</div>
<?php $this->view('footer'); ?>