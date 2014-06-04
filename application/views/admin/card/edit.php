<?php $this->view('header'); ?>
	<div class="container main">
		<?php $this->view('admin/sidebar'); ?>
		<form class="form form-horizontal" method="post">
			<div class="head"><?=end($this->page_path)['text']?></div>
			<?php if(isset($card)){ ?>
			<div class="table-border">
				<table class="table">
					<tbody>
						<?php foreach($card['meta'] as $key => $value){ ?>
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
					<thead>
						<tr>
							<th>状态</th>
							<th>时间</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($card['status'] as $name => $date){ ?>
						<tr>
							<td><?=$name?></td>
							<td><?=implode(', ', $date)?></td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
			<?php }else{ ?>
			<div class="control-group">
				<label class="control-label">
					卡号：
				</label>
				<div class="controls">
					<input type="text" name="num">
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">
					密码：
				</label>
				<div class="controls">
					<input type="text" name="code">
				</div>
			</div>
			<?php } ?>
			<?php if(!isset($card) || get_meta($card, '已激活') !== '是'){ ?>
			<div class="control-group">
				<label class="control-label">
					绑定套餐：
				</label>
				<div class="controls">
					<select name="package"><?=options(array_column($packages['data'], 'name', 'id'), isset($card) ? get_relative($card, 'package', 'id') : '', '未绑定', true, false, false)?></select>
					数量：
					<input type="number" name="amount" value="<?=set_value('amount', isset($card) ? get_meta($card, '次数') : '')?>">
				</div>
			</div>
			<?php } ?>
			<div class="control-group">
				<div class="controls">
					<button type="submit" name="submit" class="btn">保存</button>
				</div>
			</div>
		</form>
	</div>  

<?php $this->view('footer'); ?>
