
<?php $this->load->view('teacher_home/_header') ?>
<?php $this->load->view('message') ?>

<script type="text/javascript" src="<?php echo base_url()?>js/jquery.battatech.excelexport.min.js"></script>

<script tyep="text/javascript">
  $().ready(function(){
    $("#performance_li").addClass("active"); 
	 
	 $('.selectpicker').selectpicker({});
	 $("#export_all_grades_form").validate({
		rules:{
			logic_class_id:
			{
				required:true
			},
			
		}
	});  
	
    
  });

   
</script>

<div class="container">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title">选项</h3> 
		</div>
		<div class="panel-body">
			<form id="export_all_grades_form" method="post" class="form-horizontal"  enctype="multipart/form-data" action="<?php echo site_url('teacher_performance/export_all_grades')?>" >
				<fieldset>
				<div class="row">
					<div class="form-group">
						<label class="col-lg-2 control-label">逻辑班:</label>
						<div class="col-lg-8">
							<select class="form-control" name="logic_class_id" id="logic_class_id">
								<option value="">--不限--</option>
								<?php foreach ($logic_classes as $item) :?>
									<option value="<?=$item['id']?>" 
										<?php if (isset($logic_class_id_selected)&&$item['id']==$logic_class_id_selected): ?>
											selected="selected"
										<?php endif ?>
									>
										<?=$item['big_lecture_name']?>(逻辑班号：<?=$item['number']?>)
									</option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-lg-2 control-label">模块:</label>
						<div class="col-lg-8">

							<select class="selectpicker form-control" multiple data-live-search="true" data-style="btn-primary" multiple data-selected-text-format="count" name="relative_modules[]">

								<?php foreach ($modules as $item ): ?>
								<option value="<?=$item['id']?> 
									">
									<?=$item['name']?><?php echo $item['type']==0?'(系统)':'(定制)'?>
								</option>
								<?php endforeach ?></select>

						</div>
					</div>

					
					<div class="form-group">
						<label class="col-lg-2 control-label"></label>
						<div class="col-lg-10">
							<button type="submit" class="btn btn-primary">导出</button>
						</div>
					</div>
					
				</div>
				
				</fieldset>
			</form>
		</div>
	</div>
</div>


  
<?php $this->load->view('teacher_home/_footer')?>