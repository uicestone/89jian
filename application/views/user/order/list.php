<?php $this->view('header'); ?>

	<div class="container main">
		<?php $this->view('user/sidebar'); ?>
		<form class="form">
			<div class="head"><?=end($this->page_path)['text']?></div>
			<div class="table-border">
				<table>
					<thead>
						<tr>
							<th></th>
							<th>订单号</th>
							<th>套餐</th>
							<th>周数</th>
							<th>下单时间</th>
							<th>状态</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($orders as $order){ ?>
						<tr>
							<td><input type="checkbox" name="checked[]" value="<?=$order['id']?>"></td>
							<td><?=$order['num']?></td>
							<td><?=end($order['relative']['package'])['name']?></td>
							<td><?=end($order['meta']['次数'])?></td>
							<td><?=$order['status']['下单']?></td>
							<td><?=end(array_keys($order['status']))?></td>
							<td><a href="/user/order/<?=$order['id']?>">详情</a></td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</form>
	</div>  
<?php $this->view('footer'); ?>
