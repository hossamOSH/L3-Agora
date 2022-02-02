<?php
class Db_model extends CI_Model { 
     
     public function __construct(){                
          	$this->load->database();  
          	    }    

           public function GetListAvalues(){
        $query = $this->db->query("SELECT * FROM a ;");
        return $query->result_array();
    }       
}
