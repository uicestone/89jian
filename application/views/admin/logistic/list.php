<?php $this->view('header'); ?>
    <div class="container main">
        <?php $this->view('admin/sidebar'); ?>
        <form class="form">
            <div class="head"><?=end($this->page_path)['text']?></div>
            <div class="table-border">
                <table class="table">
                    <thead>
                        <tr>
                            <th>套餐</th>
                            <th>用户</th>
                            <th>发货日期</th>
                            <th>状态</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($meals['data'] as $meal){ ?>
                        <tr>
                            <td>
                                <input type="checkbox" name="checked[]" value="<?=$meal['id']?>">
                                <?=end($meal['relative']['package'])['name']?>
                            </td>
                            <td><?=end($meal['relative']['user'])['name']?></td>
                            <td><?=end($meal['meta']['送货日期'])?></td>
                            <td><?=end(array_keys($meal['status']))?></td>
                            <td><a href="/admin/logistic/<?=$meal['id']?>">详情</a></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <button name="deliver" class="btn">发货</button>
        </form>
    </div>  
<?php $this->view('footer'); ?>