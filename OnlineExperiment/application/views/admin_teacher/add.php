<?php $this->load->view('admin_home/_header') ?>
<?php $this->load->view('message') ?>
<script tyep="text/javascript">
  $().ready(function(){
    $("#teacher_li").addClass("active"); 
    $("#teacher_add_form").validate({
		rules:{
			teacher_name:
			{
				required:true,
				maxlength:45
			},
			major_id:
			{
				required:true,
			},
			teacher_number:
			{
				required:true,
				maxlength:45,
				remote: {
				    url: "<?php echo site_url('admin_teacher/check_teacher_number_exist')?>",     //后台处理程序
				    type: "post",               //数据发送方式 
				    dataType: "json",           //接受数据格式  
				    data: {                     //要传递的数据
				        teacher_number: function() {
				            return $("#teacher_number").val();
				        }
				    }
				}
			}
		},
		messages:
		{
			teacher_number:
			{
				remote:"这个教职工号已存在"
			}
		}
	});   
  });
</script> 

<div class="container">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title">添加教师</h3>
		</div>
		<div class="panel-body">
			<?php echo validation_errors(); ?>
			<form id="teacher_add_form" method="post" class="form-horizontal"  enctype="multipart/form-data" action="<?php echo site_url('admin_teacher/add')?>" >
				<fieldset>
					<div class="form-group">
						<label class="col-lg-2 control-label">姓名:</label>
						<div class="col-lg-8">
							<input class="form-control" id="teacher_name" name="teacher_name"/>
						</div>

					</div>
					<div class="form-group">
						<label class="col-lg-2 control-label">专业:</label>
						<div class="col-lg-8">
							<select class="form-control" name="major_id" id="major_id">
								<option value="">--选择专业--</option>
								<?php foreach ($majors as $item) :?>
									<option value="<?=$item['id']?>">
										<?=$item['name']?>
									</option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2 control-label">教职工号:</label>
						<div class="col-lg-8">
							<input class="form-control" id="teacher_number" name="teacher_number"/>
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

<?php $this->load->view('admin_home/_footer')?>