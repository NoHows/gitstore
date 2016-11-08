<?php 
/**
* admin 学生管理
*/
class Admin_student extends CI_Controller
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
		$data['majors']=$this->major_model->get_all();
		$data['classes']=$this->class_model->get_all();
		$data['logic_classes']=$this->logic_class_model->get_all_logic_classes();
		$data['students']=$this->student_model->get_all_students();
		//var_dump($this->student_model->get_all_students());
		//填充查询默认数据
		$data['major_id_select']=0;
		$data['class_id_select']=0;
		$data['logic_class_id_select']=0;
		$data['student_type_select']=0;

		$this->load->view('admin_student/index',$data);
	}     

	/**
	 * 添加学生
	 */
	function add()
	{
		//表单验证
		if($this->form_validation->run('admin_student/add'))
		{
			//post方法
			//读取数据
			$student_name=$this->input->post('student_name');
			$student_id=$this->input->post('student_id');
			$major_id=$this->input->post('major_id');
			$class_id=$this->input->post('class_id');
			$major_id=$this->input->post('major_id');
			$logic_classes=$this->input->post('logic_classes');
			//$student_type=$this->input->post('student_type');
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
						redirect('admin_student/index');	
					}
					
				}
			}

			$this->session->set_flashdata('message','操作失败');
			redirect('admin_student/index');
					
		}

		//get方法
		$data['title']='添加学生';
		$this->load->model('major_model');
		$this->load->model('class_model');
		$this->load->model('logic_class_model');

		$data['majors']=$this->major_model->get_all();
		$data['classes']=$this->class_model->get_all();
		$data['logic_classes']=$this->logic_class_model->get_all();

		$this->load->view('admin_student/add',$data);
	}
	
	/**
	 * 批量删除学生
	 */
	function batch_delete()
	{
		$students_id=$this->input->post('batch_delete_students');
		var_dump($students_id);
		//计数
		$students_num=0;
		$students_delete=0;

		$this->load->model('student_model');
		foreach ($students_id as $students_id_item) {
			if(!$this->student_model->get_by_id($students_id_item))
				$this->load->view('error');
			$students_num++;
			if($this->student_model->delete_cascade($students_id_item))
				$students_delete++;
		}

		if($students_num==$students_delete)
			$this->session->set_flashdata('message','操作成功');
		else
			$this->session->set_flashdata('message','存在相关引用，未完全删除');

		redirect('admin_student/index');
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
			if(!$teacher_exist) 
				$teacher_state=TRUE;
			else 
			{
				$teacher=$this->teacher_model->get_by_teacher_number($teacher_number);
				if($teacher_name==$teacher['name'])
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
					if($logic_class_name==$logic_class['big_lecture_name'])
					$logic_class_state=TRUE;
				}
			}
			
			
			

			$major_name=strtok("\n");
			$major_name=trim($major_name);
			$this->load->model('major_model');
			$major_exist=$this->major_model->check_major_name_exist($major_name);

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
					$data['error_message']='文件信息不完整，或格式错误';
					$this->load->view('error',$data);
				}
				array_push($students, $student);
			}

			if(!($teacher_name&&$teacher_number&&$logic_class_name&&$logic_class_number&&$class_name&&$major_name))
			{
				$data['error_message']='文件信息不完整，或格式错误';
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
			// var_dump($data);
			$this->load->view('admin_student/batch_add_preview',$data);
			
			



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
			$data['error_message']='文件信息不完整，或格式错误';
			return $this->load->view('error',$data);
		}	


		
		$teacher_exist=$this->teacher_model->teacher_number_exist($teacher_number);
		$class_exist=$this->class_model->check_class_name_exist($class_name);
		$logic_class_exist=$this->logic_class_model->logic_class_number_exist($logic_class_number);
		$major_exist=$this->major_model->check_major_name_exist($major_name);

		//如果不存在，不合法
		if(!$major_exist)
		{
			return $this->load->view('error');
			//新建一个
			// $major = array(
			// 	'name' => $major_name
			// 	 );

			// $this->major_model->add($major);
		}
		$major=$this->major_model->get_by_major_name($major_name);

		//如果不存,不合法
		if(!$class_exist)
		{
			return $this->load->view('error');
			// $class = array(
			// 	'name' => $class_name
			// 	 );

			// $this->class_model->add($class);
		}
		$class=$this->class_model->get_by_class_name($class_name);

		if(!$teacher_exist)
		{
			//新建一个用户
			$user = array(
				'username' => $teacher_number,
				'password' => md5($teacher_number),
				'role_id' => 2,
				 );

			
			$this->user_model->add($user);

			$user_id=$this->db->insert_id();

			$teacher = array(
				'user_id' => $user_id,
				'teacher_number' => $teacher_number,
				'name' => $teacher_name,
				'major_id' => $major['id']
				 );

			$this->teacher_model->add($teacher);
		}
		$teacher=$this->teacher_model->get_by_teacher_number($teacher_number);

		//如果不存在新建一个
		if(!$logic_class_exist)
		{
			//通过名称得到课程id
			$lecture_name=$logic_class_name;
			$this->load->model('lecture_model');
			$lecture_id=$this->lecture_model->get_lecture_id($lecture_name);
			if(!$lecture_id) return $this->load->view('error');
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
		redirect('admin_student/index');

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
	function check($id=0)
	{
		$this->load->model('student_model');
		$student=$this->student_model->get_by_id($id);
		if(!$student)
			return $this->load->view('error');

		$data['title']='查看学生';
		$data['student']=$this->student_model->get_student_by_id($id);
		$data['relative_logic_classes']=$this->student_model->get_relative_logic_classes($id);
		//var_dump($this->student_model->get_relative_logic_classes($id));

		$this->load->view('admin_student/check',$data);


	}

	/**
	 * 删除一个学生
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	function delete($id)
	{
		$this->load->model('student_model');
		if(!$this->student_model->get_by_id($id))
			$this->load->view('error');
		if($this->student_model->delete_cascade($id))
			$this->session->set_flashdata('message','操作成功');
		else
			$this->session->set_flashdata('message','存在相关引用，操作失败');

		redirect('admin_student/index');
	}

	/**
	 * 编辑一个学生的信息
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	function edit($id=0)
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

			$data['majors']=$this->major_model->get_all();
			$data['classes']=$this->class_model->get_all();
			$data['logic_classes']=$this->logic_class_model->get_all_logic_classes();
			$data['logic_classes_select']=$this->student_model->get_logic_classes_select($id);
			$this->load->view('admin_student/edit',$data);
		}
		else
		{
			//post方法
			//读取数据
			$this->load->model('student_model');

			$id=$this->input->post('id');
			$student=$this->student_model->get_by_id($id);
			if(!$student)
				return $this->load->view('error');
			if($this->form_validation->run('admin_student/edit'))
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
				
				//数据库操作
				if($this->student_model->delete_relative_logic_classes($id)&&
					$this->student_model->add_relative_logic_classes($id,$logic_classes)&&
					$this->student_model->update($id,$student))
				{
					$this->session->set_flashdata('message','操作成功');
					redirect('admin_student/index');	
				}
				else
				{
					$this->session->set_flashdata('message','操作失败');
					redirect('admin_student/index');	
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
				$data['logic_classes']=$this->logic_class_model->get_all();

				$this->load->view('admin_student/edit',$data);
			}
				
		}
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
		$this->load->view('admin_student/index',$data);
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
 