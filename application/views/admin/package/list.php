<?php $this->view('header'); ?>
	<div class="container main">
		<?php $this->view('admin/sidebar'); ?>
		<form class="form" method="post">
			<div class="head"><?=end($this->page_path)['text']?></div>
			<div class="row"><a href="/admin/package/add" class="btn">添加套餐</a></div>
			<div class="table-border">
				<table class="table">
					<tbody>
						<?php foreach($packages['data'] as $package){ ?>
						<tr>
							<td><a href="/package/<?=$package['id']?>" target="_blank"><?=$package['name']?></a></td>
							<td><?=get_tag($package, '价格档次')?>档</td>
							<td>¥<?=get_meta($package, '价格')?></td>
							<td><?=get_tag($package, '内容分类')?></td>
							<td><a href="/admin/package/<?=$package['id']?>">编辑</a></td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</form>
	</div>  
<?php $this->view('footer'); ?>
