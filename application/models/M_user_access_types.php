<?php

class M_user_access_types extends MY_Model
{
	public $table = 'user_access_types'; // you MUST mention the table name
	public $primary_key = 'acctype_id'; // you MUST mention the primary key
	public function __construct()
	{
        $this->soft_deletes = TRUE;
		$this->return_as = 'array';
		parent::__construct();
	}
}