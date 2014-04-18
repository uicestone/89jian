<?php $this->view('header'); ?>

<div class="container main">
	<?php $this->view('user/sidebar'); ?>
	<form class="form form-horizontal" method="post">
		<div class="head">我的资料</div>
		<?php $this->view('alert'); ?>
		<div class="well well-small">点击资料内容来编辑</div>
		<div class="table-border">
			<table class="table">
				<tbody>
					<?php foreach($user['meta'] as $key => $value){ ?>
					<tr>
						<td><?=$key?></td>
						<td><span class="meta-value" data-key="<?=$key?>"><?=get_meta($user, $key)?></span></td>
					</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
		
		<div class="well well-small">在这里修改你的密码</div>
		<div class="control-group">
			<label class="control-label">原密码：</label>
			<div class="controls"><input type="password" name="password"><label class="label label-important"><?=form_error('password')?></label></div>
		</div>
		
		<div class="control-group">
			<label class="control-label">新密码：</label>
			<div class="controls"><input type="password" name="password_new"><label class="label label-important"><?=form_error('password_new')?></label></div>
		</div>
		
		<div class="control-group">
			<label class="control-label">重复新密码：</label>
			<div class="controls"><input type="password" name="password_new_confirm"><label class="label label-important"><?=form_error('password_new_confirm')?></label></div>
		</div>
		
		<button type="submit" name="submit" class="btn">保存</button>

	</form>
</div>

<script type="text/javascript">
	(function($){
		$(function(){
			$('.meta-value').on('click', function(){
				$(this).hide();
				$('<input />', {'type': 'text', 'name':'meta[' + $(this).data('key') + ']', 'value': $(this).text(), 'class': 'span5', 'style': 'margin-bottom:0'}).insertAfter(this);
			});
		});
	})(jQuery)
</script>

<?php $this->view('footer'); ?>
