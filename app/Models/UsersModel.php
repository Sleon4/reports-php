<?php

namespace App\Models;

use Database\Class\LionDatabase\Users;
use LionDatabase\Drivers\MySQL\MySQL as DB;
use LionDatabase\Drivers\MySQL\Schema;

class UsersModel {

	public function __construct() {
		
	}

	public function readUsersDB() {
		return DB::table('users')
            ->select()
            ->fetchMode(\PDO::FETCH_CLASS, Users::class)
            ->getAll();
	}

}
