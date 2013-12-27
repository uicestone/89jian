<?php $this->view('header'); ?>
	<?php $this->view('admin/sidebar'); ?>
	<div id="right" class="span9">
		<div class="model">
			<div class="title"><h3><?php if(isset($user['id'])){ ?>编辑用户<?php }else{ ?>添加用户<?php } ?></h3></div>
			<div class="main">
				<div class="show_content">
					<?php $this->view('alert'); ?>
					<form class="form-horizontal" method="post">
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
								<input type="text" name="group" value="<?=set_value('group',$user['group'])?>">
								<span class="label label-important"><?=form_error('group')?></span>
							</div>
						</div>
						<div class="control-group">
							<div class="controls">
								<button class="btn btn-primary" type="submit" name="submit">保存</button>
							</div>
						</div>
						<?php if(isset($user['id'])){ ?>
						<table class="table table-bordered">
							<thead>
								<tr><th>资料项</th><th>内容</th></tr>
							</thead>
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
					</form>
				</div>
			</div>
		</div>
	</div>
<?php $this->view('footer'); ?>