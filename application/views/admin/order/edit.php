<?php $this->view('header'); ?>
	<div class="container main">
		<?php $this->view('admin/sidebar'); ?>
		<form method="post" class="form">
			<div class="head"><?=end($this->page_path)['text']?></div>
			<div class="table-border">
				<table class="table">
					<thead>
						<tr>
							<th>状态</th>
							<th>时间</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($order['status'] as $name => $date){ ?>
						<tr>
							<td><?=$name?></td>
							<td><?=implode(', ', $date)?></td>
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
							<td><?=implode(', ', $value)?></td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
			<div class="table-border">
				<table class="table">
					<tbody>
						<?php foreach($order['relative'] as $relation => $relative){ ?>
						<tr>
							<td><?=$relation?></td>
							<td><a href="<?=$relative[0]['name']?>"><?=$relative[0]['name']?></td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
			
			<?php if(get_meta($order, '是否卡片') === '是'){ ?>
			<?php	 if(!get_relative($order, 'card')){ ?>
			<div class="well well-small">
				该订单尚未关联到卡片
			</div>
			<?php	}else{ ?>
			卡片发送信息：<input type="text" name="card_delivery_comment">
			<button type="submit" name="deliver_card" class="btn">发卡</button>
			<?php	} ?>
			<?php } ?>
			
		</form>
	</div>  

<?php $this->view('footer'); ?>
