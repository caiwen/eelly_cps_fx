<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?php echo (!empty($seo_title)) ? $seo_title .' - ' : ''; echo $this->config->item('company_name'); ?></title>


<?php if(isset($meta)):?>
	<?php echo $meta;?>
<?php else:?>
<meta name="Keywords" content="Shopping Cart, eCommerce, Code Igniter">
<meta name="Description"
	content="Go Cart is an open source shopping cart built on the Code Igniter framework">
<?php endif;?>

<?php echo theme_css('bootstrap.min.css', true);?>
<?php echo theme_css('buttons.css', true);?>
<?php echo theme_css('bootstrap-responsive.min.css', true);?>
<?php echo theme_css('theme.css', true);?>
<?php echo theme_css('freshgreen.css', true);?>
<?php echo theme_css('styles.css', true);?>

<?php echo theme_js('jquery.js', true);?>
<?php echo theme_js('bootstrap.min.js', true);?>
<?php echo theme_js('squard.js', true);?>
<?php echo theme_js('equal_heights.js', true);?>

<?php
// with this I can put header data in the header instead of in the body.
if (isset($additional_header_info)) {
    echo $additional_header_info;
}

?>
</head>
<body>
<div id="header" class="header">
    <div class="topbar">
        <div class="area">
            <span class="welcome">亲，欢迎来到衣联网分销联盟．</span>
            <ul class="action">
                <li><a href="javascript:;">［设为首页］</a></li>
                <li><a href="javascript:;">［加入收藏］</a></li>
            </ul>
        </div>
    </div>
        
    <div class="mbox">
    	<div class="area">
            <div class="logo">
                <a href="javascript:;"><img src="/gocart/themes/freshgreen/assets/img/logo.png" alt="家居达人"></a>
            </div>
            <form action="<?php echo site_url('cart/search')?>" method="post">
             <div class="searchbar">
                <input type="text" class="keywords" name="term" autocomplete="off"/>
                <input type="submit" class="button" value="搜 索" />
             </div>
            </form>
        </div>
    </div>
</div>
    
<div id="nav" class="nav">
	<ul>
    	<li class="home"><a href="<?php echo site_url();?>">首页</a></li>
    	<?php foreach($this->categories as $cat_menu):?>
    	<?php 
    	$cur='';
    	if(isset($cate_id) && $cate_id===$cat_menu['category']->id) {
    		$cur='class="cur"';
    	}
    	?>
        <li <?php echo $cur;?>>
        <a href="<?php echo site_url($cat_menu['category']->slug);?>"><?php echo $cat_menu['category']->name;?></a>
        </li>
        <?php endforeach;?>
    </ul>
</div>	
