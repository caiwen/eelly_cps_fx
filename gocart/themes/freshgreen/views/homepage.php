<?php include('header.php'); ?>
<div id="container">
	<div class="area">
		<div class="news-box clearfix">
			<div class="focus">
				<div id="myCarousel" class="carousel slide">
					<!-- Carousel items -->
					<div class="carousel-inner">
				<?php
				$active_banner	= 'active ';
				foreach($banners as $banner):?>
					<div class="<?php echo $active_banner;?>item">
						<?php
						
						$banner_image	= '<img src="'.base_url('uploads/'.$banner->image).'" />';
						if($banner->link)
						{
							$target=false;
							if($banner->new_window)
							{
								$target=' target="_blank"';
							}
							echo '<a href="'.$banner->link.'"'.$target.'>'.$banner_image.'</a>';
						}
						else
						{
							echo $banner_image;
						}
						?>
					
					</div>
				<?php 
				$active_banner = false;
				endforeach;?>
			</div>
					<!-- Carousel nav -->
					<a class="carousel-control left" href="#myCarousel"
						data-slide="prev">&lsaquo;</a> <a class="carousel-control right"
						href="#myCarousel" data-slide="next">&rsaquo;</a>
				</div>
			</div>
			<script type="text/javascript">
            $('.carousel').carousel({
              interval: 5000
             });
            </script>

			<div class="bulletin">
				<div class="hd">
					<h2>服装资讯</h2>
				</div>
				<div class="bd">
					<ul>
					<?php foreach($this->pages as $menu_page):?>
						<li>
						<?php if(empty($menu_page->content)):?>
									<a href="<?php echo $menu_page->url;?>"
							<?php if($menu_page->new_window ==1){echo 'target="_blank"';} ?>><?php echo $menu_page->menu_title;?></a>
								<?php else:?>
									<a href="<?php echo site_url($menu_page->slug);?>"><?php echo $menu_page->menu_title;?></a>
								<?php endif;?>
						</li>
					<?php endforeach;?>
					</ul>
				</div>
			</div>
		</div>
		
		<div class="row">
			<h2 class="section_header">
				<hr class="left visible-desktop">
				<span>热卖推荐</span>
				<hr class="right visible-desktop">
			</h2>
		</div>

		<div class="row">
	<?php foreach($boxes as $box):?>
	<div class="span3 mrg-10">
		<?php
		
		$box_image	= '<img class="responsiveImage" src="'.base_url('uploads/'.$box->image).'" />';
		if($box->link != '')
		{
			$target	= false;
			if($box->new_window)
			{
				$target = 'target="_blank"';
			}
			echo '<a class="thumbnail" href="'.$box->link.'" '.$target.' >'.$box_image.'</a>';
		}
		else
		{
			echo $box_image;
		}
		?>
	</div>
	<?php endforeach;?>
    </div>
    <?php if(!empty($nvzlist)):?>
    <div class="outbox">
            <div class="hd">
                <dl>
                	<dt><b>1F</b><h2>女装</h2></dt>
                </dl>
                <span class="fr"><a href="/nvzhuang" class="white" target="_blank">查看全部...</a></span>
            </div>
            <div class="bd">
                <ul>
                    <?php foreach($nvzlist as $k=>$product):?>
                    <li>
                    <?php
						$photo	= !empty($product->eelly_thumb_img) ? '<img  src="'.$product->eelly_thumb_img.'" alt="'.$product->seo_title.'"/>' : theme_img('no_picture.png', lang('no_image_available'));
						if ($product->images) {
						$product->images	= array_values($product->images);
				       }
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

							$photo	= '<img src="'.base_url('uploads/images/thumbnails/'.$primary->filename).'" alt="'.$product->seo_title.'"/>';
					}?>
                        <dl>
                            <dt><a target="_blank" href="<?php echo site_url(implode('/', $base_url).'/'.$product->slug); ?>"><?php echo $photo; ?></a></dt>
                            <dd><span><?php echo lang('product_sale');?> <?php echo format_currency($product->saleprice); ?></span></dd>
                        </dl>
                    </li>
                    <?php endforeach;?>
                </ul>
            </div>
        </div>
        <?php endif;?>
        
        <?php if(!empty($nzlist)):?>
        <div class="outbox">
            <div class="hd">
                <dl>
                	<dt><b>2F</b><h2>男装</h2></dt>
                </dl>
                <span class="fr"><a href="/nanzhuang" class="white" target="_blank">查看全部...</a></span>
            </div>
            <div class="bd">
                <ul>
                    <?php foreach($nzlist as $k=>$product):?>
                    <li>
                    <?php
						$photo	= !empty($product->eelly_thumb_img) ? '<img  src="'.$product->eelly_thumb_img.'" alt="'.$product->seo_title.'"/>' : theme_img('no_picture.png', lang('no_image_available'));
						if ($product->images) {
						$product->images	= array_values($product->images);
				       }
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

							$photo	= '<img src="'.base_url('uploads/images/thumbnails/'.$primary->filename).'" alt="'.$product->seo_title.'"/>';
					}?>
                        <dl>
                            <dt><a target="_blank" href="<?php echo site_url(implode('/', $base_url).'/'.$product->slug); ?>"><?php echo $photo; ?></a></dt>
                            <dd><span><?php echo lang('product_sale');?> <?php echo format_currency($product->saleprice); ?></span></dd>
                        </dl>
                    </li>
                    <?php endforeach;?>
                </ul>
            </div>
        </div>
        <?php endif;?>
        <?php if(!empty($tzlist)):?>
        <div class="outbox">
            <div class="hd">
                <dl>
                	<dt><b>3F</b><h2>童装</h2></dt>
                </dl>
                <span class="fr"><a href="/tongzhuang" class="white" target="_blank">查看全部...</a></span>
            </div>
            <div class="bd">
                <ul>
                    <?php foreach($tzlist as $k=>$product):?>
                    <li>
                    <?php
						$photo	= !empty($product->eelly_thumb_img) ? '<img  src="'.$product->eelly_thumb_img.'" alt="'.$product->seo_title.'"/>' : theme_img('no_picture.png', lang('no_image_available'));
						if ($product->images) {
						$product->images	= array_values($product->images);
				       }
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

							$photo	= '<img src="'.base_url('uploads/images/thumbnails/'.$primary->filename).'" alt="'.$product->seo_title.'"/>';
					}?>
                        <dl>
                            <dt><a target="_blank" href="<?php echo site_url(implode('/', $base_url).'/'.$product->slug); ?>"><?php echo $photo; ?></a></dt>
                            <dd><span><?php echo lang('product_sale');?> <?php echo format_currency($product->saleprice); ?></span></dd>
                        </dl>
                    </li>
                    <?php endforeach;?>
                </ul>
            </div>
        </div>
        <?php endif;?>
        <?php if(!empty($xmlist)):?>
        <div class="outbox">
            <div class="hd">
                <dl>
                	<dt><b>4F</b><h2>箱包</h2></dt>
                </dl>
                <span class="fr"><a href="/xiangbao" class="white" target="_blank">查看全部...</a></span>
            </div>
            <div class="bd">
                <ul>
                    <?php foreach($xmlist as $k=>$product):?>
                    <li>
                    <?php
						$photo	= !empty($product->eelly_thumb_img) ? '<img  src="'.$product->eelly_thumb_img.'" alt="'.$product->seo_title.'"/>' : theme_img('no_picture.png', lang('no_image_available'));
						if ($product->images) {
						$product->images	= array_values($product->images);
				       }
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

							$photo	= '<img src="'.base_url('uploads/images/thumbnails/'.$primary->filename).'" alt="'.$product->seo_title.'"/>';
					}?>
                        <dl>
                            <dt><a target="_blank" href="<?php echo site_url(implode('/', $base_url).'/'.$product->slug); ?>"><?php echo $photo; ?></a></dt>
                            <dd><span><?php echo lang('product_sale');?> <?php echo format_currency($product->saleprice); ?></span></dd>
                        </dl>
                    </li>
                    <?php endforeach;?>
                </ul>
            </div>
        </div>
        <?php endif;?>
        

	</div>
</div>
<?php include('footer.php'); ?>