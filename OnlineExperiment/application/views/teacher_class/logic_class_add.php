<?php $this->load->view('teacher_home/_header') ?>
<?php $this->load->view('message') ?>
<script tyep="text/javascript">
  $().ready(function(){
    $("#class_li").addClass("active"); 
    $("#logic_class_add_form").validate({
		rules:{
			logic_class_name:
			{
				required:true,
				maxlength:45
			},
			logic_class_number:
			{
				required:true,
				maxlength:45,
				remote: {
				    url: "<?php echo site_url('teacher_class/check_logic_class_number_exist')?>",     //后台处理程序
				    type: "post",               //数据发送方式 
				    dataType: "json",           //接受数据格式  
				    data: {                     //要传递的数据
				        logic_class_number: function() {
				            return $("#logic_class_number").val();
				        }
				    }
				}
			},
			logic_class_type:
			{
				required:true
			},	
		},
		messages:
		{
			logic_class_number:
			{
				remote:"这个逻辑班号号已存在"
			}
		}
		
	});   
  });
</script> 

<div class="container">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title">添加班级</h3>
		</div>
		<div class="panel-body">
			<?php echo validation_errors(); ?>
			<form id="logic_class_add_form" method="post" class="form-horizontal"  enctype="multipart/form-data" action="<?php echo site_url('teacher_class/logic_class_add')?>" >
				<fieldset>
					<div class="form-group">
						<label class="col-lg-2 control-label">课程名称:</label>
						<div class="col-lg-8">
							<input class="form-control" id="logic_class_name" name="logic_class_name"/>
						</div>

					</div>
					<div class="form-group">
						<label class="col-lg-2 control-label">逻辑班号:</label>
						<div class="col-lg-8">
							<input class="form-control" id="logic_class_number" name="logic_class_number"/>
						</div>

					</div>
					<div class="form-group">
						<label class="col-lg-2 control-label">类型:</label>
						<div class="col-lg-8">
							<select class="form-control" name="logic_class_type" id="logic_class_type">
								<option value="">--选择课程类型--</option>
								<option value="1">校内</option>
								<option value="2">校外</option>
							</select>
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

<?php $this->load->view('teacher_home/_footer')?>