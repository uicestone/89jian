<?php $this->view('header'); ?>
<?php $this->view('admin/sidebar'); ?>
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
		<?php foreach($order['meta'] as $key => $value){ ?>
		<tr>
			<td><?=$key?></td>
			<td><?=implode(', ', $value)?></td>
		</tr>
		<?php } ?>
	</table>
</div>
<?php $this->view('footer'); ?>
