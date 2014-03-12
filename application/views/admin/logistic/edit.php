<?php $this->view('header'); ?>
    <div class="container main">
        <?php $this->view('admin/sidebar'); ?>
        <form class="form form-horizontal">
            <div class="head"><?=end($this->page_path)['text']?></div>
            <div class="table-border">
                <table class="table">
                    <thead>
                        <tr>
                            <th>状态</th>
                            <th>时间</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($meal['status'] as $name => $date){ ?>
                        <tr>
                            <td><?=$name?></td>
                            <td><?=$date?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <div class="table-border">
                <table class="table">
                    <tbody>
                        <?php foreach($meal['meta'] as $key => $value){ ?>
                        <tr>
                            <td><?=$key?></td>
                            <td><?=implode(', ', $value)?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </form>
    </div>  
<?php $this->view('footer'); ?>