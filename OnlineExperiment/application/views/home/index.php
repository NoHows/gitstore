<!DOCTYPE html>

<html>
	<head>
		<meta content="text/html; charset=utf-8" http-equiv="Content-Type"/>
		<title><?php echo $title; ?></title>
		<link type="text/css" rel="stylesheet" href="<?php echo base_url()?>css/bootstrap.css"/>

		<script type="text/javascript" src="<?php echo base_url()?>js/jquery.js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>js/jquery.validate.js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>js/bootstrap.js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>js/messages_cn.js"></script>

		<script type="text/javascript">
			$().ready(function(){

				$("#loginForm").validate({
					rules:{
						username:"required",
						password:"required"
					},
				});
			});
		</script>

	</head>
	
<body>
	<div class="container-fluid">
		<div class="row col-md-12" style="margin-top:80px">
			<h2 align="center">自动化电工学实验预习系统</h2>
		</div>
		<div class="row col-md-12" style="margin-top:40px">
			<div class="col-md-2"></div>
			<div class="col-md-8">
				<div class="col-md-7">
					<img class="img-responsive" src="<?php echo base_url() ?>/images/home_test.jpg">
				</div>
				
				<div class="col-md-5">
					 <div class="panel panel-primary">
	                    <div class="panel-heading">
	                        <h3 class="panel-title">登陆</h3>
	                    </div>
	                    <div class="panel-body">
	                            <fieldset>
	                                <legend>
	                                	<?php 
	                                		if($login_state == 'fail') 
	                                			echo $message;  
	                                	?>
	                                </legend>
	                               	<form id="loginForm" action="<?php echo site_url('/home/login') ?>" method="post">
	                               		<div class="form-group row" >
		                                    <div class="col-lg-12  login-textbox">
		                                        <input class="form-control" type="text" id="username" name="username" placeholder="用户名" >
		                                    </div>
	                                	</div>

	                                	<div class="form-group row" >
		                                    <div class="col-lg-12  login-textbox">
		                                        <input class="form-control" type="password" id="password" name="password" placeholder="密码">  
		                                    </div>
	                                	</div>
	                                	<div class="form-group row" >
		                                    
		                                    <div class="col-lg-12  login-textbox">
		                                        <button type="submit" class="btn btn-primary btn-block">登录</button>
		                                    </div>
		                                    
	                                	</div>                               	
      									
	                               	</form>
	                               	<div class="form-group row" >		                                    
		                                    <div class="col-lg-12  login-textbox">
		                                        <button type="button" class="btn btn-primary btn-block" onclick="window.open('<?php echo site_url('register/index')?>')">注册</button>
		                                    </div>
		                             </div>
	                                
	                                
	                            </fieldset>
	                    </div>
	                </div>
				</div>
			</div>
			<div class="clo-md-2"></div>
		</div>
	</div>
	<div style="text-align:center;"><br></br><em>© 天津大学 版权所有</em></div>
</body>
</html>