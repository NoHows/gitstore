<?php  
/*老师，模型*/
class Teacher_model extends CI_Model
{

	var $table='teacher';

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
	 * 得到所有老师，包括专业信息
	 * @return [type] [description]
	 */
	function get_all_teachers()
	{
		$sql='SELECT t.id,t.name,m.name as major_name,t.teacher_number FROM teacher as t,major as m WHERE t.major_id=m.id';
		return $this->db->query($sql)->result_array();
	}

	/**
	 * 查看数据库中是否已经有这个教职工号
	 * @param  [type] $teacher_number [description]
	 * @return [type]                 [description]
	 */
	function teacher_number_exist($teacher_number)
	{
		$sql='SELECT count(*) as count FROM teacher WHERE teacher.teacher_number =?';
		$row_teacher=$this->db->query($sql,$teacher_number)->row_array();
		$sql='SELECT count(*) as count FROM user WHERE user.username =?';
		$row_user=$this->db->query($sql,$teacher_number)->row_array();
		return ($row_teacher['count']>0||$row_user['count']>0);
	}

	/**
	 * 删除一个老师
	 * @param  [type] $teacher_id [description]
	 * @return [type]             [description]
	 */
	function delete_cascade($teacher_id)
	{
		$teacher=$this->get_by_id($teacher_id);
		//先删除这个老师
		if($this->delete($teacher_id))
		{
			//删除这个user
			$this->load->model('user_model');
			if($this->user_model->delete($teacher['user_id']))
				return TRUE;
		}
		return FALSE;
	}

	/**
	 * 通过教职工号得到老师
	 * @param  [type] $teacher_number [description]
	 * @return [type]                 [description]
	 */
	function get_by_teacher_number($teacher_number)
	{
		$sql='SELECT * FROM teacher WHERE teacher_number=?';
		return $this->db->query($sql,$teacher_number)->row_array();
	}

	/**
	 * 通过user_id返回一个teacher
	 * @param  [type] $user_id [description]
	 * @return [type]          [description]
	 */
	function get_by_user_id($user_id)
	{
		return $this->db->get_where($this->table, array('user_id' => $user_id ))->row_array();
	}
	

	/**
	 * 通过id返回teacher信息，包括专业
	 * @param  [type] $teacher_id [description]
	 * @return [type]             [description]
	 */
	function get_teacher_by_id($teacher_id)
	{
		$sql='SELECT t.id,t.user_id,t.teacher_number,t.name,m.name as major_name FROM teacher as t,major as m WHERE t.major_id=m.id and t.id=?';
		return $this->db->query($sql,$teacher_id)->row_array();
	}

	/**
	 * 通过username返回一个teacher
	 * @param  [type] $user_id [description]
	 * @return [type]          [description]
	 */
	function get_by_username($username)
	{
		$sql='SELECT t.id,t.user_id,t.teacher_number,t.name,t.major_id FROM teacher as t,user as u WHERE t.user_id=u.id and u.username=?';
		return $this->db->query($sql,$username)->row_array();
	}

	/**
	 * 得到这个老师教的课程的数目
	 * @return [type] [description]
	 */
	function get_logic_class_count($teacher_id)
	{
		$sql='SELECT count(*) as count FROM logic_class WHERE teacher_id=?';
		$res=$this->db->query($sql,$teacher_id)->row_array();
		return $res['count'];
	}


	/**
	 * 返回一个老师的学生个数
	 * @param  [type] $teacher_id [description]
	 * @return [type]             [description]
	 */
	function get_students_count($teacher_id)
	{
		$sql='SELECT COUNT(DISTINCT s.id) as count FROM student as s,major as m,class as c,student_in_logic_class as silc,logic_class as lc WHERE s.major_id=m.id and s.class_id=c.id and s.id=silc.student_id and lc.id=silc.logic_class_id and lc.teacher_id=?';
		$res=$this->db->query($sql,$teacher_id)->row_array();
		return $res['count'];

	}

	/**
	 * 得到个人的组卷的个数
	 * @param  [type] $teacher_id [description]
	 * @return [type]             [description]
	 */
	function get_private_module_count($teacher_id)
	{
		$sql='SELECT count(*) as count FROM module WHERE teacher_id=?';
		$res=$this->db->query($sql,$teacher_id)->row_array();
		return $res['count'];
	}
}
