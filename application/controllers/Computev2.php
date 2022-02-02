<?php
define('ROOT',dirname(__DIR__));
require("C:\wamp64\www\Test-merc\system\core\Model.php");
require("Computation.php");
require("C:\wamp64\www\Test-merc\application\models\Db_model.php");
require("C:\wamp64\www\Test-merc\application\controllers\Concretectrl.php");


class Computev2 extends CI_controller{

	public $ci;
	protected $v1;
	protected $v2;

	public function __construct(){
		parent::__construct();
		$this->ci = & get_instance();
		$this->load->database();
		$this->load->helper('url');
		$this->load->helper('url_helper');
		$this->load->library('form_validation');
		$this->load->helper('url');
		$v1=$this->input->post('A');
        $v2=$this->input->post('X');
	}

	public function index(){  
        $this->load->view('computev2/front');
     }

//	public function rendering(){  
//		$cont=new Concretectrl;
//		 $data=$this->Get_data();
//		 foreach($data as $row){
//			 echo $row['nb'];
//		 }
//		 $cont->render('computev2/add',['data'=>$data]);
//     }

     public function __init(){
     	$this->v1=0;
     	$this->v2=0;
     }

      public function Get_V1(){
     	return $this->v1;
     }

      public function Get_V2(){
     	return $this->v2;
     }

     public function Get_data(){
     		$query=$this->db->query('SELECT * FROM a ;');
			return $query->result_array();
     }

	public function go($v1=0,$v2=0): int
	{
		$comp=new Computation();
		$this->load->view('computev2/add');
		$result=$comp->add($v1,$v2);
	//	$this->rendering();
		return $result;
	}

}







?>