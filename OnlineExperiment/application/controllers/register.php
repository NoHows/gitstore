<?php 
/**
* 注册校外用户
*/
class Register extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();

	}

	function index()
	{
    
		$data = array();
    $data['title']='在线考试系统';
 
    $data['login_state']="tring";
    $data['message']= "";
		$data['title']='用户注册';

    
    
		$this->load->view('register/index',$data);
	}

	function student_register()
	{
		//表单验证
		if($this->form_validation->run('register/student_register'))
      {
			$this->load->model('user_model');
			$this->load->model('student_model');
			$this->load->model('logic_class_model');

			//获取参数
			$username = $this->input->post('username');
			$name = $this->input->post('name');
			$password = $this->input->post('password');

			//存入用户表
			$user_item = array(
               'username' => $username ,
               'password' => md5($password) ,
               'role_id' => 3 ,
            );	
         $bool1 = $this->user_model->add($user_item);
         $user = $this->user_model->get_by_username($username);
         echo "bool1";
         var_dump($bool1);
         //存入学生表
			$student_item = array(
               'user_id' => $user['id'] ,
               'name' => $name ,
               'student_id' => $username,
               'major_id' => 13 ,
               'type' => 2,
               'class_id' => 26,
            );	
          $bool2 = $this->student_model->add($student_item);
         $student =  $this->student_model->get_by_user_id($user['id']);
         echo "bool2";
         var_dump($bool2);
         //获取所有要加入的逻辑班
         $logic_classes = $this->logic_class_model->get_by_type(2);
          $bool3 = $this->student_model->add_student_in_logic_classes($student['id'],$logic_classes);
         echo "bool3";
         var_dump($bool3);
         redirect('home/index');
		}

	}
  /**
   * 异步jquery验证
   * @return [type] [description]
   */
  function check_username_exist()
  {
    $username=$this->input->post('username');
    $this->load->model('user_model');
    if($this->user_model->username_exist($username))
      echo json_encode(FALSE);
    else 
      echo json_encode(TRUE);
  }
   /**
    * CI的表单回调函数验证
    * @param  [type] $str [description]
    * @return [type]      [description]
    */
   function username_check($username)
   {
      $this->load->model('user_model');
      if($this->user_model->username_exist($username))
         return FALSE;
      else 
         return TRUE;
   }
}