<?php 
/**
* student入口
*/
class Student_home extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		//登陆状态检测
		if(!$this->session->userdata('e_user_in'))
			redirect('home');
		//权限检测
		if($this->session->userdata('e_role_id') != 3)
			redirect('home');
	}

	function index()
	{
		if(date_default_timezone_get() != "Asia/Shanghai") 
			date_default_timezone_set("Asia/Shanghai");
		//考试日期晚于这个日期的试卷可以查看
		$date_early_limit_check=date("Y-m-d",strtotime("-7 day"));
		
		//准备数据		
		$username=$this->session->userdata('e_username');
		$this->load->model('user_model');
		$this->load->model('student_model');
		$this->load->model('major_model');
		$this->load->model('class_model');
		$this->load->model('report_model');
		$this->load->model('module_model');
		$this->load->model('big_lecture_model');
		$this->load->model('logic_class_model');

		//获取用户信息
		$user=$this->user_model->get_by_username($username);
		$student=$this->student_model->get_by_user_id($user['id']);

		//将学生的姓名放到session中
		$this->session->set_userdata(array('e_name'=>$student['name']));
		//获取学生参加的逻辑班
		$student_logic_class=$this->student_model->get_student_logic_class($student['id']);
		//var_dump($student_logic_class);
		// echo "student_logic_class";
		// var_dump($student_logic_class);
		//获取所有逻辑班的信息
		$all_logic_class = array();
		foreach ($student_logic_class as $item) {
			$logic_class=$this->logic_class_model->get_by_id($item['logic_class_id']);
			array_push($all_logic_class, $logic_class);
		}
		//var_dump($all_logic_class);

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
					$report_max_grade_module = $this->report_model->get_max_grade_by_module_student_logic_class($student['id'],$module_item['id'],$logic_class_item['id']);
					$report_min_grade_module = $this->report_model->get_min_grade_by_module_student_logic_class($student['id'],$module_item['id'],$logic_class_item['id']);
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
						'report_count' => $report_count_module,
						'report_max_grade' => $report_max_grade_module,
						'report_min_grade' => $report_min_grade_module
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
					'report_count' => null,
					'report_max_grade' => null,
					'report_min_grade' => null
					);
				array_push($module_add_report_count_in_logic_class, $module_add_report_count);
			}
			array_push($all_logic_class_module, $module_add_report_count_in_logic_class);
		}

		//var_dump($all_logic_class_module);
		if(md5($username)==$user['password'])
		{
			$change_password=0;
		}
		else
		{
			$change_password=1;
		}

		$major=$this->major_model->get_by_id($student['major_id']);
		$class=$this->class_model->get_by_id($student['class_id']);
		
		$data = array();
		$data['title']='学生';
		$data['change_password']=$change_password;
		$data['student']=$student;
		$data['major']=$major;
		$data['class']=$class;
		$data['all_logic_class_module']=$all_logic_class_module;
		
		$this->load->view('student_home/index',$data);

	}

	//更新选课
	function update_register_logic_class()
	{
		$username=$this->session->userdata('e_username');
		$this->load->model('user_model');
		$this->load->model('student_model');
		$this->load->model('major_model');
		$this->load->model('class_model');
		$this->load->model('report_model');
		$this->load->model('module_model');
		$this->load->model('logic_class_model');

		//获取用户信息
		$user=$this->user_model->get_by_username($username);
		$student=$this->student_model->get_by_user_id($user['id']);

		//将学生的姓名放到session中
		$this->session->set_userdata(array('name'=>$student['name']));
		//删除学生的选课
		$this->student_model->delete_relative_logic_classes($student['id']);
		//重新选课
		//获取所有要加入的逻辑班
         $logic_classes = $this->logic_class_model->get_by_type(2);
         $bool1 = $this->student_model->add_student_in_logic_classes($student['id'],$logic_classes);
		if($bool1)
			$this->session->set_flashdata('message','操作成功');
		else
			$this->session->set_flashdata('message','操作失败');

		redirect('student_home/index');
	}

	function module_check()
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

		$big_lecture = $this->big_lecture_model->get_by_id($big_lecture_id);
		$logic_class = $this->logic_class_model->get_by_id($logic_class_id);
		$module = $this->module_model->get_by_id($module_id);

		//获取该学生在该实验模块的历次考试记录
		$reports = $this->report_model->get_all_reports_of_student_module_logic_class($student_id,$module_id,$logic_class_id);

		$data = array();
		$data['title']='查看实验成绩';
		$data['student_id']=$student_id;
		$data['big_lecture']=$big_lecture;
		$data['logic_class']=$logic_class;
		$data['module']=$module;
		$data['reports']=$reports;
		
		$this->load->view('student_home/module_check',$data);
	}
	/**
	 * 更新一次考试的成绩，判分，内部函数，已经保证数据合法
	 * @param  [type] $report_id      [description]
	 * @return [type]                 [description]
	 */
	function refresh_grades($report_id)
	{
		if(date_default_timezone_get() != "Asia/Shanghai") 
			date_default_timezone_set("Asia/Shanghai");
		//根据数据库存储的选择判分
		$this->load->model('report_model');
		$this->load->model('question_model');
		$questions_in_report=$this->report_model->get_from_question_in_report($report_id);
		$grades=0;
		foreach ($questions_in_report as $item) {
			$real_question = $this->question_model->get_by_id($item['question_id']);//考题
			if ($item['choose'] == $real_question['answer']) {
				$grades++;
			}	
		}

		//更新report状态
		//将结果存入report表
		$report_item = array(
               'grades' => (int)($grades*100.0/count($questions_in_report)),
               'state' => 1
            );
		$this->report_model->update($report_id,$report_item);
		
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
	 * 进入考试页面
	 * @return [type]
	 */
	function test()
	{
		$data = array();
		$data['title']='电路基本问题及分析方法';
		$this->load->view('student_home/test',$data);
	}   

	/**
	 * 查看考试结果
	 * @return [type] [description]
	 */
	function check_detail()
	{
		$data['title']='查看考试结果';
		$this->load->view('student_home/check_detail',$data);
	}
	

	/**
	 * 修改密码
	 * @return [type] [description]
	 */
	function change_password()
	{
		//表单验证
		if($this->form_validation->run('student_home/change_password'))
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
 