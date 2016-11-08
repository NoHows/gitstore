<?php $this->load->view('admin_home/_header') ?>
<?php $this->load->view('message') ?>

<script type="text/javascript">
  $().ready(function(){
    $("#question_li").addClass("active");

    $('.selectpicker').selectpicker();   
  });

  function check_button_click()
  	{
  		var id=$(".selectpicker").val();
  		if(id!='0')
  			location.href="<?php echo site_url('admin_question/check').'/'?>"+id;
  	}

  	function edit_button_click()
  	{
  		var id=$(".selectpicker").val();
  		if(id!='0')
  			location.href="<?php echo site_url('admin_question/edit').'/'?>"+id;
  	}

  	function delete_button_click()
  	{
  		var id=$(".selectpicker").val();
  		if(id!='0')
  			if(confirm("删除后不可恢复，确定吗？"))
  			location.href="<?php echo site_url('admin_question/delete').'/'?>"+id;
  	}

  	function delete_item(id)
  	{
  		if(confirm("删除后不可恢复，确定吗？"))
  			location.href="<?php echo site_url('admin_question/delete').'/'?>"+id;
  	}
</script>


<div class="container">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title">查询题目</h3>
		</div>
		<div class="panel-body">
			<div class="col-lg-9">
				<select class="selectpicker form-control" id="questions_select" data-live-search="true">
					<option value="0">点击输入题号，题目，实验来查询题目</option>
					<?php foreach ($questions_all as $item ): ?>
						<option value="<?=$item['id']?>">
							<?php echo $item['number'].':'.$item['content_main'].'('.$item['module_name'].')'?>
						</option>
					<?php endforeach ?>
				</select>
			</div>
			<div class="col-lg-1">
				<button onclick="check_button_click()" class="btn btn-primary">查看</button>
			</div>
			<div class="col-lg-1">
				<a onclick="edit_button_click()" class="btn btn-primary">编辑</a>
			</div>
			<div class="col-lg-1">
				<a onclick="delete_button_click()" class="btn btn-primary">删除</a>
			</div>
		</div>	

	</div>
</div>
<div class="container">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title">题目列表</h3>
		</div>
		<div class="panel-body">
			<div id="table">
				<table class="table table-striped table-hover ">
					<thead>
						<tr>
							<th>题号</th>
							<th>内容</th>
							<th>实验名称</th>
							<th>操作</th>
							<th></th>
							
							<th>
								<a href="<?php echo site_url('admin_question/add')?>
									" class="btn btn-primary ">
									添加
								</a>
							</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($questions as $item ): ?>
						<tr>
							<td>
								<?php echo $item['number']?></td>
							<td>
								<?php echo $item['content_main']?></td>

							<td>
								<?php echo $item['module_name']?></td>
							<td>
								<a href="<?php echo site_url('admin_question/check').'/'.$item['id']?>">查看</a>
							</td>
							<td>
								<a href="<?php echo site_url('admin_question/edit').'/'.$item['id']?>">编辑</a>
							</td>
							<td>
								<a onclick="delete_item(<?=$item['id']?>)" href="#">删除</a>
							</td>
						</tr>
						<?php endforeach; ?></tbody>
				</table>
				<?php echo $this->pagination->create_links(); ?>
			</div>

		</div>
	</div>

</div>

<?php $this->load->view('admin_home/_footer')?>