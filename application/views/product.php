<?php $this->view('header'); ?>
<div class="setfood article-page" id="setfood">
	<h3 class="title text-center">单品食材</h3>
	<div class="others">
		<ul class="selections">
			<?php foreach ($products['data'] as $product) { ?>
				<li class="item">
					<div class="title">
						<div class="spell"><?= get_meta($product, '英文名称') ?></div>
						<div class="name"><?= $product['name'] ?></div>
					</div>
					<a href="/product/<?= $product['id'] ?>"><img src="<?=site_url()?>/img/<?= get_meta($product, '缩略图') ?>" alt="<?= $product['name'] ?>"></a>
				</li>
			<?php } ?>
		</ul>
	</div>
</div>
<?php $this->view('footer'); ?>
