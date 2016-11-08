<?php 
/**
* admin入口
*/
class Admin_home extends CI_Controller
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
	 * 管理员的主页面
	 * @return [type]
	 */
	function index()
	{
		//准备数据
		$data = array();
		$data['title']='管理员';
		$this->load->model('question_model');
		$this->load->model('module_model');
		$this->load->model('teacher_model');
		$this->load->model('student_model');
		$this->load->model('class_model');
		$this->load->model('big_lecture_model');

		$big_lectures=$this->big_lecture_model->get_all();
		$index=0;
		$big_lectures_with_module_count = array();
		foreach ($big_lectures as $big_lecture) {
			$module_count_by_big_lecture=$this->module_model->get_module_count_by_big_lecture_id($big_lecture['id']);
			$big_lecture_with_module_count = array('id' => $big_lecture['id'],
												   'name'=> $big_lecture['name'], 
												   'module_count'=> $module_count_by_big_lecture);
			array_push($big_lectures_with_module_count, $big_lecture_with_module_count );
			$index++;
		}

		$data['big_lecture_count']=$this->big_lecture_model->count_all();
		$data['question_count']=$this->question_model->count_all();
		$data['teacher_count']=$this->teacher_model->count_all();
		$data['student_count']=$this->student_model->count_all();
		$data['class_count']=$this->class_model->count_all();
		$data['big_lectures_with_module_count']=$big_lectures_with_module_count;
		$this->load->view('admin_home/index',$data);
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
		if($this->form_validation->run('admin_home/change_password'))
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
					redirect('admin_home/index');
				}
				else
				{
					$this->session->set_flashdata('message','操作失败');
					redirect('admin_home/index');
				}
					
			}
			else{
				$this->session->set_flashdata('message','密码错误，修改失败');
				redirect('admin_home/index');	
			}
						
		}

		//get方法
		$data['title']='修改密码';
		$this->load->view('admin_home/change_password',$data);
	}
}
 