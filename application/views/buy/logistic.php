<?php $this->view('header'); ?>
<div class="article-page">
	<h1>订单详情</h1>
	<div class="table-border" style="width:400px">
		<table class="table">
			<tbody>
				<tr>
					<td>套餐</td>
					<td><?=get_relative($order, 'package')?></td>
				</tr>
				<?php foreach($order['meta'] as $key => $value){ ?>
				<?php if(in_array($key, array('收货人','联系电话','收货地址','邮编'))){ break; }?>
				<tr>
					<td><?=$key?></td>
					<td><?=implode(', ',$value)?></td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
	
	<hr>
	
	<h1>收货信息</h1>
	<form method="post" class="form form-horizontal">
		
		<div class="control-group">
			<div class="control-label">收货人： </div>
			<div class="controls">
				<input type="text" name="meta[收货人]" value="<?=set_value('meta[收货人]', get_meta($order, '收货人'))?>" />
			</div>
		</div>
		<div class="control-group">
			<div class="control-label">联系电话：</div>
			<div class="controls">
				<input type="text" name="meta[联系电话]" value="<?=set_value('meta[联系电话]', get_meta($order, '联系电话'))?>" />
			</div>
		</div>
		<div class="control-group">
			<div class="control-label">收货地址：</div>
			<div class="controls">
				<input type="text" name="meta[收货地址]" value="<?=set_value('meta[收货地址]', get_meta($order, '收货地址'))?>" />
			</div>
		</div>
		<div class="control-group">
			<div class="control-label">邮编：</div>
			<div class="controls">
				<input type="text" name="meta[邮编]" value="<?=set_value('meta[邮编]', get_meta($order, '邮编'))?>" />
			</div>
		</div>
		<div class="control-group">
			<div class="controls">
				<button type="submit" name="next" class="btn">去支付宝支付</button>
				<button type="submit" name="cancel" class="btn">放弃此订单</button>
			</div>
		</div>
	</form>
</div>
<?php $this->view('footer'); ?>
