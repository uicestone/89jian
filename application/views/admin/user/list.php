<?php $this->view('header'); ?>
<?php $this->view('admin/sidebar'); ?>
<div class="span9">
	<table class="table table-bordered">
		<thead>
			<tr><th>名称</th><th>电子邮件</th><th>组</th><th></th></tr>
		</thead>
		<tbody>
			<?php foreach ($users['data'] as $user) { ?>								
			<tr> 
				<td><a href="/space/<?=$user['id']?>"><?=$user['name']?></a></td>
				<td><?=$user['email']?></td>
				<td><?=$user['group']?></td>
				<td>
					<a href="/admin/user/<?=$user['id']?>" class="btn btn-small">编辑</a>
				</td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
</div>
<?php $this->view('footer'); ?>