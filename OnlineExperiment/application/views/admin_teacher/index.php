
<?php $this->load->view('admin_home/_header') ?>
<?php $this->load->view('message') ?>

<script tyep="text/javascript">
  $().ready(function(){
    $("#teacher_li").addClass("active"); 
	  
  	});

  	function delete_item(id)
	{
		if(confirm("删除后不可恢复，确定吗？"))
			location.href="<?php echo site_url('admin_teacher/delete').'/'?>"+id;
	}
</script>

<div class="container">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title">教师列表</h3>
		</div>
		<div class="panel-body">
			<div id="table">
				<table class="table table-striped table-hover ">
					<thead>
						<tr>
							<th>序号</th>
							<th>教师姓名</th>
							<th>专业</th>
							<th>教职工号</th>							
							<th></th>
							<th>
								<a href="<?php echo site_url('admin_teacher/add')?>" class="btn btn-primary ">
									添加
								</a>
							</th>
						</tr>
					</thead>
					<tbody>
						<?php $index=1; ?>
						<?php foreach ($teachers as $item ): ?>
						<tr>
							<td>
								<?php echo $index++ ;?></td>
							<td>
								<?php echo $item['name']?></td>
							<td>
								<?php echo $item['major_name']?></td>
							<td>
								<?php echo $item['teacher_number']?></td>
							<td>
								<a href="<?php echo site_url('admin_teacher/edit').'/'.$item['id']?>">编辑</a>
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