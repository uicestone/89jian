<?php $this->view('header'); ?>

<div class="container main">
	<?php $this->view('admin/sidebar'); ?>
	<form method="post" class="form form-horizontal row-fluid">
		<div class="head"><?=end($this->page_path)['text']?></div>
		<div class="control-group">
			<label class="control-label">名称</label>
			<div class="controls">
				<input type="text" name="name" value="<?=set_value('name', isset($package) ? $package['name'] : '')?>" />
			</div>
		</div>
		<div class="control-group">
			<label class="control-label">价格档次</label>
			<div class="controls">
				<input type="text" name="tag[价格档次]" value="<?=set_value('tag[价格档次]', isset($package) ? get_tag($package, '价格档次') : '')?>" />
				<label class="label label-info">套餐显示名称，如 A, B, C</label>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label">价格</label>
			<div class="controls">
				<input type="text" name="meta[价格]" value="<?=set_value('meta[价格]', isset($package) ? get_meta($package, '价格') : '')?>" />
			</div>
		</div>
		<div class="control-group">
			<label class="control-label">内容分类</label>
			<div class="controls">
				<input type="text" name="tag[内容分类]" value="<?=set_value('tag[内容分类]', isset($package) ? get_tag($package, '内容分类') : '')?>" />
			</div>
		</div>
		<div class="control-group">
			<label class="control-label">组成</label>
			<div class="controls">
				<textarea name="meta[组成]"><?=set_value('tag[组成]', isset($package) ? get_meta($package, '组成') : '')?></textarea>
			</div>
		</div>
		<button type="submit" name="submit" class="btn">提交</button>
		<button type="submit" name="remove" class="btn-link">删除</button>
	</form>
</div>  

<script type="text/javascript" src="/js/tinymce/tinymce.min.js"></script>
<script type="text/javascript">
$(function(){
	tinymce.init({
		selector: "textarea",
		language:'zh_CN',
		menubar:false,
		plugins:['autoresize'],
		content_css:'/css/bootstrap.css,/css/base.css'
	});
});
</script>

<?php $this->view('footer'); ?>
