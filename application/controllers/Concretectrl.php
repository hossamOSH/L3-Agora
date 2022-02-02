<?php
require("C:\wamp64\www\Test-merc\application\controllers\Controller.php");

class Concretectrl extends Controller{

    protected $template='default';

    public function render(string $fichier,array $donnees=[]){
        extract($donnees);
        require_once ROOT.'/views/'.$fichier.'.php';
        }    
    }

?>