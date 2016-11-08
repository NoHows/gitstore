<?php  
/*成绩单，模型
针对一次考试module
*/
class Report_model extends CI_Model
{

	var $table='report';

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
	 * 查询某条成绩记录
	 * @param  [type] $student_id     [description]
	 * @param  [type] $module_id      [description]
	 * @param  [type] $logic_class_id [description]
	 * @return [type]                 [description]
	 */
	function get_grade($student_id,$module_id,$logic_class_id)
	{
		$sql='SELECT * FROM report WHERE student_id=? and module_id=? and logic_class_id=?';
		$res=$this->db->query($sql,array($student_id,$module_id,$logic_class_id))->row_array();
		if($res)
			return $res['grades'];
		else 
			return NULL;
	}

	/**
	 * 通过module_id和student_id返回未提交的条目
	 * @param  [type] $module_id,$student_id [description]
	 * @return [type]                        [description]
	 */
	function get_by_module_student_logic_class($module_id,$student_id,$logic_class_id)
	{
		return $this->db->get_where($this->table, array('module_id' => $module_id,'student_id' => $student_id,'logic_class_id' => $logic_class_id,'state' => 0 ))->row_array();
	}

	/**
	 * 通过module_id和student_id返回条目个数
	 * @param  [type] $module_id,$student_id [description]
	 * @return [type]                        [description]
	 */
	function get_count_by_module_student_logic_class($student_id,$module_id,$logic_class_id)
	{
		$sql='SELECT count(*) as count FROM report WHERE student_id=? and module_id=? and logic_class_id=?';
		$res=$this->db->query($sql,array($student_id,$module_id,$logic_class_id))->row_array();
		return $res['count'];
	}
	/**
	 * 通过module_id和student_id和logic_class_id返回全部条目
	 * @param  [type] $module_id,$student_id,$logic_class_id [description]
	 * @return [type]                        [description]
	 */
	function get_all_reports_of_student_module_logic_class($student_id,$module_id,$logic_class_id)
	{
		return $this->db->get_where($this->table, array('student_id' => $student_id,'module_id' => $module_id,'logic_class_id' => $logic_class_id ))->result_array();
	}
	/**
	 * 向question_in_report表中添加一个条目
	 * @param [type] $item [description]
	 */
	function add_question_in_report($item)
	{
		return	$this->db->insert('question_in_report',$item);
	}

	/**
	 * 通过report_id从question_in_report表中返回条目
	 * @param  [type] $report_id [description]
	 * @return [type]            [description]
	 */
	function get_from_question_in_report($report_id)
	{
		return $this->db->get_where('question_in_report', array('report_id' => $report_id ))->result_array();
	}

	/**
	 * 通过reportid,questionid返回question_in_report
	 * @param  [type] $report_id   [description]
	 * @param  [type] $question_id [description]
	 * @return [type]              [description]
	 */
	function get_question_in_report($report_id,$question_id)
	{
		return $this->db->get_where('question_in_report', array('report_id' => $report_id,'question_id'=> $question_id ))->row_array();
	}

	/**
	 * 更新question_in_report内容
	 * @param  [type] $id   [description]
	 * @param  [type] $item [description]
	 * @return [type]       [description]
	 */
	function update_question_in_report($id,$item)
	{
		$this->db->where('id', $id);
		return $this->db->update('question_in_report',$item);
	}

	function get_max_grade_by_module_student_logic_class($student_id,$module_id,$logic_class_id)
	{
		$sql='SELECT max(grades) as max_grade FROM report WHERE student_id=? and module_id=? and logic_class_id=?';
		$res=$this->db->query($sql,array($student_id,$module_id,$logic_class_id))->row_array();
		return $res['max_grade'];
	}

	function get_min_grade_by_module_student_logic_class($student_id,$module_id,$logic_class_id)
	{
		$sql='SELECT min(grades) as min_grade FROM report WHERE student_id=? and module_id=? and logic_class_id=?';
		$res=$this->db->query($sql,array($student_id,$module_id,$logic_class_id))->row_array();
		return $res['min_grade'];
	}

}
