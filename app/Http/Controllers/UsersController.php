<?php

namespace App\Http\Controllers;

use App\Models\UsersModel; 

class UsersController {

	private UsersModel $usersModel;

	public function __construct() {
		$this->usersModel = new UsersModel();
	}

	public function readUsers() {
		return $this->usersModel->readUsersDB();
	}

}
