<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Device
 *
 * @author Radek
 */
class Device {
    
    private $id;
    private $typ_id;
    private $typ_nazwa;
    private $model_id;
    private $model_nazwa;
    private $lok_id;
    private $lok_nazwa;
    private $skrot;
    private $sn;
    private $sn2;
    private $stan;
    private $serwis;
    private $opis;
    private $fv;
    private $utyl;
    private $protokol_id;
    private $czas_op;
    
    public function setId(int $id){
        $this->id = $id;
    }
    
    public function setTypId(int $typ_id){
        $this->typ_id = $typ_id;
    }
    
    public function setTypeName(string $name){
        $this->typ_nazwa = $name;
    }
    
    public function setModelId(int $model_id){
        $this->model_id = $model_id;
    }
    
    public function setModelName(string $modelName){
        $this->model_nazwa = $modelName;
    }
    
    public function setLokId(int $lok_id){
        $this->lok_id = $lok_id;
    }
    
    public function setShortName(string $shortName){
        $this->skrot = $shortName;
    }   
    
    public function setSN(string $sn){
        $this->sn = $sn;
    }

    public function setSN2(string $sn2){
        $this->sn = $sn2;
    }
    
    public function setStan(string $stan){
        $this->stan = $stan;
    }
    
    public function setService(int $service){
        $this->serwis = $service;
    }
    
    public function setDesc(string $desc){
        $this->opis = $desc;
    }
    
    public function setFV(int $fv){
        $this->fv = $fv;
    }

    public function setUtyl(int $utyl){
        $this->utyl = $utyl;
    }
    
    public function setProtocolId(int $protocol_id){
        $this->protokol_id = $protocol_id;
    }
    
    public function setOperationTime($operationTime){
        $this->czas_op = $operationTime;
    }
    
    public function setLocName($lok_name){
        $this->lok_nazwa = $lok_name;
    }
    
    public function getId(){
        return $this->id;
    }
    
    public function getTypId(){
        return $this->typ_id;
    }
    
    public function getTypeName(){
        return $this->typ_nazwa;
    }
    
    public function getModelId(){
        return $this->model_id;
    }
    
    public function getModelName(){
        return $this->model_nazwa;
    }
    
    public function getLokId(){
        return $this->lok_id;
    }
    
    public function getShortName(){
        return $this->skrot;
    }
    
    public function getSN(){
        return $this->sn;
    }

    public function getSN2(){
        return $this->sn2;
    }
    
    public function getStan(){
        return $this->stan;
    }
    
    public function getService(){
        return $this->serwis;
    }
    
    public function getDesc(){
        return $this->opis;
    }
    
    public function getFV(){
        return $this->fv;
    }

    public function getUtyl(){
        return $this->utyl;
    }
    
    public function getProtocolId(){
        return $this->protokol_id;
    }
    
    public function getOperationTime(){
        return $this->czas_op;
    }
    
    public function getLocName(){
        return $this->lok_nazwa;
    }
    
}
