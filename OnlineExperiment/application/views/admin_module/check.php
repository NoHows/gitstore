<?php $this->
load->view('admin_home/_header') ?>
<?php $this->
load->view('message') ?>
<script tyep="text/javascript">
  $().ready(function(){
    $("#module_li").addClass("active"); 

 	
     
      
  });
      
  });
</script>

<div class="container">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title">查看实验模块</h3>
		</div>
		<div class="panel-body">
			<fieldset>
					<div class="form-group">
						<label class="col-lg-2 control-label">实验序号:</label>
						<div class="col-lg-10">
							<p ><?=$module['module_sort']?></p>
						</div>

					</div>
					<div class="form-group">
						<label class="col-lg-2 control-label">实验名称:</label>
						<div class="col-lg-10">
							<p ><?=$module['name']?></p>
						</div>

					</div>
					<div class="form-group">
						<label class="col-lg-2 control-label">相关课程:</label>
						<div class="col-lg-10">
							<p ><?=$module['big_lecture_name']?></p>
						</div>
						
					</div>

					<div class="form-group">
						<label class="col-lg-2 control-label"></label>
						<div class="col-lg-10">
							<a class="btn btn-primary" href="<?php echo site_url('admin_module/edit').'/'.$module['id']?>">编辑</a>
							<a class="btn btn-primary" href="<?php echo site_url('admin_class/big_lecture_check').'/'.$big_lecture_id?>">返回</a>
						</div>
						
					</div>
					
				</fieldset>

		</div>
	</div>
</div>
<?php $this->load->view('admin_home/_footer')?>