
<?php $this->load->view('teacher_home/_header') ?>
<?php $this->load->view('message') ?>

<script type="text/javascript" src="<?php echo base_url()?>js/jquery.battatech.excelexport.min.js"></script>

<script tyep="text/javascript">
  $().ready(function(){
    $("#performance_li").addClass("active"); 
	  
  	});

  function tableToExcel()
  {
  	 $("#performace_table").battatech_excelexport({
                containerid: "performace_table"
               , datatype: "table"
            });
  }
</script>

<div class="container">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title">查询</h3>
		</div>
		<div class="panel-body">
			<form id="student_search_form" method="post" class="form-horizontal"  enctype="multipart/form-data" action="<?php echo site_url('teacher_performance/search')?>" >
				<fieldset>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label class="col-lg-2 control-label">逻辑班:</label>
							<div class="col-lg-8">
								<select class="form-control" name="logic_class_id" id="logic_class_id">
									<option value="0">--不限--</option>
									<?php foreach ($logic_classes as $item) :?>
										<option value="<?=$item['id']?>" 
											<?php if (isset($logic_class_id_selected)&&$item['id']==$logic_class_id_selected): ?>
												selected="selected"
											<?php endif ?>
										>
											<?=$item['name']?>(逻辑班号：<?=$item['number']?>)
										</option>
									<?php endforeach; ?>
								</select>
							</div>

						</div>
						
						
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="col-lg-2 control-label">姓名:</label>
							<div class="col-lg-8">
								<input class="form-control" id="student_name" name="student_name"
									<?php if (isset($student_name_selected)): ?>
										value="<?=$student_name_selected?>"
									<?php endif ?>
								/>
							</div>

						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label class="col-lg-2 control-label">班级:</label>
							<div class="col-lg-8">
								<select class="form-control" name="class_id" id="class_id">
									<option value="0">--不限--</option>
									<?php foreach ($classes as $item) :?>
										<option value="<?=$item['id']?>" 
										<?php if (isset($class_id_selected)&&$item['id']==$class_id_selected): ?>
											selected="selected"
										<?php endif ?>
									>
											<?=$item['name']?>
										</option>
									<?php endforeach; ?>
								</select>
							</div>

						</div>
						
						
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="col-lg-2 control-label">学号:</label>
							<div class="col-lg-8">
								<input class="form-control" id="student_id" name="student_id"
									<?php if (isset($student_id_selected)): ?>
										value="<?=$student_id_selected?>"
									<?php endif ?>
								/>

							</div>

						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label class="col-lg-2 control-label">专业:</label>
							<div class="col-lg-8">
								<select class="form-control" name="major_id" id="major_id">
									<option value="0">--不限--</option>
									<?php foreach ($majors as $item) :?>
										<option value="<?=$item['id']?>" 
											<?php if (isset($major_id_selected)&&$item['id']==$major_id_selected): ?>
												selected="selected"
											<?php endif ?>
										>
											<?=$item['name']?>
										</option>
									<?php endforeach; ?>
								</select>
							</div>

						</div>
						
						
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="col-lg-2 control-label">分数:</label>
							<div class="col-lg-3">
								<input class="form-control" id="grades_low" name="grades_low"
									<?php if (isset($grades_low_selected)): ?>
										value="<?=$grades_low_selected?>"
									<?php endif ?>
								/>
							</div>
							<div class="col-lg-2">
								<p align="center">---</p>
							</div>
							<div class="col-lg-3">
								<input class="form-control" id="grades_high" name="grades_high"
									<?php if (isset($grades_high_selected)): ?>
										value="<?=$grades_high_selected?>"
									<?php endif ?>
								/>
							</div>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<div class="col-lg-10 col-lg-offset-2">
								<button type="submit" class="btn btn-primary">查询</button>
							</div>
						</div>
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
			<h3 class="panel-title">学习情况列表</h3>
		</div>
		<div class="panel-body">
			<div id="table">
				<table id="performace_table" class="table table-striped table-hover ">
					<thead>
						<tr>
							<th>序号</th>
							<th>姓名</th>
							<th>学号</th>
							<th>专业</th>
							<th>班级</th>
							<th>课程</th>
							<th>分数</th>						
							<th></th>
							<th></th>
							
						</tr>
					</thead>
					<tbody>
						<?php if (is_array($performances)): ?>
							

							<?php $index=1; ?>
							<?php foreach ($performances as $item ): ?>
							<tr>
								<td>
									<?php echo $index++ ;?></td>
								<td>
									<?php echo $item['student_name']?></td>
								<td>
									<?php echo $item['student_id']?></td>
								<td>
									<?php echo $item['major_name']?></td>
								<td>
									<?php echo $item['class_name']?></td>
								<td>
									<?php echo $item['logic_class_name']?>(<?=$item['logic_class_number']?>)</td>
								<td>
									<?php echo $item['grades']?></td>
								<td>
									<a href="<?php echo site_url('teacher_performance/check_student').'/'.$item['id']?>">详情</a></td>	
							</tr>
							<?php endforeach; ?>
						<?php endif ?>
					</tbody>
				</table>
				<form id="student_search_form" method="post" class="form-horizontal"  enctype="multipart/form-data" action="<?php echo site_url('teacher_performance/export_excel')?>" >
				<fieldset hidden="hidden">
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label class="col-lg-2 control-label">逻辑班:</label>
							<div class="col-lg-8">
								<select class="form-control" name="logic_class_id" id="logic_class_id">
									<option value="0">--不限--</option>
									<?php foreach ($logic_classes as $item) :?>
										<option value="<?=$item['id']?>" 
											<?php if (isset($logic_class_id_selected)&&$item['id']==$logic_class_id_selected): ?>
												selected="selected"
											<?php endif ?>
										>
											<?=$item['name']?>(逻辑班号：<?=$item['number']?>)
										</option>
									<?php endforeach; ?>
								</select>
							</div>

						</div>
						
						
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="col-lg-2 control-label">姓名:</label>
							<div class="col-lg-8">
								<input class="form-control" id="student_name" name="student_name"
									<?php if (isset($student_name_selected)): ?>
										value="<?=$student_name_selected?>"
									<?php endif ?>
								/>
							</div>

						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label class="col-lg-2 control-label">班级:</label>
							<div class="col-lg-8">
								<select class="form-control" name="class_id" id="class_id">
									<option value="0">--不限--</option>
									<?php foreach ($classes as $item) :?>
										<option value="<?=$item['id']?>" 
										<?php if (isset($class_id_selected)&&$item['id']==$class_id_selected): ?>
											selected="selected"
										<?php endif ?>
									>
											<?=$item['name']?>
										</option>
									<?php endforeach; ?>
								</select>
							</div>

						</div>
						
						
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="col-lg-2 control-label">学号:</label>
							<div class="col-lg-8">
								<input class="form-control" id="student_id" name="student_id"
									<?php if (isset($student_id_selected)): ?>
										value="<?=$student_id_selected?>"
									<?php endif ?>
								/>

							</div>

						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label class="col-lg-2 control-label">专业:</label>
							<div class="col-lg-8">
								<select class="form-control" name="major_id" id="major_id">
									<option value="0">--不限--</option>
									<?php foreach ($majors as $item) :?>
										<option value="<?=$item['id']?>" 
											<?php if (isset($major_id_selected)&&$item['id']==$major_id_selected): ?>
												selected="selected"
											<?php endif ?>
										>
											<?=$item['name']?>
										</option>
									<?php endforeach; ?>
								</select>
							</div>

						</div>
						
						
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="col-lg-2 control-label">分数:</label>
							<div class="col-lg-3">
								<input class="form-control" id="grades_low" name="grades_low"
									<?php if (isset($grades_low_selected)): ?>
										value="<?=$grades_low_selected?>"
									<?php endif ?>
								/>
							</div>
							<div class="col-lg-2">
								<p align="center">---</p>
							</div>
							<div class="col-lg-3">
								<input class="form-control" id="grades_high" name="grades_high"
									<?php if (isset($grades_high_selected)): ?>
										value="<?=$grades_high_selected?>"
									<?php endif ?>
								/>
							</div>
						</div>
					</div>
				</div>

				
				</fieldset>
				<button type="submit" class="btn btn-primary">导出到Excel</button>
			</form>
				
			</div>
		</div>
	</div>
</div>
  
<?php $this->load->view('admin_home/_footer')?>