<?php $this->load->view('admin_home/_header') ?>
<?php $this->load->view('message') ?>
<script type="text/javascript">
  $().ready(function(){
    $("#class_li").addClass("active"); 

    $("#class_edit_form").validate({
		rules:{
			class_name:
			{
				required:true,
				maxlength:45
			}
		}
	});   
  });
</script>

<div class="container">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title">编辑班级信息</h3>
		</div>
		<div class="panel-body">
			<?php echo validation_errors(); ?>
			<form id="class_edit_form" method="post" class="form-horizontal"  enctype="multipart/form-data" action="<?php echo site_url('admin_class/class_edit')?>" >
				<fieldset>
					<input type="text" id="class_id" name="class_id" value="<?=$class['id']?>" class="hidden">
					<div class="form-group">
						<label class="col-lg-2 control-label">名称:</label>
						<div class="col-lg-8">
							<input class="form-control" id="class_name" name="class_name" value="<?=$class['name']?>" />
						</div>

					</div>
					
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