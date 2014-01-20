<?php $this->view('header'); ?>
    <h1>订单选项</h1>
    <form method="post" class="form form-horizontal">
        <div class="control-group">
            <div class="controls">
                <?=radio(array_column($this->object->getList(array('type'=>'package'))['data'], 'name', 'id'), 'package', $this->input->get('package'), true)?>
            </div>
        </div>
        <div class="control-group">
            <div class="controls">
                <div class="input-append">
                    <input type="text" name="次数" class="span1" />
                    <span class="add-on">周</span>
                </div>                
            </div>
        </div>
        <div class="control-group">
            <div class="controls">
                <?=radio(array(''=>'现货','1'=>'礼品卡'), '是否卡片', $this->input->get('是否卡片'),true)?>
            </div>
        </div>
        <div class="control-group">
            <div class="control-label">首次送餐日：</div>
            <div class="controls">
                <input type="text" name="首次送货日期" class="span2" />
            </div>
        </div>
        <div class="control-group">
            <div class="controls">
                <button type="submit" class="btn">下一步</button>
            </div>
        </div>
    </form>
<?php $this->view('footer'); ?>
