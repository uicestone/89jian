<?php $this->view('header'); ?>
    <div class="container main">
        <?php $this->view('admin/sidebar'); ?>
        <form class="form" method="post">
            <div class="head"><?=end($this->page_path)['text']?></div>
            <div class="table-border">
                <table class="table">
                    <thead>
                        <tr><th>键</th><th>值</th><th style="width: 4em;">&nbsp;</th></tr>
                    </thead>
                    <tbody>
                        <?php foreach ($items as $key => $value) { ?>								
                        <tr> 
                            <td><?=$key?></td>
                            <td><?=$value?></td>
                            <td><a href="/admin/config/<?=$key?>" class="btn btn-small">编辑</a></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <button type="submit" name="confirm" class="btn">确认</button>
        </form>
    </div>  
<?php $this->view('footer'); ?>