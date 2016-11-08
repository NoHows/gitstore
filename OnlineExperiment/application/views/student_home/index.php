<?php $this->load->view('student_home/_header')?>
<script type="text/javascript">
  $().ready(function(){
    $("#main_page_li").addClass("active");    
  });

	function addLoadEvent(func){
 		var oldonload = window.onload;
 		if (typeof window.onload != 'function'){
  			window.onload = func;
  			}
 		else{
   			window.onload = function(){
    			oldonload();
    			func();
    			}
   			}
	}

	function password_change()
	{
		var change_password = <?php echo $change_password?>;
		if (!change_password) {
			if(confirm("请及时修改您的初始密码，并妥善保存！"))
				location.href="<?php echo site_url('student_home/change_password')?>";
		}
	}
	addLoadEvent(password_change);
</script>

	<div class="container">
	<div class="col-md-3">
		<div class="panel panel-primary">
	  		<div class="panel-heading">
	    		<h3 class="panel-title">个人信息</h3>
	  		</div>
	 		 <div class="panel-body">
	    		<div class="row form-group" style="border-bottom:1px ridge;">
			      <label  class="col-lg-4 control-label">姓名</label>
			      <div class="col-lg-8">
			      		<label  class="ontrol-label"><?php echo $student['name']?></label>
			      </div>
			    </div>
			    <div class="row form-group" style="border-bottom:1px ridge;">
			      <label  class="col-lg-4 control-label">学号</label>
			      <div class="col-lg-8">
			      		<label  class="ontrol-label"><?php echo $student['student_id']?></label>
			      </div>
			    </div>
			    <div class="row form-group" style="border-bottom:1px ridge;">
			      <label  class="col-lg-4 control-label">专业</label>
			      <div class="col-lg-8">
			      		<label  class="ontrol-label"><?php echo $major['name']?></label>
			      </div>
			    </div>
			    <div class="row form-group" style="border-bottom:1px ridge;">
			      <label  class="col-lg-4 control-label">班级</label>
			      <div class="col-lg-8">
			      		<label  class="ontrol-label"><?php echo $class['name']?></label>
			      </div>
			    </div>
			    <?php if($student['type']==2) {?>
			    <div class="row form-group" style="border-bottom:1px ridge;">
			      <label  class="col-lg-4 control-label"></label>
			      <div class="col-lg-8">
			      		<a href="<?php echo site_url('student_home/update_register_logic_class')?>" class="btn btn-primary ">更新课程</a>
			      </div>
			    </div>
			    <?php }?>
	  		</div>
		</div>
	</div>



<div class="col-md-9">
	<div class="panel panel-primary">
		<div class="panel-heading">
	    		<h3 class="panel-title">课程信息</h3>
	  	</div>
		<div class="panel-body">
			<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
				<?php  $index=0; foreach ($all_logic_class_module as $item_logic_class ): ?>
					<div class="panel panel-default">
					    <div class="panel-heading" role="tab" id="heading<?=$index?>">
					      <h4 class="panel-title">
					        <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?=$index?>" aria-expanded="true" aria-controls="collapse<?=$index?>">
					         	<?php echo '(逻辑班号：'.$item_logic_class[0]['logic_class_number'].')课程名称：'.$item_logic_class[0]['big_lecture_name'] ?>
					         	<!-- .'<'.($item['type']==1?'校内':'校外').'>' -->
					        </a>
					      </h4>
					    </div>
					    <div id="collapse<?=$index?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading<?=$index?>">
					     
					      <div class="panel-body">
					      		
					      			<table class="table table-striped table-hover ">
										<thead>
											<tr>
												<th>实验名称</th>
										        <th>考试次数</th>
										        <th>最高成绩</th>
										        <th>最低成绩</th>			      
										        <th>操作</th>
											</tr>
										</thead>
										<tbody>
											<?php $i=1; ?>
											
											<?php  foreach ($item_logic_class as $item_module ): ?>
		       								 <?php if($item_module['module_id']) { ?>
											<tr>
									        	<th><?php echo $item_module['module_name']?></th>
									        	<td><?php echo $item_module['report_count']?></td>
										        <td><?php echo $item_module['report_max_grade']?></td>
										        <td><?php echo $item_module['report_min_grade']?></td>
										        <?php 
										        $module_id = $item_module['module_id'];
										        $logic_class_id = $item_module['logic_class_id']; 
										        $big_lecture_id = $item_logic_class[0]['big_lecture_id']
										        ?>
										        <td><a href="<?php echo site_url('student_home/module_check').'/'.$student['id'].'/'.$module_id.'/'.$logic_class_id.'/'.$big_lecture_id?>" class="btn btn-primary ">
															查看详细
													</a></td>
												<th>
													<?php if ($item_module['report_max_grade']<100) {?>
														<a href="<?php echo site_url('student_test/test').'/'.$student['id'].'/'.$item_module['module_id'].'/'.$item_module['logic_class_id'].'/'.$item_module['time_limit']?>" class="btn btn-primary ">
												     去考试
													</a>
													<?php } else {?>
														预习完成
													<?php }?>
													
												</th>

										        <!-- <td>
										        <?php 
										        $module_id = $item_module['id']; 
										        $report_id = $item_module['report_id']; 
										        $logic_class_id = $item_module['logic_class_id']; 
										        if ($report_id==0) { ?>
												        <a href="<?php echo site_url('student_test/test').'/'.$student['id'].'/'.$module_id.'/'.$logic_class_id.'/'.$item_module['time_limit']?>" class="btn btn-primary ">
															去考试
														</a>
												<?php }  
												else { ?>
														<a href="<?php echo site_url('student_test/check').'/'.$report_id.'/'.$module_id.'/'.$logic_class_id.'/'.$student['id']?>" class="btn btn-primary ">
															查看
														</a>
												<?php } ?>
										        </td> -->
									    	</tr>
										    <?php } else {?>
										    <tr>
										    <th>该课程没有实验</th>			    
										    </tr>
										    <?php }?>

											<?php endforeach;?></tbody>
									</table>
					      </div> 
					    </div>
				  	</div>
				<?php $index++; ?>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</div>




<?php $this->load->view('student_home/_footer')?>