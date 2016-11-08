<?php $this->load->view('teacher_home/_header')?>
<?php $this->load->view('message') ?>
<script type="text/javascript">
  $().ready(function(){
    $("#main_page_li").addClass("active");    
  });
</script>
<div class="container">
	<div class="col-md-4">
		<div class="panel panel-primary">
	  		<div class="panel-heading">
	    		<h3 class="panel-title">个人信息</h3>
	  		</div>
	 		 <div class="panel-body">
	    		<div class="row form-group" style="border-bottom:1px ridge;">
			      <label  class="col-lg-6 control-label">姓名</label>
			      <div class="col-lg-6">
			      		<label  class="ontrol-label"><?=$teacher['name']?></label>
			      </div>
			    </div>
			    <div class="row form-group" style="border-bottom:1px ridge;">
			      <label  class="col-lg-6 control-label">教职工号</label>
			      <div class="col-lg-6">
			      		<label  class="ontrol-label"><?=$teacher['teacher_number']?></label>
			      </div>
			    </div>
			    <div class="row form-group" style="border-bottom:1px ridge;">
			      <label  class="col-lg-6 control-label">专业</label>
			      <div class="col-lg-6">
			      		<label  class="ontrol-label"><?=$teacher['major_name']?></label>
			      </div>
			    </div>
			    <div class="row form-group" style="border-bottom:1px ridge;">
			      <label  class="col-lg-6 control-label">我的课程</label>
			      <div class="col-lg-6">
			      		<label  class="ontrol-label"><?=$my_logic_class_count?></label>
			      </div>
			    </div>
			    <div class="row form-group" style="border-bottom:1px ridge;">
			      <label  class="col-lg-6 control-label">我的学生</label>
			      <div class="col-lg-6">
			      		<label  class="ontrol-label"><?=$my_students_count?></label>
			      </div>
			    </div>
			    <!-- <div class="row form-group" style="border-bottom:1px ridge;">
			      <label  class="col-lg-6 control-label">我的组卷</label>
			      <div class="col-lg-6">
			      		<label  class="ontrol-label"><?=$my_module_count?></label>
			      </div>
			    </div> -->
	  		</div>
		</div>
	</div>
	<div class="col-md-3">
		<div class="panel panel-primary">
	  		<div class="panel-heading">
	    		<h3 class="panel-title">系统信息</h3>
	  		</div>
	 		 <div class="panel-body">
	    		<div class="row form-group" style="border-bottom:1px ridge;">
			      <label  class="col-lg-8 control-label">课程</label>
			      <div class="col-lg-4">
			      		<label  class="ontrol-label"><?=$big_lecture_count?></label>
			      </div>
			    </div>
			    <div class="row form-group" style="border-bottom:1px ridge;">
			      <label  class="col-lg-8 control-label">实验模块</label>
			      <div class="col-lg-4">
			      		<label  class="ontrol-label"><?=$module_count?></label>
			      </div>
			    </div>
			    <div class="row form-group" style="border-bottom:1px ridge;">
			      <label  class="col-lg-8 control-label">题目</label>
			      <div class="col-lg-4">
			      		<label  class="ontrol-label"><?=$question_count?></label>
			      </div>
			    </div>			    
	  		</div>
		</div>
	</div>
	
</div>
<?php $this->load->view('student_home/_footer')?>