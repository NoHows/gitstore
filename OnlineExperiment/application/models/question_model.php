<?php  
/*考点模型*/
class Question_model extends CI_Model
{

	var $table='question';

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
	 * 得到所有问题，包括问题指向的考点的内容
	 * @return [type] [description]
	 */
	function get_all_with_test_point()
	{
		$sql='select q.id, q.number, substr(q.content_main,1,25) as content_main,substr(tp.content,1,25) as test_point_content from question as q , test_point tp where q.test_point_id=tp.id';
		return $this->db->query($sql)->result_array();
	}

	/**
	 * 得到所有问题，包括问题指向的实验的内容
	 * @return [type] [description]
	 */
	function get_all_with_module()
	{
		$sql='select q.id, q.number, substr(q.content_main,1,25) as content_main,substr(m.name,1,25) as module_name from question as q , module as m where q.module_id=m.id';
		return $this->db->query($sql)->result_array();
	}

	function get_all_questions_by_offset($limit,$offest)
	{
		$sql='select q.id, q.number, substr(q.content_main,1,25) as content_main,substr(m.name,1,25) as module_name from question as q , module as m where q.module_id=m.id LIMIT ? OFFSET ?';
		return $this->db->query($sql,array($limit,$offest))->result_array();
	}

	
	/**
	 * 得到和问题相关的知识点
	 * @param  [type] $question_id [description]
	 * @return [type]              [description]
	 */
	function get_relative_knowledge_points($question_id)
	{
		// $question=$this->get_by_id($question_id);
		// if(!$question) return NULL;
		// //得到和考点相关的知识点
		// $this->load->model('test_point_model');
		// return $this->test_point_model->

		$sql='select kp.id,kp.content,kp.explanation,kp.picture from knowledge_point as kp,question_in_knowledge_point as qikp where kp.id=qikp.knowledge_point_id and qikp.question_id=?';
		return $this->db->query($sql,$question_id)->result_array();
	}

	/**
	 * 连带删除一个题目的内容
	 * @param  [type] $question_id [description]
	 * @return [type]              [description]
	 */
	function delete_cascade($question_id)
	{
		//有question_in_report引用不能删
		$sql='select * from question_in_report as qir where qir.question_id = ?';
		if(count($this->db->query($sql,array($question_id))->result_array()))
			return FALSE;
		//删除问题
		$sql='delete from question where id = ?';
		if($this->db->query($sql,array($question_id)))
			return TRUE;
	}

	/**
	 * 删除一个问题相关的图片在数据库中的记录
	 * @param  [type] $question_id [description]
	 * @return [type]              [description]
	 */
	function delete_relative_pictures($question_id)
	{
		$sql='delete from picture where id = ?';
		$question=$this->get_by_id($question_id);
		if(!$question) return FALSE;

		$picture_main_id=$question['picture_main_id'];
		$picture_1_id=$question['picture_1_id'];
		$picture_2_id=$question['picture_2_id'];
		$picture_3_id=$question['picture_3_id'];
		$picture_4_id=$question['picture_4_id'];

		$question['picture_main_id']=NULL;
		$question['picture_1_id']=NULL;
		$question['picture_2_id']=NULL;
		$question['picture_3_id']=NULL;
		$question['picture_4_id']=NULL;

		if(!$this->update($question['id'],$question))
			return FALSE;

		if($picture_main_id)
			if(!$this->db->query($sql,array($picture_main_id)))
				return FALSE;

		if($picture_1_id)
			if(!$this->db->query($sql,array($picture_1_id)))
				return FALSE;

		if($picture_2_id)
			if(!$this->db->query($sql,array($picture_2_id)))
				return FALSE;
		if($picture_3_id)
			if(!$this->db->query($sql,array($picture_3_id)))
				return FALSE;
		if($picture_4_id)
			if(!$this->db->query($sql,array($picture_4_id)))
				return FALSE;
		
		
		return TRUE;
	}

	/**
	 * 添加知识点和问题的关系
	 * @param [type] $question_in_knowledge_point [description]
	 */
	function add_knowledge_point_relation($question_in_knowledge_point)
	{
		return	$this->db->insert('question_in_knowledge_point',$question_in_knowledge_point);
	}

	/**
	 * 删除和这个问题相关的知识点的关联关系
	 * @param  [type] $question_id [description]
	 * @return [type]              [description]
	 */
	function delete_knowledge_point_relation($question_id)
	{
		$sql='delete from question_in_knowledge_point where question_id= ?';
		return $this->db->query($sql,array($question_id));
	}

	/**
	 * 通过test_point_id返回条目
	 * @param  [type] $test_point_id [description]
	 * @return [type]                [description]
	 */
	function get_by_module_id($module_id)
	{
		return $this->db->get_where($this->table, array('module_id' => $module_id ))->result_array();
	}


}

