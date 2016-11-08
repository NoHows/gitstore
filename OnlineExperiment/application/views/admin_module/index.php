<?php $this->load->view('admin_home/_header') ?>
<?php $this->load->view('message') ?>

<script tyep="text/javascript">
  $().ready(function(){
    $("#module_li").addClass("active"); 
	  
  	});

  	function delete_item(id)
	{
		if(confirm("删除后不可恢复，确定吗？"))
			location.href="<?php echo site_url('admin_module/delete').'/'?>"+id;
	}
</script>

<div class="container">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title">当前的模块</h3>
		</div>
		<div class="panel-body">
			<div id="table">
				<table class="table table-striped table-hover ">
					<thead>
						<tr>
							<th>序号</th>
							<th>名称</th>
							<th>考试时间</th>
							<th>操作</th>
							<th></th>
							<th>
								<a href="<?php echo site_url('admin_module/add')?>" class="btn btn-primary ">
									添加
								</a>
							</th>
						</tr>
					</thead>
					<tbody>
						<?php $index=1; ?>
						<?php foreach ($modules as $item ): ?>
						<tr>
							<td>
								<?php echo $index++ ;?></td>
							<td>
								<?php echo $item['name']?></td>
							<td>
								<?php echo $item['time_limit']?>分钟</td>
							<td>
								<a href="<?php echo site_url('admin_module/check').'/'.$item['id']?>">查看</a>
							</td>
							<td>
								<a href="<?php echo site_url('admin_module/edit').'/'.$item['id']?>">编辑</a>
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