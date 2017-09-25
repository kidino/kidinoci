<?php

class M_user_profiles extends MY_Model
{
	public $table = 'user_profiles'; // you MUST mention the table name
	public $primary_key = 'id'; // you MUST mention the primary key
	public function __construct()
	{
        $this->soft_deletes = TRUE;
		$this->return_as = 'array';
		parent::__construct();
	}
}