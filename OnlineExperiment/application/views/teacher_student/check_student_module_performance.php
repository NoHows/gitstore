<?php $this->load->view('teacher_home/_header') ?>
<?php $this->load->view('message') ?>

<script tyep="text/javascript">
  $().ready(function(){
    $("#student_li").addClass("active"); 
	  
  	});
</script>

<div class="container">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title"><?php echo $student['name'] ;?>在<?php echo $module['name'] ;?>的成绩列表</h3>
		</div>
		<div class="panel-body">
			<div id="table">
				<table class="table table-striped table-hover ">
					<thead>
						<tr>
							<th>序号</th>
							<th>考试时间</th>
							<th>考试成绩</th>
							<th><a href="<?php echo site_url('teacher_student/check_student_performance').'/'.$student['id'].'/'.$logic_class['id'].'/'.$class_id?>"class="btn btn-primary ">返回</a>						
							</th>
						</tr>
					</thead>
					<tbody>
						<?php $index=1; ?>
						<?php foreach ($reports as $item ): ?>
						<tr>
							<td>
								<?php echo $index++ ;?></td>
							<td>
								<?php echo $item['datetime']?></td>
							<td>
								<?php echo $item['grades']?></td>
							<td>
								<?php if ($item['state']==1): ?>        		 		
			        			<a href="<?php echo site_url('teacher_student/check_module_report').'/'.$item['id'].'/'.$module['id'].'/'.$logic_class['id'].'/'.$student_id?>" class="btn btn-primary ">
										查看
									</a>
			        			<?php endif ?>
			        		</td>
						</tr>
						<?php endforeach; ?></tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<?php $this->load->view('teacher_home/_footer')?>