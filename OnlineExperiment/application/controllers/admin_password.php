<?php 
/*管理员修改用户密码
*/
class Admin_password extends CI_Controller
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
	function index()
	{
		$data['title']='修改用户密码';
		$this->load->view('admin_password/index',$data);
	}

		/**
	 * 修改密码
	 * @return [type] [description]
	 */
	function change_password()
	{
		//表单验证
		if($this->form_validation->run('admin_password/change_password'))
		{
			//post方法
			//读取数据
			$username=$this->input->post('username');
			$new_password=$this->input->post('new_password');
			
			$this->load->model('user_model');
			$user = $this->user_model->get_by_username($username);
			//var_dump($user);
			if($user)
			{
				$user['password']=md5($new_password);
				if($this->user_model->update($user['id'],$user))
				{
					$this->session->set_flashdata('message','修改成功');
					redirect('admin_password/index');
				}
				else
				{
					$this->session->set_flashdata('message','操作失败');
					redirect('admin_password/index');
				}
					
			}
			else{
				$this->session->set_flashdata('message','用户名不存在，修改失败');
				redirect('admin_password/index');	
			}
						
		}

		//get方法
		$data['title']='修改用户密码';
		$this->load->view('admin_password/index',$data);
	}
}