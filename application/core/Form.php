<?php

class Form{

	private $formname="";


	public function create(){
		return $this->formname;
	}

	public static function validate(array $form,array $champs){
		//parcours les champs
		foreach($champs as $champ){
			//si c'est vide
			if(!isset($form[$champ]) || empty($form[$champ])){
				return false;
			}
		}
		return true;
	}

	private function ajoutAttributs(array $attributs): string{
		$str="";
		$att=['checked','disabled','readonly','required'];

		foreach($attributs as $attr => $valeur){
			if(in_array($attr,$att) && $valeur==true){
				$str .= " $attr";
			}
			else{
				$str .=" $attr='$valeur'";
			}
		}
		return $str;
	}


	public function debutForm(string $method='post',string $action='#',array $attributs=[]):self
	{
		//Creation de la balise Form
		$this->formname .="<form action='$action' method='$method'";
		//Ajout d'attributs
        $this->formname .= $attributs ? $this->ajoutAttributs($attributs).'>': '>';
		
		//renvoie l'objet lui meme
		return $this;
	}

	public function finform():self
	{
		$this->formname .='</form>';
		return $this;
	}

	public function ajoutLabelFor(string $for,string $texte,array $attributs=[]):self
	{
		$this->formname .="<label for='$for'";
		$this->formname .= $attributs ? $this->ajoutAttributs($attributs) : '';
		$this->formname .=">$texte</label>";
		return $this;
	}

	public function ajoutInput(string $type,string $nom,array $attributs =[]):self
	{
		$this->formname .="<input type='$type' name='$nom'";
		$this->formname .= $attributs ? $this->ajoutAttributs($attributs).'>': '>';
		return $this;
	}


	public function ajoutSelect(string $nom,array $options,array $attributs=[]):self{

		$this->formname .= "<select name='$nom'";
		$this->formname .=$attributs ? $this->ajoutAttributs($attributs).'>' : '>';
		foreach($options as $valeur => $texte){
			$this->formname .= "<option value='$valeur'>$valeur</option>";
		}
		$this->formname .="</select>";
		return $this;
	}

	public function ajoutBouton(string $texte,array $attributs=[]):self
	{
		$this->formname .= "<button ";
		$this->formname .=$attributs ? $this->ajoutAttributs($attributs) : '';
		$this->formname .=">$texte</button>";
		return $this;
	}




}
?>