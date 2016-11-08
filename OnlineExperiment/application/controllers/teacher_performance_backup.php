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
		$this->load->model('class_model');
		$me=$this->teacher_model->get_by_username($this->session->userdata('username'));

		//配置查询选项
		$search_content=NULL;
		$logic_classes=$this->logic_class_model->get_all_logic_classes_by_teacher_id($me['id']);
		$logic_class_id_selected=NULL;
		// $major_id_selected=NULL;
		// $class_id_selected=NULL;
		// $name_selected=NULL;
		// $student_id_selected=NULL;
		// $grades_low_selected=NULL;
		// $grades_high_selected=NULL;
		$classes=$this->class_model->get_classes_by_teacher_id($me['id']);

		if(count($logic_classes)>0){
			$logic_class=$logic_classes[0];
			$search_content['logic_class_id']=$logic_class['id'];
			$logic_class_id_selected=$logic_class['id'];
		}		
		$performances=$this->student_model->get_performances($me['id'],$search_content);
		
		$majors=$this->major_model->get_all();

		$data['performances']=$performances;
		$data['logic_classes']=$logic_classes;
		$data['logic_class_id_selected']=$logic_class_id_selected;
		$data['classes']=$classes;
		$data['majors']=$majors;

		$data['title']='学习情况';
		$this->load->view('teacher_performance/index',$data);

	}

	/**
	 * 查询学生的表现
	 * @return [type] [description]
	 */
	function search()
	{
		$logic_class_id=$this->input->post('logic_class_id');
		$student_name=$this->input->post('student_name');
		$class_id=$this->input->post('class_id');
		$student_id=$this->input->post('student_id');
		$major_id=$this->input->post('major_id');
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
		$me=$this->teacher_model->get_by_username($this->session->userdata('username'));
		$performances=$this->student_model->get_performances($me['id'],$search_content);
		
		$logic_classes=$this->logic_class_model->get_all_logic_classes_by_teacher_id($me['id']);
		$classes=$this->class_model->get_classes_by_teacher_id($me['id']);
		$majors=$this->major_model->get_all();

		$data['performances']=$performances;
		$data['logic_classes']=$logic_classes;
		$data['classes']=$classes;
		$data['majors']=$majors;

		$data['logic_class_id_selected']=$logic_class_id;
		$data['student_name_selected']=$student_name;
		$data['class_id_selected']=$class_id;
		$data['student_id_selected']=$student_id;
		$data['major_id_selected']=$major_id;
		$data['grades_low_selected']=$grades_low;
		$data['grades_high_selected']=$grades_high;

		$data['title']='学习情况';
		$this->load->view('teacher_performance/index',$data);

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
		if($grades_low)
			$search_content['grades_low']=$grades_low;
		if($grades_high)
			$search_content['grades_high']=$grades_high;

		//查询
		$this->load->model('teacher_model');
		$this->load->model('student_model');
		$me=$this->teacher_model->get_by_username($this->session->userdata('username'));
		$query=$this->student_model->performances_export_excel($me['id'],$search_content);
		// $this->load->helper('export_excel');
		// export_excel($query);
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
	    $objPHPExcel->getActiveSheet()->getStyle('E')->getNumberFormat()->setFormatCode('0000');
	    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
	    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
	    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
	    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
	    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
	    $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
	    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
	    
	    // Fetching the table data
	    $row = 2;
	    foreach($query->result() as $data)
	    {
	        $col = 0;
	        foreach ($fields as $field)
	        {
	            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $data->$field);
	            $col++;
	        }

	        $row++;
	    }

	    $objPHPExcel->setActiveSheetIndex(0);

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
	
}  
 