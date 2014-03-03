    <div class="footer" id="contact">
        <div class="container">
            <div class="contact">
                <a target="_blank" href="javascript:;" class="map"><img src="http://maps.googleapis.com/maps/api/staticmap?size=506x260&sensor=true&markers=%E6%B5%99%E6%B1%9F%E7%9C%81%E4%B8%BD%E6%B0%B4%E6%99%AF%E5%AE%81%E7%95%B2%E6%97%8F%E8%87%AA%E6%B2%BB%E5%8E%BF&maptype=satellite" width="506" height="260"></a>
                <div class="info">
                    <div class="title">Contact Info 联系方式</div>
                    <div class="address">
                        Add: 上海市長寧區臨虹路280弄1號105室  (上海國際商務花園)<br>
                        Tel: +86 (021) 52832162<br>
                        Fax: +86 (021) 52833621<br>
                        www.89jian.com<br>
                        微信：ba-jiu-jian<br>
                    </div>
                    <img src="/img/qrcode.png" alt="" class="qrcode">
                </div>
            </div>
            <ul class="link-groups row">
                <li class="group span3">
                    <div class="title">食品安全</div>
                    <ul class="links">
                        <li><a href="#">原生態食材選擇指南</a></li>
                        <li><a href="#">為何選擇原生態食品</a></li>
                    </ul>
                </li>
                <li class="group span2">
                    <div class="title">新手指南</div>
                    <ul class="links">
                        <li><a href="#">會員註冊</a></li>
                        <li><a href="#">購物流程</a></li>
                        <li><a href="#">會員手冊</a></li>
                    </ul>
                </li>
                <li class="group span2">
                    <div class="title">支付方式</div>
                    <ul class="links">
                        <li><a href="#">在綫支付</a></li>
                        <li><a href="#">貨到付款</a></li>
                        <li><a href="#">發票制度</a></li>
                    </ul>
                </li>
                <li class="group span3">
                    <div class="title">配送說明</div>
                    <ul class="links">
                        <li><a href="#">冷鏈配送</a></li>
                        <li><a href="#">上門自提</a></li>
                        <li><a href="#">配送範圍與費用</a></li>
                    </ul>
                </li>
                <li class="group span2">
                    <div class="title">幫助中心</div>
                    <ul class="links">
                        <li><a href="#">退換貨說明</a></li>
                        <li><a href="#">找回密碼</a></li>
                        <li><a href="#">常見問題</a></li>
                        <li><a href="#">聯系我們</a></li>
                    </ul>
                </li>
            </ul>
            <div class="copyright">
                上海丽原生态农业发展有限公司 © 2011-2013 All Rights Reserved
            </div>
        </div>
    </div>
    <script src="/js/bootstrap.js"></script>
    <? if(!$this->input->cookie('fontloaded')){ ?><script src="/js/fontloader.js"></script><? } ?>
    <script>
        $('.navigation').sticky();
        (function(){
            var navpanel = $(".navpanel");
            $(window).on("scroll",function(){
                if($(window).scrollTop() > 520){
                    navpanel.fadeIn();
                }else{
                    navpanel.fadeOut(200);
                }
            })
        })();
    </script>
</body>
</html>
