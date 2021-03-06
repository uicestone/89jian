<?php $this->view('header'); ?>

	<div class="container main">
		<?php $this->view('admin/sidebar'); ?>
		<form class="form">
			<div class="head"><?=end($this->page_path)['text']?></div>
			<div class="row"><button class="btn">增加新用户</button></div>
			<div class="table-border">
				<table class="table">
					<thead>
						<tr><th>名称</th><th>电子邮件</th><th style="width:45%">组</th><th style="width:65px">操作</th></tr>
					</thead>
					<tbody>
						<?php foreach ($users['data'] as $user) { ?>								
						<tr> 
							<td><?=$user['name']?></td>
							<td><?=$user['email']?></td>
							<td><?=$user['roles']?></td>
							<td>
								<a href="/admin/user/<?=$user['id']?>" class="btn btn-small">编辑</a>
							</td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</form>
	</div>  

<?php $this->view('footer'); ?>