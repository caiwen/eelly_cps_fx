<?php include('header.php'); ?>
<div class="page-header">
		<h1>管理员信息</h1>
</div>
<form accept-charset="utf-8" method="post" action="http://fx.eelly.dev/admin/customers/form">
	<div class="row">
		<div class="span3">
			<label>公司</label>
			<input type="text" class="span3" value="" name="company">		</div>
	</div>

	<div class="row">
		<div class="span3">
			<label>名字</label>
			<input type="text" class="span3" value="" name="firstname">		</div>
		<div class="span3">
			<label>姓</label>
			<input type="text" class="span3" value="" name="lastname">		</div>
	</div>

	<div class="row">
		<div class="span3">
			<label>邮箱</label>
			<input type="text" class="span3" value="" name="email">		</div>
		<div class="span3">
			<label>手机</label>
			<input type="text" class="span3" value="" name="phone">		</div>
	</div>

	<div class="row">
		<div class="span3">
			<label>密码</label>
			<input type="password" class="span3" value="" name="password">		</div>
		<div class="span3">
			<label>确认</label>
			<input type="password" class="span3" value="" name="confirm">		</div>
	</div>

	<div class="row">
		<div class="span3">
			<label class="checkbox">
			<input type="checkbox" value="1" name="email_subscribe"> 电子邮件订阅			</label>
		</div>
	</div>

	<div class="row">
		<div class="span3">
			<label class="checkbox">
				<input type="checkbox" value="1" name="active"> 活跃			</label>
		</div>
	</div>

	<div class="row">
		<div class="span3">
			<label>组</label>
			<select class="span3" name="group_id">
<option value="1">Shoppers</option>
</select>		</div>
	</div>

	<div class="form-actions">
		<input type="submit" value="保存" class="btn btn-primary">
	</div>
</form>

<?php include('footer.php');