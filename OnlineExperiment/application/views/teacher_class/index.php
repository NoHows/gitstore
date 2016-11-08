<?php $this->load->view('teacher_home/_header') ?>
<?php $this->load->view('message') ?>

<script tyep="text/javascript">
  $().ready(function(){
    $("#class_li").addClass("active"); 
	  
  	});

  	function delete_class(id)
	{
		if(confirm("删除后不可恢复，确定吗？"))
			location.href="<?php echo site_url('teacher_class/class_delete').'/'?>"+id;
	}

	function delete_major(id)
	{
		if(confirm("删除后不可恢复，确定吗？"))
			location.href="<?php echo site_url('teacher_class/major_delete').'/'?>"+id;
	}

	function delete_logic_class(id)
	{
		if(confirm("删除后不可恢复，确定吗？"))
			location.href="<?php echo site_url('teacher_class/logic_class_delete').'/'?>"+id;
	}
	
</script>
<div class="container">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title">课程</h3>
		</div>
		<div class="panel-body">
			<table class="table table-striped table-hover ">
					<thead>
						<tr>
							<th>序号</th>
							<th>逻辑班号</th>
							<th>课程名称</th>
							<th>任课教师</th>
							<th>类型</th>						
							<th></th>
							<th></th>
							<th>
								<a href="<?php echo site_url('teacher_class/logic_class_add')?>" class="btn btn-primary ">
									添加
								</a>
							</th>
						</tr>
					</thead>
					<tbody>
						<?php $index=1; ?>
						<?php foreach ($logic_classes as $item ): ?>
						<tr>
							<td>
								<?php echo $index++ ;?></td>
							<td>
								<?php echo $item['number']?></td>
							<td>
								<?php echo $item['name']?></td>
							<td>
								<?php echo $item['teacher_name']?></td>
							<td><?php echo ($item['type']==1?'校内':'校外') ?></td>
							<td>
								<a href="<?php echo site_url('teacher_class/logic_class_check').'/'.$item['id']?>">查看</a></td>
							<td>
								<a href="<?php echo site_url('teacher_class/logic_class_edit').'/'.$item['id']?>">编辑</a>
							</td>
							<td>
								<a onclick="delete_logic_class(<?=$item['id']?>)" href="#">删除</a>
							</td>
						</tr>
						<?php endforeach; ?></tbody>
			</table>
		</div>
	</div>	  	
</div>


<?php $this->load->view('teacher_home/_footer')?>