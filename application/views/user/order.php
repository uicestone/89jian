<?php $this->view('header'); ?>
<?php $this->view('user/sidebar'); ?>
<div class="span9">
	<table>
		<tr>
			<th>订单号</th>
			<th>订单名称</th>
			<th>状态</th>
			<th></th>
		</tr>
		<?php foreach($orders as $order){ ?>
		<tr>
			<td><?=$order['num']?></td>
			<td><?=$order['name']?></td>
			<td><?=array_shift($order['status'])['name']?></td>
			<td><a href="/user/order/<?=$order['id']?>">订单详情</a></td>
			
		</tr>
		<?php } ?>
	</table>
</div>
<?php $this->view('footer'); ?>
