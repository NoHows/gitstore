<?php  
/*用户模型*/
class User_model extends CI_Model
{

	var $username;

	var $password;

	var $role_id;

	var $table='user';


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


	function __construct()
	{
		parent::__construct();
	}

	//查询是否是合法的用户名密码组合
	function check_user_valid($uname,$pwd)
	{
		$query = $this->db->get_where('user',array('username' => $uname,'password' => md5($pwd)));
		if($row=$query->row_array())
			return $row;
		return array();
	}

	//返回用户的角色
	function get_role($user)
	{
		if($user['role_id'] == 1) 
			return 'admin';
		else if($user['role_id'] == 2)
			return 'teacher';
		else if($user['role_id'] == 3)
			return 'student';
		else 
			return 'false';
	}

	/**
	 * 通过用户名返回user
	 * @param  [type] $username [description]
	 * @return [type]           [description]
	 */
	function get_by_username($username)
	{
		return $this->db->get_where($this->table, array('username' => $username ))->row_array();
	}

	/**
	 * 查看数据库中是否已经有这个用户名
	 * @param  [type] $username [description]
	 * @return [type]           [description]
	 */
	function username_exist($username)
	{
		$sql='SELECT count(*) as count FROM student WHERE student.student_id =?';
		$row_student=$this->db->query($sql,$username)->row_array();
		$sql='SELECT count(*) as count FROM user WHERE user.username =?';
		$row_user=$this->db->query($sql,$username)->row_array();
		return ($row_student['count']>0||$row_user['count']>0);
	}
}
