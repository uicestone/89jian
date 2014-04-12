<?php $this->view('header'); ?>
	<div class="container main">
		<?php $this->view('admin/sidebar'); ?>
		<form class="form form-horizontal" method="post">
			<div class="head"><?=end($this->page_path)['text']?></div>
			<?php $this->view('alert'); ?>
			<div class="control-group">
				<label class="control-label">用户名</label>
				<div class="controls">
					<input type="text" name="name" value="<?=set_value('name',$user['name'])?>">
					<span class="label label-important"><?=form_error('name')?></span>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">密码</label>
				<div class="controls">
					<input type="password" name="password">
					<span class="label label-important"><?=form_error('password')?></span>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">电子邮件</label>
				<div class="controls">
					<input type="text" name="email" value="<?=set_value('email',$user['email'])?>">
					<span class="label label-important"><?=form_error('email')?></span>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">组</label>
				<div class="controls">
					<input type="text" name="roles" value="<?=set_value('roles',$user['roles'])?>">
					<span class="label label-important"><?=form_error('roles')?></span>
				</div>
			</div>
			<div class="control-group">
				<div class="controls">
					<button class="btn btn-primary" type="submit" name="submit">保存</button>
				</div>
			</div>
			<div class="table-border">
				<?php if(isset($user['id'])){ ?>
				<table class="table">
					<tbody>
						<?php foreach ($user['meta'] as $key => $value) { ?>
							<tr> 
								<td><?=$key?></td>
								<td><?=implode(', ',$value)?></td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
				<?php } ?>
			</div>
		</form>
	</div>  
<?php $this->view('footer'); ?>
