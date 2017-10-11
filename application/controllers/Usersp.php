<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Usersp extends Loggedin_Controller
{
	function __construct() {
		parent::__construct();
		
		$this->load->library('userlib');
	}

	function index() {
		
		if (!check_access('admin_users')) {
			redirect('dashboard/invalid');
		}
		
		//$this->_load_view('users');
		$this->data['page_title'] = 'Users';
		$this->load->library('grocery_CRUD',null,'gc');
		
		$this->gc->set_table('users');
		$this->gc->set_subject('User', 'Users');
		$this->gc->columns('email','username', 'activated','banned','last_login','created','modified');
		
		$this->gc->set_rules('email', 'Email', 'trim|required|valid_email');
		
		if ($this->uri->segment(3) == 'add') {		
			$this->gc->set_rules('cpassword', 'Password', 'required|trim|min_length['.$this->config->item('password_min_length', 'tank_auth').']|max_length['.$this->config->item('password_max_length', 'tank_auth').']|alpha_dash');
			$this->gc->set_rules('username', 'Username', 'trim|required|min_length['.$this->config->item('username_min_length', 'tank_auth').']|max_length['.$this->config->item('username_max_length', 'tank_auth').']|alpha_dash');
		} else {
			$this->gc->set_rules('cpassword', 'Password', 'trim|min_length['.$this->config->item('password_min_length', 'tank_auth').']|max_length['.$this->config->item('password_max_length', 'tank_auth').']|alpha_dash');
			$this->gc->set_rules('username', 'Username', 'trim|required|min_length['.$this->config->item('username_min_length', 'tank_auth').']|max_length['.$this->config->item('username_max_length', 'tank_auth').']|alpha_dash');
		}
		
		if ($this->uri->segment(3) == 'edit') {
			$this->userlib->_user_tab('user');
		}		
		
		$this->load->model('m_user_groups');
		$ggroup = $this->m_user_groups->get_all();
		
		$groups = array();
		foreach($ggroup as $g) {
			$groups[$g['group_id']] = $g['name'];
		}
		
		$this->gc->required_fields('username','email','fullname');

		
		$this->gc->field_type('groups','multiselect',$groups);
		$this->gc->edit_fields('email','username', 'fullname','activated','cpassword','is_super','groups','banned','ban_reason','last_ip','last_login','password');
		$this->gc->add_fields('email','username', 'fullname','activated','cpassword','is_super','groups','banned','ban_reason','last_ip','last_login','password');
		
		$this->hide_fields[] = 'password';
		
		$this->gc->callback_field('cpassword',array($this->userlib,'password_field'));
		$this->gc->display_as('cpassword','Password');
		$this->gc->unique_fields(array('email','username'));
			
		$this->before_insert_funcs[] = 'update_user_created';
		$this->before_update_funcs[] = 'update_user_modified';
		
		$this->data['page_title'] = 'Users';
		
		$this->_gc_view();
		
	}
		
	function update_user_created($post_array){
		
		if ($post_array['cpassword'] != '') {
			$hasher = new PasswordHash(
					$this->config->item('phpass_hash_strength', 'tank_auth'),
					$this->config->item('phpass_hash_portable', 'tank_auth'));
			$post_array['password'] = $hasher->HashPassword($post_array['cpassword']);
		}
		
		unset($post_array['cpassword']);

		return $post_array;
	}
	
	function update_user_modified($post_array, $primary_key) {
		if ($post_array['cpassword'] != '') {
			$hasher = new PasswordHash(
					$this->config->item('phpass_hash_strength', 'tank_auth'),
					$this->config->item('phpass_hash_portable', 'tank_auth'));
			$post_array['password'] = $hasher->HashPassword($post_array['cpassword']);
		}
		
		unset($post_array['cpassword']);
		
		$post_array['modified'] = $post_array['updated_at'] = date('Y-m-d H:i:s');
		return $post_array;
	}
	
	function password_field($value, $primary_key){
		return '<input id="field-cpassword" class="form-control" name="cpassword" type="password" value="">	
		&nbsp; <em>only enter to update</em>';
	}
	
	function groups() {
		
		if (!check_access('admin_groups')) {
			redirect('dashboard/invalid');
		}
		
		$this->data['page_title'] = 'User Groups';
		$this->load->library('grocery_CRUD',null,'gc');
		
		$this->gc->set_table('user_groups');
		$this->gc->set_subject('User Group', 'User Groups');
		
		$this->gc->add_action('Access', base_url('assets/grocery_crud/themes/flexigrid/css/images/table_key.png'), 'users/group_access', 'ui-icon-locked');
		
		$this->_gc_view();
	}

	function group_access(){
		
		if (!check_access('admin_group_access')) {
			redirect('dashboard/invalid');
		}
		
		$group_id = $this->uri->segment(3);
		$this->data['access_ids'] = array();
		$this->load->model('m_user_groups');
		$this->load->model('m_user_group_access');
		$this->load->model('m_user_access_types');
		
		$this->data['user_group'] = $this->m_user_groups->get($group_id);
		$this->data['user_access_types'] = $this->m_user_access_types->order_by('code','asc')->get_all();
		$this->data['user_group_access'] = $this->m_user_group_access->where(array('group_id' => $group_id))->get_all();
		
		$this->data['access_ids'] = array();
		$this->data['error'] = false;
		$this->data['success'] = false;
		
		if ($_POST) {
			$insert_data = array();
			foreach($_POST['access_ids'] as $access_id){
				$this->data['access_ids'][] =  $access_id;
				$insert_data[] = array(
					'group_id' => $group_id,
					'acctype_id' => $access_id
				);
			}
			
			if (count($_POST['access_ids']) == 0) {
				$this->data['error'] = true;
			} else {
				$this->db->where(array('group_id' => $group_id))->delete('user_group_access');
				$this->db->insert_batch('user_group_access', $insert_data);
				$this->data['success'] = true;
			}
			
		} else {
			if ($this->data['user_group_access']) {
				foreach($this->data['user_group_access'] as $access_id) {
					$this->data['access_ids'][] =  $access_id['acctype_id'];
				}
			}
		}
		
		$this->_load_view('users_group_access');
		
	}
	
	function access_types() {
		
		if (!check_access('admin_access_types')) {
			redirect('dashboard/invalid');
		}
				
		$this->data['page_title'] = 'Access Types';
		$this->load->library('grocery_CRUD',null,'gc');
		
		$this->gc->set_table('user_access_types');
		$this->gc->set_subject('Access Type', 'Access Types');
		
		$this->_gc_view();
	}

	function user_profile() {
		
		if (!check_access('admin_users')) {
			redirect('dashboard/invalid');
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
			$this->userlib->_user_tab('profile');
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

	
}
