<?php include('header.php'); ?>
<?php define('ADMIN_FOLDER', $this->config->item('admin_folder'));?>
<div class="row">
	<h2 class="section_header">
		<span><?php echo lang('select_theme')?></span>
	</h2>
</div>
<div class="row">
	<div class="span3 mrg-10">
		<a 
			href="javascript:void(0);"
			class="thumbnail" onclick="change_theme('freshgreen');" title="<?php echo lang('fresh_green')?>"><img
			src="/gocart/themes/freshgreen/assets/img/theme/freshgreen.png"
			class="responsiveImage"></a>
	</div>
	<div class="span3 mrg-10">
		<a 
			href="javascript:void(0);"
			class="thumbnail" onclick="change_theme('default');" title="<?php echo lang('df_red')?>"><img
			src="/gocart/themes/freshgreen/assets/img/theme/red.png"
			class="responsiveImage"></a>
	</div>
</div>
<script type="text/javascript">
function change_theme(theme)
{
	$.post('<?php echo  site_url(ADMIN_FOLDER.'/theme/modify_theme')?>',{theme:theme},function(d){
        console.log(d);
	});
}
</script>
<?php include('footer.php'); ?>
