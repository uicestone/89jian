<?php $this->view('header'); ?>

	<div class="container main">
		<?php $this->view('user/sidebar'); ?>
		<form class="form">
			<div class="head">我的订单</div>
			<?php if(!in_array('支付完成', array_column($order['status'], 'name'))){ ?>
			<a href="<?=site_url()?>buy/pay/<?=$order['id']?>" class="btn">去支付宝支付</a>
			<hr>
			<?php } ?>
			<div class="table-border">
				<table class="table">
					<thead>
						<tr>
							<th>状态</th>
							<th>时间</th>
							<th>备注</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($order['status'] as $status){ ?>
						<tr>
							<td><?=$status['name']?></td>
							<td><?=$status['date']?></td>
							<td><?=$status['comment']?></td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>

			<div class="table-border">
				<table class="table">
					<tbody>
						<?php foreach($order['meta'] as $key => $value){ ?>
						<tr>
							<td><?=$key?></td>
							<td><?=implode(', ',$value)?></td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</form>
	</div>  
<?php $this->view('footer'); ?>
