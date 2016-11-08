<?php  
/*专业，模型*/
class Major_model extends CI_Model
{

	var $table='major';

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
	 * 检查专业名称是否已经存在
	 * @return [type] [description]
	 */
	function check_major_name_exist($major_name)
	{
		$sql='SELECT count(*) as count FROM major as m WHERE m.name=?';
		$row=$this->db->query($sql,$major_name)->row_array();
		return ($row['count']>0);
		//return $row;
	}

	/**
	 * 通过专业名称，得到专业
	 * @param  [type] $major_name [description]
	 * @return [type]             [description]
	 */
	function get_by_major_name($major_name)
	{
		$sql='SELECT * FROM major WHERE name=?';
		return $this->db->query($sql,$major_name)->row_array();
	}
}
