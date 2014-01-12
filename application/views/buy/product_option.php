<?php $this->view('header'); ?>
    <form method="post">
        <?=radio(array_column($this->object->getList(array('type'=>'package'))['data'], 'name', 'id'), 'package', NULL, true)?>
        <input type="number" name="number" />周
        <input type="radio" name="is_card" value="">现货
        <input type="radio" name="is_card" value="1">礼品卡
        首次送餐日：<input type="date" name="date_first_delivery" />
        <button type="submit">下一步</button>
    </form>
<?php $this->view('footer'); ?>
