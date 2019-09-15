<?php

///// Project Activity Types key
/// 1 => Priority Changed
/// 2 => Status Changed
/// 3 => New User invited
/// 4 => Removed invited User
class StaticArray
{
	public static $project_status_arr = [
		'1' =>  'In progress',
        '2' =>  'Completed',
        '3' =>  'Closed Incompleted',
        '4' =>  'Cancelled',
        '5' =>  'On Hold',
	];

	public static $project_priority_arr = [
		'1'=>'Critical',
		'2'=>'High',
        '3'=>'Medium',
        '4'=>'Low'
	];

	public static $image_extensions_arr = ['jpg','jpeg','png','bmp','gif'];
	//  'pdf'  => 'pdf',


}