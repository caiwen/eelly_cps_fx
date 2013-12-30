<?php include('header.php'); ?>
<?php define('ADMIN_FOLDER', $this->config->item('admin_folder'));?>
<div class="page-header">
	<h1>同步"<?php echo $catename?>"下的产品</h1>
	<span class="badge"></span>
	<span class="label label-info">正在同步商品ID大于<?php echo $max_goods_id;?>的110个商品</span>
</div>
<div class="alert">
	<a data-dismiss="alert" class="close">×</a> <strong>温馨提示:</strong>
	同步产品的过程可能需要几分钟时间，请耐心等待
</div>

<div class="progress">
	<div class="bar" style="width: 0%;"></div>
</div>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">同步成功</h4>
      </div>
      <div class="modal-body">
        <p>恭喜你同步成功!</p>
        <p>
        <a class="btn btn-default" href="<?php echo  site_url(ADMIN_FOLDER.'/categories/organize/'.$cateid)?>">返回<?php echo $catename?>分类整理</a>
        <a class="btn btn-default" href="javascript:window.location.reload();">同步下一组数据</a>
        </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script type="text/javascript">
var dataPool=<?php echo $jsondata?>;
var process=new processData(dataPool,'bar','badge','<?php echo  site_url(ADMIN_FOLDER.'/products/sync_eelly_goods')?>');
$(function() {
	process.setCompleteFn(function(){
		$('.bar').width("100%").html('同步完毕!');
		$('#myModal').modal();
		});
	process.run();
});
</script>
<?php include('footer.php');
