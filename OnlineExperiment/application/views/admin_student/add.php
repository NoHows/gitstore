<?php $this->load->view('admin_home/_header') ?>
<?php $this->load->view('message') ?>
<script tyep="text/javascript">
  $().ready(function(){
    $("#student_li").addClass("active"); 

    $('.selectpicker').selectpicker();
    $("#student_add_form").validate({
		rules:{
			student_name:
			{
				required:true,
				maxlength:45
			},
			student_id:
			{
				required:true,
				maxlength:45,
				remote: {
				    url: "<?php echo site_url('admin_student/check_student_id_exist')?>",     //后台处理程序
				    type: "post",               //数据发送方式 
				    dataType: "json",           //接受数据格式  
				    data: {                     //要传递的数据
				        student_id: function() {
				            return $("#student_id").val();
				        }
				    }
				}
			},
			major_id:
			{
				required:true
			},
		},
		messages:
		{
			student_id:
			{
				remote:"这个学号的学生已存在"
			}
		}
	});   
  });
</script> 

<div class="container">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title">批量添加</h3>
		</div>
		<div class="panel-body">
			<form id="student_batch_add_form" method="post" class="form-horizontal"  enctype="multipart/form-data" action="<?php echo site_url('admin_student/batch_add')?>">
				<div class="form-group">			
					<div class="col-lg-3">
						<input id="student_file" type="file" name="student_file" size="20"/>
					</div>
					<div class="col-lg-3">
						<button type="submit" class="btn btn-primary">提交</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="container">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title">单独添加</h3>
		</div>
		<div class="panel-body">
			<?php echo validation_errors(); ?>
			<form id="student_add_form" method="post" class="form-horizontal"  enctype="multipart/form-data" action="<?php echo site_url('admin_student/add')?>" >
				<fieldset>
					<div class="form-group">
						<label class="col-lg-2 control-label">姓名:</label>
						<div class="col-lg-8">
							<input class="form-control" id="student_name" name="student_name"/>
						</div>

					</div>

					<div class="form-group">
						<label class="col-lg-2 control-label">学号:</label>
						<div class="col-lg-8">
							<input class="form-control" id="student_id" name="student_id"/>
							<p>(提示：用户的初始密码和学号相同)</p>
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
						<label class="col-lg-2 control-label">班级:</label>
						<div class="col-lg-8">
							<select class="selectpicker form-control" data-live-search="true" data-style="btn-primary" data-selected-text-format="count" name="class_id">
								<?php foreach ($classes as $item ): ?>
									<option value="<?=$item['id']?> ">
										<?=$item['name']?>
									</option>
								<?php endforeach ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2 control-label">逻辑班:</label>
						<div class="col-lg-8">
							<select class="selectpicker form-control" multiple data-live-search="true" 
							data-style="btn-primary" multiple data-selected-text-format="count" name="logic_classes[]">
								<?php foreach ($logic_classes as $item ): ?>
									<option value="<?=$item['id']?> ">
										逻辑班号：<?=$item['number']?>
									</option>
								<?php endforeach ?>
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

<?php $this->load->view('admin_home/_footer')?>