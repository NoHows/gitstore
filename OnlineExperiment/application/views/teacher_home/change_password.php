<?php $this->load->view('student_home/_header') ?>
<?php $this->load->view('message') ?>
<script tyep="text/javascript">
  $().ready(function(){  

$("#change_password_form").validate({
		rules:{
			old_password:
			{
				required:true,
				maxlength:45
			},
			new_password:
			{
				required:true,
				maxlength:45
			},
			new_password_confirm:
			{
				equalTo:"#new_password"
			}
		},
		messages:
		{
			new_password_confirm:"两次输入的密码不一致"
		}
	});   
  });
</script>

<div class="container">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title">修改密码</h3>
		</div>
		<div class="panel-body">
			<?php echo validation_errors(); ?>
			<form id="change_password_form" method="post" class="form-horizontal"  enctype="multipart/form-data" action="<?php echo site_url('student_home/change_password')?>
				" >
				<fieldset>
					<div class="form-group">
						<label class="col-lg-2 control-label">原密码:</label>
						<div class="col-lg-8">
							<input  type="password" class="form-control" id="old_password" name="old_password"/>
						</div>

					</div>
					<div class="form-group">
						<label class="col-lg-2 control-label">新密码:</label>
						<div class="col-lg-8">
							<input  type="password" class="form-control" id="new_password" name="new_password"/>
						</div>

					</div>
					<div class="form-group">
						<label class="col-lg-2 control-label">确认新密码:</label>
						<div class="col-lg-8">
							<input  type="password" class="form-control" id="new_password_confirm" name="new_password_confirm"/>
						</div>

					</div>

					<div class="form-group">
						<div class="col-lg-10 col-lg-offset-2">
							<button type="submit" class="btn btn-primary">提交</button>
						</div>
					</div>
				</fieldset>
			</form>
		</div>
	</div>
</div>

<?php $this->load->view('student_home/_footer')?>