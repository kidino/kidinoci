<?php

class M_user_group_access extends MY_Model
{
	public $table = 'user_group_access'; // you MUST mention the table name
	public $primary_key = 'group_access_id'; // you MUST mention the primary key
	public function __construct()
	{
        $this->soft_deletes = TRUE;
		$this->return_as = 'array';
		parent::__construct();
	}
}