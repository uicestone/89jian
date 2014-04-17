<?php $this->view('header'); ?>
	<div class="container main">
		<?php $this->view('user/sidebar'); ?>
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
								<?=get_relative($meal,'user', 'name')?> 的 <?=get_relative($meal, 'package', 'name')?>
							</td>
							<td><?=get_meta($meal, '送货日期')?></td>
							<td><?=get_status($meal)?></td>
							<td><?=get_meta($meal, '物流供应商')?> <?=get_meta($meal, '物流单号')?></td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</form>
	</div>  
<?php $this->view('footer'); ?>