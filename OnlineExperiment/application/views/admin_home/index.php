<?php $this->load->view('admin_home/_header')?>
<?php $this->load->view('message') ?>
<script type="text/javascript">
  $().ready(function(){
    $("#main_page_li").addClass("active");    
  });

	function delete_item(id)
	{
		if(confirm("将删除本课程及其所有的实验，删除后不可恢复，确定吗？"))
			location.href="<?php echo site_url('admin_class/big_lecture_delete').'/'?>"+id;
	}
</script>
<div class="container">
	<div class="col-md-3">
		<div class="panel panel-primary">
	  		<div class="panel-heading">
	    		<h3 class="panel-title">系统信息</h3>
	  		</div>
	 		 <div class="panel-body">
			    <div class="row form-group" style="border-bottom:1px ridge;">
			      <label  class="col-lg-8 control-label">题目</label>
			      <div class="col-lg-4">
			      		<label  class="ontrol-label"><?=$question_count?></label>
			      </div>
			    </div>
			    <div class="row form-group" style="border-bottom:1px ridge;">
			      <label  class="col-lg-8 control-label">课程</label>
			      <div class="col-lg-4">
			      		<label  class="ontrol-label"><?=$big_lecture_count?></label>
			      </div>
			    </div>
			    <div class="row form-group" style="border-bottom:1px ridge;">
			      <label  class="col-lg-8 control-label">教师</label>
			      <div class="col-lg-4">
			      		<label  class="ontrol-label"><?=$teacher_count?></label>
			      </div>
			    </div>
			     <div class="row form-group" style="border-bottom:1px ridge;">
			      <label  class="col-lg-8 control-label">班级</label>
			      <div class="col-lg-4">
			      		<label  class="ontrol-label"><?=$class_count?></label>
			      </div>
			    </div>
			    <div class="row form-group" style="border-bottom:1px ridge;">
			      <label  class="col-lg-8 control-label">学生</label>
			      <div class="col-lg-4">
			      		<label  class="ontrol-label"><?=$student_count?></label>
			      </div>
			    </div>
			   
	  		</div>
		</div>
	</div>
	<div class="col-md-9">
			
			<div class="row">
				<div class="panel panel-primary">
			  		<div class="panel-heading">
			    		<h3 class="panel-title">课程列表</h3>
			  		</div>
			 		 <div class="panel-body">
			    		<div id="table">
							<table class="table table-striped table-hover ">
								<thead>
									<tr>
										<th>序号</th>
										<th>课程名称</th>
										<th>实验数量</th>
										<th>操作</th>
										<th></th>
										<th>
											<a href="<?php echo site_url('admin_class/big_lecture_add')?>" class="btn btn-primary ">
												添加
											</a>
										</th>
									</tr>
								</thead>
								<tbody>
									<?php $index=1; ?>
									<?php foreach ($big_lectures_with_module_count as $item ): ?>
									<tr>
										<td>
											<?php echo $index++ ;?></td>
										<td>
											<?php echo $item['name']?></td>
											<td>
											<?php echo $item['module_count']?></td>
										<td>
											<a href="<?php echo site_url('admin_class/big_lecture_check').'/'.$item['id']?>">查看</a></td>
										<td>
											<a href="<?php echo site_url('admin_class/big_lecture_edit').'/'.$item['id']?>">编辑</a>
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
	</div>
</div>
<?php $this->load->view('admin_home/_footer')?>