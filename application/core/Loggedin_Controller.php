<?php

require_once(APPPATH.'libraries/phpass-0.1/PasswordHash.php');

class Loggedin_Controller extends MY_Controller {
	
	var $unset_columns = array();
	var $hide_fields = array();
	var $after_update_funcs = array();
	var $after_insert_funcs = array();
	var $before_update_funcs = array();
	var $before_insert_funcs = array();
	
    function __construct(){
        parent::__construct();
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} 		
		
		$this->data['css_files'][] = base_url('assets/css/font-awesome.css');
    }
	
	private function base_data() {
		if (!isset($this->data['topmenu'])) {
			$this->data['topmenu'] = 'topmenu';
		}
		
		if (!isset($this->data['page_title'])) {
			$this->data['page_title'] = $this->data['appname'];
		} else {
			$this->data['page_title'] =  $this->data['appname'].' - '.$this->data['page_title'];
		}		
	}
	
	protected function _load_view($view) {
		
		$this->base_data();
		
		$this->data['view'] = $view;
		$this->load->view('main_view', $this->data);
	}
	
	protected function _gc_view() {
		
		$this->base_data();

		$this->data['the_table'] = $this->gc->get_table_name();
		
		if ($this->_field_exists($this->data['the_table'], 'deleted_at')) {
			$this->gc->where($this->data['the_table'].'.deleted_at is', ' null', false);
		}
		
		$this->hide_fields();
		
		if (count($this->unset_columns) > 0) {
			$this->gc->unset_columns($this->unset_columns);
		}

		$this->gc->callback_before_update(array($this,'before_update_callback'));
		$this->gc->callback_after_update(array($this,'after_update_callback'));
		
		$this->gc->callback_before_insert(array($this,'before_insert_callback'));
		$this->gc->callback_after_insert(array($this, 'after_insert_callback'));
		
		$this->gc->callback_delete(array($this,'gc_soft_delete'));

		
		$output = $this->gc->render();
		$this->data = array_merge($this->data, (array)$output);
		$this->load->view('gc', $this->data);
	}
	
	function gc_soft_delete($primary_key){
		
		if($this->_field_exists($this->data['the_table'], 'deleted_at') ) {
			return $this->db->update($this->data['the_table'],array('deleted_at' => date('Y-m-d H:i:s')),array($this->gc->get_primary_key() => $primary_key));
		} 
		return $this->db->delete($this->data['the_table'],array($this->gc->get_primary_key() => $primary_key));
	}
	
	function before_update_callback($post_array, $primary_key) {
		foreach($this->before_update_funcs as $func) {
			if (method_exists($this, $func)){
				$post_array = $this->{$func}($post_array, $primary_key);
			} 
		}
		
		if($this->_field_exists($this->data['the_table'],'updated_at')) {
			$post_array['updated_at'] = date('Y-m-d H:i:s');
		}
		
		if($this->_field_exists($this->data['the_table'],'modified')) {
			$post_array['updated_at'] = date('Y-m-d H:i:s');
		}
		
		return $post_array;
	}

	function after_update_callback($post_array,$primary_key) {
		foreach($this->after_update_funcs as $func) {
			if (method_exists($this, $func)){
				$this->{$func}($post_array, $primary_key);
			} 
		}
		return true;
	}

	function before_insert_callback($post_array) {
		foreach($this->before_insert_funcs as $func) {
			if (method_exists($this, $func)){
				$post_array = $this->{$func}($post_array);
			} 
		}
		
		if($this->_field_exists($this->data['the_table'],'created_at')) {
			$post_array['created_at'] = date('Y-m-d H:i:s');
		}
		
		if($this->_field_exists($this->data['the_table'],'created')) {
			$post_array['created'] = date('Y-m-d H:i:s');
		}
		
		return $post_array;
	}

	function after_insert_callback($post_array,$primary_key) {
		foreach($this->after_insert_funcs as $func) {
			if (method_exists($this, $func)){
				$this->{$func}($post_array, $primary_key);
			} 
		}
		
		return true;
	}
	
/*=== GROCERY CRUD HELPER FUNCTIONS ===*/	
	
	function _field_exists( $tablename, $colname ){
		
/*
		Column and table structure doesn't change often, so we cache the result
		for faster access next time. If you just modified a table by adding or
		removing columns (ie to support soft delete), then you may want to delete
		the cache associate with it which is <table name>_<column name>.
		
		You can call the URL:
		http://your_ci_installation/settings/delete_cache/<cache name>
		
		You have to be logged in and have super access to do this.
*/

		$this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
		$colcache = $tablename.'_'.$colname;

		if ( !$column_exists = $this->cache->get($colcache))
		{
			$res = $this->db->query("SHOW COLUMNS FROM $tablename LIKE '$colname'");
			$column_exists = ($res->num_rows() > 0);
			// Save into the cache for 1 year, 31557600 secs in a year
			$this->cache->save($colcache, $column_exists, 31557600 );
		}
		
		return ($column_exists);
	}
	
	function hide_fields() {
		
		$hide_fields = array_merge($this->hide_fields,
			array('deleted_at','created_at','created','deleted_at','modified','updated_at'));

		foreach($hide_fields as $f){
			//if ($this->_field_exists($this->data['the_table'], $f)) {
				$this->gc->change_field_type($f, 'invisible');
				$this->unset_columns[] = $f;
			//}
		}
	}
	
}


