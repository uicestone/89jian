<?php $this->view('header'); ?>

<h1><?=$article['name']?></h1>
<?=end($article['meta']['内容'])?>

<?php $this->view('footer'); ?>