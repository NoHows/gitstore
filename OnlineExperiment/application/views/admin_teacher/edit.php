<?php $this->load->view('admin_home/_header') ?>
<?php $this->load->view('message') ?>
<script type="text/javascript">
  $().ready(function(){
    $("#teacher_li").addClass("active"); 

    $("#teacher_edit_form").validate({
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
			}
		},
	});   
  });
</script>

<div class="container">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title">编辑教师信息</h3>
		</div>
		<div class="panel-body">
			<?php echo validation_errors(); ?>
			<form id="teacher_edit_form" method="post" class="form-horizontal"  enctype="multipart/form-data" action="<?php echo site_url('admin_teacher/edit')?>" >
				<fieldset>
					<input type="text" id="teacher_id" name="teacher_id" value="<?=$teacher['id']?>" class="hidden">
					<div class="form-group">
						<label class="col-lg-2 control-label">姓名:</label>
						<div class="col-lg-8">
							<input class="form-control" id="teacher_name" name="teacher_name" value="<?=$teacher['name']?>" />
						</div>

					</div>
					<div class="form-group">
						<label class="col-lg-2 control-label">专业:</label>
						<div class="col-lg-8">
							<select class="form-control" name="major_id" id="major_id">
								<option value="">--选择专业--</option>
								<?php foreach ($majors as $item) :?>
									<option value="<?=$item['id']?>" <?php echo ($item['id'] == $teacher['major_id'])?'selected="selected"':'' ?>>
										<?=$item['name']?>
									</option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2 control-label">教职工号:</label>
						<div class="col-lg-8">
							<input class="form-control" id="teacher_number" name="teacher_number" value="<?=$teacher['teacher_number']?>" disabled="disabled"/>
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