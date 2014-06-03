<?php $this->view('header'); ?>
<div class="article-page" style="padding:0">
	<div class="price-tag">
		<a href="<?=site_url()?>package/A"><img src="<?=site_url()?>img/package-A.jpg" alt="套餐A"></a>
	</div>
	<hr>
	<div class="price-tag">
		<a href="<?=site_url()?>package/B"><img src="<?=site_url()?>img/package-B.jpg" alt="套餐B"></a>
	</div>
	<hr>
	<div class="price-tag">
		<a href="<?=site_url()?>package/C"><img src="<?=site_url()?>img/package-C.jpg" alt="套餐C"></a>
	</div>
</div>
<?php $this->view('footer'); ?>