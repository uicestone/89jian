<?php $this->view('header'); ?>
	<div class="container main">
		<?php $this->view('user/sidebar'); ?>
		<form class="form form-horizontal" method="post">
			<div class="head"><?=end($this->page_path)['text']?></div>
			<?php $this->view('alert'); ?>
			<?php if($bought){ ?>
			<div class="table-border">
				<table class="table">
					<thead>
						<tr>
							<th>套餐</th>
							<th>数量</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($bought as $package => $amount){ ?>
						<tr>
							<td><?=$package?></td>
							<td><?=$amount?></td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
			送餐状态：
			<?=get_meta($user, '套餐')?>
			<?php	if(get_meta($user, '下次送餐日期')){ ?>
			每周送餐中，下次送餐日期：<?=get_meta($user, '下次送餐日期')?>
			<div class="pull-right">
				<button type="submit" name="stop" class="btn">暂停送餐</button>
			</div>
			<?	} else{ ?>
			暂停送餐中
			<div class="pull-right">
				<div class="input-append date" id="datepicker" data-date="<?=date('Y-m-d', time() + 86400 * 7)?>" data-date-format="yyyy-mm-dd">
					<input name="下次送餐日期" class="span2" size="16" type="text" value="<?=date('Y-m-d', time() + 86400 * 7)?>">
					<span class="add-on"><i class="icon-calendar"></i></span>
				</div>
				<button type="submit" name="start" class="btn">开始送餐</button>
			</div>
			<?php	} ?>
			<?php }else{ ?>
			<p class="well well-small">您还没有购买任何套餐</p>
			<?php } ?>
		</form>
		<hr>
		<form method="post" class="form-horizontal pull-right" autocomplete="off">
			
			<!--禁止Chrome密码填充-->
			<input style="display:none" type="text" />
			<input style="display:none" type="password" />
			
			<div class="well well-small">将消费卡充入仓库</div>
			<div class="control-group">
				<label class="control-label">
					卡号：
				</label>
				<div class="controls">
					<input type="text" name="card_num" autocomplete="off">
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">
					密码：
				</label>
				<div class="controls">
					<input type="password" name="card_pass" autocomplete="off">
				</div>
			</div>
			<div class="control-group">
				<div class="controls">
					<button type="submit" name="card_activation" class="btn">激活</button>
				</div>
			</div>
		</form>
	</div>  
<?php $this->view('footer'); ?>