<?php $this->view('header'); ?>

<div class="container main">
	<?php $this->view('admin/sidebar'); ?>
	<form method="post" class="form form-horizontal row-fluid">
		<div class="head"><?=end($this->page_path)['text']?></div>
		<div class="control-group">
			<label class="control-label">产品名称</label>
			<div class="controls">
				<input type="text" name="name" value="<?=set_value('name', isset($product) ? $product['name'] : '')?>" />
			</div>
		</div>
		<div class="control-group">
			<label class="control-label">英文名称</label>
			<div class="controls">
				<input type="text" name="meta[英文名称]" value="<?=set_value('meta[英文名称]', isset($product) ? get_meta($product, '英文名称') : '')?>" />
			</div>
		</div>
		<div class="control-group">
			<textarea name="meta[内容]" placeholder="在这里输入文章内容" rows="10" class="span12">
				<?=set_value('meta[内容]', isset($product) ? get_meta($product, '内容') : '')?>
			</textarea>
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
		content_css:'/css/bootstrap.css,/css/base.css'
	});
});
</script>

<?php $this->view('footer'); ?>
