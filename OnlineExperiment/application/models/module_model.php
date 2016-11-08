<?php  
/*考试模块，模型*/
class Module_model extends CI_Model
{

	var $table='module';

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
		$sql='SELECT count(*) as count FROM module WHERE type=0';
		$result=$this->db->query($sql)->row_array();
		return $result['count'];
	}


	/**
	 * 获得所有的条目
	 * @return [type] [description]
	 */
	function get_all()
	{
		$sql='SELECT * FROM module WHERE type=0';
		return $this->db->query($sql)->result_array();
		// $res=$this->db->get($this->table)->result_array();
		// return $res;
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
	 * 删除模块和这个模块相关的内容（中间表）
	 * 如果存在指向这个模块的外键，则删除失败
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	function delete_cascade($id)
	{
		//检查是否存在指向这个模块的外键，report,test_point_in_model,model_in_logic_class
		//report存在外键不能删
		$sql='select * from report as r where r.module_id = ?';
		if(count($this->db->query($sql,array($id))->result_array()))
			return FALSE;
		//question存在不能删
		$sql='select * from question where question.module_id = ?';
		if(count($this->db->query($sql,array($id))->result_array()))
			return FALSE;
		//最后删除module中的条目
		$sql='delete from module where id = ?';
		if($this->db->query($sql,array($id)))
			return TRUE;

	}

	/**
	 * 返回一个模块相关的考点
	 * @param  [type] $module_id [description]
	 * @return [type]            [description]
	 */
	function get_relative_test_point($module_id)
	{
		$sql='
		select tp.id,tp.content 
		from test_point_in_module as tpim,test_point as tp 
		where tpim.test_point_id=tp.id and module_id=?';
		return $this->db->query($sql,$module_id)->result_array();
	}



	/**
	 * 返回一个老师的模块相关的考点
	 * @param  [type] $module_id [description]
	 * @return [type]            [description]
	 */
	function get_relative_test_point_of_teacher($module_id)
	{
		$module=$this->module_model->get_by_id($module_id);
		if(!$module)
			return NULL;
		$real_module_id=$module['id'];
		if($module['parent_id'])
			$real_module_id=$module['parent_id'];
		$sql='
		select tp.id,tp.content 
		from test_point_in_module as tpim,test_point as tp 
		where tpim.test_point_id=tp.id and module_id=?';
		return $this->db->query($sql,$real_module_id)->result_array();
	}

	/**
	 * 删除一个模块相关的考点
	 * @param  [type] $module_id [description]
	 * @return [type]            [description]
	 */
	function delete_relative_test_point($module_id)
	{
		$sql='delete from test_point_in_module where module_id = ?';
		return $this->db->query($sql,array($module_id));
	}

	/**
	 * 为模块添加相关的考点
	 * @param [type] $relative_test_points [description]
	 */
	function add_relative_test_point($module_id, $relative_test_points)
	{
		foreach ($relative_test_points as $test_point_id ) {
			$relation = array(
				'module_id' => $module_id,
				'test_point_id' => $test_point_id
				 );
			if(!$this->db->insert('test_point_in_module',$relation))
				return FALSE;
		}
		return TRUE;
	}

	/**
	 * 删除一个模块相关的课程
	 * @param  [type] $module_id [description]
	 * @return [type]            [description]
	 */
	function delete_relative_big_lectures($module_id)
	{
		$sql='delete from module_in_big_lecture where module_id = ?';
		return $this->db->query($sql,array($module_id));
	}

	/**
	 * 为模块添加相关的课程
	 * @param [type] $relative_test_points [description]
	 */
	function add_relative_big_lectures($module_id, $relative_big_lectures)
	{
		foreach ($relative_big_lectures as $big_lecture_id ) {
			$relation = array(
				'module_id' => $module_id,
				'big_lecture_id' => $big_lecture_id
				 );
			if(!$this->db->insert('module_in_big_lecture',$relation))
				return FALSE;
		}
		return TRUE;
	}
	


	/**
	 * 通过老师的id得到老师相关的课程
	 * @return [type] [description]
	 */
	function get_modules_by_teacher_id($teacher_id)
	{
		$sql='select distinct m.id,m.name,m.time_limit,m.type,m.big_lecture_id,bl.name as big_lecture_name 
from module as m,logic_class as lc,big_lecture as bl 
where m.big_lecture_id=bl.id and lc.big_lecture_id=bl.id and lc.teacher_id=?';
		return $this->db->query($sql,$teacher_id)->result_array();
	}

	/**
	 * 通过老师的id得到老师相关的课程,包括系统的模块
	 * @return [type] [description]
	 */
	function get_all_modules_by_teacher_id($teacher_id)
	{
		$sql='SELECT * FROM module WHERE type=0  union SELECT * FROM module as m where m.teacher_id=?';
		return $this->db->query($sql,array($teacher_id,$teacher_id))->result_array();
	}

	/**
	 * 通过id返回模块，包含课程信息
	 * @return [type] [description]
	 */
	function get_module_by_id($module_id)
	{
		$module=$this->module_model->get_by_id($module_id);
		if(!$module) return NULL;
		if($module['type']==0) 
		{
			$sql="SELECT m.id,m.name,m.time_limit,m.type,m.parent_id,m.teacher_id,m.module_sort,bl.name as big_lecture_name FROM module as m,big_lecture as bl WHERE m.big_lecture_id=bl.id and m.id=?";
			return $this->db->query($sql,$module_id)->row_array();
		}
		else
		{
			$parent_module=$this->module_model->get_by_id($module['parent_id']);
			if(!$parent_module) return NULL;
			$sql="SELECT m.id,m.name,m.time_limit,m.type,m.parent_id,m.teacher_id,m.module_sort,bl.name as big_lecture_name FROM module as m,big_lecture as bl WHERE bl.id=? and m.id=?";
			return $this->db->query($sql,array($parent_module['big_lecture_id'],$module_id))->row_array();
		}
		
	}

	/**
	 * 返回所有的模块，包含大类的名称
	 * @return [type] [description]
	 */
	function get_all_with_big_lecture_name()
	{
		$sql='SELECT m.id,m.name,m.big_lecture_id as big_lecture_id,bl.name as big_lecture_name FROM module as m,big_lecture as bl WHERE m.big_lecture_id=bl.id and type=0';
		return $this->db->query($sql)->result_array();		
	}
	

	/**
	 * 通过module_id返回test_point信息
	 * @param  [type] $module_id [description]
	 * @return [type]            [description]
	 */
	function get_test_point($module_id)
	{
		return $this->db->get_where('test_point_in_module', array('module_id' => $module_id ))->result_array();
	}
	
	/**
	 * 通过big_lecture_id返回module信息
	 * @param  [type] $big_lecture_id [description]
	 * @return [type]            [description]
	 */
	function get_module_in_logic_class($big_lecture_id)
	{
		$sql="SELECT m.id as id,m.name as name,m.time_limit as time_limit,m.type as type,m.parent_id as parent_id,m.teacher_id as teacher_id,m.big_lecture_id as big_lecture_id,m.module_sort as module_sort,bl.name as big_lecture_name FROM module as m,big_lecture as bl WHERE m.big_lecture_id=bl.id and bl.id=? ORDER BY module_sort ASC";
		return $this->db->query($sql,$big_lecture_id)->result_array();
	}

	/**
	 * 通过module_id返回test_point信息
	 * @param  [type] $module_id [description]
	 * @return [type]            [description]
	 */
	function get_module_type_1_parent_teacher($parent_id,$teacher_id)
	{
		return $this->db->get_where($this->table, array('type'=>'1','parent_id' => $parent_id,'teacher_id' => $teacher_id ))->result_array();
	}

	/**
	 * 通过大课程id得到所有的实验模块
	 * @return [type] [description]
	 */
	function get_modules_by_big_lecture_id($big_lecture_id)
	{
		$sql='SELECT * FROM module WHERE big_lecture_id=? ORDER BY module_sort ASC';
		return $this->db->query($sql,$big_lecture_id)->result_array();
	}

	/**
	 * 返回数据表总条目个数
	 * @return [type] [description]
	 */
	function get_module_count_by_big_lecture_id($big_lecture_id)
	{
		$sql='SELECT count(*) as count FROM module WHERE big_lecture_id=?';
		$result=$this->db->query($sql,$big_lecture_id)->row_array();
		return $result['count'];
	}




}
