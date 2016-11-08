<?php $this->load->view('teacher_home/_header') ?>
<?php $this->load->view('message') ?>
<script tyep="text/javascript">
	$().ready(function(){
		$("#student_li").addClass("active"); 
	});

	function delete_item(id)
	{
		if(confirm("删除后将删除学生在这个课程下的相关的考试信息，不可恢复，确定吗？"))
			location.href="<?php echo site_url('teacher_student/delete').'/'.$logic_class['id'].'/'.$class['id'].'/'?>"+id;
	}
	function reset_password(id)
	{
		if(confirm("将会重置该学生的密码为学号，确定吗？"))
			location.href="<?php echo site_url('teacher_student/reset_password').'/'.$logic_class['id'].'/'.$class['id'].'/'?>"+id;
	}
</script>

<div class="container">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title">信息</h3>
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
							<p ><?=$logic_class['big_lecture_name']?></p>
						</div>
					</div>
					<!-- <div class="form-group">
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

					</div> -->
					<div class="form-group">
						<label class="col-lg-2 control-label">班级:</label>
						<div class="col-lg-10">
							<p ><?=$class['name']?></p>
						</div>

					</div>
					<div class="form-group">
						<label class="col-lg-2 control-label">人数:</label>
						<div class="col-lg-10">
							<p><?=count($students)?></p>
						</div>

					</div>
					<div class="form-group">
						<label class="col-lg-2 control-label"></label>
						<div class="col-lg-10">
							<a class="btn btn-primary" href="<?php echo site_url('teacher_student/index') ?>">返回</a>
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
						<th>操作</th>
						<th></th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php $index=1; ?>
					<?php foreach ($students as $item ): ?>
					<tr>
						<td>
							<?php echo $index++ ;?></td>
						<td>
							<a href="<?php echo site_url('teacher_student/check_student').'/'.$item['id'].'/'.$logic_class['id'].'/'.$class['id']?>"><?php echo $item['name']?></a>
						</td>
						<td>
							<?php echo $item['student_id']?></td>
						<td>
							<?php echo $item['major_name']?></td>
						<td>
							<a href="<?php echo site_url('teacher_student/check_student_performance').'/'.$item['id'].'/'.$logic_class['id'].'/'.$class['id']?>">学习情况</a>
						</td>
						<td>
							<?php if ($item['editable']): ?>
								<a href="<?php echo site_url('teacher_student/edit').'/'.$item['id'].'/'.$logic_class['id'].'/'.$class['id']?>">编辑</a>
							<?php endif ?>
						</td>
						<td><a onclick="delete_item(<?=$item['id']?>)" href="#">删除</a></td>
						<td><a onclick="reset_password(<?=$item['id']?>)" href="#">重置密码</a></td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>

		</div>
	</div>
</div>
<?php $this->load->view('teacher_home/_footer')?>