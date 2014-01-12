<?php $this->view('header'); ?>
<?php $this->view('user/sidebar'); ?>
    <table>
        <tr>
            <th></th>
            <th>订单号</th>
            <th>套餐</th>
            <th>周数</th>
            <th>下单时间</th>
            <th>状态</th>
            <th></th>
        </tr>
        <?php foreach($orders as $order){ ?>
        <tr>
            <td><input type="checkbox" name="checked[]" value="<?=$order['id']?>"></td>
            <td><?=$order['num']?></td>
            <td><?=array_pop($order['relative']['package'])['name']?></td>
            <td><?=array_pop($order['meta']['number'])?></td>
            <td><?=array_column($order['status'], 'date', 'name')['下单']?></td>
            <td><?=array_pop($order['status'])['name']?></td>
            <td><a href="/admin/order/<?=$order['id']?>">详情</a></td>
        </tr>
        <?php } ?>
    </table>
<?php $this->view('footer'); ?>
