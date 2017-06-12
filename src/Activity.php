<?php

namespace B2\Log\Users;

class Activity extends \B2\Obj\Mysql
{
	function db_name() { return \B2\Cfg::get('b2.changeable.db'); }
	function table_name() { return 'bors_log_users_activity'; }
	function table_fields()
	{
		return [
			'id',
			'user_class_name',
			'user_id',
			'view_class_name',
			'view_id',
			'action',
			'action_data',
			'create_time' => ['name' => 'UNIX_TIMESTAMP(`create_ts`)'],
			'modify_time' => ['name' => 'UNIX_TIMESTAMP(`modify_ts`)'],
		];
	}

	static function user_view_register($view)
	{
		if(!$view)
			return;

		if(!\B2\App::main_app()->me()->id())
			return;

		self::create([
			'user_class_name' => \B2\App::main_app()->me()->class_name(),
			'user_id' => \B2\App::main_app()->me()->id(),
			'view_class_name' => $view->class_name(),
			'view_id' => $view->id(),
		]);
	}

	static function user_action_register($object, $data)
	{
		if(!\B2\App::main_app()->me()->id())
			return;

		self::create([
			'user_class_name' => \B2\App::main_app()->me()->class_name(),
			'user_id' => \B2\App::main_app()->me()->id(),
			'view_class_name' => $object->class_name(),
			'view_id' => $object->id(),
			'action' => @$data['act'],
			'action_data' => json_encode($data),
		]);
	}
}
