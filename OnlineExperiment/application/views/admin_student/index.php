
<?php $this->load->view('admin_home/_header') ?>
<?php $this->load->view('message') ?>

<script tyep="text/javascript">
  $().ready(function(){
    $("#student_li").addClass("active"); 
	  
  	});

  	function delete_item(id)
	{
		if(confirm("删除后将删除学生的账户，以及相关的考试信息，不可恢复，确定吗？"))
			location.href="<?php echo site_url('admin_student/delete').'/'?>"+id;
	}

	function submit_batch_delete()
	{
		if(confirm("删除后将删除列表中所有学生的账户，以及相关的考试信息，不可恢复，确定吗？"))
		{
			$("#batch_delete").submit();
		}
		else
		{
			 return false;
		}

	}
</script>

<div class="container">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title">查询</h3>
		</div>
		<div class="panel-body">
			<form id="student_search_form" method="post" class="form-horizontal"  enctype="multipart/form-data" action="<?php echo site_url('admin_student/search')?>" >
				<fieldset>
					<div class="form-group">
						<label class="col-lg-2 control-label">专业:</label>
						<div class="col-lg-8">
							<select class="form-control" name="major_id" id="major_id">
								<option value="0">--不限--</option>
								<?php foreach ($majors as $item) :?>
									<option value="<?=$item['id']?>" <?php echo ($item['id'] == $major_id_select)?'selected="selected"':'' ?>>
										<?=$item['name']?>
									</option>
								<?php endforeach; ?>
							</select>
						</div>

					</div>
					<div class="form-group">
						<label class="col-lg-2 control-label">班级:</label>
						<div class="col-lg-8">
							<select class="form-control" name="class_id" id="class_id">
								<option value="0">--不限--</option>
								<?php foreach ($classes as $item) :?>
									<option value="<?=$item['id']?>" <?php echo ($item['id'] == $class_id_select)?'selected="selected"':'' ?>>
										<?=$item['name']?>
									</option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2 control-label">逻辑班:</label>
						<div class="col-lg-8">
							<select class="form-control" name="logic_class_id" id="logic_class_id">
								<option value="0">--不限--</option>
								<?php foreach ($logic_classes as $item) :?>
									<option value="<?=$item['id']?>" <?php echo ($item['id'] == $logic_class_id_select)?'selected="selected"':'' ?>>
										逻辑班号:<?=$item['number']?>, <?=$item['teacher_name']?>
									</option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2 control-label">类型:</label>
						<div class="col-lg-8">
							<select class="form-control" name="student_type" id="student_type">
								<option value="0">--不限--</option>
									<option value="1" <?php echo (1 == $student_type_select)?'selected="selected"':'' ?>>
										本校用户
									</option>
									<option value="2" <?php echo (2 == $student_type_select)?'selected="selected"':'' ?>>
										注册用户
									</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<div class="col-lg-10 col-lg-offset-2">
							<button type="submit" class="btn btn-primary">查询</button>
						</div>
					</div>


				</fieldset>
			</form>

		</div>
	</div>
</div>

<div class="container">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title">学生列表</h3>
		</div>
		<div class="panel-body">
			<div id="table">
				<table class="table table-striped table-hover ">
					<thead>
						<tr>
							<th>序号</th>
							<th>学生姓名</th>
							<th>学号</th>
							<th>专业</th>
							<th>班级</th>
							<th>类型</th>						
							<th></th>							
							<th>
								<a href="<?php echo site_url('admin_student/add')?>" class="btn btn-primary ">
									添加
								</a>
							</th>
							<th>
								<form id="batch_delete" method="post" class="form-horizontal"  enctype="multipart/form-data" action="<?php echo site_url('admin_student/batch_delete')?>" >
									<?php $item_number=0;foreach ($students as $students_item) :?>
										<input type="text" name="batch_delete_students[<?php echo $item_number?>]" value="<?php echo $students_item['id']?>" class="hidden">
									<?php $item_number++;?>
							  
									<?php endforeach; ?>
									
									<div>
										<button class="btn btn-primary" onclick="return submit_batch_delete()">删除下列学生</button>
									</div>
									
								</form>								
							</th>
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
							<td>
								<?php echo $item['class_name']?></td>
							<td>
								<?php if ($item['type']==1): ?>
									本校
								<?php elseif ($item['type']==2): ?>
									注册
								<?php endif ?>
							</td>
							<td>
								<a href="<?php echo site_url('admin_student/check').'/'.$item['id']?>">查看</a></td>
							<td>
								<a href="<?php echo site_url('admin_student/edit').'/'.$item['id']?>">编辑</a>
							</td>
							<td>
								<a onclick="delete_item(<?=$item['id']?>)" href="#">删除</a>
							</td>
						</tr>
						<?php endforeach; ?></tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<?php $this->load->view('admin_home/_footer')?>