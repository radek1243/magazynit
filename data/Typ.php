<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Typ
 *
 * @author Radek
 */

class Typ {
    
    private $id;
    private $nazwa;
    
    public function setId(int $id){
        $this->id = $id;
    }
    
    public function setName(string $nazwa){
        $this->nazwa = $nazwa;
    }
    
    public function getId(){
        return $this->id;
    }
    
    public function getName(){
        return $this->nazwa;
    }
}
