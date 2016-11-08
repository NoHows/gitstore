<?php 
/**
* teacher管理组卷的入口
*/
class Teacher_performance extends CI_Controller
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
		$this->load->model('student_model');
		$this->load->model('teacher_model');
		$this->load->model('logic_class_model');
		$this->load->model('major_model');
		$this->load->model('module_model');
		$this->load->model('class_model');
		$me=$this->teacher_model->get_by_username($this->session->userdata('e_username'));

		//配置查询选项
		
		$search_content=NULL;

		$not_limit_logic_class = array('id' =>'0' ,'number' =>'' ,  'big_lecture_name' =>'--不限--');
		$logic_classes = array();
		array_push($logic_classes, $not_limit_logic_class); 
		foreach ($this->logic_class_model->get_all_logic_classes_by_teacher_id($me['id']) as $logic_classes_item) {
		 	array_push($logic_classes,$logic_classes_item);
		 }

		$logic_class_id_selected=NULL;
		// $major_id_selected=NULL;
		// $class_id_selected=NULL;
		// $name_selected=NULL;
		// $student_id_selected=NULL;
		// $grades_low_selected=NULL;
		// $grades_high_selected=NULL;
		$classes=$this->class_model->get_classes_by_teacher_id($me['id']);

		if(count($logic_classes)>1){
			$logic_class=$logic_classes[1];
			$search_content['logic_class_id']=$logic_class['id'];
			$logic_class_id_selected=$logic_class['id'];
		}		
		$performances=$this->student_model->get_performances($me['id'],$search_content);
		$majors=$this->major_model->get_all();

		
		//逻辑班相关专业
		if (count($logic_classes)>1) {
			if ($logic_class['id']==0) {
				$student_major=$this->major_model->get_all();
			}
			else{
				$all_major = $this->logic_class_model->get_relative_student_major($logic_class['id']);
				//去掉重复值
				$student_major = array();
				foreach ($all_major as $all_major_item) {
					$exit = 0;
					foreach ($student_major as $student_major_item) {
						if ($student_major_item['id']==$all_major_item['id']) {
							$exit = 1;
						}
					}
					if ($exit==0) {
						array_push($student_major, $all_major_item);
					}
				}
			}
		}
		else
		{
			$student_major=$this->major_model->get_all();
		}
		


		$data['student_major']=$student_major;

		$data['performances']=$performances;
		$data['logic_classes']=$logic_classes;
		$data['logic_class_id_selected']=$logic_class_id_selected;
		//$data['student_major_id_selected']=$major_id;
		$data['classes']=$classes;
		$data['majors']=$majors;
		$data['modules']=$this->module_model->get_all_modules_by_teacher_id($me['id']);
		$data['title']='学习情况';
		$this->load->view('teacher_performance/index',$data);

	}

	/**
	 * 查询学生的表现
	 * @return [type] [description]
	 */
	function search()
	{
		$logic_class_id=$this->input->post('logic_class_select');
		$student_name=$this->input->post('student_name');
		$class_id=$this->input->post('class_id');
		$student_id=$this->input->post('student_id');
		$major_id=$this->input->post('relative_major_select');
		$module_id=$this->input->post('module_id');
		$grades_low=$this->input->post('grades_low');
		$grades_high=$this->input->post('grades_high');

		// echo "logic_class_id";
		// var_dump($logic_class_id);
		// echo "major_id";
		// var_dump($major_id);

		$search_content=NULL;
		if($logic_class_id)
			$search_content['logic_class_id']=$logic_class_id;
		if($student_name)
			$search_content['student_name']=$student_name;
		if($class_id)
			$search_content['class_id']=$class_id;
		if($student_id)
			$search_content['student_id']=$student_id;
		if($major_id)
			$search_content['major_id']=$major_id;
		if($module_id)
			$search_content['module_id']=$module_id;
		if($grades_low)
			$search_content['grades_low']=$grades_low;
		if($grades_high)
			$search_content['grades_high']=$grades_high;

		//查询
		$this->load->model('teacher_model');
		$this->load->model('student_model');
		$this->load->model('logic_class_model');
		$this->load->model('class_model');
		$this->load->model('major_model');
		$this->load->model('module_model');
		$me=$this->teacher_model->get_by_username($this->session->userdata('e_username'));
		$performances=$this->student_model->get_performances($me['id'],$search_content);
		
		$not_limit_logic_class = array('id' =>'0' ,'number' =>'' ,  'big_lecture_name' =>'--不限--');
		$logic_classes = array();
		array_push($logic_classes, $not_limit_logic_class); 
		foreach ($this->logic_class_model->get_all_logic_classes_by_teacher_id($me['id']) as $logic_classes_item) {
		 	array_push($logic_classes,$logic_classes_item);
		 }

		 //逻辑班相关专业
		if ($logic_class_id==0) {
			$student_major=$this->major_model->get_all();
		}
		else{
			$all_major = $this->logic_class_model->get_relative_student_major($logic_class_id);
			//去掉重复值
			$student_major = array();
			foreach ($all_major as $all_major_item) {
				$exit = 0;
				foreach ($student_major as $student_major_item) {
					if ($student_major_item['id']==$all_major_item['id']) {
						$exit = 1;
					}
				}

				if ($exit==0) {
					array_push($student_major, $all_major_item);
				}
			}
		}

		$classes=$this->class_model->get_classes_by_teacher_id($me['id']);
		$majors=$this->major_model->get_all();


		$data['student_major']=$student_major;
		$data['performances']=$performances;
		$data['logic_classes']=$logic_classes;
		$data['classes']=$classes;
		$data['majors']=$majors;
		$data['modules']=$this->module_model->get_all_modules_by_teacher_id($me['id']);
		
		$data['logic_class_id_selected']=$logic_class_id;
		$data['student_major_id_selected']=$major_id;		
		$data['student_name_selected']=$student_name;
		$data['class_id_selected']=$class_id;
		$data['student_id_selected']=$student_id;
		$data['major_id_selected']=$major_id;
		$data['module_id_selected']=$module_id;
		$data['grades_low_selected']=$grades_low;
		$data['grades_high_selected']=$grades_high;
		
		$data['title']='学习情况';
		$this->load->view('teacher_performance/index',$data);

	}

	/**
	 * 查看学生的试卷详情
	 */
	function check_report()
	{
		$this->load->model('question_model');
		$this->load->model('report_model');
		$this->load->model('module_model');
		$this->load->model('student_model');
		

		$report_id = $this->uri->segment(3);

		$report_check = $this->report_model->get_by_id($report_id);
		$student = $this->student_model->get_by_id($report_check['student_id']);
		$module_check = $this->module_model->get_by_id($report_check['module_id']);
		
		$question_in_report_check = $this->report_model->get_from_question_in_report($report_id);
		

		$check_question = array();

		foreach ($question_in_report_check as $item) {
			
			
			$question_check = $this->question_model->get_by_id($item['question_id']);
			
			//var_dump($knowledge_points_of_question);
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
		$data['module']=$module_check;
		$data['grades']=$report_check['grades'];
		$data['check_question']=$check_question;
		$data['title']="查看答卷详情";
		$this->load->view('teacher_performance/check_report',$data);
	}

	/**
	 * 导出到excel
	 * @return [type] [description]
	 */
	function export_excel()
	{
		$logic_class_id=$this->input->post('logic_class_id');
		$student_name=$this->input->post('student_name');
		$class_id=$this->input->post('class_id');
		$student_id=$this->input->post('student_id');
		$major_id=$this->input->post('major_id');
		$module_id=$this->input->post('module_id');
		$grades_low=$this->input->post('grades_low');
		$grades_high=$this->input->post('grades_high');
		
		$search_content=NULL;
		if($logic_class_id)
			$search_content['logic_class_id']=$logic_class_id;
		if($student_name)
			$search_content['student_name']=$student_name;
		if($class_id)
			$search_content['class_id']=$class_id;
		if($student_id)
			$search_content['student_id']=$student_id;
		if($major_id)
			$search_content['major_id']=$major_id;
		if($module_id)
			$search_content['module_id']=$module_id;
		if($grades_low)
			$search_content['grades_low']=$grades_low;
		if($grades_high)
			$search_content['grades_high']=$grades_high;

		//查询
		$this->load->model('teacher_model');
		$this->load->model('student_model');
		$this->load->model('logic_class_model');
		$this->load->model('class_model');
		$this->load->model('major_model');
		$this->load->model('module_model');
		$me=$this->teacher_model->get_by_username($this->session->userdata('e_username'));

		$query=$this->student_model->get_performances_query($me['id'],$search_content);
		// $this->load->helper('export_excel');
		// export_excel($query);	    
		$this->handle_excel($query);
	}

	/**
	 * 将数据库的query导出到excel
	 * @param  [type] $query [description]
	 * @return [type]        [description]
	 */
	function handle_excel($query)
	{
		 if(!$query)
        return false;

	    // Starting the PHPExcel library
	    $this->load->library('PHPExcel');
	    $this->load->library('PHPExcel/IOFactory');

	    $objPHPExcel = new PHPExcel();
	    $objPHPExcel->getProperties()->setTitle("export")->setDescription("none");

	    $objPHPExcel->setActiveSheetIndex(0);

	    // Field names in the first row
	    $fields = $query->list_fields();
	    $col = 0;
	    foreach ($fields as $field)
	    {
	        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, 1, $field);
	        $col++;
	    }

	    //设置逻辑班号的显示格式
	    // $objPHPExcel->getActiveSheet()->getStyle('E')->getNumberFormat()->setFormatCode('0000');
	    // $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
	    // $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
	    // $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
	    // $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
	    // $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
	    // $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
	    // $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
	    
	    // Fetching the table data
	    $row = 1;
	    $student_id_pre = null;
	    $logic_class_id_pre = null;
	    $big_lecture_name_pre = null;
	    $module_name_pre = null;
	    foreach($query->result() as $data)
	    {
	        $student_id_current = $data->$fields[1];
	        $logic_class_id_current = $data->$fields[3];
	        $big_lecture_name_current = $data->$fields[4];
	        $module_name_current = $data->$fields[5];
	        if($student_id_pre==$student_id_current&&$logic_class_id_pre==$logic_class_id_current&&$big_lecture_name_pre==$big_lecture_name_current&&$module_name_pre==$module_name_current)
	        {
	        	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $data->$fields[6]);
	        	$col++;
	        }
	        else
	        {
	        	$row++;
	        	$col = 0;
	        	foreach ($fields as $field)
	        	{

	            	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $data->$field);
	            	$col++;
	        	}
	        }
	        $student_id_pre = $student_id_current;
	    	$logic_class_id_pre = $logic_class_id_current;
	    	$big_lecture_name_pre = $big_lecture_name_current;
	    	$module_name_pre = $module_name_current;
	        
	    }

	    $objPHPExcel->setActiveSheetIndex(0);

	    // foreach (range('A', $objPHPExcel->getActiveSheet()->getHighestDataColumn()) as $col) {
     //    $objPHPExcel->getActiveSheet()
     //            ->getColumnDimension($col)
     //            ->setAutoSize(true);
    	// } 

	    $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');

	    // Sending headers to force the user to download the file
	    header('Content-Type: application/vnd.ms-excel');
	    header('Content-Disposition: attachment;filename="学习情况.xls"');
	    header('Cache-Control: max-age=0');

	    $objWriter->save('php://output');
	}
	/**
	 * 老师查看一个学生的学习情况详情
	 * @param  integer $id [description]
	 * @return [type]      [description]
	 */
	function check_student($id=0)
	{
		
	}

	/**
	 * 导出总成绩
	 * @return [type] [description]
	 */
	function export_all_grades()
	{
		//表单验证
		if($this->form_validation->run('teacher_performance/export_all_grades'))
		{
			//post方法
			//读取数据
			$this->load->model('logic_class_model');
			$this->load->model('module_model');
			$this->load->model('student_model');
			$this->load->model('report_model');
			$logic_class_id=$this->input->post('logic_class_id');
			$logic_class=$this->logic_class_model->get_by_id($logic_class_id);
			if(!$logic_class)
				return $this->load->view('error');
			$relative_modules=$this->input->post('relative_modules');
			if(!$relative_modules)
			{
				$data['error_message']="您必须至少选择一个模块";
				return $this->load->view("error",$data);	
			}
			
			//生成Excel
		    $this->load->library('PHPExcel');
		    $this->load->library('PHPExcel/IOFactory');

		    $objPHPExcel = new PHPExcel();
		    $objPHPExcel->getProperties()->setTitle("export")->setDescription("none");

		    $objPHPExcel->setActiveSheetIndex(0);

		    
		    $students=$this->student_model->get_students_from_logic_class_id($logic_class_id);

		    //设置表头的名称
		    $col=0;
		    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col++, 1, '姓名');
		    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col++, 1, '学号');
		    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col++, 1, '班级');
		    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col++, 1, '专业');
		    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col++, 1, '课程');
		    foreach ($relative_modules as $module_id) {
		    	$module=$this->module_model->get_by_id($module_id);
		    	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col++, 1, $module['name']);
		    }
		    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col++, 1, '总分');

		    //填入学生个人信息
		    $row=2;
	    	foreach ($students as $student) {
	    		$col=0;
		    	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col++, $row, $student['name']);
		    	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col++, $row, $student['student_id']);
		    	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col++, $row, $student['class_name']);
		    	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col++, $row, $student['major_name']);
		    	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col++, $row, $student['big_lecture_name']);
		    	$row++;
	    	}

		    //填入分数,同时计算总分
		    $module_count=count($relative_modules);
		    $row=2;
	    	foreach ($students as $student) {
	    		$total_grades=0;
	    		$col=5;
	    		foreach ($relative_modules as $module_id) {
		    		$grades=$this->report_model->get_max_grade_by_module_student_logic_class($student['id'],$module_id,$logic_class['id']);
		    		if(!$grades) $grades=0;
		    		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col++, $row, $grades);
		    		$total_grades=$total_grades+$grades;
		    	}
		    	$total_grades=$total_grades/$module_count;
		    	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col++, $row, $total_grades);
		    	$row++;
	    	}
	    	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
		    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
		    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
		    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
		    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
		    $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(15);

		   	$objPHPExcel->setActiveSheetIndex(0);

	    

		    $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');

		    // Sending headers to force the user to download the file
		    header('Content-Type: application/vnd.ms-excel');
		    header('Content-Disposition: attachment;filename="总成绩'.$logic_class['number'].'".xls');
		    header('Cache-Control: max-age=0');

		    $objWriter->save('php://output');
						
		}

		//get方法
		$this->load->model('teacher_model');
		$this->load->model('logic_class_model');
		$this->load->model('module_model');

		$me=$this->teacher_model->get_by_username($this->session->userdata('e_username'));
		$logic_classes=$this->logic_class_model->get_all_logic_classes_by_teacher_id($me['id']);
		$modules=$this->module_model->get_modules_by_teacher_id($me['id']);

		$data['logic_classes']=$logic_classes;
		$data['modules']=$modules;
		$data['title']='导出总成绩';
		$this->load->view('teacher_performance/export_all_grades',$data);
	}
	
		/**
	 * ajax方法，通过逻辑班查询相关学生专业
	 * @return [type] [description]
	 */
	function find_relative_student_major($logic_class_id)
	{
		$this->load->model('logic_class_model');
		$this->load->model('major_model');
		if ($logic_class_id==0) {
			$majors=$this->major_model->get_all();
		}
		else{			
			$all_major = $this->logic_class_model->get_relative_student_major($logic_class_id);

			//去掉重复值
			$majors = array();
			foreach ($all_major as $all_major_item) {
				$exit = 0;
				foreach ($majors as $majors_item) {
					if ($majors_item['id']==$all_major_item['id']) {
						$exit = 1;
					}
				}

				if ($exit==0) {
					array_push($majors, $all_major_item);
				}
			}

		}

		$data['student_major']=$majors;
		$this->load->view('teacher_performance/relative_student_major',$data);	
	}

}  
 