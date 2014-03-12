<?php $this->view('header'); ?>
	<div class="container main">
		<?php $this->view('admin/sidebar'); ?>
		<form class="form" method="post">
			<div class="head"><?=end($this->page_path)['text']?></div>
			<div class="table-border">
				<table class="table">
					<thead>
						<tr>
							<th>账号</th>
							<th>套餐</th>
							<th>次数</th>
							<th>剩余</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($cards['data'] as $card){ ?>
						<tr>
							<td><a href="/admin/card/<?=$card['id']?>"><?=$card['num']?></a></td>
							<td><?=get_relative($card, '套餐')?></td>
							<td><?=get_meta($card, '次数')?></td>
							<td><?=get_meta($card, '剩余次数')?></td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</form>
	</div>  
<?php $this->view('footer'); ?>
