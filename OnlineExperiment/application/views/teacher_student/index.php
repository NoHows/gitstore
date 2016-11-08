<?php $this->load->view('teacher_home/_header') ?>
<?php $this->load->view('message') ?>

<script tyep="text/javascript">
	$().ready(function(){
		$("#student_li").addClass("active"); 
	});

	function delete_class(logic_class_id,class_id)
	{
		if(confirm("删除后将删除该班级所有学生在这个课程下的相关的考试信息，不可恢复，确定吗？"))
			location.href="<?php echo site_url('teacher_student/delete_class').'/'?>"+logic_class_id+"/"+class_id;
	}

</script>

<div class="container">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title">我的学生</h3>
		</div>
		<div class="panel-body">
			<div class="row" style="margin-bottom:15px">
				<div class="col-md-10"></div>
				<div class="col-md-2"><a href="<?php echo site_url('teacher_student/add')?>" class="btn btn-primary">添加学生</a></div>
			</div>
			<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
				<?php $index=0; ?>
				<?php if(!$logic_classes){echo "请联系管理员建立您的逻辑班";} else {?>
				<?php foreach ($logic_classes as $item): ?>
					<div class="panel panel-default">
					    <div class="panel-heading" role="tab" id="heading<?=$index?>">
					      <h4 class="panel-title">
					        <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?=$index?>" aria-expanded="true" aria-controls="collapse<?=$index?>">
					         	<?php echo '(逻辑班号：'.$item['number'].')课程名称：'.$item['big_lecture_name'] ?>
					         	<!-- .'<'.($item['type']==1?'校内':'校外').'>' -->
					        </a>
					      </h4>
					    </div>
					    <div id="collapse<?=$index?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading<?=$index?>">
					      <div class="panel-body">
					      		
					      			<table class="table table-striped table-hover ">
										<thead>
											<tr>
												<th>序号</th>
												<th>名称</th>
												<th>人数</th>
												<th>操作</th>
											</tr>
										</thead>
										<tbody>
											<?php $i=1; ?>
											
											<?php foreach ($classes_list_by_logic_class[$index] as $class): ?>
											<tr>
												<td>
													<?php echo $i++ ;?></td>
												<td>
													<?php echo $class['name']?></td>
												<td>
													<?php echo $class['select_num'].'/'.$class['total_num']?></td>
												<td>
													<a class='btn btn-primary' href="<?php echo site_url('teacher_student/check_class').'/'.$item['id'].'/'.$class['id'] ?>">查看</a>
												</td>
												<td><a class='btn btn-primary' onclick="delete_class(<?=$item['id']?>,<?=$class['id']?>)" href="#">删除</a></td>
											</tr>

											<?php endforeach;?></tbody>
									</table>
					      </div> 
					    </div>
				  	</div>
				<?php $index++; ?>
				<?php endforeach;}?>
			</div>
		</div>
	</div>
</div>




<?php $this->load->view('teacher_home/_footer')?>