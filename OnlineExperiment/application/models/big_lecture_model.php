<?php  
/*课程模型*/
class Big_lecture_model extends CI_Model
{

	var $table='big_lecture';

	function __construct()
	{
		parent::__construct();
		
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
	 * 返回数据表总条目个数
	 * @return [type] [description]
	 */
	function count_all()
	{
		return $this->db->count_all($this->table);
	}

	/**
	 * 通过id得到相关的模块的内容
	 * @param  [type] $big_lecture_id [description]
	 * @return [type]                 [description]
	 */
	function get_relative_modules($big_lecture_id)
	{
		$sql='SELECT * FROM module WHERE big_lecture_id=?';
		return $this->db->query($sql,$big_lecture_id)->result_array();
	}

	/**
	 * 检查课程是否存在
	 * @return [type] [description]
	 */
	function check_big_lecture_exist($big_lecture_name)
	{
		$sql='SELECT count(*) as count FROM big_lecture WHERE name=?';
		$res=$this->db->query($sql,$big_lecture_name)->row_array();
		return $res['count']>0?TRUE:FALSE;
	}
}