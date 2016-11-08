<?php $this->load->view('admin_home/_header') ?>
<?php $this->load->view('message') ?>

<script tyep="text/javascript">
  $().ready(function(){
    $("#main_page_li").addClass("active"); 
	  
  	});

  	function delete_item(id)
	{
		if(confirm("删除后不可恢复，确定吗？"))
			location.href="<?php echo site_url('admin_module/delete').'/'.$big_lecture['id'].'/'?>"+id;
	}
</script>

<div class="container">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title"><?php echo $big_lecture['name'] ;?>实验列表</h3>
		</div>
		<div class="panel-body">
			<div id="table">
				<table class="table table-striped table-hover ">
					<thead>
						<tr>
							<th>实验序号</th>
							<th>实验名称</th>
							<th>操作</th>
							<th></th>
							<th>
								<a href="<?php echo site_url('admin_module/add').'/'.$big_lecture['id']?>" class="btn btn-primary ">
									添加
								</a>
							</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($relative_modules as $item ): ?>
						<tr>
							<td>
								<?php echo $item['module_sort'] ;?></td>
							<td>
								<?php echo $item['name']?></td>
							<td>
								<a href="<?php echo site_url('admin_module/check').'/'.$item['id'].'/'.$big_lecture['id']?>">查看</a>
							</td>
							<td>
								<a href="<?php echo site_url('admin_module/edit').'/'.$item['id'].'/'.$big_lecture['id']?>">编辑</a>
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