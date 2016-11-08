// <?php 
// /**
// * teacher 班级管理，包括专业，班级，逻辑班
// */
// class Teacher_class extends CI_Controller
// {
	
// 	function __construct()
// 	{
// 		parent::__construct();
// 		//登陆状态检测
// 		if(!$this->session->userdata('user_in'))
// 			redirect('home');
// 		//权限检测
// 		if($this->session->userdata('role_id') != 2)
// 			redirect('home');
// 	}

// 	/**
// 	 * 班级管理的主界面
// 	 * @return [type]
// 	 */
// 	function index()
// 	{
// 		//准备数据
// 		$data = array();
// 		$data['title']='班级管理';
// 		$this->load->model('logic_class_model');
// 		$this->load->model('teacher_model');
// 		$teacher=$this->teacher_model->get_by_username($this->session->userdata('username'));
// 		$data['logic_classes']=$this->logic_class_model->get_all_logic_classes_by_teacher_id($teacher['id']);
// 		$this->load->view('teacher_class/index',$data);
// 	}     

// 	/**
// 	 * 查看一个班级的详细信息
// 	 * @param  [type] $id [description]
// 	 * @return [type]     [description]
// 	 */
// 	function class_check($id)
// 	{
// 		$data['title']='查看班级';
// 		$this->load->model('class_model');
// 		$class=$this->class_model->get_by_id($id);
// 		if(!$class) return View('error');

// 		$data['class']=$class;
// 		$data['students']=$this->class_model->get_students_from_class_id($class['id']);

// 		$this->load->view('teacher_class/class_check',$data);
// 	}

// 	/**
// 	 * 添加一个班级的信息
// 	 * @param  [type] $id [description]
// 	 * @return [type]     [description]
// 	 */
// 	function class_add()
// 	{
// 		//表单验证
// 		if($this->form_validation->run('teacher_class/class_add'))
// 		{
// 			//post方法
// 			//读取数据
// 			$class_name=$this->input->post('class_name');

// 			$this->load->model('class_model');

// 			//检查如果这个班级名称已经存在，则提醒
// 			if($this->class_model->check_class_name_exist($class_name))
// 			{
// 				$this->session->set_flashdata('message','这个班级已存在，添加失败');
// 				redirect('teacher_class/class_add');
// 			}

// 			//新建一个
// 			$class = array(
// 				'name' => $class_name
// 				 );

// 			$this->class_model->add($class);

			
// 			redirect('teacher_class/index');		
// 		}

// 		//get方法
// 		$data['title']='添加班级';
// 		$this->load->view('teacher_class/class_add',$data);
// 	}


// 	/**
// 	 * 删除一个班级
// 	 * @param  [type] $id [description]
// 	 * @return [type]     [description]
// 	 */
// 	function class_delete($id)
// 	{
// 		$this->load->model('class_model');
// 		if(!$this->class_model->get_by_id($id))
// 			return $this->load->view('error');
// 		if($this->class_model->delete($id))
// 			$this->session->set_flashdata('message','操作成功');
// 		else
// 			$this->session->set_flashdata('message','存在相关引用，操作失败');

// 		redirect('teacher_class/index');

// 	}
	
// 	/**
// 	 * 编辑一个班级
// 	 * @param  [type] $id [description]
// 	 * @return [type]     [description]
// 	 */
// 	function class_edit($id=0)
// 	{
// 		if($id)
// 		{
// 			//get方法
// 			$this->load->model('class_model');
// 			$class=$this->class_model->get_by_id($id);
// 			if(!$class)
// 				return $this->load->view('error');
// 			$data['title']='编辑班级信息';
// 			$data['class']=$class;

			
// 			$this->load->view('teacher_class/class_edit',$data);
// 		}
// 		else
// 		{
// 			//post
// 			//读取数据
// 			$this->load->model('class_model');

// 			$id=$this->input->post('class_id');
// 			$class=$this->class_model->get_by_id($id);
// 			if(!$class)
// 				return $this->load->view('error');
// 			if($this->form_validation->run('teacher_class/class_edit'))
// 			{
// 				//post方法
// 				$name=$this->input->post('class_name');
				
// 				//检查如果这个班级名称已经存在，则提醒
// 				if($this->class_model->check_class_name_exist($name))
// 				{
// 					$this->session->set_flashdata('message','这个班级已存在，操作失败');
// 					redirect('teacher_class/index');
// 				}

// 				//将内容写入数据库
// 				$item = array(
// 					'name' => $name,
// 					 );
				
// 				//数据库操作
// 				if($this->class_model->update($id,$item))
// 				{
// 					$this->session->set_flashdata('message','操作成功');
// 					redirect('teacher_class/index');	
// 				}
// 				else
// 				{
// 					$this->session->set_flashdata('message','操作失败');
// 					redirect('teacher_class/index');	
// 				}
// 			}
// 			else
// 			{
// 				//验证失败
// 				//get方法
// 				$data['title']='编辑班级信息';
// 				$data['class']=$class;
// 				$this->load->view('teacher_class/class_edit',$data);
// 			}
// 		}
		
		
// 	}
// 	/**
// 	 * 添加一个专业
// 	 * @return [type] [description]
// 	 */
// 	function major_add()
// 	{
// 		//表单验证
// 		if($this->form_validation->run('teacher_class/major_add'))
// 		{
// 			//post方法
// 			//读取数据
// 			$major_name=$this->input->post('major_name');

// 			$this->load->model('major_model');

// 			//检查如果这个班级名称已经存在，则提醒
// 			if($this->major_model->check_major_name_exist($major_name))
// 			{
// 				$this->session->set_flashdata('message','这个专业已存在，添加失败');
// 				redirect('teacher_class/major_add');
// 			}

// 			//新建一个
// 			$major = array(
// 				'name' => $major_name
// 				 );

// 			$this->major_model->add($major);

// 			$this->session->set_flashdata('message','添加成功');
// 			redirect('teacher_class/index');		
// 		}

// 		//get方法
// 		$data['title']='添加专业';
// 		$this->load->view('teacher_class/major_add',$data);
// 	}
	
// 	/**
// 	 * 删除一个专业
// 	 * @param  [type] $id [description]
// 	 * @return [type]     [description]
// 	 */
// 	function major_delete($id)
// 	{
// 		$this->load->model('major_model');
// 		if(!$this->major_model->get_by_id($id))
// 			return $this->load->view('error');
// 		if($this->major_model->delete($id))
// 			$this->session->set_flashdata('message','操作成功');
// 		else
// 			$this->session->set_flashdata('message','存在相关引用，操作失败');

// 		redirect('teacher_class/index');

// 	}
	
// 	/**
// 	 * 编辑一个专业
// 	 * @param  [type] $id [description]
// 	 * @return [type]     [description]
// 	 */
// 	function major_edit($id=0)
// 	{
// 		if($id)
// 		{
// 			//get方法
// 			$this->load->model('major_model');
// 			$major=$this->major_model->get_by_id($id);
// 			if(!$major)
// 				return $this->load->view('error');
// 			$data['title']='编辑班级信息';
// 			$data['major']=$major;

			
// 			$this->load->view('teacher_class/major_edit',$data);
// 		}
// 		else
// 		{
// 			//post
// 			//读取数据
// 			$this->load->model('major_model');

// 			$id=$this->input->post('major_id');
// 			$major=$this->major_model->get_by_id($id);
// 			if(!$major)
// 				return $this->load->view('error');


// 			if($this->form_validation->run('teacher_class/major_edit'))
// 			{
// 				//post方法
// 				$name=$this->input->post('major_name');
				
// 				//检查如果这个名称已经存在，则提醒
// 				if($this->major_model->check_major_name_exist($name))
// 				{
// 					$this->session->set_flashdata('message','这个班级已存在，操作失败');
// 					redirect('teacher_class/index');
// 				}

// 				//将内容写入数据库
// 				$item = array(
// 					'name' => $name,
// 					 );
				
// 				//数据库操作
// 				if($this->major_model->update($id,$item))
// 				{
// 					$this->session->set_flashdata('message','操作成功');
// 					redirect('teacher_class/index');	
// 				}
// 				else
// 				{
// 					$this->session->set_flashdata('message','操作失败');
// 					redirect('teacher_class/index');	
// 				}
// 			}
// 			else
// 			{
// 				//验证失败
// 				//get方法
// 				$data['title']='编辑班级信息';
// 				$data['major']=$major;
// 				$this->load->view('teacher_class/major_edit',$data);
// 			}
// 		}
		
		
// 	}


// 	/**
// 	 * 查看一个逻辑班级的详细信息
// 	 * @param  [type] $id [description]
// 	 * @return [type]     [description]
// 	 */
// 	function logic_class_check($id)
// 	{
// 		$data['title']='查看逻辑班';
// 		$this->load->model('logic_class_model');
// 		$logic_class=$this->logic_class_model->get_by_id($id);
// 		if(!$logic_class) return View('error');

// 		$data['logic_class']=$logic_class;
// 		$data['students']=$this->logic_class_model->get_students_from_logic_class_id($logic_class['id']);
// 		$data['teacher']=$this->logic_class_model->get_teacher($logic_class['id']);
// 		$this->load->view('teacher_class/logic_class_check',$data);
// 	}

// 	/**
// 	 * 添加一个逻辑班的信息
// 	 * @param  [type] $id [description]
// 	 * @return [type]     [description]
// 	 */
// 	function logic_class_add()
// 	{
// 		//表单验证
// 		if($this->form_validation->run('teacher_class/logic_class_add'))
// 		{
// 			//post方法
// 			//读取数据
// 			$logic_class_name=$this->input->post('logic_class_name');
// 			$logic_class_number=$this->input->post('logic_class_number');
// 			$teacher_id=$this->input->post('teacher_id');
// 			$logic_class_type=$this->input->post('logic_class_type');

// 			$this->load->model('logic_class_model');
// 			$this->load->model('teacher_model');
// 			$me=$this->teacher_model->get_by_username($this->session->userdata('username'));
// 			//新建一个
// 			$logic_class = array(
// 				'number' => $logic_class_number,
// 				'name' => $logic_class_name,
// 				'teacher_id' => $me['id'],
// 				'type'=>$logic_class_type
// 				 );

// 			$this->logic_class_model->add($logic_class);

// 			$this->session->set_flashdata('message','操作成功');
// 			redirect('teacher_class/index');		
// 		}

// 		//get方法
// 		$data['title']='添加班级';
// 		$this->load->model('teacher_model');
// 		$data['teachers']=$this->teacher_model->get_all();
// 		$this->load->view('teacher_class/logic_class_add',$data);
// 	}


// 	/**
// 	 * 异步jquery验证
// 	 * @return [type] [description]
// 	 */
// 	function check_logic_class_number_exist()
// 	{
// 		$logic_class_number=$this->input->post('logic_class_number');
// 		$current_logic_class_number=$this->input->post('current_logic_class_number');
// 		if($current_logic_class_number)
// 		{
// 			if($current_logic_class_number==$logic_class_number){
// 				echo json_encode(TRUE);
// 				return ;
// 			}
// 		}
// 		$this->load->model('logic_class_model');
// 		if($this->logic_class_model->logic_class_number_exist($logic_class_number))
// 			echo json_encode(FALSE);
// 		else 
// 			echo json_encode(TRUE);
// 	}

// 	/**
// 	 * CI的表单回调函数验证
// 	 * @param  [type] $str [description]
// 	 * @return [type]      [description]
// 	 */
// 	function logic_class_number_check($logic_class_number)
// 	{
// 		$this->load->model('logic_class_model');
// 		if($this->logic_class_model->logic_class_number_exist($logic_class_number))
// 			return FALSE;
// 		else 
// 			return TRUE;
// 	}

// 	/**
// 	 * 删除一个逻辑班
// 	 * @param  [type] $id [description]
// 	 * @return [type]     [description]
// 	 */
// 	function logic_class_delete($id)
// 	{
// 		$this->load->model('logic_class_model');
// 		if(!$this->logic_class_model->get_by_id($id))
// 			return $this->load->view('error');
// 		if($this->logic_class_model->delete($id))
// 			$this->session->set_flashdata('message','操作成功');
// 		else
// 			$this->session->set_flashdata('message','逻辑班内还有学生，删除失败');

// 		redirect('teacher_class/index');

// 	}

// 	/**
// 	 * 编辑一个逻辑班的信息
// 	 * @param  [type] $id [description]
// 	 * @return [type]     [description]
// 	 */
// 	function logic_class_edit($id=0)
// 	{
// 		if($id)
// 		{
// 			//get方法
// 			$this->load->model('logic_class_model');
// 			$logic_class=$this->logic_class_model->get_by_id($id);
// 			if(!$logic_class)
// 				return $this->load->view('error');
// 			$data['title']='编辑逻辑班信息';
// 			$data['logic_class']=$logic_class;

// 			$this->load->model('teacher_model');
// 			$data['teachers']=$this->teacher_model->get_all();

// 			$this->load->view('teacher_class/logic_class_edit',$data);
// 		}
// 		else
// 		{
// 			//post方法
// 			//读取数据
// 			$this->load->model('logic_class_model');

// 			$id=$this->input->post('logic_class_id');
// 			$logic_class=$this->logic_class_model->get_by_id($id);
// 			if(!$logic_class)
// 				return $this->load->view('error');
// 			if($this->form_validation->run('teacher_class/logic_class_edit'))
// 			{

// 				$logic_class_name=$this->input->post('logic_class_name');
// 				$logic_class_number=$this->input->post('logic_class_number');
// 				$teacher_id=$this->input->post('teacher_id');
// 				$logic_class_type=$this->input->post('logic_class_type');

// 				//将数据写入数据库
// 				$logic_class = array(
// 					'number' => $logic_class_number,
// 					'name' => $logic_class_name,
// 					'type'=>$logic_class_type
// 				 );
				
// 				//数据库操作
// 				if($this->logic_class_model->update($id,$logic_class))
// 				{
// 					$this->session->set_flashdata('message','操作成功');
// 					redirect('teacher_class/index');	
// 				}
// 				else
// 				{
// 					$this->session->set_flashdata('message','操作失败');
// 					redirect('teacher_class/index');	
// 				}
	
// 			}
// 			else
// 			{
// 				//验证失败
// 				//get
// 				$data['title']='编辑逻辑班信息';
// 				$data['logic_class']=$logic_class;

// 				$this->load->model('teacher_model');
// 				$data['teachers']=$this->teacher_model->get_all();

// 				$this->load->view('teacher_class/logic_class_edit',$data);
// 			}
				
// 		}
// 	}
// }
//  