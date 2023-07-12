<?php

use App\Traits\Framework\Faker;
use LionDatabase\Drivers\MySQL\Schema;

return new class {

	use Faker;

	private string $table = "users";

	public function getMigration(): array {
		return ["type" => "TABLE", "table" => $this->table, "connection" => env->DB_NAME, "index" => null];
	}

	public function execute(): object {
		return Schema::connection(env->DB_NAME)
			->table($this->table, true)
			->create()
			->column('id', ['type' => 'int', 'primary-key' => true, 'lenght' => 11, 'null' => false, 'auto-increment' => true])
			->column('name', ['type' => 'varchar', 'length' => 45, 'null' => false, 'comment' => '', 'default' => ''])
			->column('lastname', ['type' => 'varchar', 'length' => 45, 'null' => false, 'comment' => '', 'default' => ''])
			->execute();
	}

	public function insert(): array {
		return [
			'columns' => [
				'idusers',
				'users_name',
				'users_lastname',
			],
 			'rows' => [
				[null, self::get()->name(), self::get()->lastName()],
                [null, self::get()->name(), self::get()->lastName()],
                [null, self::get()->name(), self::get()->lastName()],
                [null, self::get()->name(), self::get()->lastName()],
                [null, self::get()->name(), self::get()->lastName()],
                [null, self::get()->name(), self::get()->lastName()],
                [null, self::get()->name(), self::get()->lastName()],
                [null, self::get()->name(), self::get()->lastName()],
                [null, self::get()->name(), self::get()->lastName()],
                [null, self::get()->name(), self::get()->lastName()],
			]
		];
	}

};
