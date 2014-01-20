<?php $this->view('header'); ?>

<ul>
    <?php foreach($objects['data'] as $object){ ?>
    <li>
        <?=$object['name']?>
    </li>
    <?php } ?>
</ul>

<?php $this->view('footer'); ?>
