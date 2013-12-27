<?php $this->view('header'); ?>
<?php $this->view('admin/sidebar'); ?>
<div class="span9">
	<table class="table table-bordered">
		<thead>
			<tr><th>键</th><th>值</th><th style="width: 4em;">&nbsp;</th></tr>
		</thead>
		<tbody>
			<?php foreach ($items as $key => $value) { ?>								
			<tr> 
				<td><?=$key?></td>
				<td><?=$value?></td>
				<td><a href="/admin/config/<?=$key?>" class="btn btn-small">编辑</a></td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
</div>
<?php $this->view('footer'); ?>