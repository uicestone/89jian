<?php $this->view('header'); ?>
<?php $this->view('admin/sidebar'); ?>
<?php $this->view('alert'); ?>
    <form class="form-horizontal" method="post">
        <div class="control-group">
            <label class="control-label">值</label>
            <div class="controls">
                <input type="text" name="value" value="<?=set_value('value',$value)?>">
            </div>
        </div>
        <div class="control-group">
            <div class="controls">
                <button class="btn btn-primary" type="submit" name="submit">保存</button>
            </div>
        </div>
    </form>
<?php $this->view('footer'); ?>