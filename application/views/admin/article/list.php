<?php $this->view('header'); ?>
	<div class="container main">
		<?php $this->view('admin/sidebar'); ?>
		<form class="form" method="post">
			<div class="head"><?=end($this->page_path)['text']?></div>
			<div class="row"><a href="/admin/article/add" class="btn">添加文章</a></div>
			<div class="table-border">
				<table class="table">
					<tbody>
						<?php foreach($articles['data'] as $article){ ?>
						<tr>
							<td><a href="/article/<?=$article['id']?>" target="_blank"><?=$article['name']?></a></td>
							<td><a href="/admin/article/<?=$article['id']?>">编辑</a></td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</form>
	</div>  
<?php $this->view('footer'); ?>
