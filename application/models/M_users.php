<?php

class M_users extends MY_Model
{
	public $table = 'users'; // you MUST mention the table name
	public $primary_key = 'id'; // you MUST mention the primary key
	public function __construct()
	{
        $this->soft_deletes = TRUE;
		$this->return_as = 'array';
		parent::__construct();
	}
}