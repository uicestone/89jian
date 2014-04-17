<?php $this->view('header'); ?>
<div class="article-page">
	<a type="button" id="font-standard" class="btn pull-right">标准字体</a>
	<h1><?=$article['name']?></h1>
	<?=get_meta($article, '内容')?>
</div>
<script type="text/javascript">
(function($){
	$(function(){
		$('#font-standard').on('click', function(){
			$('.article-page').css('font-family', 'STZhongsong, Songti SC, SimSun, serif');
			$(this).fadeOut(100);
		});
	});
})(jQuery)
</script>
<?php $this->view('footer'); ?>