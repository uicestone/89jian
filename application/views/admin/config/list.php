<?php $this->view('header'); ?>
	<div class="container main">
		<?php $this->view('admin/sidebar'); ?>
		<form class="form" method="post">
			<div class="head"><?=end($this->page_path)['text']?></div>
			<div class="table-border">
				<table class="table">
					<thead>
						<tr><th>键</th><th>值</th></tr>
					</thead>
					<tbody>
						<?php foreach ($items as $key => $value) { ?>								
						<tr> 
							<td><a href="/admin/config/<?=$key?>"><?=$key?></a></td>
							<td><?=is_string($value) ? $value : json_encode($value, JSON_UNESCAPED_UNICODE)?></td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</form>
	</div>  
<?php $this->view('footer'); ?>