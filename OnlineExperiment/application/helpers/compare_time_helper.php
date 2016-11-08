<?php 
/**
 * 比较两个时间的时间差差
 */

function compare_time_of_minute($start,$end)
{
	if(strtotime($start)===false)
		return -1;
	if(strtotime($end)===false)
		return -1;
	$time1=strtotime($start);
	$time2=strtotime($end);
	return (($time2-$time1)/60);
}