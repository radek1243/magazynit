<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DBManager
 *
 * @author Radek
 */

    //ogolnie aktualne funkcje działają po przeróbkach, można dodawać nowe funkcjonalnosci + uproscic plik z widokiem
    //
class DBManager {
    
    
    private static $host=
    private static $user=
    private static $pass=
    private static $port=3306;
    private static $db=
    
    public static function connect2(){
        try{
            return new PDO('mysql:host=;dbname=;charset=utf8', DBManager::$user, DBManager::$pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // this is important
            PDO::ATTR_PERSISTENT => true,    //połączenie będzie stałe a nie kończone po zakończeniu skryptu - pomyslec czy ma byc
            PDO::ATTR_AUTOCOMMIT => false    //na razie wyłączone bo nie do końca działa  
            ]);
        } 
        catch (PDOException $ex) {
            return null;
        }
    }
    
    public static function insert($link, $query, $values){
        if($link!==null){
            $link->beginTransaction();
            try{
                $st = $link->prepare($query);
                for($i=1;$i<=sizeof($values);$i++){
                    $st->bindParam($i, $values[$i-1]);
                }
                $st->execute();
                $result = $link->commit();
                $st = null;
                $link=null;
                return $result;
            }
            catch (Exception $e){
                $link ->rollBack();
                $link=null;
                return false;
            }
        }
        else{
            return false;
        }
    }

    public static function insertWithLIID($link, $query, $values){
        if($link!==null){
            $link->beginTransaction();
            try{
                $st = $link->prepare($query);
                for($i=1;$i<=sizeof($values);$i++){
                    $st->bindParam($i, $values[$i-1]);
                }
                $st->execute();
                $result = $link->lastInsertId();
                $result2 = $link->commit();
                $st = null;
                $link=null;
                return array("id" => $result, "ok" => $result2);
            }
            catch (Exception $e){
                $link ->rollBack();
                $link=null;
                return false;
            }
        }
        else{
            return false;
        }
    }

    public static function call($link, string $query, string $procedure_name, $params){
        if($link!==null){
            try{
                $st = $link->prepare(str_replace("proc_name", $procedure_name, $query));     //parametry id urzadzenia, nowy opis
                for($i=1;$i<=sizeof($params);$i++){                
                    $st->bindValue($i, $params[$i-1]);
                }                
                $result = $st->execute(); 
                $st = null;
                $link=null;
                return $result;
            }
            catch (Exception $e){
                $link=null;
                return false;
            }
        }
        else{
            return false;
        }
    }
    
    public static function login($link, $username, $password) {
        require_once '../data/User.php'; 
        $query = "SELECT id FROM uzytkownik WHERE login=? AND haslo=?";
        if($link!==null){
            try{
                $st = $link->prepare($query);
                $st->bindParam(1, $username);
                $st->bindParam(2, $password);
                $st->execute();
                $result = $st->fetchAll(PDO::FETCH_CLASS, "User");
                $link = null;   
                $st = null;
                if(sizeof($result)==0) {
                    return -1;
                }
                else{
                    return $result[0]->getId();
                }
            }
            catch (Exception $e){
                return -1;
            }
        }
        else{
            return -1;
        }
    }
    
    /**
        @return false
    */
    public static function executeUpdate($link, string $query_forupdate, $params_forupdate, string $query_update, $params_update){
        if($link!==null){     
            $link->beginTransaction();
            try{
                $st = $link->prepare($query_forupdate);
                if($params_forupdate!==null){
                    for($i=1;$i<=sizeof($params_forupdate);$i++){
                       $st->bindParam($i, $params_forupdate[$i-1]);
                    }
                }
                $st->execute();
                $st = $link->prepare($query_update);
                if($params_update!==null){
                    for($i=1;$i<=sizeof($params_update);$i++){
                       $st->bindParam($i, $params_update[$i-1]);
                    }
                }
                $st->execute();
                $result = $link->commit();
                $st = null;
                $link=null;
                return $result;
            }
            catch (Exception $e){
                $link->rollBack();
                $link=null;
                return false;
            }
        }
        else{
            return false;
        }
    }
    
    public static function select($link, string $query, $params, string $class){
        if($link!==null){
            $link->beginTransaction();
            try{
                $st = $link->prepare($query);
                if($params!==null){
                    for($i=1;$i<=sizeof($params);$i++){
                       $st->bindParam($i, $params[$i-1]);
                    }
                }
                $st->execute();
                $result = $st->fetchAll(PDO::FETCH_CLASS, $class);
                $link->commit();
                $st = null;
                $link=null;
                return $result;
            }
            catch (Exception $e){
                $link=null;
                return false;
            }
        }
        else{
            return false;
        }
    }
}
