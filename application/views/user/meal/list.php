<?php $this->view('header'); ?>

    <div class="container main">
        <?php $this->view('user/sidebar'); ?>
        <form class="form">
            <div class="head">產品管理</div>
            <div class="row"><button class="btn">增加新產品</button></div>
            <div class="table-border">
                <table class="table">
                    <thead> 
                        <tr>
                            <th width="140">產品名稱</th>
                            <th>描述</th>
                            <th width="150">項目</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <div class="title">可口可樂</div>
                                <img src="" alt="">
                                <button class="btn">修改</button>
                            </td> 
                            <td>
                                <p>可口可乐公司(The Coca-Cola Company)成立于1886年5月8日，总部设在美国乔亚州亚特兰大，是全球最大的饮料公司，拥有全球48%市场占有率以及全球前三大饮料的二项（可口可乐排名第一，百事可乐第二，低热量可口可乐第三）,可口可乐在200个国家拥有160种饮料品牌，包括汽…</p>
                            </td> 
                            <td>
                                <p>进行中：0个</p>
                                <p>投票中：1个</p>
                                <button class="btn">發佈項目</button>
                            </td> 
                        </tr>
                    </tbody>
                </table>
            </div>
        </form>
    </div>  
    <!-- end of body -->

<?php $this->view('footer'); ?>
