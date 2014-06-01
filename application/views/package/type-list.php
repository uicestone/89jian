<?php $this->view('header'); ?>
<?php foreach($packages['data'] as $package){ ?>
<div>
	<h1><?=$package['name']?></h1>
	<div><?=get_meta($package, '组成')?></div>
</div>
<? } ?>
<?php $this->view('footer'); ?>