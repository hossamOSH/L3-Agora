<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require("C:\wamp64\www\Test-merc\application\models\Manage_DB.php");
require("C:\wamp64\www\Test-merc\application\controllers\Computation.php");

class ApiCompute extends CI_Controller{ 

    /**
	 * Manage_DB
	 *
	 * @var	Manage_DB
	 */
	public $mdb;
 
    /**
	 * Computation
	 *
	 * @var	Computation
	 */
	public $comp;

    public $result;
    
    public function __construct(){
        parent::__construct();
        $this->load->library('form_validation');
        $this->mdb=new Manage_DB();
        $this->comp=new Computation();
    }

    public function get_data(){
        return $this->mdb->GetListAvalues();
    }

    public function add($v1,$v2){
        return $this->comp->add($v1,$v2);
    }

    public function mult($v1,$v2){
        return $this->comp->mult($v1,$v2);
    }

    public function square($v1,$v2){
        return $this->comp->square($v1,$v2);
    }
}
?>