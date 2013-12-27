<?php $this->view('header'); ?>
<?php $this->view('admin/sidebar'); ?>
<div class="span9">
	<table class="table table-bordered">
		<tr>
			<th>套餐</th>
			<th>用户</th>
			<th>发货日期</th>
			<th>状态</th>
			<th></th>
		</tr>
		<?php foreach($meals['data'] as $meal){ ?>
		<tr>
			<td><?=end($meal['relative']['package'])['name']?></td>
			<td><?=end($meal['relative']['user'])['name']?></td>
			<td><?=end($meal['meta']['delivery'])?></td>
			<td><?=end($meal['status'])['name']?></td>
			<td><a href="/admin/logistic/<?=$meal['id']?>">详情</a></td>
		</tr>
		<?php } ?>
	</table>
</div>
<?php $this->view('footer'); ?>