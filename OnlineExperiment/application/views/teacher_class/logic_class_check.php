<?php $this->load->view('teacher_home/_header') ?>
<?php $this->load->view('message') ?>
<script tyep="text/javascript">
  $().ready(function(){
    $("#class_li").addClass("active");   
      
  });
</script>

<div class="container">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title">查看逻辑班</h3>
		</div>
		<div class="panel-body">
			<fieldset>
					<div class="form-group">
						<label class="col-lg-2 control-label">逻辑班号:</label>
						<div class="col-lg-10">
							<p ><?=$logic_class['number']?></p>
						</div>

					</div>
					<div class="form-group">
						<label class="col-lg-2 control-label">课程名称:</label>
						<div class="col-lg-10">
							<p ><?=$logic_class['name']?></p>
						</div>

					</div>
					<div class="form-group">
						<label class="col-lg-2 control-label">老师:</label>
						<div class="col-lg-10">
							<p ><?=$teacher['name']?></p>
						</div>

					</div>
					<div class="form-group">
						<label class="col-lg-2 control-label">类型:</label>
						<div class="col-lg-10">
							<p >
							<?php if ($logic_class['type']==1): ?>
								校内
							<?php endif ?>
							<?php if ($logic_class['type']==2): ?>
								校外
							<?php endif ?>
						</div>

					</div>
					<div class="form-group">
						<label class="col-lg-2 control-label"></label>
						<div class="col-lg-10">
							<a class="btn btn-primary" href="<?php echo site_url('teacher_class/index') ?>">返回</a>
						</div>
						
					</div>
					
				</fieldset>

		</div>
	</div>
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title">学生列表</h3>
		</div>
		<div class="panel-body">
			<table class="table table-striped table-hover ">
				<thead>
					<tr>
						<th>序号</th>
						<th>姓名</th>
						<th>学号</th>						
						<th>专业</th>
					</tr>
				</thead>
				<tbody>
					<?php $index=1; ?>
					<?php foreach ($students as $item ): ?>
					<tr>
						<td>
							<?php echo $index++ ;?></td>
						<td>
							<?php echo $item['name']?></td>
						<td>
							<?php echo $item['student_id']?></td>
						<td>
							<?php echo $item['major_name']?></td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>

		</div>
	</div>
</div>
<?php $this->load->view('teacher_home/_footer')?>