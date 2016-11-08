<?php $this->load->view('register/_header') ?>
<?php $this->load->view('message') ?>

<script tyep="text/javascript">
  $(document).ready(function(){  

$("#register_form").validate({
		rules:{
			username:
			{
				required:true,
				maxlength:45,
				remote: {
				    url: "<?php echo site_url('register/check_username_exist')?>",     //后台处理程序
				    type: "post",                //数据发送方式 
				    dataType: "json",          //接受数据格式  
				    data: {                     //要传递的数据
				        username: function() {
				            return $("#username").val();
				        }
				    }
				}
			},
			name:
			{
				required:true,
				maxlength:45
			},
			password:
			{
				required:true,
				maxlength:45
			},
			password_confirm:
			{
				equalTo:"#password"
			}
		},
		messages:
		{
			username:
			{
				remote:"此用户名已存在"
			},
			password_confirm:"两次输入的密码不一致"
			
		}
	});   
  });
</script>

<div class="container">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title">用户注册</h3>
		</div>
		<div class="panel-body">
			<?php echo validation_errors(); ?>
			<form id="register_form" method="post" class="form-horizontal"  enctype="multipart/form-data" action="<?php echo site_url('register/student_register')?>" >
				<fieldset>
					<div class="form-group">
						<label class="col-lg-2 control-label">用户名:</label>
						<div class="col-lg-8">
							<input class="form-control" id="username" name="username"/>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2 control-label">姓名:</label>
						<div class="col-lg-8">
							<input class="form-control" id="name" name="name"/>						
						</div>
					</div>

					<div class="form-group">
						<label class="col-lg-2 control-label">密码:</label>
						<div class="col-lg-8">
							<input  type="password" class="form-control" id="password" name="password"/>
						</div>
					</div>

					<div class="form-group">
						<label class="col-lg-2 control-label">确认密码:</label>
						<div class="col-lg-8">
							<input  type="password" class="form-control" id="password_confirm" name="password_confirm"/>
						</div>
					</div>
					
					<div class="form-group">
						<div class="col-lg-10 col-lg-offset-2">
							<button type="submit" class="btn btn-primary">注册去登陆</button>
						</div>
					</div>
				</fieldset>
			</form>
		</div>
	</div>
</div>



	</body>
</html>
