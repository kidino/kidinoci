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
		
		//$this->gc->set_theme('datatables');
		//$this->gc->unset_jquery();
		//$this->gc->unset_bootstrap();
		
		$this->base_data();

		$this->data['the_table'] = $this->gc->get_table_name();
		
		if ($this->_field_exists($this->data['the_table'], 'deleted_at')) {
			$this->gc->where($this->data['the_table'].'.deleted_at is', ' null', false);
		}
		
		$this->hide_fields();
		
		if (count($this->unset_columns) > 0) {
			$this->gc->unset_columns($this->unset_columns);
		}

		//$this->gc->callback_before_upload(array($this,'before_upload_callback'));

		$this->gc->callback_before_update(array($this,'before_update_callback'));
		$this->gc->callback_after_update(array($this,'after_update_callback'));
		
		$this->gc->callback_before_insert(array($this,'before_insert_callback'));
		$this->gc->callback_after_insert(array($this, 'after_insert_callback'));
		
		$output = $this->gc->render();
		$this->data = array_merge($this->data, (array)$output);
		$this->load->view('gc', $this->data);
	}
	
	function before_update_callback($post_array, $primary_key) {
		foreach($this->before_update_funcs as $func) {
			if (method_exists($this, $func)){
				$post_array = $this->{$func}($post_array, $primary_key);
			} 
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
				$post_array = $this->{$func}($post_array, $primary_key);
			} 
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
		$res = $this->db->query("SHOW COLUMNS FROM $tablename LIKE '$colname'");
		$r = $res->num_rows();
		return ($r > 0);
	}
	
	function hide_fields() {
		
		$hide_fields = array_merge($this->hide_fields, array(
			'deleted_at','created_at','createdDate','modifiedDate','createdBy',
			'updated_at','modifiedBy','hits','viewCount','ifcategorycode2',
			'ifcategorycode3','ifcategorycode4','ifcategorycode5','ifcategorycode6',
			'ifcategorycode7','ifcategorycode8','ifcategorycode9','ifcategorycode10',
			'ifcategoryCode','views','hits','viewCount','ifcategoryId'
		));

		foreach($hide_fields as $f){
			//if ($this->_field_exists($this->data['the_table'], $f)) {
				$this->gc->change_field_type($f, 'invisible');
				$this->unset_columns[] = $f;
			//}
		}
	}

}


