<?php

require(FCPATH . "system\core\Model.php");

class Manage_DB extends CI_Model
{


    /**
     * Manage_DB
     *
     * @var	PDO
     */
    public $dbh;

    public function __construct()
    {
        $this->dbh = new PDO('mysql:host=localhost;dbname=mydb', 'root', '');
    }

    /** 
     *permet de recuperer le nom des départements   
     * @return array[char] 
     **/
    public function get_config_name()
    {

        $sth = $this->dbh->prepare("SELECT * FROM `t_config_con` ;");
        $sth->execute();
        $result = $sth->fetchAll(\PDO::FETCH_ASSOC);
        return $result;
    }


    /** 
     *permet de recuperer les noms des groupes associés à un departement 
     * @param int $id 
     * @return array[char]
     **/

    public function get_grps($id)
    {
        $sth = $this->dbh->prepare("SELECT * FROM `t_groupe_grou` where con_id='" . $id . "';");
        $sth->execute();
        $result = $sth->fetchAll(\PDO::FETCH_ASSOC);
        return $result;
    }

    /** 
     *permet de recuperer le groupe d'une proposition en donnant son identifiant
     * @param int $idp
     * @return char
     **/
    public function get_grp_from_prop($idp)
    {

        $this->load->database();
        $query = $this->db->query("SELECT * FROM t_groupe_grou left join t_proposition_pro using (grou_id) where pro_id='" . $idp . "';");
        return $query->row();
    }
    /** 
     *permet de recuperer les propositions d'un groupe en donnant son identifiant
     * @param int $id
     * @return array[char]
     **/

    public function get_props_from_grp($id)
    {
        $sth = $this->dbh->prepare("SELECT * FROM `t_proposition_pro` where grou_id='" . $id . "';");
        $sth->execute();
        $result = $sth->fetchAll(\PDO::FETCH_ASSOC);
        return $result;
    }
    /** 
     *permet de recuperer le nom du departemnt d'un groupe  en donnant son identifiant
     * @param int $id
     * @return char
     **/

    public function get_conf_from_grp($id)
    {
        $this->load->database();
        $query = $this->db->query("select con_nom from t_config_con 
        left join t_groupe_grou using (con_id)
        where grou_id='" . $id . "';");
        return $query->row();
    }
    /** 
     *permet de recuperer l'identifiant du departemnt d'un groupe 
     * @param int $id
     * @return int
     **/
    public function get_confid_from_grp($id)
    {
        $this->load->database();
        $query = $this->db->query("select con_id from t_config_con 
        left join t_groupe_grou using (con_id)
        where grou_id='" . $id . "';");
        return $query->row();
    }

    /** 
     *permet de recuperer toutes les informations associées à un groupe en donnant son identifiant
     * @param int $id
     * @return char
     **/

    public function get_grp_from_id($id)
    {
        $this->load->database();
        $query = $this->db->query("SELECT * FROM `t_groupe_grou` 
        join t_config_con using (con_id)
        where grou_id='" . $id . "';");
        return $query->result_array();
    }
    /** 
     *permet de recuperer la liste des groupes de travails présentes dans la base de données   
     * @return array[char] 
     **/

    public function get_grp_name()
    {
        $sth = $this->dbh->prepare("SELECT * FROM `t_groupe_grou` ;");
        $sth->execute();
        $result = $sth->fetchAll(\PDO::FETCH_ASSOC);
        return $result;
    }
    /** 
     *permet de recuperer la liste des propositions présentes dans la base de données  
     * @return array[char] 
     **/
    public function get_propositions()
    {
        $sth = $this->dbh->prepare("SELECT * FROM `t_proposition_pro` ;");
        $sth->execute();
        $result = $sth->fetchAll(\PDO::FETCH_ASSOC);
        return $result;
    }

    /** 
     *permet de recuperer l'identifiant de la dernière proposition ajoutée dans la base de données par l'utilisation d'une fonction idlastprop fait dans phpmyadmin
     * @return int 
     **/
    public function last_prop()
    {
        $this->load->database();
        $query = $this->db->query("select idlastprop() as idp;");
        return $query->row();
    }
    /** 
     *permet de recuperer l'identifiant du dernier ajoutée dans la base de données par l'utilisation d'une fonction idlastcom fait dans phpmyadmin
     * @return int 
     **/
    public function last_com()
    {
        $this->load->database();
        $query = $this->db->query("select idlastcom() as idc;");
        return $query->row();
    }

    /** 
     *permet d'ajouter une nouvelle proposition dans la base de données et de créer  un fichier associé à cette proposition sur pmwiki
     * @param char $texte
     * @param int $idg
     * @return void
     **/

    public function ajout_proposition($texte, $idg)
    {
        $idp = $this->last_prop();
        $tabid = (array) $idp;
        $idtemp = $tabid["idp"];
        $id = intval($idtemp);
        $id++;
        $filename = "prop" . $id . ".php";
        $pmfilename = "Main.prop" . $id . "";
        $base = base_url();
        $pmwikilink = "" . $base . "pmwiki/pmwiki.php?n=" . $pmfilename . "";
        $this->load->helper('file');
        $this->load->database();
        $req = "INSERT INTO `t_proposition_pro` VALUES ('" . $id . "'," . $this->db->escape($texte) . ",'" . $filename . "','ok','" . $pmwikilink . "','" . $idg . "');";
        $link = "" . $base . "index.php/controller/props/" . $idg . "";
        $data = 'text=%width=60%[[' . $link . '|https://cdn.discordapp.com/attachments/841672965967052830/846732906881220608/telechargement.png]]';

        if (!write_file("./pmwiki/wiki.d/" . $pmfilename . "", $data)) {
            echo 'Unable to write the file';
        } else {
            echo 'File written!';
        }
        $query = $this->db->query($req);
    }

    /**
     *permet de supprimer une proposition et les commentaires qui lui sont associés s'il y'en a 
     * @param int $idp
     * @param int $idg
     * @return void
     **/
    public function delete_prop($idp, $idg)
    {
        $this->load->database();
        $this->load->helper('file');
        $query1 = $this->db->query("DELETE FROM t_commentaire_com WHERE pro_id='" . $idp . "';");
        $query2 = $this->db->query("DELETE FROM t_proposition_pro WHERE pro_id='" . $idp . "' and grou_id='" . $idg . "';");
        $pmfilename = "Main.prop" . $idp . "";
        unlink("./pmwiki/wiki.d/" . $pmfilename . "");
        return $query1;
        return $query2;
    }
    /**
     *permet de supprimer un commentaire  
     * @param int $idp
     * @param int $idcom
     * @return void
     **/
    public function delete_com($idp, $idcom)
    {
        $this->load->database();
        $query = $this->db->query("DELETE FROM t_commentaire_com WHERE pro_id='" . $idp . "' and com_id='" . $idcom . "';");
        return $query;
    }
    /** 
     *permet de recuperer une proposition connaissant son identifiant 
     * @param int $id
     * @return void
     **/
    public function get_prop($id)
    {
        $this->load->database();
        $query = $this->db->query("select * from t_proposition_pro where pro_id='" . $id . "';");
        return $query->result_array();
    }
    /**
     *permet de recuperer les commentaires d'une proposition
     * @param int $id
     * @return array[char]
     **/
    public function get_comms($id)
    {
        $this->load->database();
        $query = $this->db->query("select * from t_commentaire_com 
        left outer join t_proposition_pro USING(pro_id)
        where pro_id='" . $id . "';");
        return $query->result_array();
    }
    /** 
     *permet d'ajouter un commentaire  
     * @param char $name
     * @param int $id 
     * @return void
     **/
    public function add_com($name, $id)
    {
        $idc = $this->last_com();
        $tabid = (array) $idc;
        $idtemp = $tabid["idc"];
        $idc = intval($idtemp);
        $idc++;

        $this->load->database();
        $query = $this->db->query("INSERT INTO `t_commentaire_com` VALUES ('" . $idc . "'," . $this->db->escape($name) . ",1,'','" . $id . "');");
        return $query;
    }

    /** 
     *permet de modifier le nom d'une proposition en utilisant son identifiant
     * @param char $name
     * @param int $id 
     * @return void
     **/
    public function edit_proposition_name($name, $id)
    {
        $this->load->database();
        $query = $this->db->query("UPDATE `t_proposition_pro` SET pro_nom=" . $this->db->escape($name) . " where pro_id='" . $id . "';");
        return $query;
    }
    /** 
     *permet de modifier l'avis d'une proposition
     * @param char $avis
     * @param int $id 
     * @return void
     **/
    public function edit_proposition_avis($avis, $id)
    {
        $this->load->database();
        $query = $this->db->query("UPDATE `t_proposition_pro` SET pro_avis=" . $this->db->escape($avis) . " where pro_id='" . $id . "';");
        return $query;
    }
    /** 
     *permet de modifier un commentaire en donnant son etat et la reponse associée à cet commentaire 
     * @param char $etat_com
     * @param int $idc
     * @param char $reponse
     * @return void
     **/

    public function add_rep($etat_com, $reponse, $idc)
    {
        $this->load->database();
        $query = $this->db->query("UPDATE `t_commentaire_com` SET`com_etat`='" . $etat_com . "', `com_reponse`=" . $this->db->escape($reponse) . " where com_id='" . $idc . "';");
        return $query;
    }
}
