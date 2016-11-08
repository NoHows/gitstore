<?php  
/*逻辑班，模型*/
class Logic_class_model extends CI_Model
{

	var $table='logic_class';

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
	 * 通过big_lecture_id返回条目
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	function get_by_big_lecture_id($big_lecture_id)
	{
		return $this->db->get_where($this->table, array('big_lecture_id' => $big_lecture_id ))->result_array();
	}

	/**
	 * 通过type返回条目
	 * @param  [type] $type [description]
	 * @return [type]       [description]
	 */
	function get_by_type($type)
	{
		return $this->db->get_where($this->table, array('type' => $type ))->result_array();
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
	 * 得到逻辑班的所有信息，包括逻辑班号，名称，老师
	 * @return [type] [description]
	 */
	function get_all_logic_classes()
	{
		$sql="SELECT lc.id,lc.number,lc.type,bl.name as big_lecture_name,t.name as teacher_name FROM logic_class as lc,teacher as t,big_lecture as bl WHERE lc.teacher_id=t.id and lc.big_lecture_id=bl.id";
		return $this->db->query($sql)->result_array();
	}

	/**
	 * 通过教师id,得到逻辑班的所有信息，包括逻辑班号，名称，老师
	 * @return [type] [description]
	 */
	function get_all_logic_classes_by_teacher_id($teacher_id)
	{
		$sql="SELECT lc.id,lc.number,bl.name as big_lecture_name,t.name as teacher_name,lc.type FROM logic_class as lc,teacher as t,big_lecture as bl WHERE lc.big_lecture_id=bl.id and lc.teacher_id=t.id and lc.teacher_id=?";
		return $this->db->query($sql,$teacher_id)->result_array();
	}

	/**
	 * 查询这个逻辑班级的所有学生信息
	 * @param  [type] $class_id [description]
	 * @return [type]           [description]
	 */
	function get_students_from_logic_class_id($logic_class_id)
	{
		$sql='SELECT s.id,s.user_id,s.name,s.student_id,m.name as major_name FROM student_in_logic_class as silc,logic_class as lc,student as s,major as m WHERE silc.student_id=s.id and silc.logic_class_id=lc.id and m.id=s.major_id and lc.id=?';
		return $this->db->query($sql,$logic_class_id)->result_array();
	}

	/**
	 * 得到逻辑班对应的老师
	 * @param  [type] $logic_class_id [description]
	 * @return [type]                 [description]
	 */
	function get_teacher($logic_class_id)
	{
		$sql='SELECT t.id,t.user_id,t.name FROM logic_class as lc,teacher as t WHERE lc.teacher_id=t.id and lc.id=?';
		return $this->db->query($sql,$logic_class_id)->row_array();
	}
	

	/**
	 * 查看数据库中是否已经有这个逻辑班号
	 * @param  [type] $logic_class_number [description]
	 * @return [type]                 [description]
	 */
	function logic_class_number_exist($logic_class_number)
	{
		$sql='SELECT count(*) as count FROM logic_class as lc WHERE lc.number=?';
		$row=$this->db->query($sql,$logic_class_number)->row_array();
		return ($row['count']>0);
	}

	/**
	 * 通过逻辑班号得到这个逻辑班
	 * @param  [type] $logic_class_number [description]
	 * @return [type]                     [description]
	 */
	function get_by_logic_class_number($logic_class_number)
	{
		$sql='SELECT lc.id,lc.number,lc.teacher_id,lc.type,bl.name as big_lecture_name FROM logic_class as lc ,big_lecture as bl WHERE lc.big_lecture_id=bl.id and number=?';
		return $this->db->query($sql,$logic_class_number)->row_array();
	}

	/**
	 * 通过老师id得到相应的逻辑班
	 * @return [type] [description]
	 */
	function get_logic_classes_by_teacher_id($teacher_id)
	{
		$sql='SELECT lc.id,lc.number,lc.teacher_id,lc.type,bl.name as big_lecture_name FROM logic_class as lc,big_lecture as bl where lc.big_lecture_id=bl.id and lc.teacher_id=?';
		return $this->db->query($sql,$teacher_id)->result_array();
	}

	/**
	 * 通过id得到逻辑班信息，包括课程名称
	 * @return [type] [description]
	 */
	function get_logic_class_by_id($logic_class_id)
	{
		$sql='SELECT lc.id,lc.number,lc.teacher_id,lc.type,bl.name as big_lecture_name FROM logic_class as lc,big_lecture as bl WHERE lc.big_lecture_id=bl.id and lc.id=?';
		return $this->db->query($sql,$logic_class_id)->row_array();
	}

	/**
	 * 检查一个学生是否属于一个逻辑班
	 * @param  [type] $student_id     [description]
	 * @param  [type] $logic_class_id [description]
	 * @return [type]                 [description]
	 */
	function check_student_in_logic_class($student_id,$logic_class_id)
	{
		return $this->db->get_where('student_in_logic_class', array('student_id' => $student_id,'logic_class_id'=> $logic_class_id))->row_array();
	}

	/**
	 * 检查一个逻辑班中是否有这门课
	 * @param  [type] $module_id      [description]
	 * @param  [type] $logic_class_id [description]
	 * @return [type]                 [description]
	 */
	function check_module_in_logic_class($module_id,$logic_class_id)
	{
		$this->load->model('module_model');
		$module=$this->module_model->get_by_id($module_id);
		if(!$module) return FALSE;
		$big_lecture_id1=0;
		if($module['type']==0)
			$big_lecture_id1=$module['big_lecture_id'];
		if($module['type']==1)
		{
			$module=$this->module_model->get_by_id($module['parent_id']);
			$big_lecture_id1=$module['big_lecture_id'];
		}

		$sql='SELECT lc.big_lecture_id FROM logic_class as lc where lc.id=?';
		$res=$this->db->query($sql,$logic_class_id)->row_array();
		$big_lecture_id2=$res['big_lecture_id'];
		return ($big_lecture_id1==$big_lecture_id2);
	}

		/**
	 * 根据考点的id查询相关的知识点
	 * @param  [type] $logic_class_id [description]
	 * @return [type]                 [description]
	 */
	function get_relative_student_major($logic_class_id)
	{

		$sql='SELECT m.id,m.name FROM student_in_logic_class as slc,student as s,major as m WHERE slc.student_id=s.id and s.major_id=m.id and slc.logic_class_id=?';
		return $this->db->query($sql,$logic_class_id)->result_array();
	}

}
