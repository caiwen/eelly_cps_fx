<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>欢迎使用衣联联盟分销系统</title>
	
	<link href="<?php echo $subfolder;?>assets/css/bootstrap.min.css" type="text/css" rel="stylesheet"/>

</head>
<body>
<div style="text-align:center; padding:20px;"><img src="http://static.eelly.com/themes/mall/default/styles/default/images/eelly_logo.png" alt="衣联网"/></div>
<div class="container">
	<div class="row">
		<div class="span8 offset2">
		
		<?php if(!$config_writable):?>
			<div class="alert alert-error">
				<p> <?php echo $relative_path?> 文件夹不可写！ 生成配置文件时这是必要的</p>
			</div>
		<?php endif;?>
		<?php if(!$root_writable):?>
			<div class="alert alert-error">
				<p>根目录文件夹不可写！如果你想通过生成htaccess文件从URL杜绝“index.php” 这是必要的。</p>
			</div>
		<?php endif;?>
		<?php if($errors):?>
			<div class="alert alert-error">
				<?php echo $errors;?>
			</div>
		<?php endif;?>
			
		<?php echo form_open('');?>

			<fieldset>
				<legend>数据库信息</legend>
				
				<div class="alert alert-info">
					<h4>注意&hellip;</h4>
					<p>安装程序时不会创建一个数据库。它会简单地用适当的表格和运行所需的记录填写您的现有数据库。所以您在安装前必需新建一个数据库</p>
				</div>
				
				<label for="hostname">主机名</label> <?php echo form_input(array('class'=>'span8', 'name'=>'hostname', 'value'=>set_value('hostname', 'localhost') ));?>
				<label for="database">数据库名称</label> <?php echo form_input(array('class'=>'span8', 'name'=>'database', 'value'=>set_value('database') ));?>
				<label for="username">用户名</label> <?php echo form_input(array('class'=>'span8', 'name'=>'username', 'value'=>set_value('username') ));?>
				<label for="password">密码</label> <?php echo form_input(array('class'=>'span8', 'name'=>'password', 'value'=>set_value('password') ));?>
				<label for="password">数据表前缀</label> <?php echo form_input(array('class'=>'span8', 'name'=>'prefix', 'value'=>set_value('prefix', 'gc_') ));?>
				
			</fieldset>
			
			<fieldset>
				<legend>管理员信息</legend>
				
				<label for="login">管理员邮箱</label> <?php echo form_input(array('class'=>'span8', 'name'=>'admin_email', 'value'=>set_value('admin_email') ));?>
				<label for="password">管理员密码</label> <?php echo form_input(array('class'=>'span8', 'name'=>'admin_password', 'value'=>set_value('admin_password') ));?>
				
			</fieldset>
			<fieldset>
			   <legend>站长信息</legend>
			   
			   <label>站长邮箱</label><?php echo form_input(array('class'=>'span8', 'name'=>'webmaster_mail', 'value'=>set_value('webmaster_mail') ));?>
			   <p class="alert alert-info">衣联联盟(http://cps.eelly.com)登录用户名</p>
			   <label>站长ID</label><?php echo form_input(array('class'=>'span8', 'name'=>'webmaster_id', 'value'=>set_value('webmaster_id') ));?>
			   <p class="alert alert-info">衣联联盟(http://cps.eelly.com)登录用户ID</p>
			</fieldset>
			
			<fieldset>
				<legend>附加信息</legend>
				
				<label for="company_name">公司名字</label> <?php echo form_input(array('class'=>'span8', 'name'=>'company_name', 'value'=>set_value('company_name') ));?>
				<label for="website_email">网站邮箱</label> <?php echo form_input(array('class'=>'span8', 'name'=>'website_email', 'value'=>set_value('website_email') ));?>
				<label class="checkbox">
					<?php echo form_checkbox('ssl_support', '1', (bool)set_value('ssl_support') );?> SSL 支持
				</label>
				
				<label class="checkbox">
					<?php echo form_checkbox('mod_rewrite', '1', (bool)set_value('mod_rewrite') );?> 从URL中移除“的index.php” <small>(需要Apache与mod_rewrite)</small>
				</label>
				
			</fieldset>
			<p>
				<button type="submit" class="btn btn-large btn-primary">现在开始安装</button>
			</p>
		</form>
	</div>
</div>
<hr>
<div class="footer">
	<div style="text-align:center;"><a href="http://gocartdv.com" target="_blank"><img src="<?php echo $subfolder;?>assets/img/driven-by-gocart.png" alt="Driven By GoCart"></a></div>
</div>
</body>
</html>