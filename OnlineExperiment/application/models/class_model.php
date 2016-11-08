<?php  
/*班级*/
class Class_model extends CI_Model
{

	var $table='class';

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
	 * 查询这个班级的所有学生信息
	 * @param  [type] $class_id [description]
	 * @return [type]           [description]
	 */
	function get_students_from_class_id($class_id)
	{
		$sql='SELECT s.id,s.user_id,s.name,s.student_id,m.name as major_name FROM class as c,student as s,major as m WHERE s.class_id=c.id and m.id=s.major_id and c.id=? ';
		return $this->db->query($sql,$class_id)->result_array();
	}

	/**
	 * 检查班级名称是否已经存在
	 * @return [type] [description]
	 */
	function check_class_name_exist($class_name)
	{
		$sql='SELECT count(*) as count FROM class as c WHERE c.name=?';
		$row=$this->db->query($sql,$class_name)->row_array();
		return ($row['count']>0);
	}

	/**
	 * 通过班级名称，得到班级
	 * @param  [type] $class_name [description]
	 * @return [type]             [description]
	 */
	function get_by_class_name($class_name)
	{
		$sql='SELECT * FROM class WHERE name=?';
		return $this->db->query($sql,$class_name)->row_array();
	}

	/**
	 * 通过逻辑班号，查找这个逻辑班号下的班级
	 * @param  [type] $logic_class_id [description]
	 * @return [type]                 [description]
	 */
	function get_classes_by_logic_class_id($logic_class_id)
	{
		$sql='SELECT DISTINCT c.id,c.name FROM class as c,student as s where s.class_id=c.id and s.id in (SELECT DISTINCT s.id as student_id FROM student as s,student_in_logic_class as silc where silc.student_id=s.id and silc.logic_class_id=?)';
		return $this->db->query($sql,$logic_class_id)->result_array();
	}

	/**
	 * 得到一个班级内有多少个学生选了这门课
	 * @param  [type] $logic_class_id [description]
	 * @param  [type] $class_id       [description]
	 * @return [type]                 [description]
	 */
	function get_select_num_in_class($logic_class_id,$class_id)
	{
		$sql='SELECT count(*) as count FROM student as s, student_in_logic_class as silc  where s.id=silc.student_id and silc.logic_class_id=? and s.class_id=?';
		$result=$this->db->query($sql,array($logic_class_id,$class_id))->row_array();
		return $result['count'];
	}

	/**
	 * 得到一个班级里有多少个学生
	 * @param  [type] $class_id [description]
	 * @return [type]           [description]
	 */
	function get_total_num_in_class($class_id)
	{
		$sql='SELECT count(*) as count FROM student WHERE class_id=?';
		$result=$this->db->query($sql,$class_id)->row_array();
		return $result['count'];
	}

	/**
	 * 通过老师的id得到她交的班级
	 * @param  [type] $teacher_id [description]
	 * @return [type]             [description]
	 */
	function get_classes_by_teacher_id($teacher_id)
	{
		$sql='SELECT DISTINCT c.id,c.name FROM class as c,student as s where s.class_id=c.id and s.id in (SELECT DISTINCT s.id as student_id FROM student as s,student_in_logic_class as silc,logic_class as lc where silc.student_id=s.id and silc.logic_class_id=lc.id and lc.teacher_id=?)';
		return $this->db->query($sql,$teacher_id)->result_array();

	}
}
