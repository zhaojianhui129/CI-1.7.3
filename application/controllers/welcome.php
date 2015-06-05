<?php

class Welcome extends Controller {

	function Welcome()
	{
		parent::Controller();
	}
	
	function index()
	{
	    var_dump($_FILES);exit;
		$this->load->view('welcome_message');
	}
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */