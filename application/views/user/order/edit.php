<?php $this->view('header'); ?>

	<div class="container main">
		<?php $this->view('user/sidebar'); ?>
		<form class="form">
			<div class="head">我的订单</div>
			<div class="table-border">
				<table>
					<thead>
						<tr>
							<th>状态</th>
							<th>时间</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($order['status'] as $status => $date){ ?>
						<tr>
							<td><?=$status?></td>
							<td><?=$date?></td>
						</tr>
						<?php } ?>
					</tbody>
				</table>

				<table>
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
