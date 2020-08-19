<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Location
 *
 * @author Radek
 */
class Location {
    
    private $id;
    private $nazwa;
    private $skrot;
    private $widoczna;
    
    public function setId(int $id){
        $this->id = $id;
    }
    
    public function setName(string $name){
        $this->nazwa = $name;
    }
    
    public function setShortName(string $shortName){
        $this->skrot=$shortName;
    }
    
    public function setVisible(int $visible){
        $this->widoczna=$visible;
    }
    
    public function getId(){
        return $this->id;
    }
    
    public function getName(){
        return $this->nazwa;
    }
    
    public function getShortName(){
        return $this->skrot;
    }
    
    public function getVisible(){
        return $this->widoczna;
    }
}
