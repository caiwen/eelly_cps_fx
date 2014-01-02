<?php include('header.php'); ?>
<div class="page-header">
		<h1>管理员信息</h1>
</div>
<form role="form">
<fieldset disabled>
        
        
	<div class="row">
		<div class="span3">
			<label>管理员邮箱</label>
			<input type="text" class="span3" value="<?php echo $email;?>" name="email">		</div>
	</div>
	<div class="row">
		<div class="span3">
			<label>站长ID</label>
			<input type="text" class="span3" value="<?php echo $webmaster_id;?>" name="webmaster_id">		</div>
	</div>
	<div class="row">
		<div class="span3">
			<label>站长邮箱</label>
			<input type="text" class="span3" value="<?php echo $webmaster_mail;?>" name="webmaster_mail">		</div>
	</div>
	</fieldset>
	</form>
<?php include('footer.php');