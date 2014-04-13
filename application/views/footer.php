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
					<img src="/img/qrcode.jpg" alt="" class="qrcode">
				</div>
			</div>
			<ul class="link-groups row">
				<li class="group span3">
					<div class="title">食品安全</div>
					<ul class="links">
						<li><a href="/article/%E5%8E%9F%E7%94%9F%E6%80%81%E9%A3%9F%E6%9D%90%E9%80%89%E6%8B%A9%E6%8C%87%E5%8D%97">原生態食材選擇指南</a></li>
						<li><a href="/article/%E4%B8%BA%E4%BD%95%E9%80%89%E6%8B%A9%E5%8E%9F%E7%94%9F%E6%80%81%E9%A3%9F%E5%93%81">為何選擇原生態食品</a></li>
					</ul>
				</li>
				<li class="group span2">
					<div class="title">新手指南</div>
					<ul class="links">
						<li><a href="/article/%E4%BC%9A%E5%91%98%E6%B3%A8%E5%86%8C">會員註冊</a></li>
						<li><a href="/article/%E8%B4%AD%E4%B9%B0%E6%B5%81%E7%A8%8B">購物流程</a></li>
						<li><a href="/article/%E4%BC%9A%E5%91%98%E6%89%8B%E5%86%8C">會員手冊</a></li>
					</ul>
				</li>
				<li class="group span2">
					<div class="title">支付方式</div>
					<ul class="links">
						<li><a href="/article/%E5%9C%A8%E7%BA%BF%E6%94%AF%E4%BB%98">在綫支付</a></li>
						<li><a href="/article/%E8%B4%A7%E5%88%B0%E4%BB%98%E6%AC%BE">貨到付款</a></li>
						<li><a href="/article/%E5%8F%91%E7%A5%A8%E5%88%B6%E5%BA%A6">發票制度</a></li>
					</ul>
				</li>
				<li class="group span3">
					<div class="title">配送說明</div>
					<ul class="links">
						<li><a href="/article/%E5%86%B7%E9%93%BE%E9%85%8D%E9%80%81">冷鏈配送</a></li>
						<li><a href="/article/%E4%B8%8A%E9%97%A8%E8%87%AA%E6%8F%90">上門自提</a></li>
						<li><a href="/article/%E9%85%8D%E9%80%81%E8%8C%83%E5%9B%B4%E4%B8%8E%E8%B4%B9%E7%94%A8">配送範圍與費用</a></li>
					</ul>
				</li>
				<li class="group span2">
					<div class="title">幫助中心</div>
					<ul class="links">
						<li><a href="/article/%E9%80%80%E6%8D%A2%E8%B4%A7%E8%AF%B4%E6%98%8E">退換貨說明</a></li>
						<li><a href="/article/%E6%89%BE%E5%9B%9E%E5%AF%86%E7%A0%81">找回密碼</a></li>
						<li><a href="/article/%E5%B8%B8%E8%A7%81%E9%97%AE%E9%A2%98">常見問題</a></li>
						<li><a href="/article/%E8%81%94%E7%B3%BB%E6%88%91%E4%BB%AC">聯系我們</a></li>
					</ul>
				</li>
			</ul>
			<div class="copyright">
				上海丽原生态农业发展有限公司 © 2011-2013 All Rights Reserved
			</div>
		</div>
	</div>
	<script src="/js/bootstrap.js"></script>
	<?php if(!$this->input->cookie('fontloaded')){ ?><script src="/js/fontloader.js"></script><?php } ?>
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
