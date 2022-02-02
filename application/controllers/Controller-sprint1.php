<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require("C:\wamp64\www\Test-merc\application\models\ApiCompute.php");


class Controller extends CI_Controller {

	/**
	 * ApiCompute
	 *
	 * @var	ApiCompute
	 */
	public $api;

   public $data;

   public function __construct()
   {
      parent::__construct();
      $this->api=new ApiCompute();
      $this->data['nums']= $this->api->get_data();
      $this->data['result']= 0;
      $this->data['v1']= $this->input->get('A');
      $this->data['v2']= $this->input->get('X');
   }

public function index(){
    $this->load->view('computev2/front');
}

public function add_form(){
   $this->load->view('computev2/add',$this->data);
}
public function mult_form(){
   $this->load->view('computev2/mult',$this->data);
}
public function square_form(){
   $this->load->view('computev2/square',$this->data);
}

public function add($v1,$v2){
   $result=$this->api->add($v1,$v2);
   $this->data['result']=$result;
   $this->data['v1']=$v1;
   $this->data['v2']=$v2;
   $this->load->view('computev2/add',$this->data);
}

public function mult($v1,$v2){
   $result=$this->api->mult($v1,$v2);
   $this->data['result']=$result;
   $this->data['v1']=$v1;
   $this->data['v2']=$v2;
   $this->load->view('computev2/mult',$this->data);
}

public function square($v1,$v2){
   $result=$this->api->square($v1,$v2);
   $this->data['result']=$result;
   $this->data['v1']=$v1;
   $this->data['v2']=$v2;
   $this->load->view('computev2/square',$this->data);
}

}
?>