<?php $this->load->view('admin_home/_header') ?>
<?php $this->load->view('message') ?>

<link type="text/css" rel="stylesheet" href="<?php echo base_url()?>css/jquery.dataTables.min.css"/>
<script type="text/javascript" src="<?php echo base_url()?>js/jquery.dataTables.min.js"></script>

<script tyep="text/javascript">
  $().ready(function(){
    $("#class_li").addClass("active"); 
	$('#classTable').DataTable({
		paging: false,
		searching: false
    	});
	$('#logic_class_table').DataTable({
		paging: false,
		searching: false
    	});

	$("#<?=$active_tab?>").addClass("active in");
	$("#<?=$active_tab?>_li").addClass("active");
  	});

  	function delete_class(id)
	{
		if(confirm("删除后不可恢复，确定吗？"))
			location.href="<?php echo site_url('admin_class/class_delete').'/'?>"+id;
	}

	function delete_major(id)
	{
		if(confirm("删除后不可恢复，确定吗？"))
			location.href="<?php echo site_url('admin_class/major_delete').'/'?>"+id;
	}

	function delete_logic_class(id)
	{
		if(confirm("删除后不可恢复，确定吗？"))
			location.href="<?php echo site_url('admin_class/logic_class_delete').'/'?>"+id;
	}
	function delete_register_logic_class(id)
	{
		if(confirm("删除后不可恢复，确定吗？"))
			location.href="<?php echo site_url('admin_class/delete_register_logic_class').'/'?>"+id;
	}
	
</script>
<div class="container">
	<div class="panel panel-default">
		<div class="panel-body">
			<ul class="nav nav-tabs">
			  <li id="class_tab_li"><a href="#class_tab" data-toggle="tab" aria-expanded="true">班级</a></li>
			  <li id="major_tab_li"><a href="#major_tab" data-toggle="tab" aria-expanded="true">专业</a></li>
			  <li id="logic_class_tab_li"><a href="#logic_class_tab" data-toggle="tab" aria-expanded="true">逻辑班</a></li>
			</ul>
			<div id="myTabContent" class="tab-content">
				<div class="tab-pane fade" id="class_tab">
					<div id="table">
						<table id="classTable" class="table table-striped table-hover ">
							<thead>
								<tr>
									<th>序号</th>
									<th>班级名称</th>						
									<th></th>
									<th></th>
									<th>
										<a href="<?php echo site_url('admin_class/class_add')?>" class="btn btn-primary ">
											添加
										</a>
									</th>
								</tr>
							</thead>
							<tbody>
								<?php $index=1; ?>
								<?php foreach ($classes as $item ): ?>
								<tr>
									<td>
										<?php echo $index++ ;?></td>
									<td>
										<?php echo $item['name']?></td>
									<td>
										<a href="<?php echo site_url('admin_class/class_check').'/'.$item['id']?>">查看</a></td>
									<td>
										<a href="<?php echo site_url('admin_class/class_edit').'/'.$item['id']?>">编辑</a>
									</td>
									<td>
										<a onclick="delete_class(<?=$item['id']?>)" href="#">删除</a>
									</td>
								</tr>
								<?php endforeach; ?></tbody>
						</table>
					</div>
				</div>
				<div class="tab-pane fade" id="major_tab">
					<table class="table table-striped table-hover ">
							<thead>
								<tr>
									<th>序号</th>
									<th>专业名称</th>						
									<th></th>
									<th>
										<a href="<?php echo site_url('admin_class/major_add')?>" class="btn btn-primary ">
											添加
										</a>
									</th>
								</tr>
							</thead>
							<tbody>
								<?php $index=1; ?>
								<?php foreach ($majors as $item ): ?>
								<tr>
									<td>
										<?php echo $index++ ;?></td>
									<td>
										<?php echo $item['name']?></td>
									
									<td>
										<a href="<?php echo site_url('admin_class/major_edit').'/'.$item['id']?>">编辑</a>
									</td>
									<td>
										<a onclick="delete_major(<?=$item['id']?>)" href="#">删除</a>
									</td>
								</tr>
								<?php endforeach; ?></tbody>
						</table>
				</div>
				<div class="tab-pane fade" id="logic_class_tab">
					<table id="logic_class_table" class="table table-striped table-hover ">
							<thead>
								<tr>
									<th>序号</th>
									<th>逻辑班号</th>
									<th>课程名称</th>
									<th>任课教师</th>						
									<th></th>
									<th></th>
									<th>
										<a href="<?php echo site_url('admin_class/logic_class_add')?>" class="btn btn-primary ">
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
										<?php echo $item['big_lecture_name']?></td>
									<td>
										<?php echo $item['teacher_name']?></td>
									<td>
										<a href="<?php echo site_url('admin_class/logic_class_check').'/'.$item['id']?>">查看</a></td>
									<td>
										<a href="<?php echo site_url('admin_class/logic_class_edit').'/'.$item['id']?>">编辑</a>
									</td>
									<td>
										<?php if($item['type']==1) {?>
											<a onclick="delete_logic_class(<?=$item['id']?>)" href="#">删除</a>
										<?php }?>
										<?php if($item['type']==2) {?>
											<a onclick="delete_register_logic_class(<?=$item['id']?>)" href="#">删除</a>
										<?php }?>
									</td>
								</tr>
								<?php endforeach; ?></tbody>
						</table>
				</div>
			</div>
	  	</div>
	</div>
</div>


<?php $this->load->view('admin_home/_footer')?>