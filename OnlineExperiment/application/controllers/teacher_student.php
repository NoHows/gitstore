<?php 
/**
* teacher 学生管理
*/
class Teacher_student extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		//登陆状态检测
		if(!$this->session->userdata('e_user_in'))
			redirect('home');
		//权限检测
		if($this->session->userdata('e_role_id') != 2)
			redirect('home');
	}

	/**
	 * student管理的主界面
	 * @return [type]
	 */
	function index()
	{
		//准备数据
		$data = array();
		$data['title']='学生管理';

		$this->load->model('student_model');
		$this->load->model('major_model');
		$this->load->model('class_model');
		$this->load->model('logic_class_model');

		$this->load->model('teacher_model');
		$teacher=$this->teacher_model->get_by_username($this->session->userdata('e_username'));
		
		$logic_classes=$this->logic_class_model->get_logic_classes_by_teacher_id($teacher['id']);
		$index=0;
		foreach ($logic_classes as $item) {
			$classes_list_by_logic_class[$index]=$this->class_model->get_classes_by_logic_class_id($item['id']);
			for ($i=0; $i < count($classes_list_by_logic_class[$index]); $i++) { 
				$classes_list_by_logic_class[$index][$i]['select_num']=$this->class_model->get_select_num_in_class($item['id'],$classes_list_by_logic_class[$index][$i]['id']);
				$classes_list_by_logic_class[$index][$i]['total_num']=$this->class_model->get_total_num_in_class($classes_list_by_logic_class[$index][$i]['id']);
			}
			
			$index++;	
		}

		$data['logic_classes']=$logic_classes;
		if($logic_classes)
		{
			$data['classes_list_by_logic_class']=$classes_list_by_logic_class;
		}
		//var_dump($classes_list_by_logic_class);
		$this->load->view('teacher_student/index',$data);
	}     

	/**
	 * 查看某个逻辑班下，某个班级里的学生
	 * @return [type] [description]
	 */
	function check_class($logic_class_id,$class_id)
	{
		$this->load->model('logic_class_model');
		$this->load->model('class_model');
		$logic_class=$this->logic_class_model->get_logic_class_by_id($logic_class_id);
		if(!$logic_class) return $this->load->view('error');
		$class=$this->class_model->get_by_id($class_id);
		if(!$class_id) return $this->load->view('error');

		$this->load->model('student_model');
		$students=$this->student_model->get_students_by_logic_class_id_and_class_id($logic_class_id,$class_id);
		$this->load->model('teacher_model');
		$me=$this->teacher_model->get_by_username($this->session->userdata('e_username'));
		for ($i=0; $i < count($students); $i++) { 
			$students[$i]['editable']=$this->student_model->check_student_editable($students[$i]['id'],$me['id']);
		}
		

		$data['logic_class']=$logic_class;
		$data['class']=$class;
		$data['students']=$students;
		$data['title']='查看学生';
		$this->load->view('teacher_student/check_class',$data);
	}

	/**
	 * 删除某个逻辑班下，某个班级里的学生
	 * @return [type] [description]
	 */
	function delete_class($logic_class_id,$class_id)
	{
		$this->load->model('logic_class_model');
		$this->load->model('class_model');
		$logic_class=$this->logic_class_model->get_logic_class_by_id($logic_class_id);
		// var_dump($logic_class_id);
		// var_dump($class_id);
		if(!$logic_class) return $this->load->view('error');
		$class=$this->class_model->get_by_id($class_id);
		if(!$class_id) return $this->load->view('error');

		$this->load->model('student_model');
		$students=$this->student_model->get_students_by_logic_class_id_and_class_id($logic_class_id,$class_id);
		var_dump($students);
		$this->load->model('teacher_model');
		$me=$this->teacher_model->get_by_username($this->session->userdata('e_username'));
		for ($i=0; $i < count($students); $i++) { 
			$students[$i]['editable']=$this->student_model->check_student_editable($students[$i]['id'],$me['id']);
		}

		// var_dump($logic_class);
		// var_dump($class);
		// var_dump($students);
		$students_num=0;
		$delete_num=0;

		foreach ($students as $students_item) {
			$students_num++;
			if($this->student_model->delete_from_logic_class($logic_class_id,$students_item['id']))
				//如果这个学生并没有选择其他课程，则删除这个学生
				if(!$this->student_model->check_in_logic_class($students_item['id']))
				{
					$this->student_model->delete_cascade($students_item['id']);
				}
				$students_delete++;
		}

		if($students_num==$students_delete)
			$this->session->set_flashdata('message','操作成功');
		else
			$this->session->set_flashdata('message','存在相关引用，未完全删除');
		redirect('teacher_student/index');
	}

	/**
	 * 添加学生
	 */
	function add()
	{
		//表单验证
		if($this->form_validation->run('teacher_student/add'))
		{
			//post方法
			//读取数据
			$student_name=$this->input->post('student_name');
			$student_id=$this->input->post('student_id');
			$major_id=$this->input->post('major_id');
			$class_id=$this->input->post('class_id');
			$logic_classes=$this->input->post('logic_classes');

			//如果用户没有选择课程（逻辑班），则报错
			if(!$logic_classes)
			{
				$data['error_message']='您必须为这个学生选择一个您的课程';
				return $this->load->view('error',$data);
			}

			//如果这个学生已经存在，核对信息
			$this->load->model('student_model');
			if($this->student_model->student_id_exist($student_id))
			{
				$student=$this->student_model->get_by_student_id($student_id);
				if($student['name']!=$student_name||$student['major_id']!=$major_id||$student['class_id']!=$class_id)
				{
					$data['error_message']=($student['class_id']!=$class_id).'这个学号的学生已经存在，系统尝试合并信息时出现错误，请检查您输入的姓名，专业，班级信息是否正确。';
					return $this->load->view('error',$data);
				}
				//添加学生选课关系
				$student_id=$student['id'];
				if($this->student_model->add_relative_logic_classes($student_id,$logic_classes))
				{
					$this->session->set_flashdata('message','添加成功');
					redirect('teacher_student/index');	
				}
			}
			else
			{
				//新建一个用户
				$user = array(
					'username' => $student_id,
					'password' => md5($student_id),
					'role_id' => 3,
					 );

				$this->load->model('user_model');
				if($this->user_model->add($user))
				{
					$user_id=$this->db->insert_id();

					//将学生写入数据库
					$student = array(
						'user_id' => $user_id,
						'name' => $student_name,
						'student_id' => $student_id,
						'major_id' => $major_id,
						'type' => 1,
						'class_id' => $class_id,
						 );
					$this->load->model('student_model');
					if($this->student_model->add($student))
					{
						//添加学生选课关系
						$student_id=$this->db->insert_id();
						if($this->student_model->add_relative_logic_classes($student_id,$logic_classes))
						{
							$this->session->set_flashdata('message','添加成功');
							redirect('teacher_student/index');	
						}
						
					}
				}
			}

			
			

			$this->session->set_flashdata('message','操作失败');
			redirect('teacher_student/index');
					
		}

		//get方法
		$data['title']='添加学生';
		$this->load->model('major_model');
		$this->load->model('class_model');
		$this->load->model('logic_class_model');
		$this->load->model('teacher_model');
		$me=$this->teacher_model->get_by_username($this->session->userdata('e_username'));

		$data['majors']=$this->major_model->get_all();
		$data['classes']=$this->class_model->get_all();
		$data['logic_classes']=$this->logic_class_model->get_all_logic_classes_by_teacher_id($me['id']);

		$this->load->view('teacher_student/add',$data);
	}
	
	/**
	 * 批量添加学生
	 */
	function batch_add()
	{
		$config['upload_path'] = './uploads/';
		$config['allowed_types'] = 'text|txt';
		$config['max_size'] = '1000';
		$config['file_name'] = date('ymdHis',time());
		$this->load->library('upload', $config);

		if (!$this->upload->do_upload('student_file'))
		{
			$data['error_message']='文件不符合要求';
			$this->load->view('error',$data);
		} 
		else
		{
			
			$file_info=$this->upload->data();
			$content=file_get_contents($file_info['full_path']);
			$content=$this->remove_utf8_bom($content);
			// $content = mb_convert_encoding($content, "UTF-8");
			header('Content-Type: text/html; charset=UTF-8');
			$first_line=strtok($content, "\n");
			$second_line=strtok("\n");
			$third_line=strtok("\n");

			

			$item=strtok("\n");
			$items=array();
			while($item)
			{
				array_push($items,$item);
				$item=strtok("\n");
			}

			$teacher_name=strtok($first_line, ",");
			$teacher_name=substr($teacher_name, 1);
			$teacher_name=trim($teacher_name);
			$teacher_number=strtok("\n");
			$teacher_number=trim($teacher_number);
			$this->load->model('teacher_model');
			$teacher_exist=$this->teacher_model->teacher_number_exist($teacher_number);
			
			$teacher_state=FALSE;
			// if(!$teacher_exist) 
			// 	$teacher_state=TRUE;
			// else 
			// {
			// 	$teacher=$this->teacher_model->get_by_teacher_number($teacher_number);
			// 	if($teacher_name==$teacher['name'])
			// 		$teacher_state=TRUE;
			// }
			
			$me=$this->teacher_model->get_by_username($this->session->userdata('e_username'));
			if(!$teacher_exist) 
				$teacher_state=FALSE;
			else 
			{
				$teacher=$this->teacher_model->get_by_teacher_number($teacher_number);
				
				if($teacher_name==$teacher['name']&&$teacher['teacher_number']==$me['teacher_number'])
					$teacher_state=TRUE;
			}
				
			
			$logic_class_name=strtok($second_line, ",");
			$logic_class_name=trim($logic_class_name);
			$logic_class_name=substr($logic_class_name, 1);
			$logic_class_name=trim($logic_class_name);
			$logic_class_number=strtok("\n");
			$logic_class_number=trim($logic_class_number);
			$class_name=strtok($third_line, ",");
			$class_name=substr($class_name, 1);
			$class_name=trim($class_name);
			$this->load->model('class_model');
			$class_exist=$this->class_model->check_class_name_exist($class_name);

			$this->load->model('logic_class_model');
			$logic_class_exist=$this->logic_class_model->logic_class_number_exist($logic_class_number);

			$logic_class_state=FALSE;
			//检查课程名称是否存在
			$this->load->model('big_lecture_model');
			$big_lecture_exist=$this->big_lecture_model->check_big_lecture_exist($logic_class_name);
			if(!$big_lecture_exist)
				$logic_class_state=FALSE;
			else{
				if(!$logic_class_exist)
					$logic_class_state=TRUE;
				else
				{

					$logic_class=$this->logic_class_model->get_by_logic_class_number($logic_class_number);
					if($logic_class_name==$logic_class['big_lecture_name']&&$logic_class['teacher_id']==$me['id'])
					$logic_class_state=TRUE;
				}
			}
			
			
			

			$major_name=strtok("\n");
			$major_name=trim($major_name);
			$this->load->model('major_model');
			$major_exist=$this->major_model->check_major_name_exist($major_name);
			//$major_exist=1;
			var_dump($major_name);
			var_dump($major_exist);

			$this->load->model('student_model');
			$students=array();
			foreach ($items as $item) {
				$student['student_id']=strtok($item, ',');
				$student['student_id']=trim($student['student_id']);
				$student['student_name']=strtok("\n");
				$student['student_name']=trim($student['student_name']);
				$student['student_exist']=$this->student_model->student_id_exist($student['student_id']);

				$student['student_state']=FALSE;
				if(!$student['student_exist'])
					$student['student_state']=TRUE;
				else
				{
					$stu=$this->student_model->get_by_student_id($student['student_id']);
					if($student['student_name']==$stu['name'])
					$student['student_state']=TRUE;
				}
				if(!($student['student_id']&&$student['student_name']))
				{
					$data['error_message']='文件信息不完整，或格式错误1';
					$this->load->view('error',$data);
				}
				array_push($students, $student);
			}

			if(!($teacher_name&&$teacher_number&&$logic_class_name&&$logic_class_number&&$class_name&&$major_name))
			{
				$data['error_message']='文件信息不完整，或格式错误2';
				return $this->load->view('error',$data);
			}	
			$data['teacher_name']=$teacher_name;
			$data['teacher_number']=$teacher_number;
			$data['teacher_exist']=$teacher_exist;
			$data['teacher_state']=$teacher_state;

			$data['logic_class_name']=$logic_class_name;
			$data['logic_class_number']=$logic_class_number;
			$data['logic_class_exist']=$logic_class_exist;
			$data['logic_class_state']=$logic_class_state;

			$data['class_name']=$class_name;
			$data['class_exist']=$class_exist;
			$data['major_name']=$major_name;
			$data['major_exist']=$major_exist;
			$data['students']=$students;			
			$data['title']='批量添加预览';
			//var_dump($data);
			$this->load->view('teacher_student/batch_add_preview',$data);
			



		// $data = array('upload_data' => $this->upload->data());

		// $this->load->view('upload_success', $data);
		}
	}

	/**
	 * 检测并移除字符串中的bom
	 * @param  [type] $text [description]
	 * @return [type]       [description]
	 */
	function remove_utf8_bom($text)
	{
	    $bom = pack('H*','EFBBBF');
	    $text = preg_replace("/^$bom/", '', $text);
	    return $text;
	}
	/**
	 * 批量添加学生确认
	 * @return [type] [description]
	 */
	function batch_add_confirm()
	{
		//加载需要的模型
		$this->load->model('teacher_model');
		$this->load->model('class_model');
		$this->load->model('logic_class_model');
		$this->load->model('major_model');
		$this->load->model('user_model');
		$this->load->model('student_model');

		//读取数据
		$teacher_name=$this->input->post('teacher_name');
		$teacher_number=$this->input->post('teacher_number');
		$logic_class_name=$this->input->post('logic_class_name');
		$logic_class_number=$this->input->post('logic_class_number');
		$class_name=$this->input->post('class_name');
		$major_name=$this->input->post('major_name');
		$student_count=$this->input->post('student_count');
		
		//验证信息是否完整
		if(!($teacher_name&&$teacher_number&&$logic_class_name&&$logic_class_number&&$class_name&&$major_name))
		{
			$data['error_message']='文件信息不完整，或格式错误3';
			return $this->load->view('error',$data);
		}	


		
		$teacher_exist=$this->teacher_model->teacher_number_exist($teacher_number);
		$class_exist=$this->class_model->check_class_name_exist($class_name);
		$logic_class_exist=$this->logic_class_model->logic_class_number_exist($logic_class_number);
		$major_exist=$this->major_model->check_major_name_exist($major_name);

		//如果专业不存在错误
		if(!$major_exist)
		{
			$data['error_message']='专业不存在';
			return $this->load->view('error',$data);
		}
		$major=$this->major_model->get_by_major_name($major_name);

		//如果班级不存在，错误
		if(!$class_exist)
		{
			$data['error_message']='班级不存在';
			return $this->load->view('error',$data);
		}
		$class=$this->class_model->get_by_class_name($class_name);

		//如果老师不存在，错误
		if(!$teacher_exist)
		{
			$data['error_message']='这个老师不存在';
			return $this->load->view('error',$data);
		}
		$teacher=$this->teacher_model->get_by_teacher_number($teacher_number);
		$this->load->model('teacher_model');
		$me=$this->teacher_model->get_by_username($this->session->userdata('e_username'));
		//如果不是自己，错误
		if($teacher['teacher_number']!=$me['teacher_number'])
		{
			$data['error_message']='必须添加自己的学生';
			return $this->load->view('error',$data);
		}

		//逻辑班如果不存在新建一个
		if(!$logic_class_exist)
		{
			//通过名称得到课程id
			$lecture_name=$logic_class_name;
			$this->load->model('lecture_model');
			$lecture_id=$this->lecture_model->get_lecture_id($lecture_name);
			$logic_class = array(
				'number' => $logic_class_number,
				'teacher_id' => $teacher['id'],
				'type'=>1,
				'lecture_id'=>$lecture_id
				 );
			$this->logic_class_model->add($logic_class);
		}
		$logic_class=$this->logic_class_model->get_by_logic_class_number($logic_class_number);


		for ($i=1; $i <= $student_count; $i++) { 
			$student_name=$this->input->post('student_name_'.$i);
			$student_id=$this->input->post('student_id_'.$i);
			$student_exist=$this->student_model->student_id_exist($student_id);
			//如果存在这个用户，合并
			// if($student_exist)
			// {
			// 	$student=$this->student_model->get_by_student_id($student_id);
			// 	$this->student_model->delete_cascade($student['id']);
			// }
			
			//如果不存在新建一个
			if(!$student_exist)
			{
				//新建一个用户
				$user = array(
					'username' => $student_id,
					'password' => md5($student_id),
					'role_id' => 3,
					 );

				if($this->user_model->add($user))
				{
					$user_id=$this->db->insert_id();

					//将学生写入数据库
					$student = array(
						'user_id' => $user_id,
						'name' => $student_name,
						'student_id' => $student_id,
						'major_id' => $major['id'],
						'type' => 1,
						'class_id' => $class['id'],
						 );
					$this->student_model->add($student);
				}
			}	
			
			
			$student=$this->student_model->get_by_student_id($student_id);

			//录入选课信息
			$this->student_model->add_logic_class($student['id'],$logic_class['id']);

		}

		$this->session->set_flashdata('message','操作成功');
		redirect('teacher_student/index');

	}


	function cut_last_char($str)
	{
		return substr($str, 0,strlen($str)-1);
	}

	/**
	 * 查看一个学生的信息
	 * @param  integer $id [description]
	 * @return [type]      [description]
	 */
	function check_student($id=0,$logic_class_id,$class_id)
	{
		$this->load->model('student_model');
		$student=$this->student_model->get_by_id($id);
		if(!$student)
			return $this->load->view('error');

		$data['title']='查看学生';
		$data['before_logic_class_id']=$logic_class_id;
		$data['before_class_id']=$class_id;
		$data['student']=$this->student_model->get_student_by_id($id);
		//$data['relative_logic_classes']=$this->student_model->get_relative_logic_classes($id);




		$data['relative_teacher_logic_classes']=$this->student_model->get_relative_teacher_logic_classes($logic_class_id,$id);





		$this->load->view('teacher_student/check_student',$data);


	}

	/**
	 * 删除一个学生
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	function delete($logic_class_id,$class_id,$student_id)
	{

		$this->load->model('student_model');
		if(!$this->student_model->get_by_id($student_id))
			$this->load->view('error');
		if($this->student_model->delete_from_logic_class($logic_class_id,$student_id))
		{
			//如果这个学生并没有选择其他课程，则删除这个学生
			if(!$this->student_model->check_in_logic_class($student_id))
			{
				$this->student_model->delete_cascade($student_id);
			}
			$this->session->set_flashdata('message','操作成功');
		}
		else
			$this->session->set_flashdata('message','存在相关引用，操作失败');

		redirect('teacher_student/check_class'.'/'.$logic_class_id.'/'.$class_id);
	}

	/**
	 * 编辑一个学生的信息
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	function edit($id=0,$logic_class_id,$class_id)
	{
		if($id)
		{
			//get方法
			$this->load->model('student_model');
			$student=$this->student_model->get_student_by_id($id);
			if(!$student)
				return $this->load->view('error');
			$data['title']='编辑学生信息';
			$data['student']=$student;

			$this->load->model('major_model');
			$this->load->model('class_model');
			$this->load->model('logic_class_model');

			$data['logic_class_id']=$logic_class_id;
			$data['class_id']=$class_id;
			$data['majors']=$this->major_model->get_all();
			$data['classes']=$this->class_model->get_all();
			$this->load->model('teacher_model');
			$me=$this->teacher_model->get_by_username($this->session->userdata('e_username'));
			$data['logic_classes']=$this->logic_class_model->get_all_logic_classes_by_teacher_id($me['id']);
			$data['logic_classes_select']=$this->student_model->get_logic_classes_select($id);
			$this->load->view('teacher_student/edit',$data);
		}
		else
		{
			//post方法
			//读取数据
			$this->load->model('student_model');

			$id=$this->input->post('id');
			$before_logic_class_id=$this->input->post('before_logic_class_id');
			$before_class_id=$this->input->post('before_class_id');
			$student=$this->student_model->get_by_id($id);
			if(!$student)
				return $this->load->view('error');
			if($this->form_validation->run('teacher_student/edit'))
			{
				$student_name=$this->input->post('student_name');
				$major_id=$this->input->post('major_id');
				$class_id=$this->input->post('class_id');
				$logic_classes=$this->input->post('logic_classes');

				//将模块写入数据库
				$student = array(
					'name' => $student_name,
					'major_id' => $major_id,
					'class_id' => $class_id,
					 );
				
				//如果用户没有选择课程（逻辑班），则报错
				// if(!$logic_classes)
				// {
				// 	$data['error_message']='您必须为这个学生选择一个您的课程';
				// 	return $this->load->view('error',$data);
				// }


				//数据库操作
				//$this->student_model->delete_relative_logic_classes($id)&&$this->student_model->add_relative_logic_classes($id,$logic_classes)&&
				if($this->student_model->update($id,$student))
				{
					$this->session->set_flashdata('message','操作成功');
					redirect('teacher_student/check_class'.'/'.$before_logic_class_id.'/'.$before_class_id);
				}
				else
				{
					$this->session->set_flashdata('message','操作失败');
					redirect('teacher_student/check_class'.'/'.$before_logic_class_id.'/'.$before_class_id);
				}
	
			}
			else
			{
				//验证失败
				//get
				$data['title']='编辑学生信息';
				$data['student']=$student;

				$this->load->model('major_model');
				$this->load->model('class_model');
				$this->load->model('logic_class_model');

				$data['majors']=$this->major_model->get_all();
				$data['classes']=$this->class_model->get_all();
				$this->load->model('teacher_model');
				$me=$this->teacher_model->get_by_username($this->session->userdata('e_username'));
				$data['logic_classes']=$this->logic_class_model->get_all_logic_classes_by_teacher_id($me['id']);

				$this->load->view('teacher_student/edit',$data);
			}
				
		}
	}

	/**
	 * 查看一个学生的信息
	 * @param  integer $id [description]
	 * @return [type]      [description]
	 */
	function check_student_performance($id=0,$logic_class_id,$class_id)
	{
		$this->load->model('student_model');
		$this->load->model('major_model');
		$this->load->model('class_model');
		$this->load->model('report_model');
		$this->load->model('module_model');
		$this->load->model('logic_class_model');
		$this->load->model('big_lecture_model');


		$student=$this->student_model->get_by_id($id);
		if(!$student)
			return $this->load->view('error');

		//获取学生参加的逻辑班
		$student_logic_class=$this->student_model->get_student_logic_class($student['id']);
		
		// echo "student_logic_class";
		// var_dump($student_logic_class);
		//获取所有逻辑班的信息
		$all_logic_class = array();
		foreach ($student_logic_class as $item) {
			$logic_class=$this->logic_class_model->get_by_id($item['logic_class_id']);
			array_push($all_logic_class, $logic_class);
		}

		// echo "all_logic_class";
		// var_dump($all_logic_class);

		//获取逻辑班下的考试模块
		$all_logic_class_module = array();
		foreach ($all_logic_class as $logic_class_item) {
			$module_in_logic_class=$this->module_model->get_module_in_logic_class($logic_class_item['big_lecture_id']);
			//var_dump($module_in_logic_class);
			//获取每个模块的已考试次数
			$module_add_report_count_in_logic_class = array();
			if($module_in_logic_class)
			{
				foreach ($module_in_logic_class as $module_item) {				
				$report_count_module = $this->report_model->get_count_by_module_student_logic_class($student['id'],$module_item['id'],$logic_class_item['id']);
				$module_add_report_count = array(
					'module_id' => $module_item['id'],
					'module_name' => $module_item['name'],
					'time_limit' => $module_item['time_limit'],
					'module_type' => $module_item['type'],
					'module_sort' => $module_item['module_sort'],
					'big_lecture_id' => $module_item['big_lecture_id'],
					'big_lecture_name' => $module_item['big_lecture_name'],
					'logic_class_id' => $logic_class_item['id'],
					'logic_class_number' => $logic_class_item['number'],
					'logic_class_type' => $logic_class_item['type'],
					'report_count' => $report_count_module
					);
				array_push($module_add_report_count_in_logic_class, $module_add_report_count);
				}
			}
			else
			{
				$big_lecture = $this->big_lecture_model->get_by_id($logic_class_item['big_lecture_id']);
				// var_dump($big_lecture);
				$module_add_report_count = array(
					'module_id' => null,
					'module_name' => null,
					'time_limit' => null,
					'module_type' => null,
					'module_sort' => null,
					'big_lecture_id' => $big_lecture['id'],
					'big_lecture_name' => $big_lecture['name'],
					'logic_class_id' => $logic_class_item['id'],
					'logic_class_number' => $logic_class_item['number'],
					'logic_class_type' => $logic_class_item['type'],
					'report_count' => null
					);
				array_push($module_add_report_count_in_logic_class, $module_add_report_count);
			}
			
			array_push($all_logic_class_module, $module_add_report_count_in_logic_class);
		}

		//var_dump($all_logic_class_module);

		$major=$this->major_model->get_by_id($student['major_id']);
		$class=$this->class_model->get_by_id($student['class_id']);
		
		$data = array();
		$data['title']='查看学生';
		$data['before_logic_class_id']=$logic_class_id;
		$data['before_class_id']=$class_id;
		$data['student']=$this->student_model->get_student_by_id($id);
		$data['major']=$major;
		$data['class']=$class;
		$data['all_logic_class_module']=$all_logic_class_module;
		$data['relative_logic_classes']=$this->student_model->get_relative_logic_classes($id);
		// var_dump($all_logic_class_module);
		$this->load->view('teacher_student/check_student_performance',$data);



	}

	//查看学生每门实验的考试成绩列表
	function check_student_module_performance($id=0,$logic_class_id,$class_id)
	{
		if(date_default_timezone_get() != "Asia/Shanghai") 
			date_default_timezone_set("Asia/Shanghai");
		//从url中获取学生学号和要考试的模块和逻辑班号
		$this->load->library('uri');
		$student_id = $this->uri->segment(3);
		$module_id = $this->uri->segment(4);
		$logic_class_id = $this->uri->segment(5);
		$big_lecture_id = $this->uri->segment(6);

		$this->load->model('report_model');
		$this->load->model('big_lecture_model');
		$this->load->model('module_model');
		$this->load->model('logic_class_model');
		$this->load->model('student_model');

		$student = $this->student_model->get_by_id($student_id);
		$big_lecture = $this->big_lecture_model->get_by_id($big_lecture_id);
		$logic_class = $this->logic_class_model->get_by_id($logic_class_id);
		$module = $this->module_model->get_by_id($module_id);

		//获取该学生在该实验模块的历次考试记录
		$reports = $this->report_model->get_all_reports_of_student_module_logic_class($student_id,$module_id,$logic_class_id);

		$data = array();
		$data['title']='查看实验成绩';
		$data['student']=$student;
		$data['student_id']=$student_id;
		$data['class_id']=$class_id;
		$data['big_lecture']=$big_lecture;
		$data['logic_class']=$logic_class;
		$data['module']=$module;
		$data['reports']=$reports;
		
		$this->load->view('teacher_student/check_student_module_performance',$data);
	}

	//查看试卷详细内容
	function check_module_report()
	{
		if(date_default_timezone_get() != "Asia/Shanghai") 
			date_default_timezone_set("Asia/Shanghai");
		//var_dump($date_early_limit_check);

		$this->load->model('question_model');
		$this->load->model('report_model');
		$this->load->model('module_model');
		$this->load->model('student_model');

		$report_id = $this->uri->segment(3);
		$module_id = $this->uri->segment(4);
		$logic_class_id = $this->uri->segment(5);
		$student_id = $this->uri->segment(6);

		$student = $this->student_model->get_by_id($student_id);
		$report_check = $this->report_model->get_by_id($report_id);
		
		$module_check = $this->module_model->get_by_id($module_id);
		$question_in_report_check = $this->report_model->get_from_question_in_report($report_id);
		
		$check_question = array();

		foreach ($question_in_report_check as $item) {

		$question_check = $this->question_model->get_by_id($item['question_id']);
		$each_check_question = array(
			"id"=>$question_check['id'],
			"module_id"=>$question_check['module_id'],
			"content_main"=>$question_check['content_main'],
			"picture_main_id"=>$question_check['picture_main_id'],
			"content_1"=>$question_check['content_1'],
			"picture_1_id"=>$question_check['picture_1_id'],
			"content_2"=>$question_check['content_2'],
			"picture_2_id"=>$question_check['picture_2_id'],
			"content_3"=>$question_check['content_3'],
			"picture_3_id"=>$question_check['picture_3_id'],
			"content_4"=>$question_check['content_4'],
			"picture_4_id"=>$question_check['picture_4_id'],
			"answer"=>$question_check['answer'],
			"number"=>$question_check['number'],
			"report_id"=>$item['report_id'],
			"choose"=>$item['choose']
				);		
			array_push($check_question, $each_check_question);
		}
			//var_dump($check_question);

		$data = array();	
		$data['student']=$student;
		$data['grades']=$report_check['grades'];
		$data['module']=$module_check;
		$data['logic_class_id']=$logic_class_id;
		$data['check_question']=$check_question;
		$data['title']="查看试卷详细内容";
		$this->load->view('teacher_student/check_module_report',$data);
	}

	/**
	 * 查询特定的某些同学
	 * @return [type] [description]
	 */
	function search()
	{
		$major_id=$this->input->post('major_id');
		$class_id=$this->input->post('class_id');
		$logic_class_id=$this->input->post('logic_class_id');
		$student_type=$this->input->post('student_type');

		$this->load->model('student_model');
		$students=$this->student_model->search($major_id,$class_id,$logic_class_id,$student_type);

		$this->load->model('major_model');
		$this->load->model('class_model');
		$this->load->model('logic_class_model');
		$data['majors']=$this->major_model->get_all();
		$data['classes']=$this->class_model->get_all();
		$data['logic_classes']=$this->logic_class_model->get_all_logic_classes();
		$data['students']=$students;

		$data['major_id_select']=$major_id;
		$data['class_id_select']=$class_id;
		$data['logic_class_id_select']=$logic_class_id;
		$data['student_type_select']=$student_type;
		$data['title']='查询';
		$this->load->view('teacher_student/index',$data);
	}

	//重置学生的密码
	function reset_password($logic_class_id,$class_id,$id=0)
	{
		$this->load->model('student_model');
		$student = $this->student_model->get_by_id($id);
		if(!$student)
			$this->load->view('error');
		var_dump($student);
		$username = $student['student_id'];
		$this->load->model('user_model');
		$user=$this->user_model->get_by_username($username);
		var_dump($user);
		if($user)
		{
			$user['password']=md5($username);
			if($this->user_model->update($user['id'],$user))
			{
				$this->session->set_flashdata('message','修改成功');
				redirect('teacher_student/check_class'.'/'.$logic_class_id.'/'.$class_id);
			}
			else
			{
				$this->session->set_flashdata('message','操作失败');
				redirect('teacher_student/check_class'.'/'.$logic_class_id.'/'.$class_id);
			}
					
		}
		else{
			$this->session->set_flashdata('message','不存在该用户');
			redirect('teacher_student/check_class'.'/'.$logic_class_id.'/'.$class_id);
		}
	}
	/**
	 * 异步jquery验证
	 * @return [type] [description]
	 */
	function check_student_id_exist()
	{
		$student_id=$this->input->post('student_id');
		$this->load->model('student_model');
		if($this->student_model->student_id_exist($student_id))
			echo json_encode(FALSE);
		else 
			echo json_encode(TRUE);
	}

	/**
	 * CI的表单回调函数验证
	 * @param  [type] $str [description]
	 * @return [type]      [description]
	 */
	function student_id_check($student_id)
	{
		$this->load->model('student_model');
		if($this->student_model->student_id_exist($student_id))
			return FALSE;
		else 
			return TRUE;
	}
	
}
 