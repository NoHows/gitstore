<?php $this->load->view('admin_home/_header') ?>
<?php $this->load->view('message') ?>
<script type="text/javascript">
  $().ready(function(){
    $("#student_li").addClass("active"); 

 	$('.selectpicker').selectpicker({});


 	// $('#class_select').selectpicker('val',2);

	$("#logic_classes_select").selectpicker('val',[
<?php foreach ($logic_classes_select as $item ): ?>
<?=$item['logic_class_id']?>,
<?php endforeach ?>
		0]);
					

	$("#student_edit_form").validate({
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
				
			},
			major_id:
			{
				required:true
			}
		},
	});   
  
});
</script>

<div class="container">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title">编辑学生</h3>
		</div>
		<div class="panel-body">
			<?php echo validation_errors(); ?>
			<form id="student_edit_form" method="post" class="form-horizontal"  enctype="multipart/form-data" action="<?php echo site_url('admin_student/edit')?>" >
				<input type="text" id="id" name="id" value="<?=$student['id']?>" class="hidden">
				<fieldset>
					<div class="form-group">
						<label class="col-lg-2 control-label">姓名:</label>
						<div class="col-lg-8">
							<input class="form-control" id="student_name" name="student_name" value="<?=$student['name']?>"/></div>
					</div>
					<div class="form-group">
						<label class="col-lg-2 control-label">学号:</label>
						<div class="col-lg-8">
							<input class="form-control" id="student_id" name="student_id" value="<?=$student['student_id']?>" disabled="disabled"/></div>
					</div>

					<div class="form-group">
						<label class="col-lg-2 control-label">专业:</label>
						<div class="col-lg-8">
							<select class="form-control" name="major_id" id="major_id">
								<option value="">--选择专业--</option>
								<?php foreach ($majors as $item) :?>
									<option value="<?=$item['id']?>" <?php echo ($item['id'] == $student['major_id'])?'selected="selected"':'' ?> >
										<?=$item['name']?>
									</option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-lg-2 control-label">班级:</label>
						<div class="col-lg-8">
							<select id="class_select" class="selectpicker form-control" data-live-search="true" data-style="btn-primary" name="class_id">
								<?php foreach ($classes as $item ): ?>
									<option value="<?=$item['id']?> " <?php echo ($item['id'] == $student['class_id'])?'selected="selected"':'' ?>>
										<?=$item['name']?>
									</option>
								<?php endforeach ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2 control-label">课程:</label>
						<div class="col-lg-8">
							<select id="logic_classes_select" name="logic_classes[]" class="selectpicker form-control" multiple data-live-search="true" data-style="btn-primary" data-selected-text-format="count" >
								
								<?php foreach ($logic_classes as $item ): ?>
									<option value="<?=$item['id']?>">
										<?=$item['big_lecture_name']?>(逻辑班号：<?=$item['number']?>)
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