<?php $this->view('header'); ?>
	<?php $this->view('admin/sidebar'); ?>
	<div id="right" class="span9">
		<div class="model">
			<div class="title"><h3><a href="/admin/config">系统设置</a></h3></div>
			<div class="main">
				<table class="table table-bordered">
					<thead>
						<tr><th>键</th><th>值</th><th style="width: 4em;">&nbsp;</th></tr>
					</thead>
					<tbody>
						<?php foreach ($config_items as $key => $value) { ?>								
							<tr> 
								<td><?=$key?></td>
								<td><?=$value?></td>
								<td><a href="/admin/config/<?=$key?>" class="btn btn-small">编辑</a></td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
<?php $this->view('footer'); ?>