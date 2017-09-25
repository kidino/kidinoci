<?php

class Userlib {
	
	function __construct()
	{
		$this->ci =& get_instance();
		$this->ci->load->model('m_users');
		$this->ci->load->model('m_user_profiles');
	}
	
	function _create_user_profile($user_id){
		$this->ci->db->insert('user_profiles', array(
			'user_id' => $user_id
		));
		
		return $this->ci->db->insert_id();

	}
	
	function password_field($value, $primary_key){
		return '<input id="field-cpassword" class="form-control" name="cpassword" type="password" value="">	
		&nbsp; <em>only enter to update</em>';
	}
	
	function _get_user($active_tab){
		
		if ($active_tab == 'user') {
			$this->ci->data['user'] = $this->ci->m_users->get($this->ci->uri->segment(4));
			$this->ci->data['user_profile'] = $this->ci->m_user_profiles->where(array('user_id' => $this->ci->data['user']['id']))->get();			
		} else {
			$this->ci->data['user_profile'] = $this->ci->m_user_profiles->get($this->ci->uri->segment(4));
			if (!$this->ci->data['user_profile']) {
				redirect('users');
			} else {
				$this->ci->data['user'] = $this->ci->m_users->get($this->ci->data['user_profile']['user_id']);
			}
		}
		
		if (!$this->ci->data['user_profile']) {
			$profile_id = $this->ci->_create_user_profile($this->ci->data['user']['id']);
			$this->ci->data['user_profile'] = $this->ci->m_user_profiles->get($profile_id);
		}
	}
	
	function _user_tab($active_tab, $tab = 'user_tab'){
		$this->ci->data['gc_tab'] = $tab;
		$this->ci->data['active_tab'] = $active_tab;
		$this->ci->load->model('m_users');
		$this->ci->load->model('m_user_profiles');

		$this->_get_user($active_tab);
	}

}