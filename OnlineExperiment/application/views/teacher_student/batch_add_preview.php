<?php $this->load->view('teacher_home/_header') ?>
<?php $this->load->view('message') ?>
<script tyep="text/javascript">
  $().ready(function(){
    $("#student_li").addClass("active"); 
    <?php if ((!$teacher_state)||(!$major_exist)||(!$class_exist)||(!$logic_class_state)): ?>
		$("#submit_button").attr("disabled","true");
	<?php endif ?>
	<?php foreach ($students as $item): ?>
		<?php if (!$item['student_state']): ?>
			$("#submit_button").attr("disabled","true");
		<?php endif ?>
	<?php endforeach ?>
  });
</script> 

<div class="container">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title">批量添加预览</h3>
		</div>
		<div class="panel-body">
			<div class="form-group">
				<label class="col-lg-2 control-label">老师:</label>
				<div class="col-lg-5">
					<p ><?=$teacher_name?>(教职工号:<?=$teacher_number?>)</p>
				</div>
				<div class="col-lg-5">
					<?php if ($teacher_state) :?>
						<p>已存在,将合并</p>
					<?php else :?>
						<p>信息有误，请检查(课程在系统中不存在，或逻辑班号有误)</p>
					
					<?php endif ?>
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-lg-2 control-label">专业:</label>
				<div class="col-lg-5">
					<p ><?=$major_name?></p>
				</div>
				<div class="col-lg-5">
					<?php if ($major_exist==1): ?>
						<p>已存在,将合并</p>
					<?php else :?>
						<p>专业不存在,不合法</p>
					<?php endif ?>
				</div>
			</div>

			<div class="form-group">
				<label class="col-lg-2 control-label">班级:</label>
				<div class="col-lg-5">
					<p ><?=$class_name?></p>
				</div>
				<div class="col-lg-5">
					<?php if ($class_exist): ?>
						<p>已存在,将合并</p>
					<?php else :?>
						<p>班级不存在,不合法</p>
					<?php endif ?>
				</div>
			</div>

			<div class="form-group">
				<label class="col-lg-2 control-label">课程:</label>
				<div class="col-lg-5">
					<p ><?=$logic_class_name?>(逻辑班号:<?=$logic_class_number?>)</p>
				</div>
				<div class="col-lg-5">
					<?php if ($logic_class_exist&&$logic_class_state): ?>
						<p>已存在,将合并</p>
					<?php elseif((!$logic_class_exist)&&$logic_class_state) :?>
						<p>不存在,将创建</p>
					<?php else :?>
						<p>信息有误，请检查</p>
					<?php endif ?>
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-lg-2 control-label">学生:</label>
				<div class="col-lg-10">
					<table class="table table-striped table-hover ">
					<thead>
						<tr>
							<th>序号</th>
							<th>学生姓名</th>
							<th>学号</th>
							<th>操作</th>
						</tr>
					</thead>
					<tbody>
						<?php $index=1; ?>
						<?php foreach ($students as $item ): ?>
						<tr>
							<td>
								<?php echo $index++ ;?></td>
							<td>
								<?php echo $item['student_name']?></td>
							<td>
								<?php echo $item['student_id']?></td>
							<td>
								<?php if ($item['student_exist']&&$item['student_state']): ?>
									<p>已存在,合并</p>
								<?php elseif($item['student_exist']&&(!$item['student_state'])) :?>
									<p>信息有误，请检查</p>
								<?php else :?>
									<p>不存在,将创建</p>
								<?php endif ?>
							</td>
							
						</tr>
						<?php endforeach; ?></tbody>
				</table>
				</div>
			</div>
			<div class="form-group">
				<label class="col-lg-2 control-label"></label>
				<div class="col-lg-10">
					<?php echo validation_errors(); ?>
					<form id="batch_add_confirm_form" method="post" class="form-horizontal"  enctype="multipart/form-data" action="<?php echo site_url('teacher_student/batch_add_confirm')?>" >
						<input type="text" id="teacher_name" name="teacher_name" value="<?=$teacher_name?>" class="hidden">
						<input type="text" id="teacher_number" name="teacher_number" value="<?=$teacher_number?>" class="hidden">
						<input type="text" id="logic_class_name" name="logic_class_name" value="<?=$logic_class_name?>" class="hidden">
						<input type="text" id="logic_class_number" name="logic_class_number" value="<?=$logic_class_number?>" class="hidden">
						<input type="text" id="class_name" name="class_name" value="<?=$class_name?>" class="hidden">
						<input type="text" id="major_name" name="major_name" value="<?=$major_name?>" class="hidden">
						<input type="text" id="student_count" name="student_count" value="<?=count($students)?>" class="hidden">
						<?php for ($i=1; $i <= count($students); $i++) :?>
							<input type="text" id="student_id_<?=$i?>" name="student_id_<?=$i?>" value="<?=$students[$i-1]['student_id']?>" class="hidden">
							<input type="text" id="student_name_<?=$i?>" name="student_name_<?=$i?>" value="<?=$students[$i-1]['student_name']?>" class="hidden">
						<?php endfor;?>
						<button id="submit_button" type="submit" class="btn btn-primary">确认提交</button>
						<a class="btn btn-primary" href="<?php echo site_url('teacher_student/add')?>">信息有误，返回</a>
					</form>
				</div>
			</div>
			
		</div>
	</div>
</div>

<?php $this->load->view('admin_home/_footer')?>