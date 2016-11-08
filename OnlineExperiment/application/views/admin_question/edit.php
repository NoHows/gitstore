<?php $this->load->view('admin_home/_header') ?>
<?php $this->load->view('message') ?>


<script type="text/javascript" src="<?php echo base_url()?>js/fancybox/jquery.fancybox.pack.js"></script>
<link type="text/css" rel="stylesheet" href="<?php echo base_url()?>css/fancybox/jquery.fancybox.css"/>

<script type="text/javascript" src="<?php echo base_url()?>js/ajaxfileupload.js"></script>

<script type="text/javascript">
	var leaveType="notSubmit";
  	$(document).ready(function(){

    	$("#question_li").addClass("active"); 

    	//填充编辑数据
 	 	$('#big_lecture_select').selectpicker({});
 	 	$('#relative_module_select').selectpicker({});
		$("#relative_module_select").selectpicker('val',[<?=$question['module_id']?>]);	
					
		

		$("#answer_select").val(<?=$question['answer']?>);


		<?php if ($picture_tag['pic_main'] == 'true'): ?>
			$("#pic_main_img").attr("src","<?php echo base_url() ?>uploads/<?php echo $time_stamp?>/main_thumb.jpg?"+Math.random());
	        $("#pic_main_a").attr("href","<?php echo base_url() ?>uploads/<?php echo $time_stamp?>/main.jpg?"+Math.random());
	        $("#pic_main_button").removeAttr("disabled");
		<?php endif ?>
		<?php if ($picture_tag['pic_1'] == 'true'): ?>
			$("#pic_1_img").attr("src","<?php echo base_url() ?>uploads/<?php echo $time_stamp?>/1_thumb.jpg?"+Math.random());
	        $("#pic_1_a").attr("href","<?php echo base_url() ?>uploads/<?php echo $time_stamp?>/1.jpg?"+Math.random());
	        $("#pic_1_button").removeAttr("disabled");
		<?php endif ?>
		<?php if ($picture_tag['pic_2'] == 'true'): ?>
			$("#pic_2_img").attr("src","<?php echo base_url() ?>uploads/<?php echo $time_stamp?>/2_thumb.jpg?"+Math.random());
	        $("#pic_2_a").attr("href","<?php echo base_url() ?>uploads/<?php echo $time_stamp?>/2.jpg?"+Math.random());
	        $("#pic_2_button").removeAttr("disabled");
		<?php endif ?>
		<?php if ($picture_tag['pic_3'] == 'true'): ?>
			$("#pic_3_img").attr("src","<?php echo base_url() ?>uploads/<?php echo $time_stamp?>/3_thumb.jpg?"+Math.random());
	        $("#pic_3_a").attr("href","<?php echo base_url() ?>uploads/<?php echo $time_stamp?>/3.jpg?"+Math.random());
	        $("#pic_3_button").removeAttr("disabled");
		<?php endif ?>
		<?php if ($picture_tag['pic_4'] == 'true'): ?>
			$("#pic_4_img").attr("src","<?php echo base_url() ?>uploads/<?php echo $time_stamp?>/4_thumb.jpg?"+Math.random());
	        $("#pic_4_a").attr("href","<?php echo base_url() ?>uploads/<?php echo $time_stamp?>/4.jpg?"+Math.random());
	        $("#pic_4_button").removeAttr("disabled");
		<?php endif ?>

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
		//表单验证的内容
		$("#question_edit_form").validate({
			invalidHandler: function(form, validator) {
		        leaveType="notSubmit";
    		},
			rules:{
				content_main:
				{
					required:true,
					maxlength:600
				},
				content_1:
				{
					maxlength:400
				},
				content_2:
				{
					maxlength:400
				},
				content_3:
				{
					maxlength:400
				},
				content_4:
				{
					maxlength:400
				}
			}
		});

		//离开页面的时候告知服务器删除临时上传图片的数据
		window.onbeforeunload = function (event)
        {
        	
        	if(leaveType!='submit'){
        		myUrl="<?php echo site_url('admin_question/delete_temp_picture').'/'.$time_stamp?>";
	            $.ajax({
	                url: myUrl,
	                success: function (result) {
	                },
	                error: function () {
	                }
	            });
	            return "提示：服务器上的未保存的图片已经被删除";
            }
        	
        }

        //注册预览按钮点击的事件
        $("#content_main_modal_button").click(function(){
        	var text=$("#content_main").val();
        	$("#content_main_modal_body").text(text);
        	MathJax.Hub.Queue(["Typeset",MathJax.Hub,"content_main_modal_body"]);
        	$('#content_main_modal').modal('show');
        });

        $("#content_1_modal_button").click(function(){
        	var text=$("#content_1").val();
        	$("#content_1_modal_body").text(text);
        	MathJax.Hub.Queue(["Typeset",MathJax.Hub,"content_1_modal_body"]);
        	$('#content_1_modal').modal('show');
        });
        $("#content_2_modal_button").click(function(){
        	var text=$("#content_2").val();
        	$("#content_2_modal_body").text(text);
        	MathJax.Hub.Queue(["Typeset",MathJax.Hub,"content_2_modal_body"]);
        	$('#content_2_modal').modal('show');
        });
        $("#content_3_modal_button").click(function(){
        	var text=$("#content_3").val();
        	$("#content_3_modal_body").text(text);
        	MathJax.Hub.Queue(["Typeset",MathJax.Hub,"content_3_modal_body"]);
        	$('#content_3_modal').modal('show');
        });
        $("#content_4_modal_button").click(function(){
        	var text=$("#content_4").val();
        	$("#content_4_modal_body").text(text);
        	MathJax.Hub.Queue(["Typeset",MathJax.Hub,"content_4_modal_body"]);
        	$('#content_4_modal').modal('show');
        });

	});


	function find_modules_from_big_lecture(big_lecture_value)
	{
		myUrl="<?php echo site_url('admin_class/find_relative_modules')?>/"+big_lecture_value;
		$.ajax({
			type:"post",
			url:myUrl,
			success:function(resp)
			{
				$("#relative_modules").html(resp);
			}
		});
	}

	
	function ajaxFileUpload(file)
	{
		
		$.ajaxFileUpload({
	        url:"<?php echo site_url('admin_question/ajax_file_upload').'/'.$time_stamp.'/' ?>"+file.substr(4),
	        secureuri:false,
	        fileElementId:file,
	        success: function(json,status){   
	        	$("#"+file+"_img").attr("src","<?php echo base_url() ?>uploads/<?php echo $time_stamp?>/"+file.substr(4)+"_thumb.jpg?"+Math.random());
	        	$("#"+file+"_a").attr("href","<?php echo base_url() ?>uploads/<?php echo $time_stamp?>/"+file.substr(4)+".jpg?"+Math.random());
	        	$("#"+file+"_button").removeAttr("disabled");
	        },
	        error: function(data,status,e){
	            //print error
	        }
    	});
    	
	}

	function delete_pic(file)
	{
		myUrl="<?php echo site_url('admin_question/ajax_delete_pic').'/'.$time_stamp.'/'?>"+file;
		//alert(myUrl);
		$.ajax({
			type:"post",
			url:myUrl,
			success:function()
			{
				$("#pic_"+file+"_img").attr("src","<?php echo base_url() ?>uploads/empty.jpg");
	        	$("#pic_"+file+"_a").attr("href","<?php echo base_url() ?>uploads/empty.jpg");
			}
		});
		$("#pic_"+file+"_button").attr("disabled","disabled");
		return false;
	}



	function question_submit()
	{
		leaveType="submit";
		$("#question_edit_form").submit();
	}
</script>



<div class="container">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title">编辑题目</h3>
		</div>
		<div class="panel-body">
			<?php echo validation_errors(); ?>
			<form method="post" id="question_edit_form" class="form-horizontal"  enctype="multipart/form-data" action="<?php echo site_url('admin_question/edit')?>" >
				<input type="text" name="time_stamp" value="<?=$time_stamp?>" class="hidden">
				<input type="text" id="knowledge_point_number" name="knowledge_point_number" value="1" class="hidden">
				<input type="text" id="question_id" name="question_id" value="<?=$question['id']?>" class="hidden">
				<fieldset>
					<div class="form-group">
						<label for="textArea" class="col-lg-1 control-label">
							题干:<br/>
							<button type="button" class="btn btn-primary btn-sm" id="content_main_modal_button"  data-toggle="modal">预览</button>
						</label>
						<div class="col-lg-7">
							<textarea class="form-control" rows="4" id="content_main" name="content_main"><?=$question['content_main']?></textarea>
						</div>				
						<div class="col-lg-1">
							<div id="pic_main_div">	
								<a id="pic_main_a" class="fancybox-effects">
									<img id="pic_main_img" src="">
								</a>
							</div>
						</div>
						<div class="col-lg-3">
							<input id="pic_main" type="file" name="pic_main" size="20" onchange="ajaxFileUpload('pic_main')" />
							<button type="button" id="pic_main_button" class="btn btn-primary" disabled="disabled" onclick="delete_pic('main')">删除</button>
						</div>
					</div>

					<div class="form-group">
						<label for="textArea" class="col-lg-1 control-label">
							选项1:<br/>
							<button type="button" class="btn btn-primary btn-sm" id="content_1_modal_button"  data-toggle="modal">预览</button>
						</label>
						<div class="col-lg-7">
							<textarea class="form-control" rows="4" id="content_1" name="content_1"><?=$question['content_1']?></textarea>
						</div>
						<div class="col-lg-1">
							<div id="pic_1_div">	
								<a id="pic_1_a" class="fancybox-effects">
									<img id="pic_1_img" src="">
								</a>
							</div>
						</div>
						<div class="col-lg-3">
							<input id="pic_1" type="file" name="pic_1" size="20" onchange="ajaxFileUpload('pic_1')" />
							<button type="button" id="pic_1_button" class="btn btn-primary" disabled="disabled" onclick="delete_pic('1')">删除</button>
						</div>
					</div>
					<div class="form-group">
						<label for="textArea" class="col-lg-1 control-label">
							选项2:<br/>
							<button type="button" class="btn btn-primary btn-sm" id="content_2_modal_button"  data-toggle="modal">预览</button>
						</label>
						<div class="col-lg-7">
							<textarea class="form-control" rows="4" id="content_2" name="content_2"><?=$question['content_2']?></textarea>
						</div>
						<div class="col-lg-1">
							<div id="pic_2_div">	
								<a id="pic_2_a" class="fancybox-effects">
									<img id="pic_2_img" src="">
								</a>
							</div>
						</div>
						<div class="col-lg-3">
							<input id="pic_2" type="file" name="pic_2" size="20" onchange="ajaxFileUpload('pic_2')" />
							<button type="button" id="pic_2_button" class="btn btn-primary" disabled="disabled" onclick="delete_pic('2')">删除</button>
						</div>
					</div>
					<div class="form-group">
						<label for="textArea" class="col-lg-1 control-label">
							选项3:<br/>
							<button type="button" class="btn btn-primary btn-sm" id="content_3_modal_button"  data-toggle="modal">预览</button>
						</label>
						<div class="col-lg-7">
							<textarea class="form-control" rows="4" id="content_3" name="content_3"><?=$question['content_3']?></textarea>
						</div>
						<div class="col-lg-1">
							<div id="pic_3_div">	
								<a id="pic_3_a" class="fancybox-effects">
									<img id="pic_3_img" src="">
								</a>
							</div>
						</div>
						<div class="col-lg-3">
							<input id="pic_3" type="file" name="pic_3" size="20" onchange="ajaxFileUpload('pic_3')" />
							<button type="button" id="pic_3_button" class="btn btn-primary" disabled="disabled" onclick="delete_pic('3')">删除</button>
						</div>
					</div>
					<div class="form-group">
						<label for="textArea" class="col-lg-1 control-label">
							选项4:<br/>
							<button type="button" class="btn btn-primary btn-sm" id="content_4_modal_button"  data-toggle="modal">预览</button>
						</label>
						<div class="col-lg-7">
							<textarea class="form-control" rows="4" id="content_4" name="content_4"><?=$question['content_4']?></textarea>
						</div>
						<div class="col-lg-1">
							<div id="pic_4_div">	
								<a id="pic_4_a" class="fancybox-effects">
									<img id="pic_4_img" src="">
								</a>
							</div>
						</div>
						<div class="col-lg-3">
							<input id="pic_4" type="file" name="pic_4" size="20" onchange="ajaxFileUpload('pic_4')" />
							<button type="button" id="pic_4_button" class="btn btn-primary" disabled="disabled" onclick="delete_pic('4')">删除</button>
						</div>
					</div>

					<div class="form-group">
						<label for="select" class="col-lg-1 control-label">答案：</label>
						<div class="col-lg-3">
							<select id="answer_select" class="form-control" name="answer" id="answer">
								<?php foreach ($choose as $item) :?>
									<option value="<?=$item['value']?>" <?php echo ($item['value'] == $question['answer'])?'selected="selected"':'' ?>>
										<?=$item['name']?>
									</option>
								<?php endforeach; ?>
							</select>
							<br></div>
						<div class="col-lg-8"></div>
					</div>

					<div class="form-group">
						<label for="select" class="col-lg-1 control-label">课程：</label>
						<div class="col-lg-7">
							<select name="big_lecture_select" id="big_lecture_select" title="选择相关课程" class="selectpicker form-control" data-live-search="true"  data-style="btn-primary" onchange="find_modules_from_big_lecture(this.value)">
								<?php foreach ($big_lectures as $item):?>
								<option value="<?=$item['id']?>" <?php echo ($item['id'] == $big_lecture['id'])?'selected="selected"':'' ?>>
										<?=$item['name']?>
									</option>
								<?php endforeach; ?>
							</select>
							<br>
						</div>
						<div class="col-lg-3"></div>
					</div>
					
					<div class="form-group">
						<label for="select" class="col-lg-1 control-label">实验：</label>
						<div id='relative_modules' class="col-lg-7" >
							
							<select name="relative_module_select" id="relative_module_select" title="选择实验" class="selectpicker form-control"  data-live-search="true"  data-style="btn-primary">
								<?php foreach ($module_of_big_lecture as $item):?>
								<option value="<?=$item['id']?>" <?php echo ($item['id'] == $module['id'])?'selected="selected"':'' ?>>
										<?=$item['name']?>
								</option>
								<?php endforeach; ?>
							</select>
						</div>
						<div class="col-lg-3"></div>
					</div>


					<div class="form-group">
						<div class="col-lg-10 col-lg-offset-1">
							<!-- <button type="button" onclick="question_preview()" class="btn btn-primary">预览</button> -->
							<button onclick="question_submit()" class="btn btn-primary">提交</button>
						</div>
					</div>
				</fieldset>
			</form>
		</div>

	</div>
</div>
<?php $this->load->view('admin_home/_footer')?>
<!-- Modal -->
<div class="modal fade" id="content_main_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title">题干的内容</h4>
      </div>
      <div class="modal-body" id="content_main_modal_body">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="content_1_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title">选项1的内容</h4>
      </div>
      <div class="modal-body" id="content_1_modal_body">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal -->
<div class="modal fade" id="content_2_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title">选项2的内容</h4>
      </div>
      <div class="modal-body" id="content_2_modal_body">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="content_3_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title">选项3的内容</h4>
      </div>
      <div class="modal-body" id="content_3_modal_body">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="content_4_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title">选项4的内容</h4>
      </div>
      <div class="modal-body" id="content_4_modal_body">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
      </div>
    </div>
  </div>
</div>


