<?php 
/**
 * 把题号和id相互转换的帮助函数,加上ol后缀避免和ci函数重名
 */

/**
 * 将id装换为题号的帮助函数
 * @param  [int] $id [description]
 * @return [type]     [description]
 */
function id_to_number_ol($id)
{
	$result='0';
	if(is_numeric($id))
	{
		$id=(intval($id));
		if($id<=0)
			return $result;
		else if($id < 10)
			return '000'.$id;
		else if($id < 100)
			return '00'.$id;
		else if($id < 1000)
			return '0'.$id;
		else 
			return (string)$id;
	}
	else
		return '0';
}

/**
 * 将题号转换为id的帮助函数
 * @param  [string] $number [description]
 * @return [type]         [description]
 */
function number_to_id_ol($number)
{
	if(is_numeric($number))
		return intval($number);
	else 
		return 0;
}