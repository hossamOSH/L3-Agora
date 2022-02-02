<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require(FCPATH."application\models\Api.php");


class Controller extends CI_Controller {

	/**
	 * Api
	 *
	 * @var	Api
	 */
	public $api;
   public $data;

   public function __construct()
   {
      parent::__construct();
      $this->load->helper('url');
      $this->api=new Api();
      $this->data['configname']= $this->api->get_config_name();
      $this->data['grpname']= $this->api->get_grp_name();
   }

   public function accueil(){
      $this->load->view('accueil',$this->data);
  }


  public function conf($id_conf){
   $this->data['grps']=$this->api->get_grps($id_conf);
   $this->data['idc']=$id_conf;
   $this->load->view('groupes',$this->data);
   }


   public function props($id_grp){
      $this->data['confname']=$this->api->get_conf_from_grp($id_grp);
      $this->data['grps']=$this->api->get_grp_from_id($id_grp);
      $this->data['props']=$this->api->get_props_from_grp($id_grp);
      $this->data['idg']=$id_grp;
      $this->data['confid']=$this->api->get_confid_from_grp($id_grp);
      $this->load->view('vue1',$this->data);
   }


   public function form_ajout($idg){
      $this->data['idg']=$idg;
      $this->load->view('vue2',$this->data);
   }

   public function ajout_proposition(){
      $texte=$this->input->post('texte_prop');
      $idg=$this->input->post('id');
      $this->api->ajout_proposition($texte,$idg);
      redirect('/controller/props/'.$idg.'');
   }



   public function delete_prop($idp,$idg){
      $this->api->delete_prop($idp,$idg);
      redirect('/controller/props/'.$idg.'');
   }



   public function edit_prop($id){
      $this->data['prop']=$this->api->get_prop($id);
      $this->data['comms']=$this->api->get_comms($id);
      $this->data['idg']=$this->api->get_grp_from_prop($id);
      $this->load->view('vue3',$this->data);
   }



   public function edit_proposition_name(){
      $name=$this->input->post('texte_prop');
      $id=$this->input->post('id');
      $this->api->edit_proposition_name($name,$id);
      redirect('/controller/edit_prop/'.$id.'');

   }

   public function edit_proposition_avis(){
      $avis=$this->input->post('texte_avis');
      $id=$this->input->post('id');
      $this->api->edit_proposition_avis($avis,$id);
      redirect('/controller/edit_prop/'.$id.'');

   }

   public function add_com(){
      
         if(isset($_POST['submitted'])){
      $texte=$this->input->post('texte_com');
      $id=$this->input->post('id');
      $this->api->add_com($texte,$id);
      redirect('/controller/edit_prop/'.$id.'');
      }

   }



   public function add_rep(){
      if(isset($_POST['submit2'])){

                  $reponse=$this->input->post('texte_rep');
                  $idc=$this->input->post('idc');
                   $s=$this->input->post('etat');
                   $id=$this->input->post('id');
                  if($s=="1"){
                     $etat_com=1;
                     $this->api->add_rep($etat_com,$reponse,$idc);
                     redirect('/controller/edit_prop/'.$id.'');
                               }
                  else if($s=="0"){
                    $etat_com=0;
                    $this->api->add_rep($etat_com,$reponse,$idc);
                    redirect('/controller/edit_prop/'.$id.'');
                  }


                 
                  
            }
   }



   public function delete_com($idp,$idcom){
      $this->api->delete_com($idp,$idcom);
      redirect('/controller/edit_prop/'.$idp.'');
   }

     

}
