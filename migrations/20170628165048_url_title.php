<?php

use Phinx\Migration\AbstractMigration;

class UrlTitle extends AbstractMigration
{
    public function change()
    {
		$table = $this->table('bors_log_users_activity')
			->addColumn('view_url', 'string', ['null' => true, 'after' => 'view_id'])
			->addColumn('view_title', 'string', ['null' => true, 'after' => 'view_id'])
			->save();
    }
}
