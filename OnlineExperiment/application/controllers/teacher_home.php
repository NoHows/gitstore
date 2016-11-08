<?php 
/**
* teacher入口
*/
class Teacher_home extends CI_Controller
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

	function index()
	{
		//准备数据
		$data = array();
		
		$this->load->model('teacher_model');
		$this->load->model('user_model');
		$username=$this->session->userdata('e_username');
		$user=$this->user_model->get_by_username($username);
		$teacher=$this->teacher_model->get_by_user_id($user['id']);
		$teacher=$this->teacher_model->get_teacher_by_id($teacher['id']);
		
		

		$this->session->set_userdata(array('e_name'=>$teacher['name']));

		$this->load->model('big_lecture_model');
		$this->load->model('question_model');
		$this->load->model('module_model');
		$this->load->model('teacher_model');
		$this->load->model('student_model');
		$this->load->model('class_model');

		$data['teacher']=$teacher;
		$data['title']=$teacher['name'];
		$data['big_lecture_count']=$this->big_lecture_model->count_all();
		$data['question_count']=$this->question_model->count_all();
		$data['module_count']=$this->module_model->count_all();
		
		$data['my_logic_class_count']=$this->teacher_model->get_logic_class_count($teacher['id']);
		$data['my_students_count']=$this->teacher_model->get_students_count($teacher['id']);
		$data['my_module_count']=$this->teacher_model->get_private_module_count($teacher['id']);

		$data['class_count']=$this->class_model->count_all();
		
		$this->load->view('teacher_home/index',$data);
	}

	/**
	 * 退出，删除session中的数据
	 * @return [type]
	 */
	function logout()
	{
		$this->session->sess_destroy();
		redirect('home');
	}
	
	/**
	 * 修改密码
	 * @return [type] [description]
	 */
	function change_password()
	{
		//表单验证
		if($this->form_validation->run('teacher_home/change_password'))
		{
			//post方法
			//读取数据
			$old_password=$this->input->post('old_password');
			$new_password=$this->input->post('new_password');
			
			$username=$this->session->userdata('e_username');
			$this->load->model('user_model');
			$user=$this->user_model->check_user_valid($username,$old_password);
			if($user)
			{
				$user['password']=md5($new_password);
				if($this->user_model->update($user['id'],$user))
				{
					$this->session->set_flashdata('message','修改成功');
					redirect('teacher_home/index');
				}
				else
				{
					$this->session->set_flashdata('message','操作失败');
					redirect('teacher_home/index');
				}
					
			}
			else{
				$this->session->set_flashdata('message','密码错误，修改失败');
				redirect('teacher_home/index');	
			}
						
		}

		//get方法
		$data['title']='修改密码';
		$this->load->view('teacher_home/change_password',$data);
	}
}
 