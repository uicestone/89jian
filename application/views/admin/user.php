<?php $this->view('header'); ?>
	<?php $this->view('admin/sidebar'); ?>
	<div id="right" class="span9">
		<div class="model">
			<div class="title"><h3><a href="/<?=uri_segment(1)?>/user">用户管理</a></h3></div>
			<div class="main">
				<a class="btn" href="/<?=uri_segment(1)?>/adduser">增加用户</a>
				<table class="table table-bordered">
					<thead>
						<tr><th>名称</th><th>电子邮件</th><th>组</th><th width="96px">&nbsp;</th></tr>
					</thead>
					<tbody>
						<?php foreach ($users as $user) { ?>								
							<tr> 
								<td><a href="/space/<?=$user['id']?>"><?=$user['name']?></a></td>
								<td><?=$user['email']?></td>
								<td><?=$user['group']?></td>
								<td>
									<a href="/admin/user/<?=$user['id']?>" class='btn btn-small'>编辑</a>
									<a href="/admin/finance?user=<?=$user['id']?>" class='btn btn-small'>财务</a>
								</td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
				<?=$pagination?>
			</div>
		</div>
	</div>
<?php $this->view('footer'); ?>