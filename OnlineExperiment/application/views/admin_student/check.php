<?php $this->load->view('admin_home/_header') ?>
<?php $this->load->view('message') ?>
<script tyep="text/javascript">
  $().ready(function(){
    $("#student_li").addClass("active");   
  });

</script>

<div class="container">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title">查看学生信息</h3>
		</div>
		<div class="panel-body">
			<fieldset>
					<div class="form-group">
						<label class="col-lg-2 control-label">姓名:</label>
						<div class="col-lg-10">
							<p ><?=$student['name']?></p>
						</div>

					</div>


					<div class="form-group">
						<label class="col-lg-2 control-label">学号:</label>
						<div class="col-lg-10">
							<p ><?=$student['student_id']?></p>
						</div>
						
					</div>
					
					<div class="form-group">
						<label class="col-lg-2 control-label">专业:</label>
						<div class="col-lg-10">
							<p ><?=$student['major_name']?></p>
						</div>
						
					</div>
					
					<div class="form-group">
						<label class="col-lg-2 control-label">班级:</label>
						<div class="col-lg-10">
							<p ><?=$student['class_name']?></p>
						</div>
						
					</div>

					<div class="form-group">
						<label class="col-lg-2 control-label">用户类型:</label>
						<div class="col-lg-10">
							<?php if ($student['type']==1): ?>
								<p>本校用户</p>
							<?php elseif ($student['type']==2): ?>
								<p>注册用户</p>
							<?php endif ?>
						</div>
						
					</div>

					<div class="form-group">
						<label class="col-lg-2 control-label">已选课程:</label>
						<div class="col-lg-10">
							<table class="table table-striped table-hover ">
								<thead>
									<tr>
										<th>序号</th>
										<th>课程名称</th>
										<th>逻辑班号</th>
										<th>任课老师</th>
									</tr>
								</thead>
								<tbody>
									<?php $index=1; ?>
									<?php foreach ($relative_logic_classes as $item ): ?>
									<tr>
										<td>
											<?php echo $index++ ;?></td>
										<td>
											<?php echo $item['big_lecture_name']?></td>
										<td>
											<?php echo $item['number']?></td>
										<td>
											<?php echo $item['teacher_name']?></td>
									</tr>
									<?php endforeach; ?></tbody>
							</table>
							
						</div>
						
					</div>
					<div class="form-group">
						<label class="col-lg-2 control-label"></label>
						<div class="col-lg-10">
							<a class="btn btn-primary" href="<?php echo site_url('admin_student/edit').'/'.$student['id']?>">编辑</a>
							<a class="btn btn-primary" href="<?php echo site_url('admin_student/index') ?>">返回</a>
						</div>
						
					</div>
					
				</fieldset>

		</div>
	</div>
</div>
<?php $this->load->view('admin_home/_footer')?>