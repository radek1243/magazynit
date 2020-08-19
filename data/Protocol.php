<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Protocol
 *
 * @author Radek
 */
class Protocol {
    
    private $id;
    private $lok_id;
    private $skrot;
    private $nazwa_lok;
    private $uzytkownik_id;
    private $login;
    private $osoba;
    private $poz_urz;
    private $data;
    private $wro;
	private $zlecajacy;
    
    public function setId(int $id){
        $this->id = $id;
    }
    
    public function setLokId(int $lok_id){
        $this->lok_id = $lok_id;
    }
    
    public function setShortName(string $shortName){
        $this->skrot = $shortName;
    }
    
    public function setLokName(string $name){
        $this->nazwa_lok=$name;
    }
    
    public function setUserId(int $user_id){
        $this->uzytkownik_id = $user_id;
    }
    
    public function setLogin(string $login){
        $this->login = $login;
    }
    
    public function setOso(string $oso){
        $this->osoba = $oso;
    }
    
    public function setOtherDev(string $other){
        $this->poz_urz = $other;
    }
    
    public function setDate($date){
        $this->data = $date;
    }
    
    public function setReturned($returned){
        $this->wro = $returned;
    }
	
	public function setZlec($zlec){
		$this->zlecajacy = $zlec;
	}
    
    public function getId(){
        return $this->id;
    }
    
    public function getLokId(){
        return $this->lok_id;
    }
    
    public function getShortName(){
        return $this->skrot;
    }
    
    public function getLokName(){
        return $this->nazwa_lok;
    }
    
    public function getUserId(){
        return $this->uzytkownik_id;
    }
    
    public function getLogin(){
        return $this->login;
    }
    
    public function getOso(){
        return $this->osoba;
    }
    
    public function getOtherDev(){
        return $this->poz_urz;
    }
    
    public function getDate(){
        return $this->data;
    }
    
    public function getReturned(){
        return $this->wro;
    }
	
	public function getZlec(){
		return $this->zlecajacy;
	}
}
