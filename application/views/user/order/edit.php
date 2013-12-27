<?php $this->view('header'); ?>
<?php $this->view('user/sidebar'); ?>
<div class="span9">
	<table>
		<tr>
			<th>状态</th>
			<th>时间</th>
		</tr>
		<?php foreach($order['status'] as $status){ ?>
		<tr>
			<td><?=$status['name']?></td>
			<td><?=$status['date']?></td>
		</tr>
		<?php } ?>
	</table>
	
	<table>
		<?php foreach($order['meta'] as $meta){ ?>
		<tr>
			<td><?=$meta['key']?></td>
			<td><?=$meta['value']?></td>
		</tr>
		<?php } ?>
	</table>
</div>
<?php $this->view('footer'); ?>
