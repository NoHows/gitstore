<?php $this->load->view('teacher_home/_header')?>
<script type="text/javascript">
  $().ready(function(){
    $("#student_li").addClass("active");    
  });
</script>
	
	<div class="container">
	<div class="col-md-3">
		<div class="panel panel-primary">
	  		<div class="panel-heading">
	    		<h3 class="panel-title">学生信息</h3>
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
			    <a class="btn btn-primary" href="<?php echo site_url('teacher_student/check_class').'/'.$before_logic_class_id.'/'.$before_class_id?>">返回</a>
	  		</div>
		</div>
	</div>


	<div class="col-md-9">

<div class="panel panel-primary">
	<div class="panel-heading">

	    		<h3 class="panel-title">课程信息</h3>
	  		</div>
		<div class="bs-example">
		    <table class="table table-striped">
		      <thead>
		      
		       
		      </thead>
		      <tbody>
		      	    
		     <?php  $i=1; foreach ($all_logic_class_module as $item_logic_class ): ?>	
		      	
		        <tr  class="success">			       
			        <th>课程名称</th>
			        <th><?php echo $item_logic_class[0]['big_lecture_name']?></th>			       
			        <th>逻辑班号</th>
			        <th><?php echo $item_logic_class[0]['logic_class_number']?></th>
			        <th></th>
			        <th></th>
			        <th></th>
		        </tr>
		        
		         <tr>
			        <th>实验序号</th>
			        <th>实验名称</th>
			        <th>时间限制</th>
			        <th>考试次数</th>			      
			        <th>操作</th>
		        </tr>
		      <?php  foreach ($item_logic_class as $item_module ): ?>
		        <?php if($item_module['module_id']) { ?>
		        <tr>
		        	<th><?php echo $item_module['module_sort']; $i++;?></th>
		        	<td><?php echo $item_module['module_name']?></td>
			        <td><?php echo $item_module['time_limit']?></td>
			        <td><?php echo $item_module['report_count']?></td>
			        <?php 
			        $module_id = $item_module['module_id'];
			        $logic_class_id = $item_module['logic_class_id']; 
			        $big_lecture_id = $item_logic_class[0]['big_lecture_id'];
			        ?>
			        <td><a href="<?php echo site_url('teacher_student/check_student_module_performance').'/'.$student['id'].'/'.$module_id.'/'.$logic_class_id.'/'.$big_lecture_id?>" class="btn btn-primary ">
								查看详细
						</a></td> 
					

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
		       <?php endforeach; ?>
		       <?php endforeach; ?>
		      </tbody>
		    </table>
  		</div>
		
	</div>

	</div>
</div>

<?php $this->load->view('student_home/_footer')?>