<?php  
/*学生，模型*/
class Student_model extends CI_Model
{

	var $table='student';

	function __construct()
	{
		parent::__construct();
		
	}

	/**
	 * 返回数据表总条目个数
	 * @return [type] [description]
	 */
	function count_all()
	{
		return $this->db->count_all($this->table);
	}

	/**
	 * 获得所有的条目
	 * @return [type] [description]
	 */
	function get_all()
	{
		$res=$this->db->get($this->table)->result_array();
		return $res;
	}

	/**
	 * 通过id返回条目
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	function get_by_id($id)
	{
		return $this->db->get_where($this->table, array('id' => $id ))->row_array();
	}


	/**
	 * 添加一个条目
	 * @param [type] $item [description]
	 */
	function add($item)
	{
		return	$this->db->insert($this->table,$item);
	}

	/**
	 * 删除一个条目
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	function delete($id)
	{
		return $this->db->delete($this->table, array('id' => $id ));

	}

	/**
	 * 更新一个条目
	 * @param  [type] $id   [description]
	 * @param  [type] $item [description]
	 * @return [type]       [description]
	 */
	function update($id,$item)
	{
		$this->db->where('id', $id);
		return $this->db->update($this->table,$item);
	}

	/**
	 * 得到所有学生信息，包括专业，班级
	 * @return [type] [description]
	 */
	function get_all_students()
	{
		$sql='SELECT s.id,s.user_id,s.name,s.student_id,m.name as major_name,s.type,c.name as class_name FROM student as s,major as m,class as c WHERE s.major_id=m.id and s.class_id=c.id';
		return $this->db->query($sql)->result_array();
	}

	/**
	 * 查询学生
	 * @param  [type] $major_id       [description]
	 * @param  [type] $class_id       [description]
	 * @param  [type] $logic_class_id [description]
	 * @param  [type] $student_type   [description]
	 * @return [type]                 [description]
	 */
	function search($major_id,$class_id,$logic_class_id,$student_type)
	{
		if($logic_class_id)
		{
			$sql='SELECT s.id,s.user_id,s.name,s.student_id,m.name as major_name,s.type,c.name as class_name FROM student as s,major as m,class as c,student_in_logic_class as silc WHERE s.major_id=m.id and s.class_id=c.id and silc.student_id=s.id and silc.logic_class_id=?';
			if($major_id)
				$sql=$sql.' and s.major_id='.$major_id;
			if($class_id)
				$sql=$sql.' and s.class_id='.$class_id;
			if($student_type)
				$sql=$sql.' and s.type='.$student_type;

			return $this->db->query($sql,$logic_class_id)->result_array();
		}
		else
		{
			$sql='SELECT s.id,s.user_id,s.name,s.student_id,m.name as major_name,s.type,c.name as class_name FROM student as s,major as m,class as c WHERE s.major_id=m.id and s.class_id=c.id';
			if($major_id)
				$sql=$sql.' and s.major_id='.$major_id;
			if($class_id)
				$sql=$sql.' and s.class_id='.$class_id;
			if($student_type)
				$sql=$sql.' and s.type='.$student_type;
			return $this->db->query($sql)->result_array();
		}
	}


	/**
	 * 查看数据库中是否已经有这个学号
	 * @param  [type] $teacher_number [description]
	 * @return [type]                 [description]
	 */
	function student_id_exist($student_id)
	{
		$sql='SELECT count(*) as count FROM student WHERE student.student_id =?';
		$row_student=$this->db->query($sql,$student_id)->row_array();
		$sql='SELECT count(*) as count FROM user WHERE user.username =?';
		$row_user=$this->db->query($sql,$student_id)->row_array();
		return ($row_student['count']>0||$row_user['count']>0);
	}

	/**
	 * 删除学生选课信息
	 * @param [type] $student_id    [description]
	 * @param [type] $logic_classes [description]
	 */
	function delete_relative_logic_classes($id)
	{
		$sql='delete from student_in_logic_class where student_id = ?';
		return $this->db->query($sql,$id);
	}
	
	/**
	 * 添加学生选课信息
	 * @param [type] $student_id    [description]
	 * @param [type] $logic_classes [description]
	 */
	function add_relative_logic_classes($student_id,$logic_classes)
	{
		foreach ($logic_classes as $logic_class_id ) {
			$sql='SELECT count(*) as count FROM student_in_logic_class WHERE student_id=? and logic_class_id=?';
			$row=$this->db->query($sql,array($student_id,$logic_class_id))->row_array();
			if($row['count']>0) 
				continue;
			$relation = array(
				'logic_class_id' => $logic_class_id,
				'student_id' => $student_id
				 );
			if(!$this->db->insert('student_in_logic_class',$relation))
				return FALSE;
		}
		return TRUE;
	}

	/**
	 * 添加校外学生选课信息
	 * @param [type] $student_id    [description]
	 * @param [type] $logic_classes [description]
	 */
	function add_student_in_logic_classes($student_id,$logic_classes)
	{
		foreach ($logic_classes as $logic_class ) {
			$sql='SELECT count(*) as count FROM student_in_logic_class WHERE student_id=? and logic_class_id=?';
			$row=$this->db->query($sql,array($student_id,$logic_class['id']))->row_array();
			if($row['count']>0) 
				continue;
			$relation = array(
				'logic_class_id' => $logic_class['id'],
				'student_id' => $student_id
				 );
			if(!$this->db->insert('student_in_logic_class',$relation))
				return FALSE;
		}
		return TRUE;
	}

	/**
	 * 得到学生选课信息
	 * @param [type] $student_id    [description]
	 * @param [type] $logic_classes [description]
	 */
	function get_logic_classes_select($id)
	{
		$sql='SELECT * FROM student_in_logic_class WHERE student_id=?';
		return $this->db->query($sql,$id)->result_array();
	}

	/**
	 * 得到学生的信息
	 * @param  [type] $id [description]
	 * @return [type]             [description]
	 */
	function get_student_by_id($id)
	{
		$sql='SELECT s.id,s.user_id,s.name,s.student_id,m.id as major_id,m.name as major_name,s.type,c.id as class_id,c.name as class_name FROM student as s,major as m,class as c WHERE s.major_id=m.id and s.class_id=c.id and s.id=?';
		return $this->db->query($sql,$id)->row_array();
	}

	/**
	 * 得到学生的选课信息
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	function get_relative_logic_classes($id)
	{
		$sql='SELECT lc.id,lc.number,bl.name as big_lecture_name,t.name as teacher_name,silc.grades as grades FROM big_lecture as bl,logic_class as lc,student_in_logic_class as silc,teacher as t WHERE lc.big_lecture_id=bl.id and t.id=lc.teacher_id and lc.id=silc.logic_class_id and silc.student_id=?';
		return $this->db->query($sql,$id)->result_array();
	}





	/**
	 * 得到学生的选课信息
	 * @param  [type]$logic_class_id [description]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	function get_relative_teacher_logic_classes($logic_class_id,$id)
	{
		$sql='SELECT lc.id,lc.number,bl.name as big_lecture_name,t.name as teacher_name,silc.grades as grades FROM big_lecture as bl,logic_class as lc,student_in_logic_class as silc,teacher as t WHERE lc.big_lecture_id=bl.id and t.id=lc.teacher_id and lc.teacher_id=(SELECT teacher_id from logic_class where id=?) and lc.id=silc.logic_class_id and silc.student_id=?';
		//return $this->db->query($sql,$logic_class_id,$id)->result_array();
		return $this->db->query($sql,array($logic_class_id,$id))->result_array();
		
	}






	/**
	 * 删除一个学生(使用的是数据库id)
	 * @param  [type] $id [description]
	 * @return [type]             [description]
	 */
	function delete_cascade($student_id)
	{
		$student=$this->get_by_id($student_id);
		//删除学生所选课程
		$sql='DELETE FROM student_in_logic_class where student_id=?';
		if(!$this->db->query($sql,$student_id))
			return FALSE;
		//删除学生的考试信息
		$sql='DELETE FROM question_in_report WHERE report_id in (SELECT * FROM (SELECT r.id FROM report as r,question_in_report as qir WHERE r.id=qir.report_id and r.student_id=?) as t)';
		if(!$this->db->query($sql,$student_id))
			return FALSE;
		
		$sql='DELETE FROM report where student_id=?';
		if(!$this->db->query($sql,$student_id))
			return FALSE;
		//删除这个学生
		if(!$this->delete($student_id))
			return FALSE;
		//删除这个user
		$this->load->model('user_model');
		if(!$this->user_model->delete($student['user_id']))
			return FALSE;
		
		return TRUE;
	}

	/**
	 * 从一个逻辑班下删除一个学生
	 * @param  [type] $logic_class_id [description]
	 * @param  [type] $student_id     [description]
	 * @return [type]                 [description]
	 */
	function delete_from_logic_class($logic_class_id,$student_id)
	{
		$student=$this->get_by_id($student_id);
		//删除学生所选课程
		$sql='DELETE FROM student_in_logic_class WHERE logic_class_id=? AND student_id=?';
		if(!$this->db->query($sql,array($logic_class_id,$student_id)))
			return FALSE;
		//删除学生的考试信息
		$sql='DELETE FROM question_in_report WHERE report_id in (SELECT * FROM (SELECT r.id FROM report as r,question_in_report as qir WHERE r.id=qir.report_id and r.logic_class_id=? and r.student_id=?) as t)';
		if(!$this->db->query($sql,array($logic_class_id,$student_id)))
			return FALSE;
		$sql='DELETE FROM report WHERE logic_class_id=? AND student_id=?';
		if(!$this->db->query($sql,array($logic_class_id,$student_id)))
			return FALSE;
		return TRUE;
	}

	/**
	 * 通过学号得到学生
	 * @param  [type] $student_id [description]
	 * @return [type]             [description]
	 */
	function get_by_student_id($student_id)
	{
		$sql='SELECT * FROM student WHERE student_id=?';
		return $this->db->query($sql,$student_id)->row_array();
	}

	/**
	 * 添加一条选课记录
	 * @param [type] $student_id     [description]
	 * @param [type] $logic_class_id [description]
	 */
	function add_logic_class($student_id,$logic_class_id)
	{
		//检测是否已经存在这个选课记录
		$sql='SELECT count(*) as count FROM student_in_logic_class WHERE student_id=? and logic_class_id=?';
		$row=$this->db->query($sql,array($student_id,$logic_class_id))->row_array();
		if($row['count']>0) 
			return TRUE;
		$relation = array(
				'logic_class_id' => $logic_class_id,
				'student_id' => $student_id
				 );
		return $this->db->insert('student_in_logic_class',$relation);
	}

	/**
	 * 返回一个老师的所有学生
	 * @param  [type] $teacher_id [description]
	 * @return [type]             [description]
	 */
	function get_all_students_by_teacher_id($teacher_id)
	{
		$sql='SELECT DISTINCT s.id,s.user_id,s.name,s.student_id,m.name as major_name,s.type,c.name as class_name FROM student as s,major as m,class as c,student_in_logic_class as silc,logic_class as lc WHERE s.major_id=m.id and s.class_id=c.id and s.id=silc.student_id and lc.id=silc.logic_class_id and lc.teacher_id=?';
		return $this->db->query($sql,$teacher_id)->result_array();

	}

	/**
	 * 得到一个逻辑班下，一个班级下的学生
	 * @param  [type] $logic_class_id [description]
	 * @param  [type] $class_id       [description]
	 * @return [type]                 [description]
	 */
	function get_students_by_logic_class_id_and_class_id($logic_class_id,$class_id)
	{
		$sql='SELECT s.id,s.user_id,s.name,s.student_id,m.name as major_name FROM major as m,student as s,student_in_logic_class as silc where m.id=s.major_id and s.id = silc.student_id and silc.logic_class_id=? and s.class_id=? ';
		return $this->db->query($sql,array($logic_class_id,$class_id))->result_array();
	}

	


	/**
	 * 检查一个老师能不能对一个同学进行编辑
	 * @param  [type] 学生的id [description]
	 * @param  [type] $teacher_id [description]
	 * @return [type]             [description]
	 */
	function check_student_editable($student_id,$teacher_id)
	{
		$sql='SELECT count(*) as count FROM student_in_logic_class as silc,logic_class as lc WHERE silc.logic_class_id=lc.id and silc.student_id=? and lc.teacher_id<>?';
		$result=$this->db->query($sql,array($student_id,$teacher_id))->row_array();
		return ($result['count']==0);
	}

	/**
	 * 检查这个学生是否有选择的课程
	 * @param  [type] $student_id [description]
	 * @return [type]             [description]
	 */
	function check_in_logic_class($student_id)
	{
		$sql='SELECT count(*) as count FROM student_in_logic_class WHERE student_id=?';
		$result=$this->db->query($sql,$student_id)->row_array();
		return ($result['count']>0);
	}

	/**
	 * 查询一个老师的学生的表现
	 * @param  [type] $search_content [description]
	 * @return [type]                 [description]
	 */
	function get_performances($teacher_id,$search_content)
	{
		//这样拼接字符串实际上不太安全
		$sql='SELECT distinct s.name as student_name,s.student_id as student_id,s.id as s_id,c.name as class_name,lc.number as logic_class_number,bl.name as big_lecture_name,mo.name as module_name,mo.id as module_id,r.id as report_id,max(r.grades) as max_grades, min(r.grades) as min_grades,count(r.grades) as grades_counts FROM report as r,module as mo,student as s,class as c,student_in_logic_class as silc,logic_class as lc,big_lecture as bl where r.module_id=mo.id and r.student_id=s.id and s.class_id=c.id and s.id=silc.student_id and lc.id=silc.logic_class_id and lc.big_lecture_id=bl.id';
		if(isset($search_content['logic_class_id']))
		{
			if(!$search_content['logic_class_id'])
			{
				//如果不按逻辑班查，就返回这个老师名下所有的逻辑班
				$sql=$sql.' and lc.id in (select lc.id from logic_class as lc where lc.teacher_id=1)';
			}
			else
			{
				$sql=$sql.' and lc.id='.$search_content['logic_class_id'];
			}
		}
		if(isset($search_content['class_id'])&&$search_content['class_id'])
			$sql=$sql.' and c.id='.$search_content['class_id'];
		if(isset($search_content['major_id'])&&$search_content['major_id'])
			$sql=$sql.' and s.major_id='.$search_content['major_id'];
		if(isset($search_content['module_id'])&&$search_content['module_id'])
			$sql=$sql.' and mo.id='.$search_content['module_id'];
		if(isset($search_content['student_name'])&&$search_content['student_name'])
			$sql=$sql.' and s.name like \'%'.$search_content['student_name'].'%\'';
		if(isset($search_content['student_id'])&&$search_content['student_id'])
			$sql=$sql.' and s.student_id like \'%'.$search_content['student_id'].'%\'';
		if(isset($search_content['grades_low'])&&$search_content['grades_low'])
			$sql=$sql.' and r.grades>='.$search_content['grades_low'];
		if(isset($search_content['grades_high'])&&$search_content['grades_high'])
			$sql=$sql.' and r.grades<='.$search_content['grades_high'];
		$sql=$sql.' group by s.student_id,mo.id order by s.student_id,mo.id';
		return $this->db->query($sql)->result_array();
	}

	// /**
	//  * 查询一个老师的学生的表现
	//  * @param  [type] $search_content [description]
	//  * @return [type]                 [description]
	//  */
	// function get_performances_backup($teacher_id,$search_content)
	// {
	// 	//这样拼接字符串实际上不太安全
	// 	$sql='SELECT s.id as id,s.name as student_name,m.name as major_name,s.student_id as student_id,c.name as class_name,lc.number as logic_class_number,lc.name as logic_class_name,silc.grades as grades FROM student as s,major as m,class as c,student_in_logic_class as silc,logic_class as lc where silc.student_id=s.id and s.major_id=m.id and s.class_id=c.id and lc.id=silc.logic_class_id';
	// 	if(isset($search_content['logic_class_id']))
	// 	{
	// 		if(!$search_content['logic_class_id'])
	// 		{
	// 			//如果不按逻辑班查，就返回这个老师名下所有的逻辑班
	// 			$sql=$sql.' and lc.id in (select lc.id from logic_class as lc where lc.teacher_id=1)';
	// 		}
	// 		else
	// 		{
	// 			$sql=$sql.' and lc.id='.$search_content['logic_class_id'];
	// 		}
	// 	}
	// 	if(isset($search_content['class_id'])&&$search_content['class_id'])
	// 		$sql=$sql.' and c.id='.$search_content['class_id'];
	// 	if(isset($search_content['major_id'])&&$search_content['major_id'])
	// 		$sql=$sql.' and m.id='.$search_content['major_id'];
	// 	if(isset($search_content['student_name'])&&$search_content['student_name'])
	// 		$sql=$sql.' and s.name like \'%'.$search_content['student_name'].'%\'';
	// 	if(isset($search_content['student_id'])&&$search_content['student_id'])
	// 		$sql=$sql.' and s.student_id like \'%'.$search_content['student_id'].'%\'';
	// 	if(isset($search_content['grades_low'])&&$search_content['grades_low'])
	// 		$sql=$sql.' and silc.grades>='.$search_content['grades_low'];
	// 	if(isset($search_content['grades_high'])&&$search_content['grades_high'])
	// 		$sql=$sql.' and silc.grades<='.$search_content['grades_high'];
	// 	return $this->db->query($sql)->result_array();
	// }
	// 
	// /**
	//  * 把查询结果返回到查询结果，供导出excel使用
	//  * @return [type] [description]
	//  */
	// function performances_export_excel($teacher_id,$search_content)
	// {
	// 	$sql='SELECT s.name as 姓名 ,m.name as 专业,s.student_id as 学号,c.name as 班级,lc.number as 逻辑班号,lc.name as 课程,silc.grades as 分数 FROM student as s,major as m,class as c,student_in_logic_class as silc,logic_class as lc where silc.student_id=s.id and s.major_id=m.id and s.class_id=c.id and lc.id=silc.logic_class_id';
	// 	if(isset($search_content['logic_class_id']))
	// 	{
	// 		if(!$search_content['logic_class_id'])
	// 		{
	// 			//如果不按逻辑班查，就返回这个老师名下所有的逻辑班
	// 			$sql=$sql.' and lc.id in (select lc.id from logic_class as lc where lc.teacher_id=1)';
	// 		}
	// 		else
	// 		{
	// 			$sql=$sql.' and lc.id='.$search_content['logic_class_id'];
	// 		}
	// 	}
	// 	if(isset($search_content['class_id'])&&$search_content['class_id'])
	// 		$sql=$sql.' and c.id='.$search_content['class_id'];
	// 	if(isset($search_content['major_id'])&&$search_content['major_id'])
	// 		$sql=$sql.' and m.id='.$search_content['major_id'];
	// 	if(isset($search_content['student_name'])&&$search_content['student_name'])
	// 		$sql=$sql.' and s.name like \'%'.$search_content['student_name'].'%\'';
	// 	if(isset($search_content['student_id'])&&$search_content['student_id'])
	// 		$sql=$sql.' and s.student_id like \'%'.$search_content['student_id'].'%\'';
	// 	if(isset($search_content['grades_low'])&&$search_content['grades_low'])
	// 		$sql=$sql.' and silc.grades>='.$search_content['grades_low'];
	// 	if(isset($search_content['grades_high'])&&$search_content['grades_high'])
	// 		$sql=$sql.' and silc.grades<='.$search_content['grades_high'];
	// 	return $this->db->query($sql);
	// }
	/**
	 * 把查询结果返回到查询结果，供导出excel使用
	 * @return [type] [description]
	 */
	function get_performances_query($teacher_id,$search_content)
	{
		//这样拼接字符串实际上不太安全
		$sql='SELECT s.name as 姓名,s.student_id as 学号,c.name as 班级,lc.number as 逻辑班号,bl.name as 课程,mo.name as 模块,r.grades as 分数 FROM report as r,module as mo,student as s,class as c,student_in_logic_class as silc,logic_class as lc,big_lecture as bl  where r.module_id=mo.id and r.student_id=s.id and s.class_id=c.id and s.id=silc.student_id and lc.id=silc.logic_class_id and lc.big_lecture_id=bl.id';
		if(isset($search_content['logic_class_id']))
		{
			if(!$search_content['logic_class_id'])
			{
				//如果不按逻辑班查，就返回这个老师名下所有的逻辑班
				$sql=$sql.' and lc.id in (select lc.id from logic_class as lc where lc.teacher_id=1)';
			}
			else
			{
				$sql=$sql.' and lc.id='.$search_content['logic_class_id'];
			}
		}
		if(isset($search_content['class_id'])&&$search_content['class_id'])
			$sql=$sql.' and c.id='.$search_content['class_id'];
		if(isset($search_content['major_id'])&&$search_content['major_id'])
			$sql=$sql.' and s.major_id='.$search_content['major_id'];
		if(isset($search_content['module_id'])&&$search_content['module_id'])
			$sql=$sql.' and mo.id='.$search_content['module_id'];
		if(isset($search_content['student_name'])&&$search_content['student_name'])
			$sql=$sql.' and s.name like \'%'.$search_content['student_name'].'%\'';
		if(isset($search_content['student_id'])&&$search_content['student_id'])
			$sql=$sql.' and s.student_id like \'%'.$search_content['student_id'].'%\'';
		if(isset($search_content['grades_low'])&&$search_content['grades_low'])
			$sql=$sql.' and r.grades>='.$search_content['grades_low'];
		if(isset($search_content['grades_high'])&&$search_content['grades_high'])
			$sql=$sql.' and r.grades<='.$search_content['grades_high'];
		$sql=$sql.' order by s.student_id,mo.id';
		return $this->db->query($sql);
	}

	/**
	 * 通过username返回一个student
	 * @param  [type] $username [description]
	 * @return [type]          [description]
	 */
	function get_by_username($username)
	{
		$sql='SELECT s.id,s.user_id,s.name,s.student_id,s.major_id,s.type,s.class_id FROM student as s,user as u WHERE s.user_id=u.id and u.username=?';
		return $this->db->query($sql,$username)->row_array();
	}

	/**
	 * 通过逻辑班号得到学生信息
	 * @return [type] [description]
	 */
	function get_students_from_logic_class_id($logic_class_id)
	{
		$sql='SELECT s.id,s.name,s.student_id,c.name as class_name,m.name as major_name,bl.name as big_lecture_name ,lc.number as logic_class_number FROM student_in_logic_class as silc,logic_class as lc,student as s,major as m,class as c ,big_lecture as bl WHERE bl.id=lc.big_lecture_id and s.class_id=c.id and silc.student_id=s.id and silc.logic_class_id=lc.id and m.id=s.major_id and lc.id=?';
		return $this->db->query($sql,$logic_class_id)->result_array();
	}


	/**
	 * 通过user_id返回学生信息
	 * @param  [type] $user_id [description]
	 * @return [type]     	   [description]
	 */
	function get_by_user_id($user_id)
	{
		return $this->db->get_where($this->table, array('user_id' => $user_id ))->row_array();
	}

	/**
	 * 通过学生ID返回学生的所参与的module信息
	 * @param  [type] $student_id [description]
	 * @return [type]     		  [description]
	 */
	function get_student_logic_class($student_id)
	{
		return $this->db->get_where('student_in_logic_class', array('student_id' => $student_id ))->result_array();
	}
}
