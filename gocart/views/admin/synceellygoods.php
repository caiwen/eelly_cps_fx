<?php include('header.php'); ?>
<div class="page-header">
	<h1>同步"<?php echo $catename?>"下的产品</h1>
	<span class="badge"></span>
</div>
<div class="alert">
	<a data-dismiss="alert" class="close">×</a> <strong>温馨提示:</strong>
	同步产品的过程可能需要几分钟时间，请耐心等待
</div>
<div class="progress">
	<div class="bar" style="width: 0%;"></div>
</div>
<script type="text/javascript">
var dataPool=<?php echo $jsondata?>;
var process=new processData(dataPool,'bar','badge','/admin/products/sync_eelly_goods');
$(function() {
	process.run();
});
</script>
<?php include('footer.php');
