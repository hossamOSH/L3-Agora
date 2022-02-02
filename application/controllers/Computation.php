<?php
class Computation{

/** permet de faire  l'addition entre deux nombres
* @param int $val1
*   valeur choisie sur une liste deroulante
* @param int $val2
*   valeur saisie par l'utilisateur
* @return int 
*   le resultat de l'addition
**/
  public function add($val1,$val2)
{
    $result=$val1 + $val2; 
    return $result;
}
/** permet  de faire la multiplication entre deux nombres
* @param int $val1
*  valeur choisie par l'utilisateur sur une liste deroulante
* @param int $val2
*  valeur saisie par l'utilisateur
* @return int 
**/

 public function mult($val1,$val2)
{
    $result=$val1 * $val2; 
    return $result;
}

/** permet de faire la multiplication entre un nombre et le carre d'un autre nombre
* @param int $val1
*  valeur choisie par l'utilisateur sur une liste deroulante
* @param int $val2
*  valeur saisie par l'utilisateur
* @return int 
**/

 public function square($val1,$val2)
{
    $result=$val1 * $val2 * $val2; 
    return $result;
}

}
?>