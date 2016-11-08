<?php 
/**
* 程序主入口
*/
class Home extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();

	}

	function index()
	{
		//如果存在cookie中的数据，则免去登陆的步骤
		if($this->session->userdata('e_user_in'))
		{
			if($this->session->userdata('e_role_id') == 1)
				redirect('admin_home/index');
			else if($this->session->userdata('e_role_id') == 2)
				redirect('teacher_home/index');
			else if($this->session->userdata('e_role_id') == 3)
				redirect('student_home/index');
		}
			
		//准备数据
		$data = array();
		$data['title']='实验预习系统';
		$data['login_state']="tring";
		$data['message']= "";
		$this->load->view('home/index',$data);
	}


	
	function login()
	{		
		$username=$this->input->post('username',true);
		$password=$this->input->post('password',true);

		$this->load->model('user_model');
		$user=$this->user_model->check_user_valid($username,$password);
		//根据不同的角色导入到不同的页面
		if($user)
		{
			$e_user_info = array('e_username' => $user['username'],
								'e_name'=>$user['name'],
								'e_user_in' => TRUE,
								'e_role_id' => $user['role_id'] 

			 );
			$this->session->set_userdata($e_user_info);
			
			if($this->user_model->get_role($user) == 'admin')
				redirect('admin_home/index');
			else if($this->user_model->get_role($user) == 'teacher')
				redirect('teacher_home/index');
			else if($this->user_model->get_role($user) == 'student')
				redirect('student_home/index');
			else
			{
				$this->load->view('error');
			}

		}
		else 
		{
			$data['title']='实验预习系统';
			$data['login_state']="fail";
			$data['message']= "账号或密码错误，请重试";
			$this->load->view('home/index',$data);
		}
	}
}
 

