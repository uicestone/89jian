<?php $this->view('header'); ?>

	<div class="container main">
		<?php $this->view('user/sidebar'); ?>
		<form class="form">
			<div class="head"><?=end($this->page_path)['text']?></div>
			<div class="table-border">
				<table class="table">
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
						<?php foreach($orders['data'] as $order){ ?>
						<tr>
							<td><input type="checkbox" name="checked[]" value="<?=$order['id']?>"></td>
							<td><?=$order['id']?></td>
							<td><?=get_relative($order, 'package', 'name')?></td>
							<td><?=get_meta($order, '次数')?></td>
							<td><?=get_status($order, '下单')?></td>
							<td><?=get_status($order)?></td>
							<td><a href="/user/order/<?=$order['id']?>">详情</a></td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</form>
	</div>  
<?php $this->view('footer'); ?>
