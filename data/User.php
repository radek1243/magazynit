<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of User
 *
 * @author Radek
 */
class User {
    
    private $id;
    
    public function setId($id){
        $this->id = $id;
    }
    
    public function getId(){
        return $this->id;
    }
}
