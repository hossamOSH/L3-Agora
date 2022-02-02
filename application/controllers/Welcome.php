<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	 public function __construct()        
  {                
    parent::__construct();             
    $this->load->helper('url_helper');   
      
  }

	public function index(){
		$this->load->helper('form');
		 $this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		
  		header('Refresh:1; url='.base_url().'index.php/apicompute/mult');
         

            


	}
}
