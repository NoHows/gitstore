<?php 
/**
 * 管理员管理问题
 */

class Admin_question extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		//登陆状态检测
		if(!$this->session->userdata('e_user_in'))
			redirect('home');
		//权限检测
		if($this->session->userdata('e_role_id') != 1)
			redirect('home');
	}

	/**
	 * 题目的主页面
	 * @return [type] [description]
	 */
	function index($offset=0)
	{
		$data['title']='题目管理';
		$this->load->model('question_model');

		$this->load->library('pagination');

		$config['base_url'] = site_url().'/admin_question/index';
		$config['total_rows'] = $this->question_model->count_all();
		$config['per_page'] = 10; 
		$config['first_link'] = '首页';
		$config['last_link'] = '尾页';
		$config['num_links'] = 5;
		$this->pagination->initialize($config); 

		if(!is_numeric($offset))
			$this->load->view('error');
		$offset=intval($offset);
		$data['questions']=$this->question_model->get_all_questions_by_offset($config['per_page'],$offset);
		$data['questions_all']=$this->question_model->get_all_with_module();
		$this->load->view('admin_question/index',$data);
	}

	/**
	 * 添加一个题目
	 */
	function add()
	{
		//表单验证
		if($this->form_validation->run('admin_question/add'))
		{
			//post方法提交数据
			$time_stamp=$this->input->post('time_stamp');
			$content_main=$this->input->post('content_main');
			$content_1=$this->input->post('content_1');
			$content_2=$this->input->post('content_2');
			$content_3=$this->input->post('content_3');
			$content_4=$this->input->post('content_4');
			$answer=$this->input->post('answer');
			$big_lecture_id=$this->input->post('big_lecture_select');
			$module_id = $this->input->post('relative_module_select');


			//加载模型类
			$this->load->model('question_model');
			$this->load->model('big_lecture_model');
			$this->load->model('module_model');
 			$this->load->model('picture_model');
			//验证实验模块是否存在
			$module=$this->module_model->get_by_id($module_id);
			if(!$module)
				return $this->load->view('error');

			//存储题目数据获取题号
			$item = array(
				'module_id' => $module_id,
			 	'content_main' => $content_main,
			 	'content_1' => $content_1,
			 	'content_2' => $content_2,
			 	'content_3' => $content_3,
			 	'content_4' => $content_4,
			 	'answer' => $answer
			 );
			
			

			//插入表单内容
			if($this->question_model->add($item))
			{
				//得到题号信息
				$question_id=$this->db->insert_id();
				

				//配置上传图片到upload目的信息
				if(!is_dir('./uploads/'.$question_id))
					mkdir('./uploads/'.$question_id);

				//预定义
				$picture_main_id=0;
				$picture_1_id=0;
				$picture_2_id=0;
				$picture_3_id=0;
				$picture_4_id=0;

				//处理题干的图片
				if(file_exists('./uploads/'.$time_stamp.'/main.jpg'))
				{
					//拷贝
					copy('./uploads/'.$time_stamp.'/main.jpg','./uploads/'.$question_id.'/main.jpg');
					copy('./uploads/'.$time_stamp.'/main_thumb.jpg','./uploads/'.$question_id.'/main_thumb.jpg');

					//删除
					unlink('./uploads/'.$time_stamp.'/main.jpg');
					unlink('./uploads/'.$time_stamp.'/main_thumb.jpg');

					//写入数据库
					$path='./uploads/'.$question_id.'/';
					$name='main.jpg';
					$picture_item= array(
						'path' => $path,
						'name' => $name
						 );
					$this->picture_model->add($picture_item);
					$picture_main_id=$this->db->insert_id();
				}

				//处理选项1的图片
				if(file_exists('./uploads/'.$time_stamp.'/1.jpg'))
				{
					//拷贝
					copy('./uploads/'.$time_stamp.'/1.jpg','./uploads/'.$question_id.'/1.jpg');
					copy('./uploads/'.$time_stamp.'/1_thumb.jpg','./uploads/'.$question_id.'/1_thumb.jpg');

					//删除
					unlink('./uploads/'.$time_stamp.'/1.jpg');
					unlink('./uploads/'.$time_stamp.'/1_thumb.jpg');

					//写入数据库
					$path='./uploads/'.$question_id.'/';
					$name='1.jpg';
					$picture_item= array(
						'path' => $path,
						'name' => $name
						 );
					$this->picture_model->add($picture_item);
					$picture_1_id=$this->db->insert_id();
				}

				//处理选项2的图片
				if(file_exists('./uploads/'.$time_stamp.'/2.jpg'))
				{
					//拷贝
					copy('./uploads/'.$time_stamp.'/2.jpg','./uploads/'.$question_id.'/2.jpg');
					copy('./uploads/'.$time_stamp.'/2_thumb.jpg','./uploads/'.$question_id.'/2_thumb.jpg');

					//删除
					unlink('./uploads/'.$time_stamp.'/2.jpg');
					unlink('./uploads/'.$time_stamp.'/2_thumb.jpg');

					//写入数据库
					$path='./uploads/'.$question_id.'/';
					$name='2.jpg';
					$picture_item= array(
						'path' => $path,
						'name' => $name
						 );
					$this->picture_model->add($picture_item);
					$picture_2_id=$this->db->insert_id();
				}

				//处理选项3的图片
				if(file_exists('./uploads/'.$time_stamp.'/3.jpg'))
				{
					//拷贝
					copy('./uploads/'.$time_stamp.'/3.jpg','./uploads/'.$question_id.'/3.jpg');
					copy('./uploads/'.$time_stamp.'/3_thumb.jpg','./uploads/'.$question_id.'/3_thumb.jpg');

					//删除
					unlink('./uploads/'.$time_stamp.'/3.jpg');
					unlink('./uploads/'.$time_stamp.'/3_thumb.jpg');

					//写入数据库
					$path='./uploads/'.$question_id.'/';
					$name='3.jpg';
					$picture_item= array(
						'path' => $path,
						'name' => $name
						 );
					$this->picture_model->add($picture_item);
					$picture_3_id=$this->db->insert_id();
				}

				//处理选项4的图片
				if(file_exists('./uploads/'.$time_stamp.'/4.jpg'))
				{
					//拷贝
					copy('./uploads/'.$time_stamp.'/4.jpg','./uploads/'.$question_id.'/4.jpg');
					copy('./uploads/'.$time_stamp.'/4_thumb.jpg','./uploads/'.$question_id.'/4_thumb.jpg');

					//删除
					unlink('./uploads/'.$time_stamp.'/4.jpg');
					unlink('./uploads/'.$time_stamp.'/4_thumb.jpg');

					//写入数据库
					$path='./uploads/'.$question_id.'/';
					$name='4.jpg';
					$picture_item= array(
						'path' => $path,
						'name' => $name
						 );
					$this->picture_model->add($picture_item);
					$picture_4_id=$this->db->insert_id();
				}

				rmdir('./uploads/'.$time_stamp);

				//将题号信息+插入图片的信息写入question的数据表
				$item=$this->question_model->get_by_id($question_id);
				$this->load->helper('question_convertor');
				$item['number']=id_to_number_ol($question_id);
				if($picture_main_id) $item['picture_main_id']=$picture_main_id;
				if($picture_1_id) $item['picture_1_id']=$picture_1_id;
				if($picture_2_id) $item['picture_2_id']=$picture_2_id;
				if($picture_3_id) $item['picture_3_id']=$picture_3_id;
				if($picture_4_id) $item['picture_4_id']=$picture_4_id;

				$this->question_model->update($question_id,$item);

				redirect('admin_question/check/'.$question_id);

			}

		 

		}

		//get方法返回add页面
		$data['title']='添加题目';
		$this->load->model('big_lecture_model');
		$data['big_lectures']=$this->big_lecture_model->get_all();
		$this->load->model('module_model');
		//$data['knowledge_points']=$this->knowledge_point_model->get_all();
		$data['time_stamp']=time();
		$this->load->view('admin_question/add',$data);


	}

	/**
	 * 查看一个问题的内容
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	function check($id)
	{
		$data['title']='查看题目详情';
		$this->load->model('question_model');
		$question=$this->question_model->get_by_id($id);
		if(!$question) 
			$this->load->view('error');
		$data['question']=$question;
		$this->load->model('module_model');
		$data['module']=$this->module_model->get_by_id($question['module_id']);		
		$this->load->view('admin_question/check',$data);
	}

	//处理ajax上传文件
	function ajax_file_upload($time_stamp,$name)
	{
		$config['upload_path'] = './uploads/'.$time_stamp;
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size'] = '100000';
		$config['max_width']  = '2048';
		$config['max_height']  = '1536';
		$this->load->library('upload', $config);

		//上传图片
		$config['file_name']=$name.'.jpg';
		$this->upload->initialize($config);
		if(!is_dir('./uploads/'.$time_stamp))
					mkdir('./uploads/'.$time_stamp);
		if(file_exists('./uploads/'.$time_stamp.'/'.$name.'.jpg'))
		{
			unlink('./uploads/'.$time_stamp.'/'.$name.'.jpg');
			unlink('./uploads/'.$time_stamp.'/'.$name.'_thumb.jpg');
		}		
		$data=array('state' => 'success' );
		//初始化图片的数据模型
		if($this->upload->do_upload('pic_'.$name))
		{
			$config['image_library'] = 'gd2';

			$config['source_image'] = './uploads/'.$time_stamp.'/'.$name.'.jpg';
			$config['create_thumb'] = TRUE;
			$config['maintain_ratio'] = TRUE;
			$config['width'] = 90;
			$config['height'] = 90;

			$this->load->library('image_lib', $config); 

			$this->image_lib->resize();

		}
	}

	//删除已经上传的图片
	function ajax_delete_pic($time_stamp,$name)
	{
		if(file_exists('./uploads/'.$time_stamp.'/'.$name.'.jpg'))
		{
			unlink('./uploads/'.$time_stamp.'/'.$name.'.jpg');
			unlink('./uploads/'.$time_stamp.'/'.$name.'_thumb.jpg');
		}	
	}

	/**
	 * 删除一个题目
	 * @param  [type] $question_id [description]
	 * @return [type]              [description]
	 */
	function delete($question_id)
	{
		$this->load->model('question_model');
		
			if($this->question_model->delete_cascade($question_id)){
				//删除临时文件夹中的图片
				$this->delete_files_by_dir('./uploads/'.$question_id);
				//删除临时文件夹
				rmdir('./uploads/'.$question_id);

				$this->session->set_flashdata('message','操作成功');
					redirect('admin_question/index');	
			}
		
		else
		{
			$this->session->set_flashdata('message','操作失败,存在相关引用');
			redirect('admin_question/index');	
		}
		
	}

	/**
	 * 编辑一道题目
	 * @param  [type] $question_id [description]
	 * @return [type]              [description]
	 */
	function edit($question_id=0)
	{
		if($question_id)
		{
			//get
			//get方法
			$this->load->model('question_model');
			$this->load->model('module_model');
			$this->load->model('big_lecture_model');

			$question=$this->question_model->get_by_id($question_id);
			if(!$question)
				return $this->load->view('error');

			$module = $this->module_model->get_by_id($question['module_id']);
			$big_lecture = $this->big_lecture_model->get_by_id($module['big_lecture_id']);
			$module_of_big_lecture = $this->module_model->get_modules_by_big_lecture_id($big_lecture['id']);
			$choose_1 = array('value' => '1', 'name' => '选项一');
			$choose_2 = array('value' => '2', 'name' => '选项二');
			$choose_3 = array('value' => '3', 'name' => '选项三');
			$choose_4 = array('value' => '4', 'name' => '选项四');
			$choose = array();
			array_push($choose, $choose_1);
			array_push($choose, $choose_2);
			array_push($choose, $choose_3);
			array_push($choose, $choose_4);

			$data['title']='编辑题目';
			$data['question']=$question;
			$data['big_lecture']=$big_lecture;
			$data['module_of_big_lecture']=$module_of_big_lecture;
			$data['module']=$module;
			$data['choose']=$choose;
			$data['big_lectures']=$this->big_lecture_model->get_all();
			
			//$data['knowledge_points']=$this->knowledge_point_model->get_all();
			$time_stamp=time();
			$data['time_stamp']=$time_stamp;

			$picture_tag=array(
				'pic_main' => 'false',
				'pic_1' => 'false',
				'pic_2' => 'false',
				'pic_3' => 'false',
				'pic_4' => 'false',
				 );
			//将上传的文件，复制到临时的时间戳文件夹中
			if(!is_dir('./uploads/'.$time_stamp))
				mkdir('./uploads/'.$time_stamp);
			
			//处理选项的图片
			if(file_exists('./uploads/'.$question_id.'/main.jpg'))
			{
				//拷贝
				copy('./uploads/'.$question_id.'/main.jpg','./uploads/'.$time_stamp.'/main.jpg');
				copy('./uploads/'.$question_id.'/main_thumb.jpg','./uploads/'.$time_stamp.'/main_thumb.jpg');
				$picture_tag['pic_main']='true';
			}
			if(file_exists('./uploads/'.$question_id.'/1.jpg'))
			{
				//拷贝
				copy('./uploads/'.$question_id.'/1.jpg','./uploads/'.$time_stamp.'/1.jpg');
				copy('./uploads/'.$question_id.'/1_thumb.jpg','./uploads/'.$time_stamp.'/1_thumb.jpg');
				$picture_tag['pic_1']='true';
			}
			if(file_exists('./uploads/'.$question_id.'/2.jpg'))
			{
				//拷贝
				copy('./uploads/'.$question_id.'/2.jpg','./uploads/'.$time_stamp.'/2.jpg');
				copy('./uploads/'.$question_id.'/2_thumb.jpg','./uploads/'.$time_stamp.'/2_thumb.jpg');
				$picture_tag['pic_2']='true';
			}
			if(file_exists('./uploads/'.$question_id.'/3.jpg'))
			{
				//拷贝
				copy('./uploads/'.$question_id.'/3.jpg','./uploads/'.$time_stamp.'/3.jpg');
				copy('./uploads/'.$question_id.'/3_thumb.jpg','./uploads/'.$time_stamp.'/3_thumb.jpg');
				$picture_tag['pic_3']='true';
			}
			if(file_exists('./uploads/'.$question_id.'/4.jpg'))
			{
				//拷贝
				copy('./uploads/'.$question_id.'/4.jpg','./uploads/'.$time_stamp.'/4.jpg');
				copy('./uploads/'.$question_id.'/4_thumb.jpg','./uploads/'.$time_stamp.'/4_thumb.jpg');
				$picture_tag['pic_4']='true';
			}
			
			$data['picture_tag']=$picture_tag;
			$this->load->view('admin_question/edit',$data);
		}
		else
		{
			//读取数据
			$this->load->model('question_model');
			$question_id=$this->input->post('question_id');
			$question=$this->question_model->get_by_id($question_id);
			if(!$question)
				return $this->load->view('error');
			if($this->form_validation->run('admin_question/edit'))
			{
				//post方法
				//加入表单验证的内容
				$time_stamp=$this->input->post('time_stamp');
				$content_main=$this->input->post('content_main');
				$content_1=$this->input->post('content_1');
				$content_2=$this->input->post('content_2');
				$content_3=$this->input->post('content_3');
				$content_4=$this->input->post('content_4');
				$answer=$this->input->post('answer');
				$big_lecture_id=$this->input->post('big_lecture_select');
				$module_id = $this->input->post('relative_module_select');

				//加载模型类
				
				$this->load->model('big_lecture_model');
				$this->load->model('module_model');
	 			$this->load->model('picture_model');
				//验证实验是否存在
				$module=$this->module_model->get_by_id($module_id);
				if(!$module)
					return $this->load->view('error');

				//存储题目数据获取题号
				$item = array(
					'module_id' => $module_id,
				 	'content_main' => $content_main,
				 	'content_1' => $content_1,
				 	'content_2' => $content_2,
				 	'content_3' => $content_3,
				 	'content_4' => $content_4,
				 	'answer' => $answer
				 );

				

				//更新表单内容
				if($this->question_model->update($question_id,$item))
				{
					
					//配置上传图片到upload目的信息
					if(!is_dir('./uploads/'.$question_id))
						mkdir('./uploads/'.$question_id);

					//预定义
					$picture_main_id=0;
					$picture_1_id=0;
					$picture_2_id=0;
					$picture_3_id=0;
					$picture_4_id=0;

					//删除原文件夹中的图片
					$this->delete_files_by_dir('./uploads/'.$question_id);
					//删除数据库中的记录
					$this->question_model->delete_relative_pictures($question_id);

					//处理题干的图片
					if(file_exists('./uploads/'.$time_stamp.'/main.jpg'))
					{
						//拷贝
						copy('./uploads/'.$time_stamp.'/main.jpg','./uploads/'.$question_id.'/main.jpg');
						copy('./uploads/'.$time_stamp.'/main_thumb.jpg','./uploads/'.$question_id.'/main_thumb.jpg');

						//删除
						unlink('./uploads/'.$time_stamp.'/main.jpg');
						unlink('./uploads/'.$time_stamp.'/main_thumb.jpg');

						//写入数据库
						$path='./uploads/'.$question_id.'/';
						$name='main.jpg';
						$picture_item= array(
							'path' => $path,
							'name' => $name
							 );
						$this->picture_model->add($picture_item);
						$picture_main_id=$this->db->insert_id();
					}

					//处理选项1的图片
					if(file_exists('./uploads/'.$time_stamp.'/1.jpg'))
					{
						//拷贝
						copy('./uploads/'.$time_stamp.'/1.jpg','./uploads/'.$question_id.'/1.jpg');
						copy('./uploads/'.$time_stamp.'/1_thumb.jpg','./uploads/'.$question_id.'/1_thumb.jpg');

						//删除
						unlink('./uploads/'.$time_stamp.'/1.jpg');
						unlink('./uploads/'.$time_stamp.'/1_thumb.jpg');

						//写入数据库
						$path='./uploads/'.$question_id.'/';
						$name='1.jpg';
						$picture_item= array(
							'path' => $path,
							'name' => $name
							 );
						$this->picture_model->add($picture_item);
						$picture_1_id=$this->db->insert_id();
					}

					//处理选项2的图片
					if(file_exists('./uploads/'.$time_stamp.'/2.jpg'))
					{
						//拷贝
						copy('./uploads/'.$time_stamp.'/2.jpg','./uploads/'.$question_id.'/2.jpg');
						copy('./uploads/'.$time_stamp.'/2_thumb.jpg','./uploads/'.$question_id.'/2_thumb.jpg');

						//删除
						unlink('./uploads/'.$time_stamp.'/2.jpg');
						unlink('./uploads/'.$time_stamp.'/2_thumb.jpg');

						//写入数据库
						$path='./uploads/'.$question_id.'/';
						$name='2.jpg';
						$picture_item= array(
							'path' => $path,
							'name' => $name
							 );
						$this->picture_model->add($picture_item);
						$picture_2_id=$this->db->insert_id();
					}

					//处理选项3的图片
					if(file_exists('./uploads/'.$time_stamp.'/3.jpg'))
					{
						//拷贝
						copy('./uploads/'.$time_stamp.'/3.jpg','./uploads/'.$question_id.'/3.jpg');
						copy('./uploads/'.$time_stamp.'/3_thumb.jpg','./uploads/'.$question_id.'/3_thumb.jpg');

						//删除
						unlink('./uploads/'.$time_stamp.'/3.jpg');
						unlink('./uploads/'.$time_stamp.'/3_thumb.jpg');

						//写入数据库
						$path='./uploads/'.$question_id.'/';
						$name='3.jpg';
						$picture_item= array(
							'path' => $path,
							'name' => $name
							 );
						$this->picture_model->add($picture_item);
						$picture_3_id=$this->db->insert_id();
					}

					//处理选项4的图片
					if(file_exists('./uploads/'.$time_stamp.'/4.jpg'))
					{
						//拷贝
						copy('./uploads/'.$time_stamp.'/4.jpg','./uploads/'.$question_id.'/4.jpg');
						copy('./uploads/'.$time_stamp.'/4_thumb.jpg','./uploads/'.$question_id.'/4_thumb.jpg');

						//删除
						unlink('./uploads/'.$time_stamp.'/4.jpg');
						unlink('./uploads/'.$time_stamp.'/4_thumb.jpg');

						//写入数据库
						$path='./uploads/'.$question_id.'/';
						$name='4.jpg';
						$picture_item= array(
							'path' => $path,
							'name' => $name
							 );
						$this->picture_model->add($picture_item);
						$picture_4_id=$this->db->insert_id();
					}

					//删除临时文件夹
					rmdir('./uploads/'.$time_stamp);

					//将题号信息+插入图片的信息写入question的数据表
					$item=$this->question_model->get_by_id($question_id);
					$this->load->helper('question_convertor');
					$item['number']=id_to_number_ol($question_id);
					if($picture_main_id) $item['picture_main_id']=$picture_main_id;
					if($picture_1_id) $item['picture_1_id']=$picture_1_id;
					if($picture_2_id) $item['picture_2_id']=$picture_2_id;
					if($picture_3_id) $item['picture_3_id']=$picture_3_id;
					if($picture_4_id) $item['picture_4_id']=$picture_4_id;

					$this->question_model->update($question_id,$item);

					redirect('admin_question/check/'.$question_id);

				} 	
				
			}
			else
			{
				//验证失败get
				//删除原文件夹中的图片
				$time_stamp=$this->input->post('time_stamp');
				$this->delete_files_by_dir('./uploads/'.$time_stamp);
				//删除临时文件夹
				rmdir('./uploads/'.$time_stamp);

				$this->load->model('question_model');
				$this->load->model('module_model');
				$this->load->model('big_lecture_model');

				$module = $this->module_model->get_by_id($question['module_id']);
				$big_lecture = $this->big_lecture_model->get_by_id($module['big_lecture_id']);
			
				$data['title']='编辑题目';
				$data['question']=$question;
				$data['big_lecture']=$big_lecture;
				$data['module']=$module;
				$data['big_lectures']=$this->big_lecture_model->get_all();
			
				$time_stamp=time();
				$data['time_stamp']=$time_stamp;

				$picture_tag=array(
					'pic_main' => 'false',
					'pic_1' => 'false',
					'pic_2' => 'false',
					'pic_3' => 'false',
					'pic_4' => 'false',
					 );
				//将上传的文件，复制到临时的时间戳文件夹中
				if(!is_dir('./uploads/'.$time_stamp))
					mkdir('./uploads/'.$time_stamp);
				
				//处理选项的图片
				if(file_exists('./uploads/'.$question_id.'/main.jpg'))
				{
					//拷贝
					copy('./uploads/'.$question_id.'/main.jpg','./uploads/'.$time_stamp.'/main.jpg');
					copy('./uploads/'.$question_id.'/main_thumb.jpg','./uploads/'.$time_stamp.'/main_thumb.jpg');
					$picture_tag['pic_main']='true';
				}
				if(file_exists('./uploads/'.$question_id.'/1.jpg'))
				{
					//拷贝
					copy('./uploads/'.$question_id.'/1.jpg','./uploads/'.$time_stamp.'/1.jpg');
					copy('./uploads/'.$question_id.'/1_thumb.jpg','./uploads/'.$time_stamp.'/1_thumb.jpg');
					$picture_tag['pic_1']='true';
				}
				if(file_exists('./uploads/'.$question_id.'/2.jpg'))
				{
					//拷贝
					copy('./uploads/'.$question_id.'/2.jpg','./uploads/'.$time_stamp.'/2.jpg');
					copy('./uploads/'.$question_id.'/2_thumb.jpg','./uploads/'.$time_stamp.'/2_thumb.jpg');
					$picture_tag['pic_2']='true';
				}
				if(file_exists('./uploads/'.$question_id.'/3.jpg'))
				{
					//拷贝
					copy('./uploads/'.$question_id.'/3.jpg','./uploads/'.$time_stamp.'/3.jpg');
					copy('./uploads/'.$question_id.'/3_thumb.jpg','./uploads/'.$time_stamp.'/3_thumb.jpg');
					$picture_tag['pic_3']='true';
				}
				if(file_exists('./uploads/'.$question_id.'/4.jpg'))
				{
					//拷贝
					copy('./uploads/'.$question_id.'/4.jpg','./uploads/'.$time_stamp.'/4.jpg');
					copy('./uploads/'.$question_id.'/4_thumb.jpg','./uploads/'.$time_stamp.'/4_thumb.jpg');
					$picture_tag['pic_4']='true';
				}
				
				$data['picture_tag']=$picture_tag;
				$this->load->view('admin_question/edit',$data);
			}
		}
	}

	//根据目录删除目录下的所有文件
	function delete_files_by_dir($dir) {
	  	//删除目录下的文件：
	  	$dh=opendir($dir);
	  	while ($file=readdir($dh)) {
	    	if($file!="." && $file!="..") {
	     		$fullpath=$dir."/".$file;
		      	if(!is_dir($fullpath)) 
		      	{
		          unlink($fullpath);
		      	} 
		      	else 
		      	{
		          deldir($fullpath);
		      	}
		    }
	    }
  	}

  	/**
  	 * 在离开页面的时候删除临时图片数据
  	 * @param  [type] $time_stamp [description]
  	 * @return [type]             [description]
  	 */
  	function delete_temp_picture($time_stamp)
  	{
  		//删除临时文件夹中的图片
		$this->delete_files_by_dir('./uploads/'.$time_stamp);
		//删除临时文件夹
		rmdir('./uploads/'.$time_stamp);
  	}
}