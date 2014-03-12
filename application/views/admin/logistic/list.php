<?php $this->view('header'); ?>
	<div class="container main">
		<?php $this->view('admin/sidebar'); ?>
		<form class="form" method="post">
			<div class="head"><?=end($this->page_path)['text']?></div>
			<?php $this->view('alert'); ?>
			<div class="table-border">
				<table class="table">
					<thead>
						<tr>
							<th>包裹内容</th>
							<th>发货日期</th>
							<th>状态</th>
							<th>物流</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($meals['data'] as $meal){ ?>
						<tr>
							<td>
								<input type="checkbox" name="checked[]" value="<?=$meal['id']?>">
								<a href="/admin/logistic/<?=$meal['id']?>"><?=get_relative($meal,'user', 'name')?> 的 <?=get_relative($meal, 'package', 'name')?></a>
							</td>
							<td><?=get_meta($meal, '送货日期')?></td>
							<td><?=get_status($meal)?></td>
							<td>
							  <?php if(get_meta($meal, '物流供应商')){ ?>
							  <?=get_meta($meal, '物流供应商')?>
							  <?php }else{ ?>
							  <select name="logistic_provider[<?=$meal['id']?>]" style="width: auto;"><?=options($this->company->config('物流供应商'), null, '供应商')?></select>
							  <?php } ?>
							  <?php if(get_meta($meal, '物流单号')){ ?>
							  <?=get_meta($meal, '物流单号')?>
							  <?php }else{ ?>
							  <input type="text" name="logistic_number[<?=$meal['id']?>]" placeholder="单号" style="width: 150px" />
							  <?php } ?>
							  </td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
			<button name="assign" class="btn">配货</button>
			<button name="deliver" class="btn">发货</button>
		</form>
	</div>  
<?php $this->view('footer'); ?>