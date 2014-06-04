<?php $this->view('header'); ?>
	<div class="container main">
		<?php $this->view('admin/sidebar'); ?>
		<form class="form" method="post">
			<div class="head"><?=end($this->page_path)['text']?></div>
			<div class="row">
				<a href="<?=site_url()?>admin/card/add" class="btn">添加卡片</a>
			</div>
			<div class="table-border">
				<table class="table">
					<thead>
						<tr>
							<th>卡号</th>
							<th>套餐</th>
							<th>次数</th>
							<th>操作</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($cards['data'] as $card){ ?>
						<tr>
							<td><?=$card['num']?></td>
							<td><?=get_meta($card, '套餐')?></td>
							<td><?=get_meta($card, '次数')?></td>
							<td><a href="/admin/card/<?=$card['id']?>">查看</a></td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</form>
	</div>  
<?php $this->view('footer'); ?>
