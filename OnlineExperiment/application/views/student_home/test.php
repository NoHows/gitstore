<?php $this->load->view('student_home/_header')?>
<?php $this->load->view('message') ?>

<link type="text/css" rel="stylesheet" href="<?php echo base_url()?>css/timer.css"/>
<script type="text/javascript" src="<?php echo base_url()?>js/jquery.jcountdown.js"></script>
<script type="text/javascript">
	
</script>
<style type="text/css">
	#question_number:hover div{
		display: inline !important;
	}
</style>
<script language="javascript">
	$(document).ready(function(){
		<?php 
			$index=1;
			foreach ($test_question as $question){
				if(isset($question['choose'])&&$question['choose']!=''){
		?>
			check(<?php echo $index?>);
		<?php
				}
				$index++;
			}
		?>
	});


	function check(value)
	{
		document.getElementById(value).checked=true;
	}

	function submit_test()
	{
		if(confirm("确认提交试卷并且结束这次考试吗？"))
		{
			$("#test").submit();
		}

	}

	function save_choose(question_id,choose)
	{
		myUrl="<?php echo site_url('student_test/ajax_save_user_choose')?>/"+<?php echo $report_id ?>+"/"+question_id+"/"+choose;
		$.ajax({
			type:"post",
			url:myUrl,
			success:function(resp)
			{
			}
		});
	}

	function bl()
	{
		if(bltimes<2)
		{
			alert("考试期间禁止离开答题页面，请继续答题");
			bltimes++;
		}
		else
		{
			alert("离开次数过多，您的试卷将被自动提交");
			$("#test").submit();
		}
		
	}
	window.onblur=bl;
	
	
</script>

<style type="text/css"> 
	.col-md-3 {position: fixed; left: 8%; bottom: 2%;width:23%;z-index:1} 
	.col-md-9 {position: relative; left: 28%; top: 2%,width:60%} 
</style> 


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
			      <div class="col-lg-5">
			      		<label  class="ontrol-label"><?php echo $student['student_id']?></label>
			      </div>
			    </div>
			    <div class="row form-group" style="border-bottom:1px ridge;">
			      <label  class="col-lg-4 control-label">考试科目</label>
			      <div class="col-lg-8">
			      		<label  class="ontrol-label"><?php echo $module['name']?></label>
			      </div>
			    </div>
			    
			   
	  		</div>
		</div>
		<div class="panel panel-primary">
	  		<div class="panel-heading">
	    		<h3 class="panel-title">答题情况</h3>
	  		</div>
	 		 <div class="panel-body">
	    			<div class="row">
			    		<?php  $i=1; foreach ($test_question as $question ): ?>
			    			
			    			<div class="col-lg-2 checkboxFour">
									<input type="checkbox" name="<?php echo $i?>" id="<?php echo $i?>" value="1"/>&nbsp<?php echo $i?>
			    			</div>
			    			<?php $i++;?>
						<?php endforeach; ?>		
					</div>
				<p class="text-muted">提示：以上内容只帮助记录答题信息，不代表对错</p>  
	  		</div>
		</div>
	    	<button align="center" class="btn btn-primary btn-lg" onclick="submit_test()">提交并结束考试</button>
		
	</div>
	
	
	<div class="col-md-9">
	<div class="panel panel-primary">
	<form id="test" action="<?php echo site_url('student_test/submit')?>" method="post">
		<fieldset>
			<div class="panel panel-default">
				  <div class="panel-body">
						<?php  $i=1; foreach ($test_question as $question ): ?>
								<div class="form-group row">
									<!-- <label class="col-lg-1 control-label"><?php echo $i.'.';?></label> -->
									<!-- <label class="col-lg-1n cotrol-label"><?php echo $question['id'].'.';?></label> -->
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
										<p class="question-content">&nbsp&nbsp
											<input type="radio" name="answer[<?php echo $i?>]" value="1"  onclick="check(<?php echo $i?>);save_choose(<?php echo $question['id']?>,1);"
												<?php if (isset($question['choose'])&&$question['choose']==1): ?>
													checked="checked"
												<?php endif ?>
											/> &nbsp&nbspA&nbsp&nbsp<?=$question['content_1']?> 
										</p>
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
										<p class="question-content">&nbsp&nbsp
											<input type="radio" name="answer[<?php echo $i?>]" value="2" onclick="check(<?php echo $i?>);save_choose(<?php echo $question['id']?>,2);"
												<?php if (isset($question['choose'])&&$question['choose']==2): ?>
													checked="checked"
												<?php endif ?>
											/> &nbsp&nbspB&nbsp&nbsp<?=$question['content_2']?> 
										</p>
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
										<p class="question-content">&nbsp&nbsp
											<input type="radio" name="answer[<?php echo $i?>]" value="3" onclick="check(<?php echo $i?>);save_choose(<?php echo $question['id']?>,3);"
												<?php if (isset($question['choose'])&&$question['choose']==3): ?>
													checked="checked"
												<?php endif ?>
											/> &nbsp&nbspC&nbsp&nbsp<?=$question['content_3']?> 
										</p>
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
										<p class="question-content">&nbsp&nbsp
											<input type="radio" name="answer[<?php echo $i?>]" value="4" onclick="check(<?php echo $i?>);save_choose(<?php echo $question['id']?>,4);"
												<?php if (isset($question['choose'])&&$question['choose']==4): ?>
													checked="checked"
												<?php endif ?>
											/> &nbsp&nbspD&nbsp&nbsp<?=$question['content_4']?> 
										</p>
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

								<hr size=5 color='black'>
								<input type="hidden"  name="question_id[<?php echo $i?>]" value="<?php echo $question['id']?>" >
								<?php $i++;?>
							  
						<?php endforeach; ?>
					</div>
				</div>
					<input type="hidden"  name="student_id" value="<?php echo $student_id?>" >
					<input type="hidden"  name="module_id" value="<?php echo $module['id']?>" >
					<input type="hidden"  name="logic_class_id" value="<?php echo $logic_class_id?>" >
					<!-- <div align="center">					
						<button class="btn btn-primary" type="submit">提交试卷</button>
					</div> -->
		</fieldset>
	</form>
		
		</div>
	</div>
	
</div>

<?php $this->load->view('student_home/_footer')?>