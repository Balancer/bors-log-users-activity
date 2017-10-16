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
			'view_title',
			'view_url',
			'action',
			'action_data',
			'create_time' => ['name' => 'UNIX_TIMESTAMP(`create_ts`)'],
			'modify_time' => ['name' => 'UNIX_TIMESTAMP(`modify_ts`)'],
		];
	}

	function auto_targets()
	{
		return array_merge(parent::auto_targets(), [
			'user' => 'user_class_name(user_id)',
			'view' => 'view_class_name(view_id)',
		]);
	}

	static function user_view_register($view)
	{
		if(!is_object($view))
			return;

		$me = \B2\App::main_app()->me();

		if(!$me || !$me->id() || $me->is_null())
			return;

		self::create([
			'user_class_name' => $me->class_name(),
			'user_id' => $me->id(),
			'view_class_name' => $view->class_name(),
			'view_id' => $view->id(),
			'view_title' => $view->title(),
			'view_url' => $view->coalesce('called_url', 'url'),
		]);
	}

	static function user_action_register($object, $data)
	{
		$me = \B2\App::main_app()->me();

		if(!$me || !$me->id() || $me->is_null())
			return;

		self::create([
			'user_class_name' => $me->class_name(),
			'user_id' => $me->id(),
			'view_class_name' => $object->class_name(),
			'view_id' => $object->id(),
			'action' => @$data['act'],
			'action_data' => json_encode($data),
		]);
	}

	function view_titled_link()
	{
		$view  = $this->view();
		$url   = $this->view_url() ? $this->view_url() : $view->url();
		$title = $this->view_title() ? $this->view_title() : $view->title();

		if(!$title)
			$title = $this->view_class().'('.$this->view_id().')';

		if(!$url)
			return $title;

		return "<a href=\"{$url}\">{$title}</a>";
	}

	function item_list_admin_fields()
	{
		return [
			'ctime' => 'Дата',
			'user()->admin()->titled_link()' => 'Пользователь',
			'view_titled_link' => 'Страница',
			'action' => 'Действие',
		];
	}
}
