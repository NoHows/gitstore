<?php 
/**
* 参加考试入口
*/
class Student_test extends CI_Controller
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

	/**
	 * 组卷，将组卷的内容放入report表，question_in_report表，组卷对同一个考试不会组两次
	 * @param  [type] $student_id     [description]
	 * @param  [type] $module_id      [description]
	 * @param  [type] $logic_class_id [description]
	 * @return [type]                 [description]
	 */
	function get_questions($student_id,$module_id,$logic_class_id)
	{
		if(date_default_timezone_get() != "Asia/Shanghai") 
			date_default_timezone_set("Asia/Shanghai");
		//需要提前做的检查
		//这个同学是否已经在这个逻辑班下考过这个模块
		//这个同学是否是用户自己
		//这个学生是否属于这个逻辑班
		//这个逻辑班中是否有这门课
		$this->load->model('module_model');
		$this->load->model('student_model');
		$this->load->model('question_model');

		$student = 	$this->student_model->get_by_id($student_id);
		$module = $this->module_model->get_by_id($module_id);

		$test_questions = $this->question_model->get_by_module_id($module_id);//存储所有考卷题目的数组
		
		//获取当前时间
		
		$datetime=date("Y-m-d H:i:s");
		
		//将结果存入report表
		$report_item = array(
               'module_id' => $module_id ,
               'student_id' => $student_id ,
               'datetime' => $datetime ,
               'grades' => 0 ,
               'logic_class_id' => $logic_class_id,
               'state' => 0,
            );	

		$this->report_model->add($report_item);

		//获取reportid
		$report_id=$this->db->insert_id();

		//将组题信息写入question_in_report
		$id_for_report = 1;//计数
		foreach ($test_questions as $item) {
			//$question_in_report = $this->question_model->get_by_id($item['id']);//考题		

			//要存入的关联数组
			$question_in_report_item = array(
               'question_id' => $item['id'] ,
               'report_id' => $report_id ,
            );	

			$this->report_model->add_question_in_report($question_in_report_item);

			$id_for_report++;

		}

		return $test_questions;


	}

	/**
	 * 查找数据库中的已经组好卷的信息
	 * @param  [type] $report_id [description]
	 * @return [type]            [description]
	 */
	function get_exist_questions($report_id)
	{
		if(date_default_timezone_get() != "Asia/Shanghai") 
			date_default_timezone_set("Asia/Shanghai");

		$this->load->model('report_model');
		$this->load->model('question_model');

		
		$test_questions = array();//存储所有考卷题目的数组

		//从question_in_report中查找所有满足条件的问题
		$questions_in_report=$this->report_model->get_from_question_in_report($report_id);
		foreach ($questions_in_report as $item) {
			$question=$this->question_model->get_by_id($item['question_id']);
			$question['choose']='';

			if(isset($item['choose']))
				$question['choose']=$item['choose'];
			array_push($test_questions, $question);
		}
		return $test_questions;
	}

	
	/**
	 * 学生点击去考试，或者继续考试的处理方法
	 * @return [type] [description]
	 */
	function test()
	{	
		if(date_default_timezone_get() != "Asia/Shanghai") 
			date_default_timezone_set("Asia/Shanghai");
		//从url中获取学生学号和要考试的模块和逻辑班号
		$this->load->library('uri');
		$student_id = $this->uri->segment(3);
		$module_id = $this->uri->segment(4);
		$logic_class_id = $this->uri->segment(5);
		$time_limit = $this->uri->segment(6);

		$this->load->model('module_model');
		$this->load->model('student_model');
		$this->load->model('question_model');	
		$this->load->model('logic_class_model');
		$this->load->model('report_model');
		//检查学生模块逻辑班是否存在
		$student = 	$this->student_model->get_by_id($student_id);
		if(!$student) return $this->load->view('error');
		$module = $this->module_model->get_by_id($module_id);
		if(!$module) return $this->load->view('error');
		$logic_class=$this->logic_class_model->get_by_id($logic_class_id);
		if(!$logic_class) return $this->load->view('error');

		//安全检查
		//这个同学是否是用户自己
		$me=$this->student_model->get_by_username($this->session->userdata('e_username'));
		if($student_id!=$me['id'])
			return $this->load->view('error');
		//这个学生是否属于这个逻辑班
		if(!$this->logic_class_model->check_student_in_logic_class($student_id,$logic_class_id))
			return $this->load->view('error');
		//这个逻辑班中是否有这门课
		if(!$this->logic_class_model->check_module_in_logic_class($module_id,$logic_class_id))
			return $this->load->view('error');
		//这个同学是否已经在这个逻辑班下考过这个模块
		//在report表中查找是否已经参加了考试					
		$report=$this->report_model->get_by_module_student_logic_class($module_id,$student_id,$logic_class_id);
		if(!$report)
		{
			//如果没考过，组卷进行考试
			$data['title']='考试';
			$data['student'] = $student;
			$data['student_id'] = $student_id;
			$data['logic_class_id'] = $logic_class_id;
			$data['test_question'] = $this->get_questions($student_id,$module_id,$logic_class_id);
			$report=$this->report_model->get_by_module_student_logic_class($module_id,$student_id,$logic_class_id);
			$data['report_id']=$report['id'];
			$data['module'] = $module;
			$data['title']=$module['name'];
			$this->load->view('student_home/test',$data);
		}
		else
		{
			//完成未提交的试卷
			$data['title']='考试';
			$data['student'] = $student;
			$data['student_id'] = $student_id;
			$data['logic_class_id'] = $logic_class_id;
			$data['test_question'] = $this->get_exist_questions($report['id']);
			$data['module'] = $module;
			$data['title']=$module['name'];
			$data['report_id']=$report['id'];
			$this->load->view('student_home/test',$data);
			
		}
	}

	/**
	 * 用户提交考试结果的处理方法
	 * @return [type] [description]
	 */
	function submit()
	{
		if(date_default_timezone_get() != "Asia/Shanghai") 
			date_default_timezone_set("Asia/Shanghai");
		$student_id = $this->input->post('student_id');
		$module_id = $this->input->post('module_id');
		$logic_class_id = $this->input->post('logic_class_id');
		//考题题号
		$question_ids = $this->input->post('question_id');
		//考生答案
		$student_answers = $this->input->post('answer');

		$this->load->model('question_model');
		$this->load->model('report_model');
		$this->load->model('module_model');
		$this->load->model('student_model');
		$this->load->model('logic_class_model');
		//检查学生模块逻辑班是否存在
		$student = 	$this->student_model->get_by_id($student_id);
		if(!$student) return $this->load->view('error');
		$module = $this->module_model->get_by_id($module_id);
		if(!$module) return $this->load->view('error');
		$logic_class=$this->logic_class_model->get_by_id($logic_class_id);
		if(!$logic_class) return $this->load->view('error');

		//安全检查
		//这个同学是否是用户自己
		$me=$this->student_model->get_by_username($this->session->userdata('e_username'));
		if($student_id!=$me['id'])
			return $this->load->view('error');
		//这个学生是否属于这个逻辑班
		if(!$this->logic_class_model->check_student_in_logic_class($student_id,$logic_class_id))
			return $this->load->view('error');
		//这个逻辑班中是否有这门课
		if(!$this->logic_class_model->check_module_in_logic_class($module_id,$logic_class_id))
			return $this->load->view('error');
		//这个同学是否已经在这个逻辑班下考过这个模块
		//在report表中查找是否已经参加了考试					
		$report=$this->report_model->get_by_module_student_logic_class($module_id,$student_id,$logic_class_id);
		if(!$report) 
			return $this->load->view('error');
		//如果已经提交过，则直接转到主页
		if($report['state']==1)
			return redirect('student_home/index');
		
		//判题算分
		$grades = 0;
		$id_for_mark = 1;
		foreach ($question_ids as $item) {
			$test_question = $this->question_model->get_by_id($item);//考题
			if (isset($student_answers[$id_for_mark])&&$student_answers[$id_for_mark] == $test_question['answer']) {
				$grades++;
			}
			$id_for_mark++;		

		}
		//将结果存入report表
		$report_item = array(
	            'grades' => (int)($grades*100.0/count($question_ids)) ,
	            'state' => 1
	        );	
		$this->report_model->update($report['id'],$report_item);	

		//将试卷的详细信息存入question_in_report表中
		$id_for_mark = 1;//计数
		foreach ($question_ids as $item) {
			$question_in_report=$this->report_model->get_question_in_report($report['id'],$item);
			if(!$question_in_report) 
				return $this->load->view('error');
			//要更新的关联数组
			//考虑为空的情况
			$choose='';
			if(isset($student_answers[$id_for_mark]))
				$choose=$student_answers[$id_for_mark];

			$question_in_report_item = array(
	            'choose' => $choose
	        );	
			$this->report_model->update_question_in_report($question_in_report['id'],$question_in_report_item);
			$id_for_mark++;
		}
		redirect('student_home/module_check'.'/'.$student_id.'/'.$module_id.'/'.$logic_class_id.'/'.$module['big_lecture_id']);		
	}
	//组卷
	function test_question()
	{
		if(date_default_timezone_get() != "Asia/Shanghai") 
			date_default_timezone_set("Asia/Shanghai");

		//从url中获取学生学号和要考试的模块和逻辑班号
		$this->load->library('uri');
		$student_id = $this->uri->segment(3);
		$module_id = $this->uri->segment(4);
		$logic_class_id = $this->uri->segment(5);
		$time_limit = $this->uri->segment(6);

		$this->load->model('module_model');
		$this->load->model('student_model');
		$this->load->model('question_model');	
		$student = 	$this->student_model->get_by_id($student_id);
		$module = $this->module_model->get_by_id($module_id);

		//模块范围内所有的考点
		$test_point = $this->module_model->get_test_point($module_id);
		//var_dump($test_point);

		$test_question = array();//存储所有考卷题目的数组
		
		//遍历所有考点，从每个考点中随机抽出一道题存入$test_question
		if ($test_point) 
		{
			foreach ($test_point as $item) {

				//考点所有题目
				$question_in_test_point = $this->question_model->get_by_test_point_id($item['test_point_id']);
				//取出一道题
				$each_question =  array_rand($question_in_test_point,1);

				array_push($test_question, $question_in_test_point[$each_question]);
			}

			//测试用例
			// $question_bug =  $this->question_model->get_by_id('410');
			// array_push($test_question, $question_bug);
			

			//var_dump($test_question);
			$data['title']='考试';
			$data['student'] = $student;
			$data['student_id'] = $student_id;
			$data['logic_class_id'] = $logic_class_id;
			$data['test_question'] = $test_question;
			$data['module'] = $module;
			$data['time_limit'] = $time_limit;
			$data['title']=$module['name'];
			$this->load->view('student_home/test',$data);
		}
		else
		{
			$this->load->view('student_home/error');
		}
		
		
	}

	//阅卷判分
	function mark()
	{
		if(date_default_timezone_get() != "Asia/Shanghai") 
			date_default_timezone_set("Asia/Shanghai");

		$student_id = $this->input->post('student_id');
		$module_id = $this->input->post('module_id');
		$logic_class_id = $this->input->post('logic_class_id');
		//考题题号
		$question_id = $this->input->post('question_id');
		//考生答案
		$student_answer = $this->input->post('answer');

		$this->load->model('question_model');
		$this->load->model('report_model');
		$this->load->model('module_model');
		$this->load->model('student_model');
		$this->load->model('knowledge_point_model');
		
		$student = $this->student_model->get_by_id($student_id);
		//判题算分
		$grades = 0;
		$id_for_mark = 1;
		foreach ($question_id as $item) {
			$test_question = $this->question_model->get_by_id($item);//考题
			if ($student_answer[$id_for_mark] == $test_question['answer']) {
				$grades++;
			}
			
			$id_for_mark++;		

		}

		//获取当前时间
		$datetime=date("Y-m-d H:i:s");
		
		//将结果存入report表

		$report_item = array(
               'module_id' => $module_id ,
               'student_id' => $student_id ,
               'datetime' => $datetime ,
               'grades' => $grades ,
               'logic_class_id' => $logic_class_id
            );	

		$this->report_model->add($report_item);

		//获取刚存入的report条目
		$report = $this->report_model->get_by_module_student_logic_class($module_id,$student_id,$logic_class_id);		

		//将试卷的详细信息存入question_in_report表中
		$id_for_report = 1;//计数
		foreach ($question_id as $item) {
			$question_in_report = $this->question_model->get_by_id($item);//考题		

			//要存入的关联数组
			$question_in_report_item = array(
               'question_id' => $question_in_report['id'] ,
               'report_id' => $report['id'] ,
               'choose' => $student_answer[$id_for_report]
            );	

			$this->report_model->add_question_in_report($question_in_report_item);

			$id_for_report++;

		}

		$report_id = $report['id'];
		

		$report_check = $this->report_model->get_by_id($report_id);
		$module_check = $this->module_model->get_by_id($module_id);
		$question_in_report_check = $this->report_model->get_from_question_in_report($report_id);
		

		$check_question = array();

		foreach ($question_in_report_check as $item) {
			
			
			$question_check = $this->question_model->get_by_id($item['question_id']);
			$knowledge_points_of_question = $this->knowledge_point_model->get_all_by_question_id($question_check['id']);
			$each_check_question = array(
				"id"=>$question_check['id'],
				"test_point_id"=>$question_check['test_point_id'],
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
				"choose"=>$item['choose'],
				"knowledge_points"=>$knowledge_points_of_question
			);
			
			array_push($check_question, $each_check_question);
		}
		//var_dump($check_question);
	

		$data = array();	
		$data['student']=$student;
		$data['grades']=$report_check['grades'];
		$data['module']=$module_check;
		$data['check_question']=$check_question;
		$data['title']="查看考试结果";
		$this->load->view('student_home/check',$data);
	}

	//查看成绩
	function check(){

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
		$data['title']="查看考试结果";
		$this->load->view('student_home/check',$data);
	}

	/**
	 * 异步ajax存储用户的选择
	 * @param  [type] $report_id   [description]
	 * @param  [type] $question_id [description]
	 * @return [type]              [description]
	 */
	function ajax_save_user_choose($report_id,$question_id,$choose)
	{
		if(date_default_timezone_get() != "Asia/Shanghai") 
			date_default_timezone_set("Asia/Shanghai");

		//先判断时间是否正确
		$this->load->model('report_model');
		$this->load->model('module_model');

		$report=$this->report_model->get_by_id($report_id);
		$module=$this->module_model->get_by_id($report['module_id']);

		$now=date("Y-m-d H:i:s");
		$this->load->helper('compare_time');
		$time_past=compare_time_of_minute($report['datetime'],$now);

		//实际计算时间宽限两分钟，避免由于网络引起的时间延长
		if($report['state']==0&&$time_past<=($module['time_limit']+2)){
			//更新信息
			$question_in_report=$this->report_model->get_question_in_report($report_id,$question_id);
			if(!$question_in_report) 
				return $this->load->view('error');
			//要更新的关联数组
			//考虑为空的情况
			$question_in_report_item = array( 
	           'choose' => $choose
	        );	

			$this->report_model->update_question_in_report($question_in_report['id'],$question_in_report_item);
		}

	}
}