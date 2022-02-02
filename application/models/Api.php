<?php
defined('BASEPATH') or exit('No direct script access allowed');

require(FCPATH . "application\models\Manage_DB.php");

class Api
{

    /**
     * Manage_DB
     *
     * @var	Manage_DB
     */
    public $mdb;

    public function __construct()
    {
        $this->mdb = new Manage_DB();
    }
    /** 
     *permet d'afficher les noms des départements recuperés par la fonction get_config_name
     * @return array[char]  
     **/
    public function get_config_name()
    {
        return $this->mdb->get_config_name();
    }
    /**
     *permet d'afficher les nom des groupes associés à un departement 
     * @param int $id 
     * @return array[char]
     **/
    public function get_grps($id)
    {
        return $this->mdb->get_grps($id);
    }
    /** 
     *permet d'afficher les propositions d'un groupe en donnant son identifiant
     * @param int $id
     * @return array[char]
     **/
    public function get_props_from_grp($id)
    {
        return $this->mdb->get_props_from_grp($id);
    }
    /** 
     *permet d'afficher le groupe d'une proposition en donnant son identifiant
     * @param int $id
     * @return char
     **/
    public function get_grp_from_prop($id)
    {
        return $this->mdb->get_grp_from_prop($id);
    }
    /** 
     *permet d'afficher le nom du departemnt d'un groupe  en donnant son identifiant
     * @param int $id
     * @return char
     **/
    public function get_conf_from_grp($id)
    {
        return $this->mdb->get_conf_from_grp($id);
    }

    /** 
     *permet d'afficher l'identifiant du departemnt d'un groupe 
     * @param int $id
     * @return int
     **/
    public function get_confid_from_grp($id)
    {
        return $this->mdb->get_confid_from_grp($id);
    }
    /** 
     *permet d'afficher toutes les informations associées à un groupe en donnant son identifiant
     * @param int $id
     * @return char
     **/

    public function get_grp_from_id($id)
    {
        return $this->mdb->get_grp_from_id($id);
    }
    /** 
     *permet d'afficher les noms des groupes recuperés par la fonction get_grp_name
     * @return array[char]  
     **/
    public function get_grp_name()
    {
        return $this->mdb->get_grp_name();
    }
    /** 
     *permet d'afficher les noms des propositions recuperées par la fonction get_propositions
     * @return array[char]  
     **/
    public function get_propositions()
    {
        return $this->mdb->get_propositions();
    }
    /** 
     *la fonction ajout_proposition permet d'ajouter  une proposition en utilisant la fonction ajout_proposition de Manage_DB
     * @param char $texte
     * @param int $id
     **/
    public function ajout_proposition($texte, $id)
    {
        $this->mdb->ajout_proposition($texte, $id);
    }
    /** 
     *la fonction delete_prop permet de supprimer une proposition en utilisant la fonction delete_prop de Manage_DB
     * @param int $id
     *@param int $id
     **/
    public function delete_prop($idp, $idg)
    {
        $this->mdb->delete_prop($idp, $idg);
    }

    /** 
     *la fonction delete_com permet de supprimer un commentaire en utilisant la fonction delete_com de Manage_DB
     * @param int $idp
     * @param int $idcom
     **/
    public function delete_com($idp, $idcom)
    {
        $this->mdb->delete_com($idp, $idcom);
    }
    /** 
     *la fonction get_prop permet d'afficher une proposition en utilisant la fonction get_prop de Manage_DB
     * @param int $id
     **/

    public function get_prop($id)
    {
        return $this->mdb->get_prop($id);
    }
    /** 
     *la fonction get_comms permet d'afficher un commentaire  en utilisant la fonction get_comms de Manage_DB
     * @param int $id
     **/
    public function get_comms($id)
    {
        return $this->mdb->get_comms($id);
    }
    /** 
     *la fonction add_com permet d'ajouter un commentaire en utilisant la fonction add_com de Manage_DB
     * @param char $texte
     * @param int $id
     **/
    public function add_com($texte, $id)
    {
        $this->mdb->add_com($texte, $id);
    }
    /** 
     *la fonction edit_proposition_name permet de modifier une proposition en utilisant edit_proposition_name  de Manage_DB
     * @param char $name
     * @param int $id
     **/
    public function edit_proposition_name($name, $id)
    {
        $this->mdb->edit_proposition_name($name, $id);
    }
    /** 
     *la fonction edit_proposition_avis permet de modifier l'avis d'une proposition en utilisant edit_proposition_avis  de Manage_DB
     * @param char $avis
     * @param int $id
     **/
    public function edit_proposition_avis($avis, $id)
    {
        $this->mdb->edit_proposition_avis($avis, $id);
    }
    /** 
     *la fonction add_rep permet de modifier un commentaire
     * @param char $etat_com
     * @param char $reponse
     * @param int $idc
     * @return void
     **/
    public function add_rep($etat_com, $reponse, $idc)
    {
        $this->mdb->add_rep($etat_com, $reponse, $idc);
    }
}
