<?php 
/*管理员管理模块
*/
class Admin_module extends CI_Controller
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
	 * 模块管理的主页面
	 * @return [type] [description]
	 */
	function index()
	{
		$data['title']='模块管理';
		$this->load->model('module_model');
		$data['modules']=$this->module_model->get_all();

		$this->load->view('admin_module/index',$data);
	}

	/**
	 * 添加一个模块
	 */
	function add($id=0)
	{
		//表单验证
	
			if($this->form_validation->run('admin_module/add'))
			{
				//post方法
				//读取数据
				$name=$this->input->post('module_name');
				$module_sort=$this->input->post('module_sort');
				$type=0;
				$time_limit=0;
				$relative_test_points=$this->input->post('relative_test_points');
				$big_lecture_id=$this->input->post('big_lecture_id');
					//将模块写入数据库
					$item = array(
					'name' => $name,
					'time_limit' => $time_limit,
					'type' => $type,
					'big_lecture_id' => $big_lecture_id,
					'module_sort' => $module_sort
					 );
				$this->load->model('module_model');

				if($this->module_model->add($item))
				{
					$module_id=$this->db->insert_id();
					//添加模块和考点的关系
					if($this->module_model->add_relative_test_point($module_id,$relative_test_points))
					{
						$this->session->set_flashdata('message','操作成功');
						redirect('admin_class/big_lecture_check'.'/'.$big_lecture_id);		
					}
				}
				$data['title']='添加模块';
				$this->load->model('big_lecture_model');
				$data['big_lectures_selected']=$id;
				$data['big_lectures']=$this->big_lecture_model->get_all();

				$this->load->view('admin_module/add',$data);
						
			}
		
		

		//get方法
		$data['title']='添加模块';
		$this->load->model('big_lecture_model');
		$data['big_lectures_selected']=$id;
		$data['big_lectures']=$this->big_lecture_model->get_all();

		$this->load->view('admin_module/add',$data);
	}


	/**
	 * 删除一个模块
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	function delete($big_lecture_id,$id)
	{
		$this->load->model('module_model');
		if(!$this->module_model->get_by_id($id))
			$this->load->view('error');
		if($this->module_model->delete_cascade($id))
			$this->session->set_flashdata('message','操作成功');
		else
			$this->session->set_flashdata('message','存在相关引用，操作失败');

		redirect('admin_class/big_lecture_check'.'/'.$big_lecture_id);

	}

	/**
	 * 编辑一个模块
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	function edit($id=0)
	{
		if($id)
		{
			//get方法
			$this->load->model('module_model');
			$module=$this->module_model->get_by_id($id);
			if(!$module)
				return $this->load->view('error');
			$data['title']='编辑模块';
			$data['module']=$module;
			$this->load->model('big_lecture_model');
			$data['big_lectures']=$this->big_lecture_model->get_all();
			
			$this->load->view('admin_module/edit',$data);
		}
		else
		{
			//读取数据
			$this->load->model('module_model');
			$id=$this->input->post('module_id');
			$module=$this->module_model->get_by_id($id);
			if(!$module)
				return $this->load->view('error');

			if($this->form_validation->run('admin_module/edit'))
			{
				//post方法
				$name=$this->input->post('module_name');
				$module_sort=$this->input->post('module_sort');
				$time_limit=0;
				$type=0;
				$big_lecture_id=$this->input->post('big_lecture_id');

				//将模块写入数据库
				$item = array(
					'name' => $name,
					'time_limit' => $time_limit,
					'type' => $type,
					'big_lecture_id' => $big_lecture_id,
					'module_sort' => $module_sort
					 );
				
				//数据库操作
				if($this->module_model->update($id,$item))
				{
					$this->session->set_flashdata('message','操作成功');
					redirect('admin_class/big_lecture_check'.'/'.$big_lecture_id);	
				}
				else
				{
					$this->session->set_flashdata('message','操作失败');
					redirect('admin_class/big_lecture_check'.'/'.$big_lecture_id);	
				}
			}
			else
			{
				//验证失败
				//get方法
				$data['title']='编辑模块';
				$data['module']=$module;
				$this->load->model('big_lecture_model');
				$data['big_lectures']=$this->big_lecture_model->get_all();
				$this->load->view('admin_module/edit',$data);
			}
		} 

			
		

	}

	/**
	 * 查看一个模块
	 * @param  integer $id [description]
	 * @return [type]      [description]
	 */
	function check($id=0,$big_lecture_id)
	{
		$this->load->model('module_model');
		$module=$this->module_model->get_module_by_id($id);
		if(!$module)
			return $this->load->view('error');

		$data['title']='查看模块';
		$data['module']=$module;
		$data['big_lecture_id']=$big_lecture_id;

		$this->load->view('admin_module/check',$data);


	}

}