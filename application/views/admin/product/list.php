<?php $this->view('header'); ?>
	<div class="container main">
		<?php $this->view('admin/sidebar'); ?>
		<form class="form" method="post">
			<div class="head"><?=end($this->page_path)['text']?></div>
			<div class="row"><a href="/admin/product/add" class="btn">添加产品</a></div>
			<div class="table-border">
				<table class="table">
					<tbody>
						<?php foreach($products['data'] as $product){ ?>
						<tr>
							<td><a href="/product/<?=$product['id']?>" target="_blank"><?=$product['name']?></a></td>
							<td><a href="/admin/product/<?=$product['id']?>">编辑</a></td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</form>
	</div>  
<?php $this->view('footer'); ?>
