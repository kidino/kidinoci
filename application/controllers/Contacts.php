<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Contacts extends Loggedin_Controller
{
	function __construct() {
		parent::__construct();

	}

	function index() {
		$this->data['page_title'] = 'Contacts';
		$this->load->library('grocery_CRUD',null,'gc');
		
		$this->gc->set_table('contacts');
		$this->gc->set_subject('Contact', 'Contacts');
		$this->gc->where(array('user_id' => $this->tank_auth->get_user_id()));
		
		$this->gc->field_type('user_id', 'hidden');
		
		$this->gc->set_rules('email', 'Email', 'trim|valid_email');
		$this->gc->set_rules('fullname', 'Full Name', 'required');
		
		$this->unset_columns[] = 'address1';
		$this->unset_columns[] = 'address2';
		$this->unset_columns[] = 'postcode';
		$this->unset_columns[] = 'user_id';
		
		$this->before_insert_funcs[] = 'contacts_user_id';
		
		$this->gc->set_field_upload('photo','assets/avatar',"jpg|png|gif");

		$this->gc->callback_after_upload(array($this,'resize_contact_photo'));		
		
		$this->_gc_view();
	}
	
	function resize_contact_photo($uploader_response,$field_info, $files_to_upload) {
		$this->load->library('image_moo');

		//Is only one file uploaded so it ok to use it with $uploader_response[0].
		$file_uploaded = $field_info->upload_path.'/'.$uploader_response[0]->name; 

		$this->image_moo->load($file_uploaded)
							    ->resize_crop(300,300)		
							    ->save($file_uploaded, true);
			
	}

	
	function contacts_user_id($post_array){
		$post_array['user_id'] = $this->tank_auth->get_user_id();
		return $post_array;
	}
}
