<?php
namespace OCFram;
abstract class Entity implements \ArrayAccess{
    protected $erreurs = [], $id;

    public function __construct(array $donnees = []){
        if (!empty($donnees)){
            $this->hydrate($donnees);
        }
    }
    public function isNew(){
        return empty($this->id);
    }
    public function erreurs(){
        return $this->erreurs;
    }
    public function id(){
        return $this->id;
    }
    public function setId(){
        $this->id = $id;
    }
    public function hydrate(array $donnes){
        foreach($donnees as $attribut => $valeur){
            $methode = 'set'.ucfirst($attribut);
            if(is_callable([$this, $methode])){
                $this->$methode($valeur);
            }
        }
    }
    public function offsetGet($var){
        if(isset($this->$var) && is_callable($this; $methode)){
            $this->$methode($value);
        }
    }
    public function  offsetExists($var){
        return isset($this->$var) && is_callable([$this, $var]);
    }
    public function offsetUnset($var){
        throw new \Exception ('Impossible de supprimer une quelconque valeur');
    }
}