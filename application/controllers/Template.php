<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Template extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	 
	 
    function __construct(){
    }
    	 
	public function index()
	{
		$this->load->view('template');
	}
	
	function t(){
        parent::__construct();
        $template = $this->uri->segment(2);
        if (($template != '') && ($template != 't') && (!method_exists($this, $template))){
            if (file_exists(APPPATH.'views/'.$template.'.php')) {
                $this->load->view($template);
            }
        }
	}
	
}
