<?php

use Phinx\Migration\AbstractMigration;

class Init extends AbstractMigration
{
    public function change()
    {
		$this->table('bors_log_users_activity', ['id' => false, 'primary_key' => 'id'])
			->addColumn('id', 'integer', ['signed' => false, 'identity' => true, 'limit' => 10])

			->addColumn('user_class_name', 'string')
			->addColumn('user_id', 'integer', ['signed' => false, 'length'=>10])

			->addColumn('view_class_name', 'string')
			->addColumn('view_id', 'integer', ['signed' => false, 'length'=>10])

			->addColumn('action', 'string', ['null' => true])
			->addColumn('action_data', 'text', ['null' => true])

			->addColumn('create_ts', 'timestamp', ['null' => true, 'default' => NULL])
			->addColumn('modify_ts', 'timestamp')

			->create();
    }
}
