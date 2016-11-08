<?php $this->load->view('teacher_home/_header')?>
<?php $this->load->view('message') ?>

<script type="text/javascript" src="<?php echo base_url()?>js/fancybox/jquery.fancybox.pack.js"></script>
<link type="text/css" rel="stylesheet" href="<?php echo base_url()?>css/fancybox/jquery.fancybox.css"/>
<style type="text/css">
	#question_number:hover div{
		display: inline !important;
	}
</style>
<title><?php echo $title; ?></title>

<script type="text/javascript">
  $().ready(function(){
    	$("#student_li").addClass("active");

    	$(".fancybox-effects").fancybox({
			padding: 0,

			openEffect : 'elastic',
			openSpeed  : 150,

			closeEffect : 'elastic',
			closeSpeed  : 150,

			closeClick : true,

			helpers : {
				overlay : null
			}
		});
  });
</script>

<div class="container">
<div class="col-md-3">
		<div class="panel panel-primary">
	  		<div class="panel-heading">
	    		<h3 class="panel-title">个人信息</h3>
	  		</div>
	 		 <div class="panel-body">
	    		<div class="row form-group" style="border-bottom:1px ridge;">
			      <label  class="col-lg-5 control-label">姓名</label>
			      <div class="col-lg-7">
			      		<label  class="ontrol-label"><?php echo $student['name']?></label>
			      </div>
			    </div>
			    <div class="row form-group" style="border-bottom:1px ridge;">
			      <label  class="col-lg-5 control-label">学号</label>
			      <div class="col-lg-7">
			      		<label  class="ontrol-label"><?php echo $student['student_id']?></label>
			      </div>
			    </div>
			    <div class="row form-group" style="border-bottom:1px ridge;">
			      <label  class="col-lg-5 control-label">考试科目</label>
			      <div class="col-lg-7">
			      		<label  class="ontrol-label"><?php echo $module['name']?></label>
			      </div>
			    </div>
			    <div class="row form-group" style="border-bottom:1px ridge;">
			      <label  class="col-lg-5 control-label">考试成绩</label>
			      <div class="col-lg-7">
			      		<label  class="ontrol-label"><?php echo $grades;?></label>
			      </div>
			    </div>
			   <a href="<?php echo site_url('teacher_student/check_student_module_performance').'/'.$student['id'].'/'.$module['id'].'/'.$logic_class_id.'/'.$module['big_lecture_id']?>" class="btn btn-primary ">
								返回成绩列表
						</a>
			   
	  		</div>
		</div>
	</div>

<div class="col-md-9">

	<div class="panel panel-primary">
		<fieldset>
			<div class="panel panel-default">
				<div class="panel-body">
					<?php  $i=1; foreach ($check_question as $question ): ?>
					<div class="form-group row">
						<!-- <label class="col-lg-1 control-label"><?php echo $i.'.';?></label> -->
						<!-- <label class="col-lg-1 control-label"><?php echo $question['id'].'.';?></label> -->
						<div class="col-lg-12">
							<div style="font-weight:bold; position:relative; ">
								<div id = "question_number" style="font-weight:bold; position:relative; display:inline"><?php echo $i;?>.<div style="display:none; position:absolute; bottom:15px; lift:0;width:100px;font-size:20px;"><?php echo $question['id']?></div></div>
									&nbsp&nbsp<?=$question['content_main']?><br>
							</div>
								<?php if ($question['picture_main_id']): ?>
									<img src="<?php echo base_url() ?>/uploads/<?php echo $question['id']?>/main.jpg?<?php echo rand()?>">
								<?php endif ?>
						</div>
						<!-- <div class="col-lg-4">
							<?php if ($question['picture_main_id']): ?>
								<a class="fancybox-effects" href="<?php echo base_url() ?>/uploads/<?php echo $question['id']?>/main.jpg?<?php echo rand()?>">
									<img src="<?php echo base_url() ?>/uploads/<?php echo $question['id']?>/main_thumb.jpg?<?php echo rand()?>">
								</a>
							<?php endif ?>
						</div> -->
					</div>

					<?php if ($question['content_1'] == '0' ||$question['content_1']||$question['picture_1_id']): ?>
					<div class="form-group row">
						<!-- <label class="col-lg-1 control-label"><input type="radio" name="answer[<?php echo $i?>]" value="1" /> A</label> -->
						<div class="col-lg-12">
							<p class="question-content">&nbsp&nbspA&nbsp&nbsp<?=$question['content_1']?> </p>
							<?php if ($question['picture_1_id']): ?>
								<img src="<?php echo base_url() ?>/uploads/<?php echo $question['id']?>/1.jpg?<?php echo rand()?>">
							<?php endif ?>
						</div>
						<!-- <div class="col-lg-4">
							<?php if ($question['picture_1_id']): ?>
								<a class="fancybox-effects" href="<?php echo base_url() ?>/uploads/<?php echo $question['id']?>/1.jpg?<?php echo rand()?>">
									<img src="<?php echo base_url() ?>/uploads/<?php echo $question['id']?>/1_thumb.jpg?<?php echo rand()?>">
								</a>
							<?php endif ?>
						</div> -->
					</div>
					<?php endif ?>

					<?php if ($question['content_2'] == '0' ||$question['content_2']||$question['picture_2_id']): ?>
					<div class="form-group row">
						<!-- <label class="col-lg-1 control-label"><input type="radio" name="answer[<?php echo $i?>]" value="2" /> B</label> -->
						<div class="col-lg-12">
							<p class="question-content">&nbsp&nbspB&nbsp&nbsp<?=$question['content_2']?> </p>
							<?php if ($question['picture_2_id']): ?>
								<img src="<?php echo base_url() ?>/uploads/<?php echo $question['id']?>/2.jpg?<?php echo rand()?>">
							<?php endif ?>
						</div>
						<!-- <div class="col-lg-4">
							<?php if ($question['picture_2_id']): ?>
								<a class="fancybox-effects" href="<?php echo base_url() ?>/uploads/<?php echo $question['id']?>/2.jpg?<?php echo rand()?>">
									<img src="<?php echo base_url() ?>/uploads/<?php echo $question['id']?>/2_thumb.jpg?<?php echo rand()?>">
								</a>
							<?php endif ?>
						</div> -->
					</div>
					<?php endif ?>

					<?php if ($question['content_3'] == '0' ||$question['content_3']||$question['picture_3_id']): ?>
					<div class="form-group row">
						<!-- <label class="col-lg-1 control-label"><input type="radio" name="answer[<?php echo $i?>]" value="3" /> C</label> -->
						<div class="col-lg-12">
							<p class="question-content">&nbsp&nbspC&nbsp&nbsp<?=$question['content_3']?> </p>
							<?php if ($question['picture_3_id']): ?>
								<img src="<?php echo base_url() ?>/uploads/<?php echo $question['id']?>/3.jpg?<?php echo rand()?>">
							<?php endif ?>
						</div>
						<!-- <div class="col-lg-4">
							<?php if ($question['picture_3_id']): ?>
								<a class="fancybox-effects" href="<?php echo base_url() ?>/uploads/<?php echo $question['id']?>/3.jpg?<?php echo rand()?>">
									<img src="<?php echo base_url() ?>/uploads/<?php echo $question['id']?>/3_thumb.jpg?<?php echo rand()?>">
								</a>
							<?php endif ?>
						</div> -->
					</div>
					<?php endif ?>

					<?php if ($question['content_4'] == '0' ||$question['content_4']||$question['picture_4_id']): ?>
					<div class="form-group row">
						<!-- <label class="col-lg-1 control-label"><input type="radio" name="answer[<?php echo $i?>]" value="4" /> D</label> -->
						<div class="col-lg-12">
							<p class="question-content">&nbsp&nbspD&nbsp&nbsp<?=$question['content_4']?> </p>
							<?php if ($question['picture_4_id']): ?>
								<img src="<?php echo base_url() ?>/uploads/<?php echo $question['id']?>/4.jpg?<?php echo rand()?>">
							<?php endif ?>
						</div>
						<!-- <div class="col-lg-4">
							<?php if ($question['picture_4_id']): ?>
								<a class="fancybox-effects" href="<?php echo base_url() ?>/uploads/<?php echo $question['id']?>/4.jpg?<?php echo rand()?>">
									<img src="<?php echo base_url() ?>/uploads/<?php echo $question['id']?>/4_thumb.jpg?<?php echo rand()?>">
								</a>
							<?php endif ?>
						</div> -->
					</div>
					<?php endif ?>


					<div class="col-lg-11">
					<?php   if ($question['choose'] == '1') {
								if ($question['answer'] == '1') {?>
									<p class="text-success">&nbsp&nbsp选择了A,答题正确</p>
									
								<?php }
								else{ ?>
									<p class="text-danger">&nbsp&nbsp选择了A,答题错误</p>
								<?php }
							}
							elseif ($question['choose'] == '2') {
								if ($question['answer'] == '2') {?>
									<p class="text-success">&nbsp&nbsp选择了B,答题正确</p>
									
								<?php }
								else{ ?>
									<p class="text-danger">&nbsp&nbsp选择了B,答题错误</p>
								<?php
							   		}
							}
							elseif ($question['choose'] == '3') {
								if ($question['answer'] == '3') {?>
									<p class="text-success">&nbsp&nbsp选择了C,答题正确</p>
									
								<?php }
								else{ ?>
									<p class="text-danger">&nbsp&nbsp选择了C,答题错误</p>
								<?php 
							   		}
							}
							elseif ($question['choose'] == '4') {
								if ($question['answer'] == '4') {?>
									<p class="text-success">&nbsp&nbsp选择了D,答题正确</p>
									
								<?php }
								else{ ?>
									<p class="text-danger">&nbsp&nbsp选择了D,答题错误</p>
								<?php
								}
							}
					?>

					</div>
					
					<hr size=5 color='black'>
					
					<?php $i++;?>
					<?php endforeach; ?>					
				</div>
			</div>
					
		</fieldset>
	</div>
 

</div>
</div>
<?php $this->load->view('teacher_home/_footer')?>