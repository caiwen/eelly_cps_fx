<?php include('header.php'); ?>
<script type="text/javascript">
	window.onload = function()
	{
		$('.product').equalHeights();
	}
</script>
<div id="container">
	<div class="area">
        <div class="commodity">
            <div class="commodity-info">
            	<div class="commodity-base">
                    <div class="txt-module">
                        <h1><?php echo $product->name;?></h1>
                        <p class="commodity-price">
                         <?php if($product->saleprice > 0):?>
								<small><?php echo lang('on_sale');?></small>
								<span class="product_price"><?php echo format_currency($product->saleprice); ?></span>
							<?php else: ?>
								<small><?php echo lang('product_price');?></small>
								<span class="product_price"><?php echo format_currency($product->price); ?></span>
							<?php endif;?>
                        </p>
                        <p class="commodity-actions">
                        	<a class="btn_buy" rel="nofollow" target="_blank"  href="<?php echo $product->click_url;?>">去衣联进货</a>
                            <a class="btn_favorite" onclick="addFavorite();" href="javascript:;">加收藏</a>
                        </p>
                    </div>
                    
                    <div class="img-module">
                        <?php
				$photo	= !empty($product->eelly_thumb_img) ? '<img class="responsiveImage" src="'.$product->eelly_thumb_img.'" alt="'.$product->seo_title.'"/>' : theme_img('no_picture.png', lang('no_image_available'));
				$product->images	= array_values($product->images);

				if(!empty($product->images[0]))
				{
					$primary	= $product->images[0];
					foreach($product->images as $photo)
					{
						if(isset($photo->primary))
						{
							$primary	= $photo;
						}
					}

					$photo	= '<img class="responsiveImage" src="'.base_url('uploads/images/medium/'.$primary->filename).'" alt="'.$product->seo_title.'"/>';
				}
				echo $photo
				?>
                    </div>
                </div>
                
                <div class="commodity-share">
                	<div id="bdshare" class="bdshare_t bds_tools get-codes-bdshare"><span class="bds_more">分享到：</span><a class="bds_tsina" title="分享到新浪微博" href="#">新浪微博</a><a class="bds_qzone" title="分享到QQ空间" href="#">QQ空间</a><a class="bds_tqq" title="分享到腾讯微博" href="#">腾讯微博</a><a class="bds_renren" title="分享到人人网" href="#">人人网</a><a class="bds_t163" title="分享到网易微博" href="#">网易微博</a><a class="bds_hi" title="分享到百度空间" href="#">百度空间</a><a class="bds_sqq" title="分享到QQ好友" href="#">QQ好友</a></div>
                </div>
            </div>

            <div class="commodity-des">
                <div class="hd"><h2 class="cur">宝贝描述</h2></div>
                <div class="bd">
                    <?php echo $product->description; ?>
                </div>
            </div>
        </div>
        
        <div class="side">
        	<div class="section goods-related">
                <div class="hd"><h2>可能会喜欢的宝贝</h2></div>
                <div class="bd">
                <?php if(!empty($product->related_products)):?>
                	<ul>
                	<?php foreach($product->related_products as $relate):?>
                         <li>
                         <?php
						$photo	= theme_img('no_picture.png', lang('no_image_available'));
						
						
						
						$relate->images	= array_values((array)json_decode($relate->images));
						
						if(!empty($relate->images[0]))
						{
							$primary	= $relate->images[0];
							foreach($relate->images as $photo)
							{
								if(isset($photo->primary))
								{
									$primary	= $photo;
								}
							}

							$photo	= '<img src="'.base_url('uploads/images/thumbnails/'.$primary->filename).'" alt="'.$relate->seo_title.'"/>';
						}
						?>
                        	<a href="<?php echo site_url($relate->slug); ?>">
                                <dl>
                                    <dd class="goods-img"><?php echo $photo; ?></dd>
                                    <dt class="goods-name"><?php echo $relate->name;?></dt>
                                    <dd class="goods-price"><?php if($relate->saleprice > 0):?>
								<span class="price-slash"><?php echo lang('product_reg');?> <?php echo format_currency($relate->price); ?></span>
								<span class="price-sale"><?php echo lang('product_sale');?> <?php echo format_currency($relate->saleprice); ?></span>
							<?php else: ?>
								<span class="price-reg"><?php echo lang('product_price');?> <?php echo format_currency($relate->price); ?></span>
							<?php endif; ?></dd>
                                </dl>
                            </a>
                        </li>
                    <?php endforeach;?> 
                    </ul>
                    <?php else :?>
                    <p>
                    没找到相关宝贝
                    </p>
                    <?php endif;?>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript"><!--
$(function(){ 
	$('.category_container').each(function(){
		$(this).children().equalHeights();
	});	
});
function addFavorite() 
{
	var url = window.location.href;
	var title = document.title;
	try {
		window.external.addFavorite(url, title);
	} catch (e){
		try {
			window.sidebar.addPanel(title, url, '');
        	} catch (e) {
			alert("<?php echo lang('press_ctrd_add_fav');?>");
		}
	}
}
//--></script>
<script type="text/javascript" id="bdshare_js" data="type=tools&amp;uid=0" ></script>
<script type="text/javascript" id="bdshell_js"></script>
<script type="text/javascript">document.getElementById("bdshell_js").src = "http://bdimg.share.baidu.com/static/js/shell_v2.js?cdnversion=" + Math.ceil(new Date()/3600000);</script>
<?php include('footer.php'); ?>