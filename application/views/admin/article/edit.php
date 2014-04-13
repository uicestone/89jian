<?php $this->view('header'); ?>

<div class="container main">
	<?php $this->view('admin/sidebar'); ?>
	<form method="post" class="form row-fluid">
		<div class="head"><?=end($this->page_path)['text']?></div>
		<div class="control-group">
			<input type="text" name="title" value="<?=set_value('title', isset($article) ? $article['name'] : '')?>" placeholder="在这里输入文章标题" class="span12" />
		</div>
		<div class="control-group">
			<textarea name="content" placeholder="在这里输入文章内容" rows="10" class="span12">
				<?=set_value('content', isset($article) ? get_meta($article, '内容') : '')?>
			</textarea>
		</div>
		<button type="submit" name="submit" class="btn">提交</button>
	</form>
</div>  

<script type="text/javascript" src="/js/tinymce/tinymce.min.js"></script>
<script type="text/javascript">
$(function(){
	tinymce.init({
		selector: "textarea",
		language:'zh_CN',
		menubar:false
	});
});
</script>

<?php $this->view('footer'); ?>
