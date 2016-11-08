<?php $this->
load->view('admin_home/_header') ?>
<?php $this->
load->view('message') ?>
<script tyep="text/javascript">
  $().ready(function(){
	    $("#module_li").addClass("active"); 

	 	$('.selectpicker').selectpicker({});
	 	
	    $("#module_add_form").validate({
			rules:{
				module_name:
				{
					required:true,
					maxlength:200
				},
				module_sort:
				{
					required:true,
					maxlength:200
				},
				big_lecture_id:
				{
					required:true,
				},
				
			}
		});   
  });
</script>

<div class="container">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title">添加模块</h3>
		</div>
		<div class="panel-body">
			<?php echo validation_errors(); ?>
			<form id="module_add_form" method="post" class="form-horizontal"  enctype="multipart/form-data" action="<?php echo site_url('admin_module/add')?>
				" >
				<input type="text" id="module_type" name="module_type" value="0
				" class="hidden">
				<input type="text" id="big_lecture_id" name="big_lecture_id" value="<?=$big_lectures_selected?>
				" class="hidden">
				<fieldset>
					<div class="form-group">
						<label class="col-lg-2 control-label">实验名称:</label>
						<div class="col-lg-8">
							<input class="form-control" id="module_name" name="module_name"/>
						</div>

					</div>
					<div class="form-group">
						<label class="col-lg-2 control-label">实验序号:</label>
						<div class="col-lg-8">
							<input class="form-control" id="module_sort" name="module_sort"/>
						</div>

					</div>
					<!-- <div class="form-group">
						<label class="col-lg-2 control-label">相关课程:</label>
						<div class="col-lg-8">
							<select class="form-control" name="big_lecture_id" id="big_lecture_id">
								<option value="">--相关课程--</option>
								<?php foreach ($big_lectures as $item) :?>
									<option value="<?=$item['id']?>">
										<?=$item['name']?>
									</option>
								<?php endforeach; ?>
							</select>
						</div>
					</div> -->

					<div class="form-group">
						<div class="col-lg-10 col-lg-offset-2">
							<button type="submit" class="btn btn-primary">提交</button>
						</div>
					</div>
				</fieldset>
			</form>
		</div>
	</div>
</div>

<?php $this->load->view('admin_home/_footer')?>