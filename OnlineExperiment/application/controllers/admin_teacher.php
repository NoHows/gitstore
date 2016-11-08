<?php 
/**
* admin 老师管理
*/
class Admin_teacher extends CI_Controller
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
	 * 教师管理的主界面
	 * @return [type]
	 */
	function index()
	{
		//准备数据
		$data = array();
		$data['title']='教师管理';
		$this->load->model('teacher_model');
		
		$data['teachers']=$this->teacher_model->get_all_teachers();
		
		$this->load->view('admin_teacher/index',$data);
	}     

	/**
	 * 添加一个老师
	 */
	function add()
	{
		//表单验证
		if($this->form_validation->run('admin_teacher/add'))
		{
			//post方法
			//读取数据
			$teacher_name=$this->input->post('teacher_name');
			$major_id=$this->input->post('major_id');
			$teacher_number=$this->input->post('teacher_number');


			//新建一个用户
			$user = array(
				'username' => $teacher_number,
				'password' => md5($teacher_number),
				'role_id' => 2,
				 );

			$this->load->model('user_model');
			$this->user_model->add($user);

			$user_id=$this->db->insert_id();

			$teacher = array(
				'user_id' => $user_id,
				'teacher_number' => $teacher_number,
				'name' => $teacher_name,
				'major_id' => $major_id
				 );

			$this->load->model('teacher_model');
			$this->teacher_model->add($teacher);

			redirect('admin_teacher/index');		
		}

		//get方法
		$data['title']='添加教师';
		$this->load->model('major_model');
		$data['majors']=$this->major_model->get_all();

		$this->load->view('admin_teacher/add',$data);
	}
	
	/**
	 * 异步jquery验证
	 * @return [type] [description]
	 */
	function check_teacher_number_exist()
	{
		$teacher_number=$this->input->post('teacher_number');
		$this->load->model('teacher_model');
		if($this->teacher_model->teacher_number_exist($teacher_number))
			echo json_encode(FALSE);
		else 
			echo json_encode(TRUE);
	}

	/**
	 * CI的表单回调函数验证
	 * @param  [type] $str [description]
	 * @return [type]      [description]
	 */
	function teacher_number_check($teacher_number)
	{
		$this->load->model('teacher_model');
		if($this->teacher_model->teacher_number_exist($teacher_number))
			return FALSE;
		else 
			return TRUE;
	}

	/**
	 * 删除一个老师
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	function delete($id)
	{
		$this->load->model('teacher_model');
		if(!$this->teacher_model->get_by_id($id))
			$this->load->view('error');
		if($this->teacher_model->delete_cascade($id))
			$this->session->set_flashdata('message','操作成功');
		else
			$this->session->set_flashdata('message','存在相关引用，操作失败');

		redirect('admin_teacher/index');

	}

	/**
	 * 编辑一个教师的信息
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	function edit($id=0)
	{
		if($id)
		{
			//get方法
			$this->load->model('teacher_model');
			$teacher=$this->teacher_model->get_by_id($id);
			if(!$teacher)
				return $this->load->view('error');
			$data['title']='编辑教师信息';
			$data['teacher']=$teacher;

			$this->load->model('major_model');
			$data['majors']=$this->major_model->get_all();

			$this->load->view('admin_teacher/edit',$data);
		}
		else
		{
			//post方法
			//读取数据
			$this->load->model('teacher_model');

			$id=$this->input->post('teacher_id');
			$teacher=$this->teacher_model->get_by_id($id);
			if(!$teacher)
				return $this->load->view('error');
			if($this->form_validation->run('admin_teacher/edit'))
			{
				$name=$this->input->post('teacher_name');
				$major_id=$this->input->post('major_id');
				//将模块写入数据库
				$item = array(
					'name' => $name,
					'major_id' => $major_id,
					 );
				
				//数据库操作
				if($this->teacher_model->update($id,$item))
				{
					$this->session->set_flashdata('message','操作成功');
					redirect('admin_teacher/index');	
				}
				else
				{
					$this->session->set_flashdata('message','操作失败');
					redirect('admin_teacher/index');	
				}
	
			}
			else
			{
				//验证失败
				//get
				$data['title']='编辑教师信息';
				$data['teacher']=$teacher;

				$this->load->model('major_model');
				$data['majors']=$this->major_model->get_all();

				$this->load->view('admin_teacher/edit',$data);
			}
				
		}
			
		

	}
}
 