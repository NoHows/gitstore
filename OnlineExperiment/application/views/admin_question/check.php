<?php $this->load->view('admin_home/_header') ?>
<?php $this->load->view('message') ?>

<script type="text/javascript" src="<?php echo base_url()?>js/fancybox/jquery.fancybox.pack.js"></script>
<link type="text/css" rel="stylesheet" href="<?php echo base_url()?>css/fancybox/jquery.fancybox.css"/>



<script type="text/javascript">
  $().ready(function(){
    	$("#question_li").addClass("active");

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
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title">题目详情</h3>
		</div>
		<div class="panel-body">
			<fieldset>
					<div class="form-group row">
						<label class="col-lg-1 control-label">题干:</label>
						<div class="col-lg-11">
							<p class="question-content"><?=$question['content_main']?></p>
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
					<div class="form-group row">
						<label class="col-lg-1 control-label">选项1:</label>
						<div class="col-lg-11">
							<p class="question-content"><?=$question['content_1']?> </p>
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
					<div class="form-group row">
						<label class="col-lg-1 control-label">选项2:</label>
						<div class="col-lg-11">
							<p class="question-content"><?=$question['content_2']?> </p>
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
					<div class="form-group row">
						<label class="col-lg-1 control-label">选项3:</label>
						<div class="col-lg-11">
							<p class="question-content"><?=$question['content_3']?> </p>
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
					<div class="form-group row">
						<label class="col-lg-1 control-label">选项4:</label>
						<div class="col-lg-11">
							<p class="question-content"><?=$question['content_4']?> </p>
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

					<div class="form-group row">
						<label class="col-lg-1 control-label">答案：</label>
							<div class="col-lg-7">
							 	<p class="text-danger">选项<?=$question['answer']?></p>	
							</div>
						<div class="col-lg-4"></div>
					</div>
					<div class="form-group row">
						<label class="col-lg-1 control-label">实验：</label>
						<div class="col-lg-7">
							<p class="text-primary question-content"><?=$module['name']?></p>
							</div>
						<div class="col-lg-4"></div>
					</div>
					
					<!-- <div class="form-group row">
						<label class="col-lg-1 control-label">知识点：</label>
						<div class="col-lg-7">
							<table class="table table-striped table-hover ">
								<tbody>
									<?php foreach ($relative_knowledge_points as $item ): ?>
									<tr>
										<td>
											<p class="text-success question-content"><?php echo $item['content']?></p>
										</td>
									</tr>
									<?php endforeach; ?>
								</tbody>
							</table>
							<a class="btn btn-primary" href="<?php echo site_url('admin_question/edit').'/'.$question['id']?>">编辑</a>
							<a class="btn btn-primary" href="<?php echo site_url('admin_question/index').'/'.$question['id']?>">返回</a>
						</div>
						<div class="col-lg-4"></div>
					</div> -->

					<div class="form-group row">
						<label class="col-lg-1 control-label"></label>
						<div class="col-lg-7">
							<a class="btn btn-primary" href="<?php echo site_url('admin_question/edit').'/'.$question['id']?>">编辑题目</a>
							<a class="btn btn-primary" href="<?php echo site_url('admin_question/index')?>">返回</a>
						</div>
						<div class="col-lg-4"></div>
					</div>
				</fieldset>
		</div>
	</div>

</div>

<?php $this->load->view('admin_home/_footer')?>