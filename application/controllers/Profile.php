<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Profile extends Loggedin_Controller
{
	function __construct() {
		parent::__construct();
		
		$this->load->helper(array('form', 'url'));
		$this->load->library('userlib');
		$this->load->library('form_validation');

	}

	function index() {
		if ($this->tank_auth->get_user_id() != $this->uri->segment(4))
		{
			redirect('profile/index/edit/'.$this->tank_auth->get_user_id());
		}
		
		//$this->_load_view('users');
		$this->data['page_title'] = 'Profile';
		$this->load->library('grocery_CRUD',null,'gc');
		
		$this->gc->set_table('users');
		$this->gc->set_subject('User', 'Users');
		$this->gc->unset_list();
		$this->gc->unset_add();
		$this->gc->unset_back_to_list();
		
		if ($this->uri->segment(3) == 'edit') {
			$this->userlib->_user_tab('user', 'profile_tab');
		}		
		
		$this->load->model('m_user_groups');
		$ggroup = $this->m_user_groups->get_all();
		
		$groups = array();
		foreach($ggroup as $g) {
			$groups[$g['group_id']] = $g['name'];
		}
		
		$this->gc->required_fields('username','email','fullname');

		
		$this->gc->field_type('groups','multiselect',$groups);
		$this->gc->edit_fields('email','username','fullname');
		
		$this->hide_fields[] = 'password';
		
		$this->gc->unique_fields(array('email','username'));
			
		$this->_gc_view();
	}
	
	function user_profile() {
		
		if (($this->tank_auth->get_user_id() != $this->uri->segment(4))
		&& ($this->uri->segment(3) != 'upload_file')) // allow for photo upload
		{
			redirect('profile/index/edit/'.$this->tank_auth->get_user_id());
		}
		
		if ($this->uri->segment(3) == '') {
			redirect('profile');
		}
		
		$this->data['page_title'] = 'Profile';
		$this->load->library('grocery_CRUD',null,'gc');
		
		$this->gc->set_table('user_profiles');
		$this->gc->set_subject('User', 'Users');
		$this->gc->unset_edit_fields('user_id');
		$this->gc->unset_add_fields('user_id');
		$this->gc->unset_list();
		$this->gc->unset_add();
		$this->gc->unset_back_to_list();
		
		$this->gc->set_field_upload('photo','assets/avatar',"jpg|png|gif");

		$this->gc->callback_after_upload(array($this,'resize_avatar_photo'));
		
		if ($this->uri->segment(3) == 'edit') {
			$this->userlib->_user_tab('profile','profile_tab');
		}		

		$this->_gc_view();
	}
	
	function resize_avatar_photo($uploader_response,$field_info, $files_to_upload) {
		$this->load->library('image_moo');

		//Is only one file uploaded so it ok to use it with $uploader_response[0].
		$file_uploaded = $field_info->upload_path.'/'.$uploader_response[0]->name; 

		$this->image_moo->load($file_uploaded)
							    ->resize_crop(200,200)		
							    ->save($file_uploaded, true);
			
	}
	
	function password() {
		
		$this->form_validation->set_rules('old_password', 'Old Password', 'trim|required');
		$this->form_validation->set_rules('new_password', 'New Password', 'trim|required|min_length['.$this->config->item('password_min_length', 'tank_auth').']|max_length['.$this->config->item('password_max_length', 'tank_auth').']|alpha_dash');
		$this->form_validation->set_rules('confirm_new_password', 'Confirm new Password', 'trim|required|matches[new_password]');

		$data['errors'] = array();

		if ($this->form_validation->run()) {								// validation ok
			if ($this->tank_auth->change_password(
				$this->form_validation->set_value('old_password'),
				$this->form_validation->set_value('new_password'))) {	// success
				$this->data['message'] = $this->lang->line('auth_message_password_changed');

			} else {														// fail
				$errors = $this->tank_auth->get_error_message();
				foreach ($errors as $k => $v)	$data['errors'][$k] = $this->lang->line($v);
			}
		}
		$this->data = array_merge($this->data, $data);
		
		$this->load->helper('form');
		$this->_load_view('auth/change_password_form');		
	}
}
