<?php $this->view('header'); ?>
    <h1>收货信息</h1>
    <form method="post" class="form form-horizontal">
        <div class="control-group">
            <div class="control-label">收货人： </div>
            <div class="controls">
                <input type="text" name="meta[收货人]" />
            </div>
        </div>
        <div class="control-group">
            <div class="control-label">联系电话：</div>
            <div class="controls">
                <input type="text" name="meta[联系电话]" />
            </div>
        </div>
        <div class="control-group">
            <div class="control-label">收货地址：</div>
            <div class="controls">
                <input type="text" name="meta[收货地址]" />
            </div>
        </div>
        <div class="control-group">
            <div class="control-label">邮编：</div>
            <div class="controls">
                <input type="text" name="meta[邮编]" />
            </div>
        </div>
        <div class="control-group">
            <div class="controls">
                <button type="submit" class="btn">去支付宝支付</button>
            </div>
        </div>
    </form>
<?php $this->view('footer'); ?>
